@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="">
                    <p>You will be charged ${{ number_format($plan->cost, 2) }} for {{ $plan->name }} Plan</p>
                </div>
                <div class="card">
                    <div class="card-footer">
                        <a class="btn btn-dark" href="{{ route('subscription.create', $plan->slug) }}">Pay</a>
                        <a class="btn badge-success" href="{{ route('subscription.create.trial',$plan->slug) }}">Trial
                            (7) Days</a>
                    </div>
                </div>
                <div class="alert alert-danger" role="alert">
                    If your subscription is not cancelled before the trial ending date they will be charged as
                    soon as the trial expires.
                </div>
            </div>
        </div>
    </div>
@endsection
