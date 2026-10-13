<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\AcademicProgram;
use Stripe\Checkout\Session as StripeSession;
use App\Mail\PurchaseSuccessMail;
use App\Models\AcademicProgramPurchase;
use App\Models\AcademicProgramInvoice;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Mail;
use Auth;

class ProgramPaymentController extends Controller
{    
    public function createCheckoutSession(Request $request)
    {
        $request->validate([
            'order_id' => 'required|string'
        ]);

        $cartItems = session('cart.items', []);

        if (empty($cartItems)) {
            return response()->json(['error' => 'Cart is empty'], 400);
        }

        \Stripe\Stripe::setApiKey(config('services.stripe.stripe-secret'));

        $lineItems = [];
        $subTotal = 0;

        $programs = AcademicProgram::whereIn(
            'id',
            collect($cartItems)->pluck('id')
            )->get()->keyBy('id');

        foreach ($cartItems as $item) {

            if (!isset($programs[$item['id']])) {
              return response()->json(['error' => 'Invalid program in cart'], 400);
            }

            $program = $programs[$item['id']];

            $price = (float) $program->price;
            $qty   = (int) $item['qty'];

            $unitAmount = (int) round($price * 100);

            $lineItems[] = [
                'price_data' => [
                    'currency' => 'aud',
                    'product_data' => [
                    'name' => $program->name,
                        'metadata' => [
                            'program_id' => $program->id,
                        ],
                    ],
                'unit_amount' => $unitAmount,
                ],
                'quantity' => $qty,
            ];

            $subTotal += $unitAmount * $qty;
        }
        // GST in cents
        $gstCents = (int) round($subTotal * 0.10);

        // GST as separate Stripe line item
        $lineItems[] = [
            'price_data' => [
            'currency' => 'aud',
            'product_data' => [
            'name' => 'GST (10%)',
            ],
            'unit_amount' => $gstCents,
            ],
            'quantity' => 1,
        ];

        $subTotalAmount = $subTotal / 100;
        $gstAmount = $gstCents / 100;
        $grandTotal = $subTotalAmount + $gstAmount;

        $session = \Stripe\Checkout\Session::create([
            'mode' => 'payment',
            'payment_method_types' => ['card'],
            'customer_email' => auth()->user()->email ?? null,
            'line_items' => $lineItems,
            'metadata' => [
                'order_id' => $request->order_id,
                'subtotal' => number_format($subTotalAmount, 2, '.', ''),
                'gst'      => number_format($gstAmount, 2, '.', ''),
                'total'    => number_format($grandTotal, 2, '.', ''),
                'cart'     => json_encode($cartItems),
            ],
            'success_url' => route('cart.payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'  => route('cart.payment.cancel'),
        ]);

        return response()->json(['id' => $session->id]);
    }


    public function success(Request $request)
    {
        $sessionId = $request->get('session_id');

        if (!$sessionId) {
            return redirect('/')->with('error', 'Invalid payment session');
        }

        Stripe::setApiKey(config('services.stripe.stripe-secret'));

        try {
            $session = StripeSession::retrieve($sessionId);
        } catch (\Exception $e) {
            return redirect('/')->with('error', 'Unable to verify payment');
        }

        if ($session->payment_status !== 'paid') {
            return redirect('/cart')->with('error', 'Payment not completed');
        }

        $items    = json_decode($session->metadata->cart, true) ?? [];
        $orderId  = $session->metadata->order_id;
        $subTotal = (float) $session->metadata->subtotal;
        $gst      = (float) $session->metadata->gst;
        $total    = (float) $session->metadata->total;

        $user = auth()->user();

        if (!$user || empty($items)) {
            return redirect('/')->with('error', 'Invalid purchase');
        }

        DB::transaction(function () use (
            $user,
            $items,
            $orderId,
            $sessionId,
            $subTotal,
            $gst,
            $total
        ) {
        // Create Invoice
        $invoice = AcademicProgramInvoice::firstOrCreate(
            ['stripe_session_id' => $sessionId],
            [
                'user_id'        => $user->id,
                'order_id'       => $orderId,
                'invoice_number' => 'VT-INV-' . date('Y') . '-' . str_pad(AcademicProgramInvoice::count() + 1,5,'0',STR_PAD_LEFT),
                'sub_total'      => $subTotal,
                'gst_percent'    => 10,
                'gst_amount'     => $gst,
                'total_amount'   => $total,
                'payment_status' => 'paid',
            ]
        );

        //  Create Purchases
        foreach ($items as $item) {

             $program = AcademicProgram::find($item['id']);

            if (!$program) {
                continue;
            }

            $startDate = now();

            $expiresAt = now()->addDays($program->validity);

            $purchase = AcademicProgramPurchase::firstOrCreate(
                [
                    'stripe_session_id'   => $sessionId,
                    'academic_program_id' => $program->id,
                ],
                [
                    'user_id'        => $user->id,
                    'invoice_id'     => $invoice->id,
                    'order_id'       => $orderId,
                    'quantity'       => $item['qty'],
                    'amount'         => $item['price'] * $item['qty'],
                    'payment_status' => 'paid',
                    'start_date'     => $startDate,
                    'expires_at'     => $expiresAt,
                    'status'         => 'active',
                ]
            );

            if ($purchase->wasRecentlyCreated) {

                $totalSessions = $program->number_of_sessions * $item['qty'];

                for ($i = 1; $i <= $totalSessions; $i++) {

                    \App\Models\AcademicProgramSession::create([
                        'purchase_id'   => $purchase->id,
                        'session_number'=> $i,
                        'status'        => 'pending',
                        'tutor_id'      => null,
                    ]);
                }
             }
            }
        });

        // Email
        try {
            Mail::send(new PurchaseSuccessMail(
                $user,
                $orderId,
                $subTotal,
                $gst,
                $total,
                $items
            ));
        } catch (\Exception $e) {
            Log::error("Purchase Success Mail Error: " . $e->getMessage());
        }

        // Clear Cart
        session()->forget([
            'cart.items',
            'cart.order_id',
            'cart.back_url',
        ]);

         return view('cart.payment-success', compact(
            'orderId',
            'items',
            'subTotal',
            'gst',
            'total'
        ));
    }


    public function cancel()
    {
        return view('cart.payment-cancel');
    }
}
