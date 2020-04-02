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
</style>
@endsection
@section('page-content')
<div class="content">
    <div class="container-fluid">
        <div class="col-md-8">
            <div class="card ">
                <div class="card-header card-header-rose card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">contact_support</i>
                    </div>
                    <h4 class="card-title">Edit Support Type</h4>
                </div>
                <form action="{{url('support-type') . '/' .  $supportType->id }}" method="post">
                    <div class="card-body">
                        {{ method_field('PUT') }}
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{$supportType->id}}" />
                        <div class="form-group bmd-form-group">
                            <label for="name">Name*</label>
                            <input id="name" name="name" type="text" class="form-control" value="{{$supportType->name}}" placeholder="Enter name" required>
                        </div>
                        <div class="form-group bmd-form-group">
                            <label for="serviceType">Service Type</label>
                            <select id="serviceType" name="service_type" class="form-control selectpicker">
                                <option value="">Select Service Type</option>
                                @foreach($serviceTypes as $serviceType)
                                <option value="{{$serviceType->id}}" @if(!empty($supportType->serviceType) &&$supportType->serviceType->id == $serviceType->id) selected @endif
                                    >{{$serviceType->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="card-btns" style="padding: 20px;">
                        <button type="submit" class="btn btn-fill btn-rose">Save</button>
                        <a href="{{ url('support-types') }}" class="btn">Cancel</a>
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