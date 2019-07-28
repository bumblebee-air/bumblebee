@extends('templates.aviva')

@section('page-styles')
@endsection
@section('page-content')
    <div class="row align-items-center">
        <div class="col-sm">
            <h3 style="color: #12a0c1; border-bottom: 1px solid #12a0c1;">View OBD devices</h3>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <td>ID</td>
                        <td>Actions</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($obd_devices as $obd)
                        <tr>
                            <td>{{$obd->the_id}}</td>
                            <td><a class="btn btn-info" href="{{url('obd/edit')}}/{{$obd->id}}">Edit</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <nav aria-label="OBD pagination">
                {{$obd_devices->links('vendor.pagination.bootstrap-4')}}
            </nav>
        </div>
    </div>
@endsection
@section('page-scripts')
@endsection
