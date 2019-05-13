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
                    @foreach($fleet_members as $fleet_member)
                        <tr>
                            <td>{{$fleet_member->the_user->name}}</td>
                            <td>
                                <a href="{{url('health-check/send')}}/{{$fleet_member->id}}">Send health check</a>
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
