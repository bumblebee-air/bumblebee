@extends('templates.dashboard')

@section('page-styles')
@endsection
@section('page-content')
    <div class="content">
        <div class="row align-items-center">
            <div class="col-sm">
                <h2>Import Suppliers</h2>
                <form method="POST" action="{{url('suppliers/import')}}"
                      enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <!--<h6>Download the template file then upload it with the updated data.
                        <a href="{{ asset('templates/fleet-template.xls') }}?ver=1.0" download>Download template</a></h6>-->
                    <div class="form-label-group">
                        <label for="suppliers-file">Select suppliers export file</label>
                        <br/>
                        <input class="file-upload" id="suppliers-file" name="suppliers_file" type="file"
                               accept=".csv, application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                               required/>
                    </div>
                    <br/>
                    <button class="btn btn-primary text-uppercase" type="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('page-scripts')
    <script type="text/javascript">

        $(document).ready(function() {

        });
    </script>
@endsection
