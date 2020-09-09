<?php
/**
 * Created by PhpStorm.
 * User: Khalid S. Sabbah
 * Date: 11/10/2019
 * Time: 07:16 م
 */

namespace App\Http\Controllers\PaymentServices;


class PaymentProcessorController
{

    protected $paymentMethod;
    protected $value;

    public function __construct(PaymentProcessorInterface $paymentProcessor, $value)
    {
        $this->paymentMethod = $paymentProcessor;
        $this->value = $value;
    }

    public function process()
    {
        if($this->paymentMethod instanceof StripeProcessor)
            dd($this->paymentMethod->pay().' with '.$this->value);

        dd($this->paymentMethod->pay());
    }

}
