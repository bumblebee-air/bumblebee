@extends('templates.dashboard')
@section('page-styles')
<style>
    .main-panel>.content {
        margin-top: 0;
    }

    h3 {
        margin-top: 0;
        margin-bottom: 25px;
        font-weight: bold;
    }

    div.card-btns {
        margin: 0 15px 10px;
        padding: 0;
        padding-top: 10px;
    }
</style>
@endsection
@section('page-content')
<div class="content">
    <div class="container-fluid">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header card-header-rose card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">account_box</i>
                    </div>
                    <h4 class="card-title">Add Customer</h4>
                </div>
                <form id="customer-form" action="{{url('customer')}}" method="post">
                    <div class="card-body ">
                        {{ csrf_field() }}
                        <input type="hidden" name="client_id" value="{{$client->id}}">
                        <div class="form-group bmd-form-group">
                            <label for="phone_number">Phone number *</label>
                            <input name="phone_number" type="text" class="form-control" id="phone_number" placeholder="Enter phone number" value="{{ old('phone_number') }}" required>
                        </div>

                        <div class="form-group bmd-form-group">
                            <label for="email">Email</label>
                            <input name="email" type="text" class="form-control" id="email" placeholder="Enter email address" value="{{ old('email') }}">
                        </div>

                        <div class="form-group bmd-form-group">
                            <label for="first_name">First name</label>
                            <input name="first_name" type="text" class="form-control" id="first_name" placeholder="Enter first name">
                        </div>

                        <div class="form-group bmd-form-group">
                            <label for="last_name">Last name</label>
                            <input name="last_name" type="text" class="form-control" id="last_name" placeholder="Enter last name">
                        </div>

                        <div class="form-group bmd-form-group">
                            <label for="sending_channel">Registration form sending channel *</label>
                            <select id="sending_channel" name="sending_channel" class="form-control selectpicker" required>
                                <option value="">Select channel</option>
                                <option value="sms" {{ old('sending_channel') == 'sms' ? 'selected' : '' }}>SMS</option>
                                <option value="email" {{ old('sending_channel') == 'email' ? 'selected' : '' }}>EMAIL</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-btns">
                        <button type="submit" id="addCustomer" class="btn btn-fill btn-rose">Add</button>
                        <a href="{{ url('/') }}" class="btn">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-scripts')
<script src="{{ asset('js/bootstrap-selectpicker.js') }}"></script>
<script type="text/javascript">
    
</script>
@endsection