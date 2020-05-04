<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Emergency Settings</title>

    <!-- Styles -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/fontawesome/all.css')}}" rel="stylesheet">
    <link href="{{asset('css/main.css')}}" rel="stylesheet">
    <link href="{{asset('css/material-dashboard.min.css')}}" rel="stylesheet">
    @yield('page-styles')
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <style>

    </style>
</head>

<body>
    <!-- Page Content -->
    <div class="wrapper">
        @include('partials.flash')
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="card match-height">
                        <div class="card-header card-header-rose card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">group_add</i>
                            </div>
                            <h4 class="card-title">In Case Of Emergency</h4>
                        </div>
                        <form action="{{ url('emergency-settings')}}" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" name="user_id" value="{{$user_id}}" />

                            <div class="card-body">
                                <div class="form-group bmd-form-group">
                                    <label for="contact-name">Emergency Contact Person*</label>
                                    <input id="contact-name" name="contact_name" type="text" class="form-control"
                                           placeholder="Emergency Contact Person"
                                           value="{{ ($contact_name!=null)? $contact_name : '' }}" required />
                                </div>

                                <div class="form-group bmd-form-group">
                                    <label for="contact-phone">Emergency Contact Number*</label>
                                    <input id="contact-phone" name="contact_phone" type="text" class="form-control"
                                           placeholder="Emergency Contact Number"
                                           value="{{ ($contact_phone!=null)? $contact_phone : '' }}" required />
                                </div>

                                <div class="form-check form-check-radio">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="contact_method" value="phone_call"
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

                                <div id="add-another-contact-button-container">
                                    <button type="button" class="btn btn-link"
                                        id="add-another-contact-button">Add another contact person</button>
                                </div>
                                <div id="add-another-contact-container" style=" @if($other_contact==null) display: none @endif ">
                                    <div class="form-group bmd-form-group">
                                        <label for="second-contact-name">Second Contact Person</label>
                                        <input id="second-contact-name" name="second_contact_name" type="text" class="form-control"
                                               placeholder="Second Contact Person"
                                               value="{{ ($second_contact_name!=null)? $second_contact_name : '' }}" />
                                    </div>

                                    <div class="form-group bmd-form-group">
                                        <label for="second-contact-phone">Second Contact Number</label>
                                        <input id="second-contact-phone" name="second_contact_phone" type="text" class="form-control"
                                               placeholder="Second Contact Number"
                                               value="{{ ($second_contact_phone!=null)? $second_contact_phone : '' }}" />
                                    </div>

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
                                </div>

                            </div>
                            <div class="card-btns text-center" style="padding: 20px;">
                                <button type="submit" class="btn btn-fill btn-rose">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('js/moment.min.js')}}"></script>
    <script src="{{asset('js/moment-timezone.min.js')}}"></script>
    <script src="{{ asset('js/bootstrap-selectpicker.js') }}"></script>
    <script src="{{ asset('js/jquery.matchHeight.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#add-another-contact-button').on('click', function(e){
                $('#add-another-contact-button-container').hide();
                $('#add-another-contact-container').show();
            });

            $('#second-contact-name').on('change', function(e){
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
        });
    </script>
</body>

</html>