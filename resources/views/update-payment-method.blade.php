@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if(session()->get('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                @endif
                {{--                    <a class="btn badge-primary" href="{{ route('createCustomer') }}">Create Customer</a>--}}
                <input class="form-control" id="card-holder-name" type="text">
                <!-- placeholder for Elements -->
                <div id="card-element" style="margin-top: 10px; margin-bottom: 10px"></div>
                <button class="btn btn-primary" id="card-button" data-secret="{{ $intent->client_secret }}">
                    Save Card
                </button>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://js.stripe.com/v3/"></script>

    <script>
        var style = {
            base: {
                color: '#32325d',
                lineHeight: '18px',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        };
        var stripe = Stripe('{{ env("STRIPE_KEY") }}');

        var elements = stripe.elements();
        var cardElement = elements.create('card', {style: style});
        cardElement.mount('#card-element');

        var cardholderName = document.getElementById('card-holder-name');
        var cardButton = document.getElementById('card-button');
        var clientSecret = cardButton.dataset.secret;


        cardButton.addEventListener('click', function (ev) {
            stripe.handleCardSetup(
                clientSecret, cardElement, {
                    payment_method_data: {
                        billing_details: {name: cardholderName.value}
                    }
                }
            ).then(function (result) {
                if (result.error) {
                    // Display error.message in your UI.
                } else {
                    // console.log(result)
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('updatePaymentMethod') }}',
                        data: {'paymentMethodID': result['setupIntent']['payment_method'], '_token': "{{ csrf_token() }}",},
                        success: function () {
                            console.log('User Payment Method Updated')
                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                            console.log('failed..')
                        }
                    })
                    // The setup has succeeded. Display a success message.
                }
            });
        });
    </script>
@endsection
