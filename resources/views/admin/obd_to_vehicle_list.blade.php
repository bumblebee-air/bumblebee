@extends('templates.aviva')

@section('page-styles')
@endsection
@section('page-content')
    <div class="row align-items-center">
        <div class="col-sm">
            <h3 style="color: #12a0c1; border-bottom: 1px solid #12a0c1;">View OBD to vehicle connections</h3>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <td>OBD</td>
                        <td>Vehicle</td>
                        <td>Actions</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($obd_to_vehicles as $obd_to_vehicle)
                        <tr>
                            <td>{{$obd_to_vehicle->obd->the_id}}</td>
                            <td>{{$obd_to_vehicle->vehicle->vehicle_reg}}</td>
                            <td><a class="btn btn-info" href="{{url('obd-to-vehicle/edit')}}/{{$obd_to_vehicle->id}}">Edit</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <nav aria-label="OBD pagination">
                {{$obd_to_vehicles->links('vendor.pagination.bootstrap-4')}}
            </nav>
        </div>
    </div>
@endsection
@section('page-scripts')
@endsection
