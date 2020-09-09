@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="col-md-10">

            @if(session('msg'))
                <div class="alert alert-success" role="alert">
                    {{ session('msg') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <div class="container">
                @foreach ($products as $product)
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">Products</div>
                                <div class="card-body">
                                    <ul class="list-group">
                                        <li class="list-group-item clearfix">
                                            <div class="pull-left">
                                                <h5 class="productName">{{ $product->name }}</h5>
                                                <h5>{{ $product->description }}</h5>
                                                <a
                                                    href="#"
                                                    class="btn btn-outline-info pull-right"
                                                    data-toggle="modal"
                                                    data-target="#paymentMethodDetails"
                                                    data-id="{{ $product->id }}">Buy for
                                                    @money($product->price,'USD')
                                                </a>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Modal -->
            <div class="modal fade" id="paymentMethodDetails" tabindex="-1" role="dialog"
                 aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Payment - Card</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input class="form-control" id="card-holder-name" type="text">

                            <!-- Stripe Elements Placeholder -->
                            <div id="card-element" style="margin-top: 10px; margin-bottom: 10px"></div>
                        </div>
                        <div class="modal-footer">
                            {{--<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>--}}
                            <button type="button" class="btn btn-primary" id="card-button">charge</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
@section('scripts')
    <script src="https://js.stripe.com/v3/"></script>

    <script>
        var proID;
        $(document).ready(function () {
            $('#paymentMethodDetails').on('show.bs.modal', function (event) {
                var link = $(event.relatedTarget)
                // console.log(link.parent().find('.productName').text())
                proID = link.data('id')
            })

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
            const stripe = Stripe('{{ env("STRIPE_KEY") }}');

            const elements = stripe.elements();
            const cardElement = elements.create('card', {style: style});

            cardElement.mount('#card-element');

            const cardHolderName = document.getElementById('card-holder-name');
            const cardButton = document.getElementById('card-button');

            cardButton.addEventListener('click', async (e) => {
                stripe.createPaymentMethod(
                    'card', cardElement, {
                        billing_details: {name: cardHolderName.value}
                    }
                ).then(function (result) {
                    if (result.error) {
                        console.log(result.error)
                        // Display error.message in your UI.
                    } else {
                        // The card has been verified successfully...
                        console.log(result)
                        $.ajax({
                            type: "POST",
                            url: "{{ url('/pay') }}/" + proID,
                            data: {'_token': "{{ csrf_token() }}", 'paymentMethodID' : result['paymentMethod']['id']},
                            success: function (response) {
                                console.log(response['msg'])
                            },
                            error: function () {

                            }
                        })
                    }
                });
            });
        })

    </script>
@endsection
