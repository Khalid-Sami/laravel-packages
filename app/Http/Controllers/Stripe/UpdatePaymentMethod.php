<?php
/**
 * Created by PhpStorm.
 * User: Khalid S. Sabbah
 * Date: 10/3/2019
 * Time: 05:43 م
 */

namespace App\Http\Controllers\Stripe;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\PaymentMethod;
use App\Http\Controllers\Controller;

class UpdatePaymentMethod extends Controller
{

    public function index()
    {
        return view('update-payment-method', [
            'intent' => auth()->user()->createSetupIntent()
        ]);
//        $intent = auth()->user()->createSetupIntent();
//        $payment_method = PaymentMethod::retrieve($intent->payment_method);
//        dd($payment_method);
    }

    public function createCustomer()
    {
        auth()->user()->createAsStripeCustomer();
    }

    public function updatePaymentMethod(Request $request)
    {
        auth()->user()->createAsStripeCustomer();
        auth()->user()->addPaymentMethod($request->paymentMethodID);
        auth()->user()->updateDefaultPaymentMethod($request->paymentMethodID);
        return response()->json(['msg' => '400']);
    }

}
