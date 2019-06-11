<!DOCTYPE html>
<html lang="en">

<head>
	<link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
	<style>
        html, body { height: 100%; }
    </style>
</head>

<body>

    @yield('body')

	<script src="{{ asset('assets/jquery-3.4.1.min.js') }}"></script>
	<script src="{{ asset('assets/jquery.blockUI.js') }}"></script>
	<script src="{{ asset('assets/popper.min.js') }}"></script>
	<script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
	<script src="{{ asset('assets/sweetalert2.js') }}"></script>

	@yield('javascript')

</body>

</html>
