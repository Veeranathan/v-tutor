<?php

namespace App\Http\Controllers\Student\Payment;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    // public function initPaymentCreateObject(Request $request){
    //     $apiKey = '#';
    //     $curl = curl_init();
    //     curl_setopt_array($curl, [
    //         CURLOPT_RETURNTRANSFER => 1,
    //         CURLOPT_URL => "https://api.stripe.com/v1/charges",
    //         CURLOPT_POST => 1,
    //         CURLOPT_HTTPHEADER => [
    //             "Authorization: Bearer " . $apiKey
    //         ],
    //         CURLOPT_POSTFIELDS => http_build_query([
    //             "amount" => 2,
    //             "currency" => 'usd',
    //             "source" => array(
    //                 "object" => "card",
    //                 "number" => "4242424242424242",
    //                 "exp_month" => 8,
    //                 "exp_year" => 18,
    //                 "cvc" => "123"
    //             ),
    //             "description" => "Testing"
    //         ])
    //     ]);
    //     $resp = curl_exec($curl);
    //     curl_close($curl);
    // }

    // public function redirectToGateway(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'card_no' => 'required',
    //         'ccExpiryMonth' => 'required',
    //         'ccExpiryYear' => 'required',
    //         'cvvNumber' => 'required',
    //     ]);
    //     $input = $request->all();
    //     if ($validator->passes()) { 
    //         $input = array_except($input,array('_token'));
    //         $stripe = \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    //         try {
    //             if (!empty(@$request->stripeToken)) 
    //             {
    //                 $customer = \Stripe\Customer::create(array(
    //                     "name"  => @$request->name_of_card,
    //                     "email"  => @Auth::user()->email,
    //                     'description' => "My First Test Customer from My Sister Closet's",
    //                 ));
    //                 \Stripe\Customer::createSource(
    //                     $customer->id,
    //                     ['source' => @$request->stripeToken]
    //                 );
    //                 Auth::user()->update(['stripe_id' => $customer->id,'stripe_token' => @$request->stripeToken]);
    //             }
    //             if($customer && $customer->id)
    //             {
                    
    //                 $charge = \Stripe\Charge::create([
    //                     "amount" => @$request->amount,
    //                     "customer" => @$customer->id,
    //                     "currency" => getCurrency(),
    //                     // "source" => @$request->stripeToken,
    //                     "description" => "Test payment from My Sister Closet's",
    //                     "metadata" => [@$request->metadata], 
    //                 ]);
    //             }
    //             else
    //             {
    //                 \Session::flash('error','Payment credentials not valid');
    //                 return redirect()->back();
    //             }
    //             if(!empty($charge['status']))
    //             {
    //                 $orderId = $request->orderId;
    //                 if($charge['status'] == 'succeeded') {
    //                     $orderChk = $this->order->with([
    //                         'orderMasterDetails.productDetails',
    //                         'orderMasterDetails.productVariantDetails',
    //                         'customerDetails',
    //                         'getBillingCountryCode',
    //                     ])
    //                     ->where(['id' => $orderId])
    //                     ->first();
    //                     $paymentDetails = [];
    //                     $params = [
    //                         'response'  => json_encode(@$charge),
    //                         'txn_id'    => @$charge['id'],
    //                         'status'    => 'S'
    //                     ];
    //                     $this->updatePayment($params, $orderId);
    //                     $this->updateOrderStatus($orderId);
    //                     $this->sendCustomerAndSellerMail($orderId);
    //                     $response['result']['status'] = 'success';
    //                     $this->clearCart();
    //                     return redirect()->route('order.success', ['trackId' => encrypt($orderId)]);
    //                 } else {
    //                     $params = [
    //                         'response'  => json_encode(@$charge),
    //                         'txn_id'    => @$charge['id'],
    //                         'status'    => 'F',
    //                     ];
    //                     $this->updatePayment($params, $orderId);
    //                     $this->orderMaster->where(['id' => @$orderId])->update(['status' => 'F']);
    //                     return view('modules.payment.payment_failed')->with(['ref_id' => @$charge['id']]);

    //                 }

    //             }
    //             else{
    //                 \Session::flash('error','Payment credentials not valid');
    //                 return redirect()->back();
    //             }
    //         }

    //         catch (Exception $e) {
    //             \Session::flash('error',$e->getMessage());
    //             return redirect()->back();
    //         } catch(\Cartalyst\Stripe\Exception\CardErrorException $e) {
    //             \Session::flash('error',$e->getMessage());
    //             return redirect()->back();
    //         } catch(\Cartalyst\Stripe\Exception\MissingParameterException $e) {
    //             \Session::flash('error',$e->getMessage());
    //             return redirect()->back();
    //         }
    //     }
    // }
}
