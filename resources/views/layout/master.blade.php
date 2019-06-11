<!DOCTYPE html>
<html lang="en">

<head>
	<link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
	<style>
		.invalid-tooltip {
			top: -100%;
			right: 0px;
		}
	</style>
</head>

<body>

	<div class="container">
        @yield('body')

        @yield('footer')
	</div>

	<script src="{{ asset('assets/jquery-3.4.1.min.js') }}"></script>
	<script src="{{ asset('assets/jquery.blockUI.js') }}"></script>
	<script src="{{ asset('assets/popper.min.js') }}"></script>
	<script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
	<script src="{{ asset('assets/sweetalert2.js') }}"></script>

	@yield('javascript')

</body>

</html>
