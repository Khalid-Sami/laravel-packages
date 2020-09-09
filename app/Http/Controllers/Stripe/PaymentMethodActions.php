<?php
/**
 * Created by PhpStorm.
 * User: Khalid S. Sabbah
 * Date: 10/6/2019
 * Time: 01:51 م
 */

namespace App\Http\Controllers\Stripe;

use App\Http\Controllers\Controller;


class PaymentMethodActions extends Controller
{

    public function retrieve()
    {
        dd(auth()->user()->paymentMethods());
    }

    public function default()
    {
        dd(auth()->user()->defaultPaymentMethod());
    }

    public function has()
    {
        dd(auth()->user()->hasPaymentMethod());
    }

    public function booleanOptions()
    {
//        dd(auth()->user()->subscribed('main'));

//        dd(auth()->user()->subscription('main')->onTrial());

//        dd(auth()->user()->subscribedToPlan('professional', 'main'));

//        dd(auth()->user()->subscription('main')->recurring());

//        dd(auth()->user()->subscription('main')->cancelled());

//        dd(auth()->user()->subscription('main')->onGracePeriod());

//        dd(auth()->user()->subscription('main')->ended());

//        dd(auth()->user()->subscription('main')->hasIncompletePayment());
    }

}
