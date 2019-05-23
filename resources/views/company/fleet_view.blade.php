@extends('templates.aviva')

@section('page-styles')
@endsection
@section('page-content')
    <div class="row align-items-center">
        <div class="col-sm">
            <h3 style="color: #12a0c1; border-bottom: 1px solid #12a0c1;">View fleet</h3>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <td>Name</td>
                        <td>Phone number</td>
                        <td>Actions</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($fleet_members as $fleet_member)
                        <tr>
                            <td>{{$fleet_member->the_user->name}}</td>
                            <td>{{$fleet_member->the_user->phone}}</td>
                            <td>
                                <form method="POST" action="{{url('send/health-check')}}">
                                    {{csrf_field()}}
                                    <input type="hidden" name="user_id" value="{{$fleet_member->the_user->id}}"/>
                                    <button class="btn btn-link" type="submit">Send health check</button>
                                </form>
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
