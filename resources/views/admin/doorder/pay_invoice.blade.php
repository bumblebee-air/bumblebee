<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport"
	content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>Pay Invoice</title>

<link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
<link href="{{asset('css/material-dashboard.min.css')}}"
	rel="stylesheet">
<link rel="stylesheet" href="{{asset('css/jquery-ui.css')}}">
<link rel="stylesheet" href="{{asset('css/custom-pay.css')}}">
<link rel="stylesheet" href="{{asset('css/doorder-styles.css')}}">
<link rel="stylesheet" href="{{asset('css/doorder_dashboard.css')}}">
<link
	href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap"
	rel="stylesheet">
<link
	href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700;800&display=swap"
	rel="stylesheet">
<link rel="icon" type="image/jpeg"
	href="{{asset('images/doorder-favicon.svg')}}">
<style>
.titles_custom {
	color: #e8ca49
}
/* Blue outline on focus */
.StripeElement--focus {
	border-color: #80BDFF;
}

.btn {
	font-size: 16px;
	border-radius: 20px 0;
	text-transform: capitalize;
	min-width: 100%
}

.form-control[disabled], .form-group .form-control[disabled], fieldset[disabled] .form-control,
	fieldset[disabled] .form-group .form-control {
	border-radius: 0;
	border-color: #e8ca49;
}
.containerDiv
{
padding: 1rem !important;}
.container{
padding: 1rem !important;
}
@media ( min-width : 768px) {
	.containerDiv {
		padding: 3rem !important;
	}
}
.bg-cover{
background: url({{asset('images/doorder-login-bg.jpg')}});
background-size:cover;
}
</style>

<script src="https://js.stripe.com/v3/"></script>
</head>
<body style="height: 100vh">
	<div class="container text-center bg-cover h-100 m-0 py-1 px-5  "
		style="width: 100%; max-width: 100% !important; 
		">

		<div class="row m-3 h-100 justify-content-center align-items-center">
			<div class="col-md-6 offset-md-6 containerDiv "
				style="background-color: white; border-radius: 30px;">
				<img src="{{asset('images/doorder-logo.png')}}" class="img-fluid"
					alt="DoOrder Logo" style="width: 110px; height: 80px;">
				<!--<form method="post" id="details-form" action="{{route('postPaymentDetails','doorder')}}" onsubmit="submitToStripe(event)">-->
				@csrf
				<div id="details-section">
					<h3 class="titles_custom mb-3">Invoice details</h3>

					<div class="form-group">
						<input name="customer_name" type="text" class="form-control"
							id="customer-name" placeholder="Your Name" disabled="disabled"
							value="{{$customer_name}}"> @if($errors &&
						$errors->has('customer_name')) <small id="emailHelp"
							class="form-text text-danger">{{$errors->first('customer_name')}}</small>
						@endif
					</div>

					<div class="form-group">
						<input name="invoice_number" type="text" class="form-control"
							id="invoice-number" placeholder="Invoice Number"
							disabled="disabled" value="{{$invoice_number}}"> @if($errors &&
						$errors->has('invoice_number')) <small id="emailHelp"
							class="form-text text-danger">{{$errors->first('invoice_number')}}</small>
						@endif
					</div>

					<div class="form-group">
						<input name="amount" type="text" class="form-control" id="amount"
							placeholder="Amount To Pay" required value="{{$amount}}"
							disabled="disabled"> @if($errors && $errors->has('amount')) <small
							id="emailHelp" class="form-text text-danger">{{$errors->first('amount')}}</small>
						@endif
					</div>

					<div class="row">
						<div class="col">
							<div class="alert alert-danger" id="details-error-container"
								role="alert" style="display: none">
								<span id="details-error-message"></span>
							</div>
						</div>
					</div>

					<button role="button" id="confirm-details"
						class="btn btn-primary doorder-btn-lg doorder-btn submit_button_custom mt-3">Confirm
						& Proceed to payment</button>
				</div>

				<div id="payment-section" style="display: none;">
					<h3 class="titles_custom">Card details</h3>

					<div class="form-group">
						<!--<input type="text" name="card_number" class="form-control" id="card_number" placeholder="Card Number" minlength="16" maxlength="16" size="16" required>-->
						<div id="card-number"></div>
						@if($errors && $errors->has('card_number')) <small id="emailHelp"
							class="form-text text-danger">{{$errors->first('card_number')}}</small>
						@endif
					</div>

					<div class="form-group">
						<div class="row">
							<!--<div class="col-sm-3">
                            <input type="number" name="exp_month" class="form-control" id="mm" placeholder="MM" required
                                minlength="2" maxlength="2" size="2">
                        </div>
                        <div class="col-sm-3">
                            <input type="number" name="exp_year" class="form-control" id="yy" placeholder="YY" required
                                minlength="2" maxlength="2" size="2">
                        </div>-->
							<div class="col-sm-6">
								<div id="card-expiry"></div>
							</div>
							<div class="col-sm-3">
								<!--<input type="number" name="cvc" class="form-control" id="cvc" placeholder="CVC" required
                                minlength="3" maxlength="4" size="4">-->
								<div id="card-cvc"></div>
							</div>

							<div class="col-sm-3 offset-sm-0 col-8 offset-2">
								<img src="{{asset('images/stripelogo.png')}}" class="img-fluid"
									alt="Powered By Stripe">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<div class="alert alert-danger" id="error-container" role="alert"
								style="display: none">
								<span id="message"></span>
							</div>
							<div class="alert alert-success" id="success-container"
								role="alert" style="display: none">
								<span id="success-message"></span>
							</div>
						</div>
					</div>

					<button role="button" id="confirm-payment"
						class="btn btn-primary doorder-btn-lg doorder-btn submit_button_custom">Pay</button>
				</div>
				<!--</form>-->
			</div>
		</div>
	</div>
