@extends('templates.garden_help')

@section('title', 'GardenHelp | Service Booking')

@section('page-style')
    <style>
        .input-value {
            font-family: Roboto;
            font-size: 17px;
            letter-spacing: 0.32px;
            color: #1e2432;
        }
    </style>
@endsection

@section('content')
    <form action="{{route('garde_help_postServicesBooking', $id)}}" method="POST" enctype="multipart/form-data" autocomplete="off" id="booking-form" onsubmit="stripeCreateToken(event)">
        {{csrf_field()}}
        <div class="main main-raised">
            <div class="h-100 row align-items-center">
                <div class="col-md-12 text-center">
                    <img src="{{asset('images/gardenhelp/Garden-help-new-logo.png')}}"
                         style="height: 150px" alt="GardenHelp">
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="registerSubTitle">Services Details</h5>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group ">
                            <label>Service Types</label>
                            <div class="input-value">
                                {{$customer_request->service_types}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group ">
                            <label>Site Details</label>
                            <div class="input-value">
                                {{$customer_request->site_details ? $customer_request->site_details : 'N/A'}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group ">
                            <label>Scheduled at</label>
                            <div class="input-value">
                                {{$customer_request->available_date_time}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="main main-radius main-raised content-card">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 d-flex">
                        <div class="row">
                            <div class="col-12">
                                <div class=" row">
                                    <div class="col-12">
                                        <h5 class="cardTitleGreen requestSubTitle ">Estimated
                                            Price Quotation</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row" v-for="type in services_types">
                                    <div class="col-md-3 col-6">
                                        <label class="requestLabelGreen">@{{ type.title }}</label>
                                    </div>
                                    <div class="col-md-3 col-6">
                                        <span class="requestSpanGreen">€@{{ getPropertySizeRate(type) }}</span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3 col-6">
                                        <label class="requestLabelGreen">Vat</label>
                                    </div>
                                    <div class="col-md-3 col-6">
                                        <span class="requestSpanGreen">€@{{ getVat(13.5, getTotalPrice()) }} (13.5%)</span>
                                    </div>
                                </div>

                                <div class="row" style="margin-top: 15px">
                                    <div class="col-md-3 col-6">
                                        <label class="requestSpanGreen">Total</label>
                                    </div>
                                    <div class="col-md-3 col-6">
                                        <span class="requestSpanGreen">€@{{ (getTotalPrice() + getVat(13.5, getTotalPrice())).toFixed(2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="main main-radius main-raised content-card">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="registerSubTitle">Billing Information</h5>
                    </div>
                    <div class="col-md-12">
                        <div class="payment-input" id="card-number"></div>
                    </div>
                    <div class="col">
                        <div class="payment-input" id="card-expiry"></div>
                    </div>
                    <div class="col">
                        <div class="payment-input" id="card-cvc"></div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12 mb-3 ml-2 text-center">
                <img src="{{asset('images/stripe-secure.png')}}" width="150" alt="Stripe Secure">
            </div>

            <div class="col-md-12 mb-3 submit-container">
                <button class="btn btn-gardenhelp-green btn-register" type="submit">BOOK NOW</button>
            </div>
        </div>
    </form>

@endsection

@section('scripts')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        var stripe = Stripe("{{env('STRIPE_PUBLIC_KEY')}}");

        var elements = stripe.elements({
            fonts: [
                {
                    cssSrc: 'https://fonts.googleapis.com/css?family=Roboto',
                },
            ],
            // Stripe's examples are localized to specific languages, but if
            // you wish to have Elements automatically detect your user's locale,
            // use `locale: 'auto'` instead.
            locale: 'auto'
        });

        var elementStyles = {
            iconStyle: "solid",
            style: {
                base: {
                    iconColor: "#fff",
                    color: "#fff",
                    fontWeight: 400,
                    fontFamily: "Helvetica Neue, Helvetica, Arial, sans-serif",
                    fontSize: "16px",
                    fontSmoothing: "antialiased",
                    borderBottom: "solid 1px #eaecef",
                    padding: "10px",

                    "::placeholder": {
                        color: "#BFAEF6"
                    },
                    ":-webkit-autofill": {
                        color: "#fce883"
                    }
                },
                invalid: {
                    iconColor: "#FFC7EE",
                    color: "#FFC7EE"
                }
            }
        };

        var elementClasses = {
            focus: 'focus',
            empty: 'empty',
            invalid: 'invalid',
        };

        var cardNumber = elements.create('cardNumber', {
            style: elementStyles,
            classes: elementClasses,
        });
        // Add an instance of the card Element into the `card-element` <div>
        cardNumber.mount('#card-number');

        var cardExpiry = elements.create('cardExpiry', {
            style: elementStyles,
            classes: elementClasses,
        });

        cardExpiry.mount('#card-expiry');

        var cardCvc = elements.create('cardCvc', {
            style: elementStyles,
            classes: elementClasses,
        });
        cardCvc.mount('#card-cvc');


        function stripeTokenHandler(token) {
            // Insert the token ID into the form so it gets submitted to the server
            document.createElement('input');
            var form = document.getElementById('booking-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);
            // Submit the form

            setTimeout(form.submit(), 300);

        }
        function createToken() {
            stripe.createToken(cardNumber).then(function(result) {
                if (result.error) {
                    // Inform the user if there was an error
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                    console.log(result.error.message);
                } else {
                    // Send the token to your server
                    stripeTokenHandler(result.token);
                }
            });
        }

        function stripeCreateToken(event){
            event.preventDefault();
            createToken();
        }


        $(document).ready(function () {
            $('#payment_type').on('change', function () {
                var selectVal = jQuery("#payment_type option:selected").val();
                //var form = document.getElementById('payment-form');
                if( selectVal == "Credit Card" ){
                    $('.check').hide();
                    $('.cc').show();
                }else{
                    $('.cc').hide();
                    $('.check').show();
                }
            });
        });

        new Vue({
            el: '#app',
            data: {
                services_types: {!! $customer_request->services_types_json !!},
            },
            mounted() {

            },
            methods: {
                getPropertySizeRate(type) {
                    let property_size = "{{$customer_request->property_size}}";
                    property_size = property_size.replace(' Square Meters', '');
                    let rate_property_sizes = JSON.parse(type.rate_property_sizes);
                    for (let rate of rate_property_sizes) {
                        console.log(rate)
                        let size_from = rate.max_property_size_from;
                        let size_to = rate.max_property_size_to;
                        let rate_per_hour = rate.rate_per_hour;
                        console.log('ss')
                        if (parseInt(property_size) >= parseInt(size_from) && parseInt(property_size) <= parseInt(size_to)) {
                            let service_price = parseInt(rate_per_hour) * parseInt(type.min_hours);
                            console.log(this.total_price, service_price);
                            this.total_price += service_price;
                            return service_price;
                        }
                    }
                },
                getTotalPrice() {
                    let property_size = "{{$customer_request->property_size}}";
                    property_size = property_size.replace(' Square Meters', '');
                    let total_price = 0
                    for (let type of this.services_types) {
                        let rate_property_sizes = JSON.parse(type.rate_property_sizes);
                        for (let rate of rate_property_sizes) {
                            console.log(rate)
                            let size_from = rate.max_property_size_from;
                            let size_to = rate.max_property_size_to;
                            let rate_per_hour = rate.rate_per_hour;
                            if (parseInt(property_size) >= parseInt(size_from) && parseInt(property_size) <= parseInt(size_to)) {
                                let service_price = parseInt(rate_per_hour) * parseInt(type.min_hours);
                                total_price += service_price;
                            }
                        }
                    }
                    return parseFloat(total_price);
                },
                getVat(percentage, total_price) {
                    return parseFloat(((percentage/100) * total_price).toFixed(2));
                },
            }
        });
    </script>
@endsection
