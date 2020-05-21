@extends('templates.public')

@section('title')
Emergency Settings
@endsection

@section('page-styles')
    <link rel="stylesheet" href="{{asset('css/intlTelInput.css')}}"/>
    <style>
        #submit-button {
            border-radius: 5px;
        }
        div.iti {
            width: 100%;
            color: #000 !important;
        }
        div.iti .iti__selected-dial-code {
            color: #FFF !important;
        }
        body {
            background: url('{{asset('images/mobile-bg.jpg')}}') no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
            color: #FFF;
        }
        .form-group input {
            background-color:rgba(255,255,255,0.6) !important;
        }
        .form-group input,
        .form-group input:hover,
        .form-group input:focus {
            color: #FFF;
        }
        .form-group .form-control::placeholder {
            opacity: 1; /* Firefox */
            color: #FFF;
        }
        .form-group .form-control:-ms-input-placeholder {
            color: #FFF;
        }
        .form-group .form-control::-ms-input-placeholder {
            color: #FFF;
        }
    </style>
@endsection

@section('page-content')
    <div class="row">
        <div class="col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-10 offset-1">
            <div style="margin: 20px 0;"></div>
            <h3 style="text-align: center">In Case Of Emergency</h3>
            <br/><br/>
            <form class="form" action="{{ url('emergency-settings')}}" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="user_id" value="{{$user_id}}" />

                <div class="row justify-content-center">
                    <div class="col-6">
                        <img src="{{asset('images/add_persons_pink_bg_round.svg')}}"
                             class="img-fluid" alt="Add Person"/>
                    </div>
                </div>

                <br/><b/>
                <h5 style="text-align: center">Please enter contact details</h5>
                <br/>

                <div class="form-group">
                    <input id="contact-phone" name="contact_phone" type="text" class="form-control"
                           placeholder="Phone number*"
                           value="{{ ($contact_phone!=null)? $contact_phone : '' }}" required />
                    <p id="contact-phone-intl-output"></p>
                </div>

                <div class="form-group">
                    <input id="contact-name" name="contact_name" type="text" class="form-control"
                           placeholder="Contact person name*"
                           value="{{ ($contact_name!=null)? $contact_name : '' }}" required />
                </div>

                <div id="contact-email-container" class="form-group">
                    <input id="contact-email" name="contact_email" type="email" class="form-control"
                           placeholder="Contact person email"
                           value="{{ ($contact_email!=null)? $contact_email : '' }}" @if($contact_method == 'email') required @endif />
                </div>

                <h6>Contact through</h6>
                <div class="form-check form-check-radio">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" id="contact-method" name="contact_method" value="phone_call"
                            @if($contact_method == 'phone_call') checked @endif required>
                        Phone call
                        <span class="circle">
                            <span class="check"></span>
                        </span>
                    </label>
                </div>
                <div class="form-check form-check-radio">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="contact_method" value="whatsapp"
                           @if($contact_method == 'whatsapp') checked @endif >
                        WhatsApp
                        <span class="circle">
                            <span class="check"></span>
                        </span>
                    </label>
                </div>
                <div class="form-check form-check-radio">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="contact_method" value="sms"
                           @if($contact_method == 'sms') checked @endif >
                        SMS
                        <span class="circle">
                            <span class="check"></span>
                        </span>
                    </label>
                </div>
                <div class="form-check form-check-radio">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="contact_method" value="email"
                               @if($contact_method == 'email') checked @endif >
                        Email
                        <span class="circle">
                            <span class="check"></span>
                        </span>
                    </label>
                </div>

                <div id="add-another-contact-button-container" style=" @if($other_contact!=null) display: none; @endif margin-top: 10px;">
                    <button type="button" class="btn btn-link" style="color: #FFF;"
                        id="add-another-contact-button">
                        <img src="{{asset('images/plus_white_bg_round.svg')}}" style="width: 25px; margin-right: 10px;" alt="Add button"/>
                        Add another contact person</button>
                </div>
                <div id="add-another-contact-container" style=" @if($other_contact==null) display: none; @endif margin-top: 10px;">
                    <br/>
                    <h5 style="text-align: center">Please enter second contact details</h5>
                    <br/>

                    <div class="form-group">
                        <input id="second-contact-phone" name="second_contact_phone" type="text" class="form-control"
                               placeholder="Second Contact Number"
                               value="{{ ($second_contact_phone!=null)? $second_contact_phone : '' }}" />
                        <p id="second-contact-phone-intl-output"></p>
                    </div>

                    <div class="form-group">
                        <input id="second-contact-name" name="second_contact_name" type="text" class="form-control"
                               placeholder="Second Contact Person"
                               value="{{ ($second_contact_name!=null)? $second_contact_name : '' }}" />
                    </div>

                    <div id="second-contact-email-container" class="form-group">
                        <input id="second-contact-email" name="second_contact_email" type="email" class="form-control"
                               placeholder="Second Contact person email"
                               value="{{ ($second_contact_email!=null)? $second_contact_email : '' }}" @if($second_contact_method == 'email') required @endif />
                    </div>

                    <h6>Contact through</h6>
                    <div class="form-check form-check-radio">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="second_contact_method" value="phone_call"
                                   @if($second_contact_method == 'phone_call') checked @endif id="second-contact-method">
                            Phone call
                            <span class="circle">
                            <span class="check"></span>
                        </span>
                        </label>
                    </div>
                    <div class="form-check form-check-radio">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="second_contact_method" value="whatsapp"
                                   @if($second_contact_method == 'whatsapp') checked @endif >
                            WhatsApp
                            <span class="circle">
                            <span class="check"></span>
                        </span>
                        </label>
                    </div>
                    <div class="form-check form-check-radio">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="second_contact_method" value="sms"
                                   @if($second_contact_method == 'sms') checked @endif >
                            SMS
                            <span class="circle">
                            <span class="check"></span>
                        </span>
                        </label>
                    </div>
                    <div class="form-check form-check-radio">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="second_contact_method" value="email"
                                   @if($second_contact_method == 'email') checked @endif >
                            Email
                            <span class="circle">
                            <span class="check"></span>
                        </span>
                        </label>
                    </div>
                </div>

                <div class="text-center" style="margin-top: 20px;">
                    <button type="submit" id="submit-button" class="btn btn-block btn-primary">Save</button>
                </div>
            </form>
            <div style="margin: 20px 0;"></div>
        </div>
    </div>
