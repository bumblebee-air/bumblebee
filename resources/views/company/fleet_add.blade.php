@extends('templates.aviva')

@section('page-styles')
@endsection
@section('page-content')
    <div class="row align-items-center">
        <div class="col-sm">
            <h3 style="color: #12a0c1; border-bottom: 1px solid #12a0c1;">New Fleet</h3>
            <form method="POST" action="{{url('fleet/add')}}"
                  enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-label-group">
                    <!--<label for="name">Name</label>-->
                    <input id="name" class="form-control" name="name" placeholder="Fleet name*" required>
                </div>
                <br/>
                <h6>Download the template file then upload it with the updated data.
                    <a href="{{ asset('templates/fleet-template.xls') }}?ver=1.0" download>Download template</a></h6>
                <div class="form-label-group">
                    <label for="name">Select updated file</label>
                    <br/>
                    <input class="file-upload" name="fleet_file" type="file"
                           accept=".csv, application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                           required/>
                </div>
                <br/>
                <button class="btn btn-lg text-uppercase" style="background-color: #ebbd1d; color: #FFF;
                    padding-left: 30px; padding-right: 30px;" type="submit">Submit</button>
            </form>
        </div>
        <div class="col-sm"></div>
    </div>
@endsection
@section('page-scripts')
    <script type="text/javascript">

        $(document).ready(function() {

        });
    </script>
@endsection
