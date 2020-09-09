<?php
/**
 * Created by PhpStorm.
 * User: Khalid S. Sabbah
 * Date: 11/10/2019
 * Time: 07:10 م
 */

namespace App\Http\Controllers\PaymentServices;


interface PaymentProcessorInterface
{

    public function pay();

}
