@extends('templates.aviva')

@section('page-styles')
@endsection
@section('page-content')
    <div class="row align-items-center">
        <div class="col-sm">
            <h3 style="color: #12a0c1; border-bottom: 1px solid #12a0c1;">View fleets</h3>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr style="color:#FFF; background-color: #12a0c1;">
                        <td>Name</td>
                        <td>Actions</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($fleets as $fleet)
                        <tr>
                            <td>{{$fleet->name}}</td>
                            <td>
                                <a href="{{url('fleet/view')}}/{{$fleet->id}}">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('page-scripts')
@endsection
