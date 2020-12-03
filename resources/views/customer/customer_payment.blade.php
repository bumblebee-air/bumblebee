@extends('templates.main')

@section('page-styles')
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
        }
        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }
        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }
    </style>
@endsection
@section('page-content')
    <div class="row align-items-center">
        <div class="col">
            <h2>Customer payment</h2>
            <br/>
            <div class="form">
                <div class="form-group">
                    <label for="payment-amount" class="col-12">Enter the payment amount</label>
                    <div class="col-12">
                        <input id="payment-amount" class="form-control"/>
                    </div>
                </div>
                <button role="button" id="confirm-payment-amount" class="btn btn-primary">Confirm amount</button>
            </div>
        </div>
    </div>
    <div class="row align-items-center">
        <div class="col">
            <form id="payment-form" style="display: none;">
                <div id="card-element">
                    <!-- Elements will create input elements here -->
                </div>
                <!-- We'll put the error messages in this element -->
                <div id="card-errors" role="alert"></div>
                <button id="submit">Pay</button>
            </form>
        </div>
    </div>
@endsection
@section('page-scripts')
    <script src="https://js.stripe.com/v3/"></script>
    <script type="text/javascript">
        let clientSecret = null;
        $(document).ready(function () {
            $('#confirm-payment-amount').on('click',function() {
                let payment_amount_field = $('#payment-amount');
                let amount_value = payment_amount_field.val();
                if(amount_value!=null && amount_value !='') {
                    payment_amount_field.addClass('success');
                    payment_amount_field.removeClass('error');
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        url: '{{url('custom-customer-payment-amount')}}',
                        data: {
                            amount: amount_value,
                        },
                        dataType: 'json',
                        method: 'POST',
                        success: function (resp) {
                            clientSecret = resp.client_secret;
                            //console.log(clientSecret);
                            initializePaymentForm();
                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                            console.log("Unable to set the Stripe payment intent!<br/>" + "Status: " + textStatus + "<br/>" + "Error: " + errorThrown);
                        }
                    });
                } else {
                    payment_amount_field.addClass('error');
                    payment_amount_field.removeClass('success');
                }
            });

            function initializePaymentForm(){
                let stripe = Stripe('pk_test_xKo82JXCYteO2H5AXYX67M3r001RG26ZN6');
                let stripe_elements = stripe.elements();
                $('#payment-form').show();
                let style = {
                    base: {
                        color: "#32325d",
                    }
                };
                let card = stripe_elements.create("card", { style: style });
                card.mount("#card-element");
                card.on('change', function(event) {
                    let displayError = document.getElementById('card-errors');
                    if (event.error) {
                        displayError.textContent = event.error.message;
                    } else {
                        displayError.textContent = '';
                    }
                });

                let form = document.getElementById('payment-form');
                form.addEventListener('submit', function(ev) {
                    ev.preventDefault();
                    stripe.confirmCardPayment(clientSecret, {
                        payment_method: {
                            card: card,
                            billing_details: {
                                name: 'Test paying customer'
                            }
                        }
                    }).then(function(result) {
                        if (result.error) {
                            // Show error to your customer (e.g., insufficient funds)
                            console.log(result.error.message);
                        } else {
                            // The payment has been processed!
                            if (result.paymentIntent.status === 'succeeded') {
                                console.log('Payment succeeded');
                                console.log(result.paymentIntent);
                                // Show a success message to your customer
                                // There's a risk of the customer closing the window before callback
                                // execution. Set up a webhook or plugin to listen for the
                                // payment_intent.succeeded event that handles any business critical
                                // post-payment actions.
                            }
                        }
                    });
                });
            }
        });
    </script>
@endsection
