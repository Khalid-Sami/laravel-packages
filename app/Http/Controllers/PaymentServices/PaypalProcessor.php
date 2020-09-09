<?php
/**
 * Created by PhpStorm.
 * User: Khalid S. Sabbah
 * Date: 11/10/2019
 * Time: 07:13 م
 */

namespace App\Http\Controllers\PaymentServices;


class PaypalProcessor implements PaymentProcessorInterface
{

    public function pay()
    {
        return 'pay with paypal';
    }
}
