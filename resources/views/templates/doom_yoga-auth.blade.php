<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
<meta charset="utf-8">
<meta name="viewport"
	content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="">
<meta name="author" content="">

<title>@yield('title', 'Do.OmYoga')</title>

<!-- Styles -->
<link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('css/fontawesome/all.css')}}" rel="stylesheet">
<link href="{{asset('css/main.css')}}" rel="stylesheet">
<link href="{{asset('css/material-dashboard.min.css')}}"
	rel="stylesheet">
<link href="{{asset('css/doom-yoga-styles.css')}}" rel="stylesheet">
<link href="{{asset('css/doom-yoga-butttons-styles.css')}}"
	rel="stylesheet">


<!-- Fonts -->
<link
	href="https://fonts.googleapis.com/css2?family=Arbutus+Slab&display=swap"
	rel="stylesheet">

<!-- favicon -->
<link rel="icon" type="image/jpeg"
	href="{{asset('images/doom-yoga-logo.png')}}">

@yield('page-styles')
</head>

<body>

	<!-- Navigation -->

	<!-- Page Content -->
	<div class="container-fluid h-100 p-0">@include('partials.flash')

		@yield('page-content')</div>

	<!-- Scripts -->
	<script src="{{asset('js/jquery.min.js')}}"></script>
	<script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
	<script src="{{asset('js/popper.min.js')}}"></script>
	<script
		src="{{asset('js/ct-material/bootstrap-material-design.min.js')}}"></script>
	<script src="{{asset('js/jasny-bootstrap.min.js')}}"></script>
	<script src="{{asset('js/moment.min.js')}}"></script>
	<script src="{{asset('js/moment-timezone.min.js')}}"></script>
	<script
		src="{{asset('js/ct-material/perfect-scrollbar.jquery.min.js')}}"></script>
	<script src="{{asset('js/ct-material/material-dashboard.min.js')}}"></script>
	@yield('page-scripts')
</body>
</html>
