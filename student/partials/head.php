<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>ITP 130 Web System</title>
	<link rel="shortcut icon" href="./../asset/img/time.png" type="image/x-icon">
	<link rel="stylesheet" href="./../asset/css/style.css">
	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome Icons -->
	<link rel="stylesheet" href="./../asset/plugins/fontawesome-free/css/all.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="./../asset/dist/css/adminlte.min.css">
	<!-- Sweet alert -->
	<script src="./../asset/plugins/sweetalert2/sweetalert2.all.js"></script>
	<link rel="stylesheet" href="./../asset/plugins/sweetalert2/sweetalert2.min.css">

	<!-- REQUIRED SCRIPTS -->

	<!-- jQuery -->
	<script src="./../asset/plugins/jquery/jquery.min.js"></script>
	<!-- Bootstrap 4 -->
	<script src="./../asset/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- AdminLTE App -->
	<script src="./../asset/dist/js/adminlte.min.js"></script>

	<script>
		const Toast = Swal.mixin({
			toast: true,
			position: 'top-end',
			showConfirmButton: false,
			timer: 3000,
			timerProgressBar: true,
			didOpen: (toast) => {
				toast.addEventListener('mouseenter', Swal.stopTimer)
				toast.addEventListener('mouseleave', Swal.resumeTimer)
			}
		})
	</script>

</head>

<body class="hold-transition sidebar-mini">