</body>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"
	integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
	crossorigin="anonymous"></script>

<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script type="text/javascript">
    let clientSecret = null;
    let elements = null;
    let savedErrors = {};
    let error_container = $('#error-container');
    let error_message = $('#error-container #message');
    let cardNumber = null;
    let cardExpiry = null;
    let cardCvc = null;

    $(document).ready(function () {
        let stripe = Stripe('{{env('STRIPE_KEY')}}');
        elements = stripe.elements({

        });

        $('#confirm-details').on('click',function() {
            let payment_amount_field = $('#amount');
            let amount_value = payment_amount_field.val();
            let invoice_number = $('#invoice-number').val();
            let customer_name = $('#customer-name').val();
            $('#details-error-container').hide().html('');
            if(amount_value!=null && amount_value !=''
                && invoice_number!=null && invoice_number!=''
                && customer_name!=null && customer_name!='') {
                payment_amount_field.addClass('success');
                payment_amount_field.removeClass('error');
                $(this).attr('disabled','disabled');
                let button_original_text = $(this).html();
                $(this).html('<span class="spinner-border spinner-border-sm"></span>'
                    + '&nbsp;&nbsp;Confirming');
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    url: '{{url('customer-payment-details')}}',
                    data: {
                        amount: amount_value,
                        invoice_number: invoice_number,
                        customer_name: customer_name
                    },
                    dataType: 'json',
                    method: 'POST',
                    success: function (resp) {
                        if(resp.error == 1){
                            console.log("Unable to set the Stripe payment intent!<br/> Details: "+resp.error_message);
                            $('#details-error-container').show();
                            $('#details-error-message').html("Unable to set the confirm the details, error: "+resp.error_message);
                            $('#confirm-details').removeAttr('disabled').html(button_original_text);
                        } else {
                            clientSecret = resp.client_secret;
                            //console.log(clientSecret);
                            $('#confirm-details').hide();
                            initializePaymentForm();
                        }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        console.log("Unable to set the Stripe payment intent!<br/>" + "Status: " + textStatus + "<br/>" + "Error: " + errorThrown);
                        $('#details-error-container').show();
                        $('#details-error-message').html("Unable to set the confirm the details, error: "+errorThrown);
                        $('#confirm-details').removeAttr('disabled').html(button_original_text);
                    }
                });
            } else {
                payment_amount_field.addClass('error');
                payment_amount_field.removeClass('success');
                $('#details-error-container').show().html('One or more fields are missing');
            }
        });

        $('#confirm-payment').on('click',function() {
            let customer_name = $('#customer-name').val();
            let invoice_number = $('#invoice-number').val();
            $(this).attr('disabled','disabled');
            let button_original_text = $(this).html();
            $(this).html('<span class="spinner-border spinner-border-sm"></span>'
                + '&nbsp;&nbsp;Processing payment');
            error_container.hide();
            error_message.html('');
            stripe.confirmCardPayment(clientSecret, {
                payment_method: {
                    card: cardNumber,
                    billing_details: {
                        name: customer_name
                    },
                    metadata: {
                        "invoice_number": invoice_number
                    }
                }
            }).then(function(result) {
                if (result.error) {
                    // Show error to your customer (e.g., insufficient funds)
                    console.log(result.error.message);
                    error_container.show();
                    error_message.html(result.error.message);
                    $('#confirm-payment').removeAttr('disabled').html(button_original_text);
                } else {
                    console.log(result);
                    // The payment has been processed!
                    if (result.paymentIntent.status === 'succeeded') {
                        console.log('success');
                        $('#success-container').show();
                        $('#success-message').html('The payment has been processed successfully')
                        $('#confirm-payment').html('Payment succeeded!');
                        // Show a success message to your customer
                        // There's a risk of the customer closing the window before callback
                        // execution. Set up a webhook or plugin to listen for the
                        // payment_intent.succeeded event that handles any business critical
                        // post-payment actions.
                    }
                }
            });
        });
    });

    function initializePaymentForm() {
        $('#payment-section').show();
        let elementStyles = {
            base: {
                fontFamily: '-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji"',
                /*fontSize: '16px',
                fontSmoothing: 'antialiased',*/
                fontSize: '1.11rem',
                fontWeight: 400,
                lineHeight: 1.35,
                color: '#495057',

                /*':focus': {
                    color: '#424770',
                },

                '::placeholder': {
                    color: '#9BACC8',
                },

                ':focus::placeholder': {
                    color: '#CFD7DF',
                },*/
            },
            /*invalid: {
                color: '#fff',
                ':focus': {
                    color: '#FA755A',
                },
                '::placeholder': {
                    color: '#FFCCA5',
                },
            },*/
        };

        let elementClasses = {
            base: 'form-control',
            focus: 'form-control focus',
            empty: 'form-control empty',
            invalid: 'form-control invalid',
        };

        cardNumber = elements.create('cardNumber', {
            style: elementStyles,
            classes: elementClasses,
        });
        cardNumber.mount('#card-number');

        cardExpiry = elements.create('cardExpiry', {
            style: elementStyles,
            classes: elementClasses,
        });
        cardExpiry.mount('#card-expiry');

        cardCvc = elements.create('cardCvc', {
            style: elementStyles,
            classes: elementClasses,
        });
        cardCvc.mount('#card-cvc');
        let the_stripe_elements = [cardNumber,cardExpiry,cardCvc];
        // Listen for errors from each Element, and show error messages in the UI.
        the_stripe_elements.forEach(function(element, idx) {
            element.on('change', function(event) {
                if (event.error) {
                    error_container.show();
                    savedErrors[idx] = event.error.message;
                    error_message.html(event.error.message);
                    $('#confirm-payment').attr('disabled','disabled');
                } else {
                    savedErrors[idx] = null;
                    $('#confirm-payment').attr('disabled','disabled');
                    // Loop over the saved errors and find the first one, if any.
                    let nextError = Object.keys(savedErrors)
                        .sort()
                        .reduce(function(maybeFoundError, key) {
                            return maybeFoundError || savedErrors[key];
                        }, null);

                    if (nextError) {
                        // Now that they've fixed the current error, show another one.
                        error_message.html(nextError);
                    } else {
                        // The user fixed the last error; no more errors.
                        error_container.hide();
                        $('#confirm-payment').removeAttr('disabled');
                    }
                }
            });
        });
    }
    /*let $form = $("#payment-form");
    function submitToStripe(e) {
        e.preventDefault();
        // console.log($form);
        Stripe.setPublishableKey('{{env('STRIPE_KEY')}}');
        Stripe.createToken({
            number: $('#card_number').val(),
            cvc: $('#cvc').val(),
            exp_month: $('#mm').val(),
            exp_year: $('#yy').val()
        }, stripeResponseHandler);
        return false;
    }

    function stripeResponseHandler(status, response) {
        if (response.error) {
            // $('.error')
            //     .removeClass('hide')
            //     .find('.alert')
            //     .text(response.error.message);
            alert(response.error.message);
        } else {
            // token contains id, last4, and card type
            // alert(response['id']);
            let token = response['id'];
            // insert the token into the form so it gets submitted to the server
            // $form.find('input[type=text]').empty();
            $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
            // $('stripeToken').val = token;

            $form.get(0).submit();
        }
    }*/

</script>
</html>
