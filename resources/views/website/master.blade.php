<!DOCTYPE html>
<html lang="{{ app()->getlocale() }}">


<head>
	@include('website.components.head')
</head>

<body class="fill_bg_n" id="main">


		@include('website.components.header', ['language_slugs' => $language_slugs ?? []])
	@yield('content')
	@include('website.components.footer')
	@include('website.components.scripts')
	@yield('scripts')

	<!-- WhatsApp Chat Button -->
	<a href="https://wa.me/995558000899" class="whatsapp-float" target="_blank" rel="noopener noreferrer">
		<i class="fab fa-whatsapp"></i>
	</a>

	<style>
		.whatsapp-float {
			position: fixed;
			bottom: 20px;
			right: 20px;
			background-color: #25d366;
			color: #FFF;
			width: 60px;
			height: 60px;
			border-radius: 50%;
			text-align: center;
			font-size: 30px;
			box-shadow: 2px 2px 3px rgba(0,0,0,0.2);
			display: flex;
			align-items: center;
			justify-content: center;
			text-decoration: none;
			z-index: 1000;
			transition: all 0.3s ease;
		}
		.whatsapp-float:hover {
			background-color: #128C7E;
			color: #FFF;
			transform: scale(1.1);
		}
	</style>
</body>
<!--end::Body-->

</html>
