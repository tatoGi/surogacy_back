<!DOCTYPE html>
<html lang="{{ app()->getlocale() }}">


<head>
	@include('website.components.head')
</head>

<body class="fill_bg_n" id="main">


		@include('website.components.header')
	@yield('main')
	@include('website.components.footer')
	@include('website.components.scripts')
	@yield('scripts')

</body>
<!--end::Body-->

</html>
