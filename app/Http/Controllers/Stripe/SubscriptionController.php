<?php

namespace App\Http\Controllers\Stripe;

use App\Plan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubscriptionController extends Controller
{
    public function create(Request $request, $slug)
    {
        auth()->user()
            ->newSubscription('main', $slug)
            ->create(auth()->user()->defaultPaymentMethod()->id);

        return redirect()->route('home')->with('success', 'Your plan subscribed successfully');
    }

    public function increment()
    {
        auth()->user()->subscription('main')->incrementQuantity();
    }

    public function decrement()
    {
        auth()->user()->subscription('main')->decrementQuantity();
    }

    public function syncTax()
    {
        auth()->user()->subscription('main')->syncTaxPercentage();
    }

    public function cancel()
    {
        auth()->user()->subscription('main')->cancel();
    }

    public function cancelNow()
    {
        auth()->user()->subscription('main')->cancelNow();
    }

    public function resume()
    {
        auth()->user()->subscription('main')->resume();
    }

    public function createWithTrial($slug)
    {
        auth()->user()->newSubscription('main', $slug)
            ->trialUntil(Carbon::now()->addDays(7))
            ->create(auth()->user()->defaultPaymentMethod()->id);

        return redirect()->route('home')->with('success', 'You have been subscribed to the ' . $slug . ' plan and have been given seven-days trial before payment');
    }
}
