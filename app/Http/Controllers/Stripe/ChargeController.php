<?php
/**
 * Created by PhpStorm.
 * User: Khalid S. Sabbah
 * Date: 10/19/2019
 * Time: 06:16 م
 */

namespace App\Http\Controllers\Stripe;


use App\Product;
use Illuminate\Http\Request;

class ChargeController
{

    public function pay(Product $product, Request $request)
    {
        try {
            if (auth()->user()->stripe_id == null) {
                auth()->user()->createAsStripeCustomer();
                auth()->user()->addPaymentMethod($request->paymentMethodID);
                auth()->user()->updateDefaultPaymentMethod($request->paymentMethodID);
            }
//            auth()->user()->charge($product->price, $request['paymentMethodID'], [
//                'currency' => 'usd',
//                'description' => $product->name
//            ]);

            auth()->user()->invoiceFor($product->name, $product->price);

        } catch (\Exception $e) {
            return \response()->json(['msg' => 'Your credit card was been declined. Please try again or contact us.']);
        }

        return response()->json(['msg' => 'Thanks for your purchase!']);
    }

}
