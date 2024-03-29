@extends('templates.main')

@section('page-styles')
@endsection
@section('page-content')
    <div class="row">
        <div class="col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 mx-auto">
            <div class="card card-signin my-1">
                <div class="card-body">
                    <h1>{{$title}}</h1>
                    <p>{{isset($text)? $text : ''}}</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            let logo_rep = '{{$logo}}';
            if(logo_rep!=null && logo_rep!=''){
                $('.navbar #page-logo').attr('src',logo_rep);
            }
            let favicon_rep = '{{$favicon}}';
            if(favicon_rep!=null && favicon_rep!=''){
                $('#page-favicon').attr('href',favicon_rep);
            }
        });
    </script>
@endsection