@extends('templates.audio')

@section('page-styles')
<style>
  #start_button:focus {
    outline: none;
  }
  #transcript {
    font-weight:bold;
    font-size:20px;
  }
</style>
@endsection
@section('page-content')
    <div class="row align-items-center">
        <div class="list-group align-items-center">
		  @foreach ($orders as $order)
			<a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
			<p class="mb-1">From : {{$order['from']}}</p>
			<p class="mb-1">To : {{$order['to']}}</p>
			<small>{{$order['orderno']}}</small>
		  </a>
		  @endforeach
		</div>
    </div>
@endsection
@section('page-scripts')
<script type="text/javascript">
 

</script>
@endsection
