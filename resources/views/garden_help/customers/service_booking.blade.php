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
    <form action="{{route('garde_help_postServicesBooking', $id)}}" method="POST" enctype="multipart/form-data" autocomplete="off" id="booking-form" @submit="stripeCreateToken(event)">
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
                    <div class="col-md-12 mt-3">
                        <div class="form-group">
                            <label>Scheduled at</label>
                            <div class="input-value">
                                <input name="schedule_at" type="text" class="form-control datetimepicker" id="available_date_time" v-model="available_date" required @focusout="getAvailableContractors">
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
                                        <h5 class="cardTitleGreen requestSubTitle ">Available contractors on this date</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row" v-for="contractor in available_contractors" v-if="available_contractors.length > 0">
                                    <div class="col-md-3 col-6">
                                        <span class="requestSpanGreen">@{{ contractor.name }} </span>
                                    </div>
                                    <div class="col-md-3 col-6">
                                        <label class="requestLabelGreen">@{{ contractor.experience_level }}</label>
                                    </div>
                                </div>
                                <div class="col text-center" v-else>
                                    <div>
                                        There is no contractors available on this date.
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
                                        <span class="requestSpanGreen">€@{{ (getTotalPrice()- this.percentage + getVat(13.5, getTotalPrice())).toFixed(2) }} - €@{{ (getTotalPrice() + this.percentage + getVat(13.5, getTotalPrice())).toFixed(2) }}</span>
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
                        <h5 class="registerSubTitle">Billing Type</h5>
                    </div>
                    <div class="col-md-12">
                        <div class="radio">
                            <label>
                                <input type="radio" name="payment_type" value="card" :checked="payment_type == 'card'" @click="changePaymentType('card')">
                                Credit/Debit Card
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="payment_type" value="sepa_debit" :checked="payment_type == 'sepa_debit'" @click="changePaymentType('sepa_debit')">
                                SEPA Debit
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="main main-radius main-raised content-card" v-if="payment_type == 'card'">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="registerSubTitle">Card Details</h5>
                    </div>
                </div>
                <div class="row" v-if="payment_type == 'card'">
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
        <div class="main main-radius main-raised content-card" v-else-if="payment_type == 'sepa_debit'">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="registerSubTitle">SEPA Details</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-xm-12 mt-3">
                        <div class="form-group">
                            <label>Name</label>
                            <div class="input-value">
                                <input name="sepa_name" type="text" class="form-control" id="sepa_name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <div class="input-value">
                                <input name="sepa_email" type="text" class="form-control" id="sepa_email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>IBAN</label>
                            <div id="iban-element"></div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xm-12 mt-4 pt-4">
                        By providing your IBAN and confirming this payment, you are
                        authorizing GardenHepl Inc. and Stripe, our payment service
                        provider, to send instructions to your bank to debit your account
                        and your bank to debit your account in accordance with those
                        instructions. You are entitled to a refund from your bank under the
                        terms and conditions of your agreement with your bank. A refund must
                        be claimed within 8 weeks starting from the date on which your
                        account was debited.
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

        new Vue({
            el: '#app',
            data: {
                services_types: {!! $customer_request->services_types_json !!},
                cardNumber: null,
                cardExpiry: null,
                cardCvc: null,
                stripe: null,
                percentage: 0,
                available_date: '{!! $customer_request->available_date_time !!}',
                available_contractors: {!! json_encode($available_contractors) !!},
                payment_type: '',
                sepa_client_secret: ''
            },
            mounted() {
                $('#available_date_time').datetimepicker({
                    icons: {
                        time: "fa fa-clock",
                        date: "fa fa-calendar",
                        up: "fa fa-chevron-up",
                        down: "fa fa-chevron-down",
                        previous: 'fa fa-chevron-left',
                        next: 'fa fa-chevron-right',
                        today: 'fa fa-screenshot',
                        clear: 'fa fa-trash',
                        close: 'fa fa-remove'
                    }
                });
                this.stripe = Stripe("{{env('STRIPE_PUBLIC_KEY')}}");
            },
            methods: {
                changePaymentType(type) {
                    this.payment_type = type;
                    if (type == 'card') {
                        setTimeout(() => {
                            this.initStripeCardElements();
                        }, 500)
                    } else {
                        this.initStripeIBANElements()
                    }
                },
                initStripeIBANElements() {
                    // Custom styling can be passed to options when creating an Element.
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

                    var options = {
                        style: elementStyles,
                        classes: elementClasses,
                        supportedCountries: ['SEPA'],
                        // Elements can use a placeholder as an example IBAN that reflects
                        // the IBAN format of your customer's country. If you know your
                        // customer's country, we recommend that you pass it to the Element as the
                        // placeholderCountry.
                        placeholderCountry: 'IE',
                    };
                    // Create an instance of the IBAN Element
                    var elements = this.stripe.elements();
                    this.ibanElement = elements.create('iban', options);

                    // Add an instance of the IBAN Element into the `iban-element` <div>
                    setTimeout(() => {
                        this.ibanElement.mount('#iban-element');
                    }, 300);
                },
                initStripeCardElements() {
                    var elements = this.stripe.elements({
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

                    this.cardNumber = elements.create('cardNumber', {
                        style: elementStyles,
                        classes: elementClasses,
                    });
                    // Add an instance of the card Element into the `card-element` <div>
                    this.cardNumber.mount('#card-number');

                    this.cardExpiry = elements.create('cardExpiry', {
                        style: elementStyles,
                        classes: elementClasses,
                    });

                    this.cardExpiry.mount('#card-expiry');

                    this.cardCvc = elements.create('cardCvc', {
                        style: elementStyles,
                        classes: elementClasses,
                    });
                    this.cardCvc.mount('#card-cvc');

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
                },
                getPropertySizeRate(type) {
                    let property_size = "{{$customer_request->property_size}}";
                    property_size = property_size.replace(' Square Meters', '');
                    let rate_property_sizes = JSON.parse(type.rate_property_sizes);
                    for (let rate of rate_property_sizes) {
                        let size_from = rate.max_property_size_from;
                        let size_to = rate.max_property_size_to;
                        let rate_per_hour = rate.rate_per_hour;
                        if (parseInt(property_size) >= parseInt(size_from) && parseInt(property_size) <= parseInt(size_to)) {
                            let service_price = parseInt(rate_per_hour) * parseInt(type.min_hours);
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
                            let size_from = rate.max_property_size_from;
                            let size_to = rate.max_property_size_to;
                            let rate_per_hour = rate.rate_per_hour;
                            if (parseInt(property_size) >= parseInt(size_from) && parseInt(property_size) <= parseInt(size_to)) {
                                let service_price = parseInt(rate_per_hour) * parseInt(type.min_hours);
                                total_price += service_price;
                            }
                        }
                    }
                    this.percentage = (total_price / 100) * 20;
                    return parseFloat(total_price);
                },
                getVat(percentage, total_price) {
                    return parseFloat(((percentage/100) * total_price).toFixed(2));
                },
                stripeTokenHandler(token) {
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
                },
                createToken() {
                    this.stripe.createToken(this.cardNumber).then(result => {
                        console.log(result);
                        if (result.error) {
                            // Inform the user if there was an error
                            var errorElement = document.getElementById('card-errors');
                            errorElement.textContent = result.error.message;
                            console.log(result.error.message);
                        } else {
                            // Send the token to your server
                            this.stripeTokenHandler(result.token);
                        }
                    }).catch(err => console.log(err));
                },
                stripeCreateToken(event){
                    event.preventDefault();
                    if (this.available_contractors.length == 0) {
                        swal('There is no available contractors in this date. Please select another date.')
                        return;
                    }
                    setTimeout(() => {
                        this.payment_type == 'card' ? this.createToken() : this.createSEPASource() ;
                    }, 300);
                },
                getAvailableContractors(e) {
                    let date_time = e.target.value;
                    if (date_time) {
                        fetch('{{asset('api/garden-help/available_contractors')}}' + '?available_date=' + date_time)
                            .then(response => response.json())
                            .then(data => {
                                this.available_contractors = data.data
                            });
                    }
                },
                createSEPASource() {
                    this.stripe.createSource(this.ibanElement, {
                            type: 'sepa_debit',
                            currency: 'eur',
                            owner: {
                                name: 'Jenny Rosen',
                            },
                        })
                        .then(result => {
                            // Handle result.error or result.source
                            var form = document.getElementById('booking-form');
                            var hiddenInput = document.createElement('input');
                            hiddenInput.setAttribute('type', 'hidden');
                            hiddenInput.setAttribute('name', 'stripeToken');
                            hiddenInput.setAttribute('value', result.source.id);
                            form.appendChild(hiddenInput);
                            // Submit the form

                            setTimeout(form.submit(), 300);
                        });
                }
            }
        });
    </script>
@endsection
