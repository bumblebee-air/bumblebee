@extends('templates.main')

@section('page-styles')
@endsection
@section('page-content')
    <div class="row align-items-center">
        <div class="col-sm">
            <table class="table-bordered">
                <thead>
                    <tr>
                        <td>Name</td>
                        <td>actions</td>
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
