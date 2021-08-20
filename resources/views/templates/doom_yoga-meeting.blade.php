<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
<title>@yield('title', 'DoOmYoga')</title>
<!-- favicon -->
<link rel="icon" type="image/jpeg"
	href="{{asset('images/doom-yoga-logo.png')}}">

@yield('page-styles')
</head>

<body>
	@yield('page-content')</div>

	@yield('page-scripts')
</body>
</html>
