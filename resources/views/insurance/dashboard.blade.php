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
        <div class="col-sm">
            <h3>Invite a customer</h3>
            <form method="POST" action="{{url('insurance/send-invitation')}}">
                {{ csrf_field() }}
                <div class="form-label-group">
                    <label for="name">Name</label>
                    <input id="name" class="form-control" name="name">
                </div>

                <div class="form-label-group">
                    <label for="phone">Phone</label>
                    <input id="phone" class="form-control" name="phone" required>
                </div>
                <br/>
                <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Send</button>
            </form>
        </div>
    </div>
@endsection
@section('page-scripts')
    <script type="text/javascript">

        $(document).ready(function() {

        });
    </script>
@endsection
