<?php

namespace App\Http\Controllers\Stripe;

use App\Plan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::all();
        return view('plans.index', compact('plans'));
    }

    public function show(Plan $plan, Request $request)
    {
        return view('plans.show', compact('plan'));
    }

    public function create()
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        \Stripe\Plan::create([
            "amount" => 1500,
            "interval" => "month",
            "product" => [
                "name" => "Basic"
            ],
            "currency" => "usd",
            "id" => "basic"
        ]);

        \Stripe\Plan::create([
            "amount" => 5000,
            "interval" => "month",
            "product" => [
                "name" => "Professional"
            ],
            "currency" => "usd",
            "id" => "professional"
        ]);

        Plan::create([
            'name' => 'Basic',
            'slug' => 'basic',
            'stripe_plan' => 'Basic',
            'cost' => '15'
        ]);

        Plan::create([
            'name' => 'Professional',
            'slug' => 'professional',
            'stripe_plan' => 'Professional',
            'cost' => '50'
        ]);
    }

    public function update()
    {

    }

    public function changeRoutePage()
    {
        $subscribedPlan = Plan::where('slug','=',auth()->user()->subscription('primary')->stripe_plan)->first();
        $plans = Plan::where('slug','!=',auth()->user()->subscription('primary')->stripe_plan)->get();
        return view('change-plan', compact('plans','subscribedPlan'));
    }

    public function change(Plan $plan, Request $request)
    {
        auth()->user()->subscription('primary')->swap($plan->slug);
        return redirect()->route('home')->with('success', 'Your subscription has been successfully swapped to '.$plan->name.' plan');
    }

    public function changeWithInvoice(Plan $plan, Request $request)
    {
        auth()->user()->subscription('primary')->swapAndInvoice($plan->slug);
        return redirect()->route('home')->with('success', 'Your subscription has been successfully swapped to '.$plan->name.' plan with Invoice');
    }
}
