<?php
/**
 * Created by PhpStorm.
 * User: Khalid S. Sabbah
 * Date: 11/10/2019
 * Time: 08:57 م
 */

namespace App\Http\Controllers\PaymentServices;


use Psy\Util\Str;

class PaymentTaggedController
{

    protected $classes;

    public function __construct($classes = array())
    {
        $this->classes = $classes;
    }

    public function process()
    {
        foreach ($this->classes as $instance){
            if($instance instanceof StripeProcessor){
                echo ($instance->pay().' Master-Card');
                echo "<br>";
            }
            else
                echo ($instance->pay());
        }
    }


}
