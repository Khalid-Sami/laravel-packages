<?php
/**
 * Created by PhpStorm.
 * User: Khalid S. Sabbah
 * Date: 10/13/2019
 * Time: 08:46 م
 */

namespace App\Http\Controllers\Stripe;

use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;


class WebhookController extends CashierController
{
    /**
     * Handle invoice payment succeeded.
     *
     * @param  array  $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handleInvoicePaymentSucceeded($payload)
    {
        // Handle The Event
    }

    public function handlePaymentIntentCreated($payload)
    {
        return redirect()->route('home');
    }


}
