@extends('templates.garden_help')

@section('title', 'GardenHelp | Job Confirmation')

@section('styles')
    <style>
        .delivery-confirmation-title {
            font-size: 18px;
            letter-spacing: 0.99px;
            text-align: center;
            color: #4d4d4d;
            padding-top: 25px;
        }
        .delivery-qrcode-reader {
            /*background-color: red;*/
            width: 100%;
            height: 600px;
        }
        .delivered-title-container {
            font-size: 18px;
            letter-spacing: 0.99px;
            text-align: center;
            color: #4d4d4d;
            padding-top: 30px

        }

        .delivered-image-container {
            padding-top: 30px
        }

        .delivered-image-container img {
            max-width: 100%;
        }

        .delivery-confirmation-logo {
            text-align: center;
            padding-top: 10px;
        }

        .delivery-confirmation-logo img {
            width: 180px;
            height: 110px;
        }
    </style>
@endsection

@section('content')
    <div class="container" id="app">
        @if(!$job->contractor_confirmation_status)
            <div class="row">
                <div class="col-md-12 delivery-confirmation-logo">
                    <img src="{{asset('images/Garden-Help-Logo.png')}}" alt="GardenHelp">
                </div>
                <div class="col-md-12 delivery-confirmation-title">
                    <p>
                        Please Scan the QR
                        <br>
                        Code to Confirm Delivery
                    </p>
                </div>
                <div class="col-md-12">
                    <div class="delivery-qrcode-reader">
                        <qrcode-stream @decode="onDecode"></qrcode-stream>
                    </div>
                    <form id="confirmation_form" action="{{route('postCustomerConfirmationURL')}}" method="post">
                        @csrf
                        <input type="hidden" name="customer_confirmation_code" value="{{ $job->customer_confirmation_code }}">
                        <input type="hidden" name="contractor_confirmation_code" v-model="contractor_confirmation_code">
                    </form>
                </div>
            </div>
        @else
            <div class="row justify-content-center">
                <div class="col-md-12 delivered-title-container">
                    <p>
                        Job #{{$job->id}}
                    </p>
                    <p>
                        Confirmed Successfully!
                    </p>
                </div>
{{--                <div class="col-md-12 delivered-image-container text-center">--}}
{{--                    <img src="{{asset('images/doorder_driver_assets/delivered-successfully.png')}}" alt="confirmed successfully">--}}
{{--                </div>--}}
                <div class="col-md-12 delivered-title-container">
                    Thank you for using GardenHelp, we hope that to use our service in the future
                </div>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://unpkg.com/vue-qrcode-reader/dist/VueQrcodeReader.umd.min.js"></script>
    <script>
        var app = new Vue({
            el: '#app',
            data: {
                contractor_confirmation_code: '',
            },
            methods: {
                onDecode(decodedString) {
                    if (decodedString) {
                        this.contractor_confirmation_code = decodedString;
                        this.timer = setTimeout(() => {
                            $('#confirmation_form').submit()
                        }, 500);
                    }
                },
            }
        });
    </script>
@endsection
