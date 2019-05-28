@extends('templates.aviva')

@section('page-styles')
@endsection
@section('page-content')
    <div class="row align-items-center">
        <div class="col-sm">
            <h3 style="color: #12a0c1; border-bottom: 1px solid #12a0c1;">New OBD to vehicle connection</h3>
            <form method="POST" action="{{url('obd-to-vehicle/add')}}">
                {{ csrf_field() }}
                <div class="form-label-group">
                    <label for="obd-id" class="control-label">OBD</label>
                    <select id="obd-id" class="form-control" name="obd_id" required>
                        <option value=""></option>
                        @foreach($obd_devices as $obd)
                            <option value="{{$obd->id}}">{{$obd->the_id}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-label-group">
                    <label for="vehicle-id" class="control-label">Vehicle</label>
                    <select id="vehicle-id" class="form-control" name="vehicle_id" required>
                        <option value=""></option>
                        @foreach($vehicles as $vehicle)
                            <option value="{{$vehicle->id}}">{{$vehicle->vehicle_reg}}</option>
                        @endforeach
                    </select>
                </div>
                <br/>
                <button class="btn btn-lg text-uppercase" style="background-color: #ebbd1d; color: #FFF;
                    padding-left: 30px; padding-right: 30px;" type="submit">Submit</button>
            </form>
        </div>
        <div class="col-sm">
            <div id="connection-status">
            </div>
        </div>
    </div>
@endsection
@section('page-scripts')
    <script type="text/javascript">

    </script>
@endsection
