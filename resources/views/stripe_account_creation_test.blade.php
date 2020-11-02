@extends('templates.main')

@section('page-styles')
    <style>
        :root {
            --input-padding-x: 1.5rem;
            --input-padding-y: .75rem;
        }

        body {
            background: #eee;
            /*background: linear-gradient(to right, #0062E6, #33AEFF);*/
        }

        .card-signin {
            border: 0;
            border-radius: 1rem;
            background: #eee;
            /*box-shadow: 0 0.5rem 1rem 0 rgba(0, 0, 0, 0.1);*/
        }

        .card-signin .card-title {
            margin-bottom: 2rem;
            font-weight: 300;
            font-size: 1.5rem;
        }

        .card-signin .card-body {
            padding: 2rem;
            color: #00479d;
        }

        .form-signin {
            width: 100%;
        }

        .form-signin .btn {
            /*font-size: 90%;*/
            border-radius: 5rem;
            /*letter-spacing: .1rem;*/
            font-weight: 700;
            padding: 1rem;
            transition: all 0.2s;
        }

        .form-label-group {
            position: relative;
            margin-bottom: 1rem;
        }

        .form-label-group input {
            height: auto;
            border-radius: 2rem;
        }

        .form-label-group>input,
        .form-label-group>label {
            padding: var(--input-padding-y) var(--input-padding-x);
        }

        .form-label-group>label {
            position: absolute;
            top: 0;
            left: 0;
            display: block;
            width: 100%;
            margin-bottom: 0;
            /* Override default `<label>` margin */
            line-height: 1.5;
            color: #495057;
            border: 1px solid transparent;
            border-radius: .25rem;
            transition: all .1s ease-in-out;
        }

        .form-label-group input::-webkit-input-placeholder {
            color: transparent;
        }

        .form-label-group input:-ms-input-placeholder {
            color: transparent;
        }

        .form-label-group input::-ms-input-placeholder {
            color: transparent;
        }

        .form-label-group input::-moz-placeholder {
            color: transparent;
        }

        .form-label-group input::placeholder {
            color: transparent;
        }

        .form-label-group input:not(:placeholder-shown) {
            padding-top: calc(var(--input-padding-y) + var(--input-padding-y) * (2 / 3));
            padding-bottom: calc(var(--input-padding-y) / 3);
        }

        .form-label-group input:not(:placeholder-shown)~label {
            padding-top: calc(var(--input-padding-y) / 3);
            padding-bottom: calc(var(--input-padding-y) / 3);
            font-size: 12px;
            color: #777;
        }

        .btn-google {
            color: white;
            background-color: #ea4335;
        }

        .btn-facebook {
            color: white;
            background-color: #3b5998;
        }
    </style>
@endsection
@section('page-content')
    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card card-signin my-1">
                <div class="card-body">
                    <form class="form-signin" method="POST" action="{{url('stripe-account-create-test')}}">
                        {{csrf_field()}}

                        <div class="form-label-group">
                            <input id="name" class="form-control" name="name" placeholder="Name" required>
                            <label for="name">Name</label>
                        </div>
                        
                        <div class="form-label-group">
                            <input id="phone" class="form-control" name="phone" placeholder="Phone (International format)" required>
                            <label for="phone">Phone (International format)</label>
                        </div>

                        <div class="form-label-group">
                            <input id="email" class="form-control" name="email" placeholder="Email">
                            <label for="email">Email</label>
                        </div>

                        <div class="form-label-group">
                            <input id="address" class="form-control" name="address" placeholder="Address">
                            <label for="address">Address</label>
                        </div>

                        <button class="btn btn-lg btn-aviva btn-block text-uppercase" type="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-scripts')
@endsection