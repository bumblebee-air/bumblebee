 @extends('templates.doom_yoga') @section('title', 'Doom Yoga |
Meditation Library') @section('styles')

<style>
body {
	background-color: grey;
}

#containerPageBackgrundDiv {
	background-image: none !important;
	background-color: grey !important;
}

.main {
	padding-top: 40px !important;
}

.post_wrap {
	width: 100%;
}

.pst {
	width: 100%
}
</style>
@endsection @section('content')

<div class="container-fluid " id="app">

	<div class="mt-4 mt-md-5">
		<div class="h-100 row align-items-center">
			<div class="col-md-12 text-center">
				<a href="{{route('getCustomerAccount','doom-yoga')}}"><img
					src="{{asset('images/doom-yoga/Doomyoga-logo-black.png')}}" width="160"
					style="height: 150px" alt="DoomYoga"></a>
			</div>
		</div>
		<div class="container-fluid">
			<div class="section mt-2 mt-md-3">
				<div class="row">
					<div class="col-md-6">
						<h4 class="accountTitle">Meditation Library</h4>
					</div>
				</div>
				<div class="row mx-0 mb-1">

					

				</div>
			</div>
		</div>
	</div>


</div>
@endsection @section('scripts')

<script type="text/javascript">
            
            $(document).ready(function() {
                
                
                
            });
                
                </script>

@endsection
