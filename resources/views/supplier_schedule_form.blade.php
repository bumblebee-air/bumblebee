@extends('templates.public')

@section('title')
Supplier Schedule
@endsection

@section('page-styles')
    <link rel="stylesheet" href="{{asset('css/intlTelInput.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/bootstrap-4-datetimepicker.css')}}"/>
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
        .form-group .form-control datetimepicker-input::placeholder {
            opacity: 1; /* Firefox */
            color: #FFF;
        }
        .form-group .form-control datetimepicker-input:-ms-input-placeholder {
            color: #FFF;
        }
        .form-group .form-control datetimepicker-input::-ms-input-placeholder {
            color: #FFF;
        }
    </style>
@endsection

@section('page-content')
    <div class="row">
        <div class="col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-10 offset-1">
            <div style="margin: 20px 0;"></div>
            @if($supplier!=null)
            <h3 style="text-align: center">Set your schedule</h3>
            <br/>
            <form class="form" action="{{ url('supplier/schedule-form')}}" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="supplier_id" value="{{$supplier->id}}" />

                <!--<div class="row justify-content-center">
                    <div class="col-6">
                        <img src="{{asset('images/add_persons_pink_bg_round.svg')}}"
                             class="img-fluid" alt="Add Person"/>
                    </div>
                </div>-->

                <div class="form-group row">
                    <div class="col-sm-4 col-12">
                        <span class="label">Monday</span>
                    </div>
                    <div class="col-sm-4 col-6">
                        <input id="mon-from" name="mon_from" class="form-control datetimepicker-input"
                            placeholder="From" data-toggle="datetimepicker" data-target="#mon-from"
                            @if($the_supplier_schedule!=null && $the_supplier_schedule->mon[0]!=null)
                               value="{{$the_supplier_schedule->mon[0]}}"
                            @endif/>
                    </div>
                    <div class="col-sm-4 col-6">
                        <input id="mon-to" name="mon_to" class="form-control datetimepicker-input"
                            placeholder="To" data-toggle="datetimepicker" data-target="#mon-to"
                            @if($the_supplier_schedule!=null && $the_supplier_schedule->mon[1]!=null)
                                value="{{$the_supplier_schedule->mon[1]}}"
                            @endif/>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-4 col-12">
                        <span class="label">Tuesday</span>
                    </div>
                    <div class="col-sm-4 col-6">
                        <input id="tue-from" name="tue_from" class="form-control datetimepicker-input"
                            placeholder="From" data-toggle="datetimepicker" data-target="#tue-from"
                            @if($the_supplier_schedule!=null && $the_supplier_schedule->tue[0]!=null)
                                value="{{$the_supplier_schedule->tue[0]}}"
                            @endif/>
                    </div>
                    <div class="col-sm-4 col-6">
                        <input id="tue-to" name="tue_to" class="form-control datetimepicker-input"
                            placeholder="To" data-toggle="datetimepicker" data-target="#tue-to"
                            @if($the_supplier_schedule!=null && $the_supplier_schedule->tue[1]!=null)
                                value="{{$the_supplier_schedule->tue[1]}}"
                            @endif/>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-4 col-12">
                        <span class="label">Wednesday</span>
                    </div>
                    <div class="col-sm-4 col-6">
                        <input id="wed-from" name="wed_from" class="form-control datetimepicker-input"
                            placeholder="From" data-toggle="datetimepicker" data-target="#wed-from"
                            @if($the_supplier_schedule!=null && $the_supplier_schedule->wed[0]!=null)
                                value="{{$the_supplier_schedule->wed[0]}}"
                            @endif/>
                    </div>
                    <div class="col-sm-4 col-6">
                        <input id="wed-to" name="wed_to" class="form-control datetimepicker-input"
                            placeholder="To" data-toggle="datetimepicker" data-target="#wed-to"
                            @if($the_supplier_schedule!=null && $the_supplier_schedule->wed[1]!=null)
                                value="{{$the_supplier_schedule->wed[1]}}"
                            @endif/>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-4 col-12">
                        <span class="label">Thursday</span>
                    </div>
                    <div class="col-sm-4 col-6">
                        <input id="thu-from" name="thu_from" class="form-control datetimepicker-input"
                            placeholder="From" data-toggle="datetimepicker" data-target="#thu-from"
                            @if($the_supplier_schedule!=null && $the_supplier_schedule->thu[0]!=null)
                                value="{{$the_supplier_schedule->thu[0]}}"
                            @endif/>
                    </div>
                    <div class="col-sm-4 col-6">
                        <input id="thu-to" name="thu_to" class="form-control datetimepicker-input"
                            placeholder="To" data-toggle="datetimepicker" data-target="#thu-to"
                            @if($the_supplier_schedule!=null && $the_supplier_schedule->thu[1]!=null)
                                value="{{$the_supplier_schedule->thu[1]}}"
                            @endif/>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-4 col-12">
                        <span class="label">Friday</span>
                    </div>
                    <div class="col-sm-4 col-6">
                        <input id="fri-from" name="fri_from" class="form-control datetimepicker-input"
                            placeholder="From" data-toggle="datetimepicker" data-target="#fri-from"
                            @if($the_supplier_schedule!=null && $the_supplier_schedule->fri[0]!=null)
                                value="{{$the_supplier_schedule->fri[0]}}"
                            @endif/>
                    </div>
                    <div class="col-sm-4 col-6">
                        <input id="fri-to" name="fri_to" class="form-control datetimepicker-input"
                            placeholder="To" data-toggle="datetimepicker" data-target="#fri-to"
                            @if($the_supplier_schedule!=null && $the_supplier_schedule->fri[1]!=null)
                                value="{{$the_supplier_schedule->fri[1]}}"
                            @endif/>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-4 col-12">
                        <span class="label">Saturday</span>
                    </div>
                    <div class="col-sm-4 col-6">
                        <input id="sat-from" name="sat_from" class="form-control datetimepicker-input"
                            placeholder="From" data-toggle="datetimepicker" data-target="#sat-from"
                            @if($the_supplier_schedule!=null && $the_supplier_schedule->sat[0]!=null)
                                value="{{$the_supplier_schedule->sat[0]}}"
                            @endif/>
                    </div>
                    <div class="col-sm-4 col-6">
                        <input id="sat-to" name="sat_to" class="form-control datetimepicker-input"
                            placeholder="To" data-toggle="datetimepicker" data-target="#sat-to"
                            @if($the_supplier_schedule!=null && $the_supplier_schedule->sat[1]!=null)
                                value="{{$the_supplier_schedule->sat[1]}}"
                            @endif/>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-4 col-12">
                        <span class="label">Sunday</span>
                    </div>
                    <div class="col-sm-4 col-6">
                        <input id="sun-from" name="sun_from" class="form-control datetimepicker-input"
                            placeholder="From" data-toggle="datetimepicker" data-target="#sun-from"
                            @if($the_supplier_schedule!=null && $the_supplier_schedule->sun[0]!=null)
                                value="{{$the_supplier_schedule->sun[0]}}"
                            @endif/>
                    </div>
                    <div class="col-sm-4 col-6">
                        <input id="sun-to" name="sun_to" class="form-control datetimepicker-input"
                            placeholder="To" data-toggle="datetimepicker" data-target="#sun-to"
                            @if($the_supplier_schedule!=null && $the_supplier_schedule->sun[1]!=null)
                                value="{{$the_supplier_schedule->sun[1]}}"
                            @endif/>
                    </div>
                </div>

                <div class="text-center" style="margin-top: 20px;">
                    <button type="submit" id="submit-button" class="btn btn-block btn-success">Save</button>
                </div>
            </form>
            @else
                <h3 style="text-align: center">No profile was found for this url,
                    please make sure you are using the correct link sent to you.
                    <br/>If this problem persists, please contact the support.</h3>
            @endif
            <div style="margin: 20px 0;"></div>
        </div>
    </div>
@endsection

@section('page-scripts')
    <script src="{{ asset('js/bootstrap-selectpicker.js') }}"></script>
    <script src="{{ asset('js/bootstrap-4-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('js/jquery.matchHeight.js') }}" type="text/javascript"></script>
    <script src="{{asset('js/intlTelInput/intlTelInput.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#sun-from,#sun-to,#mon-from,#mon-to,#tue-from,#tue-to,#wed-from,#wed-to,#thu-from,#thu-to,#fri-from,#fri-to,#sat-from,#sat-to').each(function(){
                let the_val = $(this).val();
                $(this).datetimepicker({format: 'hh:mm A', date: null});
                if(the_val!=null && the_val!=''){
                    $(this).val(the_val).change();
                }
            });
        });
    </script>
@endsection