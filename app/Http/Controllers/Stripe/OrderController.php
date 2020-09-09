<?php

namespace App\Http\Controllers\Stripe;

use App\Order;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class OrderController extends Controller
{

    public function getAllOrders()
    {
        $orders = Order::all();
        return view('admin', compact('orders'));
    }


    public function postPayWithStripe(Request $request, Product $product)
    {
        return $this->chargeCustomer($product->id, $product->price, $product->name, $request->input('stripeToken'));
    }

    public function chargeCustomer($product_id, $product_price, $product_name, $token)
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        if (!$this->isStripeCustomer()) {
            $customer = $this->createStripeCustomer($token);
        } else {
            $customer = \Stripe\Customer::retrieve(auth()->user()->stripe_id);
        }

        return $this->createStripeCharge($product_id, $product_price, $product_name, $customer);
    }

    public function createStripeCharge($product_id, $product_price, $product_name, $customer)
    {
        try {
            $charge = \Stripe\Charge::create(array(
                "amount" => $product_price,
                "currency" => "brl",
                "customer" => $customer->id,
                "description" => $product_name
            ));
        } catch (\Stripe\Error\Card $e) {
            return redirect()
                ->route('index')
                ->with('error', 'Your credit card was been declined. Please try again or contact us.');
        }

        return $this->postStoreOrder($product_name);
    }

    public function createStripeCustomer($token)
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $customer = \Stripe\Customer::create(array(
            "description" => auth()->user()->email,
            "source" => $token
        ));

        auth()->user()->stripe_id = $customer->id;
        auth()->user()->save();

        return $customer;
    }

    public function isStripeCustomer()
    {
        return auth()->user() && \App\User::where('id', auth()->user()->id)->whereNotNull('stripe_id')->first();
    }

    public function postStoreOrder($product_name)
    {
        Order::create([
            'email' => auth()->user()->email,
            'product' => $product_name
        ]);

        return redirect()
            ->route('index')
            ->with('msg', 'Thanks for your purchase!');
    }
}
