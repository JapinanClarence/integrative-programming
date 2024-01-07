<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
	<!-- Left navbar links -->
	<ul class="navbar-nav">
		<li class="nav-item">
			<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
		</li>
		<li class="nav-item d-none d-sm-inline-block">
			<a href="index.php" class="nav-link">Home</a>
		</li>
	</ul>
</nav>
<script>
	// Check if user is logged in
	function checkLoggedIn() {
		const userData = JSON.parse(localStorage.getItem("user"));


		if (userData) {
			if (userData.role !== 0) {
				window.locataion.href = "login.php";
			}
		} else {
			window.locataion.href = "login.php";
		}

	}
	// Call the function on page load
	$(document).ready(function() {
		checkLoggedIn();
	});
</script>