@endsection

@section('page-scripts')
    <script src="{{ asset('js/bootstrap-selectpicker.js') }}"></script>
    <script src="{{ asset('js/jquery.matchHeight.js') }}" type="text/javascript"></script>
    <script src="{{asset('js/intlTelInput/intlTelInput.js')}}"></script>
    <script type="text/javascript">
        function initializeFirstContactField(){
            let contact_phone = document.querySelector("#contact-phone");
            contact_phone = window.intlTelInput(contact_phone, {
                hiddenInput: 'contact_phone_international',
                initialCountry: 'IE',
                separateDialCode: true,
                preferredCountries: ['IE', 'GB'],
                utilsScript: "{{asset('js/intlTelInput/utils.js')}}"
            });
            let contact_phone_jq = $('#contact-phone');
            let contact_phone_intl_output = $('#contact-phone-intl-output');
            contact_phone_jq.on("keyup change", function() {
                let intlNumber = contact_phone.getNumber();
                if (intlNumber) {
                    contact_phone_intl_output.text("International: " + intlNumber);
                } else {
                    contact_phone_intl_output.text("Please enter a number below");
                }
            });
        }
        function initializeSecondContactField(){
            let second_contact_phone = document.querySelector("#second-contact-phone");
            second_contact_phone = window.intlTelInput(second_contact_phone, {
                hiddenInput: 'second_contact_phone_international',
                initialCountry: 'IE',
                separateDialCode: true,
                preferredCountries: ['IE', 'GB']
            });
            let second_contact_phone_jq = $('#second-contact-phone');
            let second_contact_phone_intl_output = $('#second-contact-phone-intl-output');
            second_contact_phone_jq.on("keyup change", function() {
                let intlNumber = second_contact_phone.getNumber();
                if (intlNumber) {
                    second_contact_phone_intl_output.text("International: " + intlNumber);
                } else {
                    second_contact_phone_intl_output.text("Please enter a number below");
                }
            });
        }
        $(document).ready(function(){
            initializeFirstContactField();
            let add_another_contact_container = $('#add-another-contact-container');
            if(add_another_contact_container.is(':visible')){
                initializeSecondContactField();
            }
            $('#add-another-contact-button').on('click', function(e){
                $('#add-another-contact-button-container').hide();
                $('#add-another-contact-container').show();
                initializeSecondContactField();
            });

            $('#second-contact-name,#second-contact-phone').on('change', function(e){
                if($(this).val()!=null && $(this).val()!=''){
                    $('#second-contact-name').attr('required','required');
                    $('#second-contact-phone').attr('required','required');
                    $('#second-contact-method').attr('required','required');
                } else {
                    $('#second-contact-name').removeAttr('required');
                    $('#second-contact-phone').removeAttr('required');
                    $('#second-contact-method').removeAttr('required');
                }
            });

            $('input[name="contact_method"]').on('change', function(){
                let selected_contact_method = $('input[name="contact_method"]:checked').val();
                if(selected_contact_method === 'email'){
                    $('#contact-email').attr('required','required');
                } else {
                    $('#contact-email').removeAttr('required');
                }
            });
            $('input[name="second_contact_method"]').on('change', function(){
                let selected_contact_method = $('input[name="second_contact_method"]:checked').val();
                if(selected_contact_method === 'email'){
                    $('#second-contact-email').attr('required','required');
                } else {
                    $('#second-contact-email').removeAttr('required');
                }
            });
        });
    </script>
@endsection