<?php

namespace App\Providers;

use function foo\func;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Laravel\Cashier\Cashier;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /* For Tagging */
        $this->app->bind('Stripe', \App\Http\Controllers\PaymentServices\StripeProcessor::class);
        $this->app->bind('Paypal', \App\Http\Controllers\PaymentServices\PaypalProcessor::class);

        $this->app->tag(['Stripe', 'Paypal'], 'payments');

        $this->app->when(\App\Http\Controllers\PaymentServices\PaymentTaggedController::class)
            ->needs('$classes')
            ->give($this->app->tagged('payments'));

        $this->app->bind('payment-tagged', \App\Http\Controllers\PaymentServices\PaymentTaggedController::class);

        /* To bind interface to specific implementation*/
//        $this->app->bind(\App\Http\Controllers\PaymentServices\PaymentProcessorInterface::class,
//            \App\Http\Controllers\PaymentServices\StripeProcessor::class);

        $this->app->when(\App\Http\Controllers\PaymentServices\PaymentProcessorController::class)
            ->needs(\App\Http\Controllers\PaymentServices\PaymentProcessorInterface::class)
            ->give(\App\Http\Controllers\PaymentServices\StripeProcessor::class);

        $this->app->when(\App\Http\Controllers\PaymentServices\PaymentProcessorController::class)
            ->needs('$value')
            ->give('master-card');

        $this->app->bind('payment', \App\Http\Controllers\PaymentServices\PaymentProcessorController::class);

        $this->app->extend(\App\Http\Controllers\PaymentServices\PaypalProcessor::class,
            function ($service)
            {
                return new \App\Http\Controllers\PaymentServices\CheckPaymentController();
            });

        $this->app->when(\App\Http\Controllers\PaymentServices\PaymentOperationsController::class)
            ->needs(\App\Http\Controllers\PaymentServices\PaymentProcessorInterface::class)
            ->give(\App\Http\Controllers\PaymentServices\StripeProcessor::class);

        $this->app->bind('payment-operation', \App\Http\Controllers\PaymentServices\PaymentOperationsController::class);


    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

//        Blade::directive('convert', function ($price){
////            $convert = Cashier::formatAmount((double)$price);
//            return "<?php
//            setlocale(LC_MONETARY, 'en_US');
//            echo money_format('%i', $price) . \"\n\";
        /*            ?>";*/
//        });
    }
}
