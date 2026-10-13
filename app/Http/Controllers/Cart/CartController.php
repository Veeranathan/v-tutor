<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AcademicProgram;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function buyNow($programId)
    {
        $program = AcademicProgram::where('status', 1)->findOrFail($programId);

        $cartItems = session('cart.items', []);

        // ADD item (DO NOT RESET CART)
        if (!isset($cartItems[$programId])) {
            $cartItems[$programId] = [
                'id' => $program->id,
                'name' => $program->name,
                'price' => $program->price,
                'qty' => 1,
                'grade_id' => $program->grade_id,
            ];
        }
    

        session([
            'cart.order_id' => session('cart.order_id') ??
            'ORD-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6)),
            'cart.items' => $cartItems
        ]);

        return redirect()->route('cart.index');
    }

    public function index()
    {
        $cartItems = session('cart.items', []);
        $orderId   = session('cart.order_id');

        //Block cart if empty
        if (empty($cartItems)) {
            return redirect('/')->with('error', 'Cart is empty');
        }

        // Store back URL
        $previousUrl = url()->previous();

        if (
            !str_contains($previousUrl, route('cart.index')) &&
            !str_contains($previousUrl, 'stripe') &&
            !str_contains($previousUrl, 'success')
        ) {
            session(['cart.back_url' => $previousUrl]);
        }

        $user = auth()->user();
        $showGradeWarning = false;
        $userGradeName = null;

        if ($user) {

            $userGrade = $user->gradeRelation; 
            $userGradeName = $user->gradeRelation?->grade_name;
            $userGradeId   = $user->gradeRelation?->id;

            foreach ($cartItems as $item) {
                if (isset($item['grade_id']) && $item['grade_id'] != $userGradeId) {
                    $showGradeWarning = true;
                    break;
                }
            }
        }
   
        
        return response()
        ->view('cart.index', [
            'cartItems'  => $cartItems,
            'orderId'    => $orderId,
            'isLoggedIn' => auth()->check(),
            'user'             => $user,
            'showGradeWarning' => $showGradeWarning,
            'userGradeName'    => $userGradeName,
        ])
        ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
        ->header('Pragma', 'no-cache')
        ->header('Expires', '0');
        }

    public function remove(Request $request)
    {
        $programId = $request->program_id;

        $cart = session('cart.items', []);

        if (isset($cart[$programId])) {
            unset($cart[$programId]);
            session(['cart.items' => $cart]);
        }

        return response()->json([
            'success' => true
        ]);
    }


    public function toggle(Request $request)
    {
        $programId = $request->program_id;
        $cartItems = session('cart.items', []);

        // REMOVE if already exists
        if (isset($cartItems[$programId])) {
            unset($cartItems[$programId]);
            session(['cart.items' => $cartItems]);
            return response()->json(['in_cart' => false]);
        }

        // ADD new item
        $program = AcademicProgram::where('status', 1)->findOrFail($programId);

        $cartItems[$programId] = [
            'id' => $program->id,
            'name' => $program->name,
            'price' => $program->price,
            'qty' => 1,
            'grade_id' => $program->grade_id,
        ];

        session([
            'cart.order_id' => session('cart.order_id') ??
            'ORD-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6)),
            'cart.items' => $cartItems
        ]);

        return response()->json(['in_cart' => true]);
    }

    public function updateQty(Request $request)
    {
        $request->validate([
            'program_id' => 'required',
            'qty'        => 'required|integer|min:1'
        ]);

        $cart = session('cart.items', []);

        foreach ($cart as &$item) {
            if ($item['id'] == $request->program_id) {
                $item['qty'] = $request->qty;
                break;
            }
        }

        session(['cart.items' => $cart]);

        return response()->json(['success' => true]);
    }
}
