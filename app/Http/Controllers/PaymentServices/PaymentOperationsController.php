<?php
/**
 * Created by PhpStorm.
 * User: Khalid S. Sabbah
 * Date: 11/13/2019
 * Time: 11:07 م
 */

namespace App\Http\Controllers\PaymentServices;


class PaymentOperationsController
{

    protected $paymentProcessor;
    protected $value;

    public function __construct(PaymentProcessorInterface $paymentProcessor, $value)
    {

        $this->paymentProcessor = $paymentProcessor;
        $this->value = $value;

    }

    public function process()
    {
        echo $this->paymentProcessor->pay().' -- with '.$this->value;
    }

}
