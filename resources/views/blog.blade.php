<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title inertia>Post by Me</title>

	<!-- Styles -->
	<style>
		@import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

		.font-poppins {
			font-family: 'Poppins', sans-serif;
		}
	</style>
	<link rel="stylesheet" href="{{ mix('css/app.css') }}">

	<!-- Scripts -->
	@routes
	<script src="{{ mix('js/app.js') }}" defer></script>
	<!-- AlpineJS -->
	<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
	<!-- Font Awesome -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>

</head>

<body class="font-poppins antialiased">
	@inertia

	@env ('local')
	<script src="http://localhost:3000/browser-sync/browser-sync-client.js"></script>
	@endenv
</body>

</html>