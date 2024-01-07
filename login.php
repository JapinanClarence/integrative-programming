<?php
include(__DIR__ . "/partials/head.php");
?>
<main class="vh-100 sm d-flex align-items-center bg-body">
	<div class="container">
		<div id="form-container" class="mx-auto card ">
			<div class="card-header py-5" style="background-color: #d3d3d3;">
				<h2 class="text-center font-weight-bold">ITPE130 <span class="font-weight-light">Web System </span><i class="fs-1 fas fa-solid fa-lock" style="color: #1e1e1e;"></i></h2>
			</div>
			<div class="card-body">
				<div class="my-5 mx-5">
					<form id="login-form">
						<div class="row mb-5">
							<label for="email" class="col-sm-2 col-form-label">Email</label>
							<div class="col-sm-10">
								<input type="email" class="form-control" id="email" required>
							</div>
						</div>
						<div class="row mb-5">
							<label for="password" class="col-sm-2 col-form-label">Password</label>
							<div class="col-sm-10">
								<input type="password" class="form-control" id="password" required>
							</div>
							<div>
								<!-- Error message for invalid credentials -->
								<span id="error-message" class="text-xs text-danger"></span>
							</div>
						</div>
						<div class="d-flex justify-content-end">
							<div class="col-sm-10 px-0">
								<!-- Submit button -->
								<button type="submit" class="btn btn-success btn-block">Sign in</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>

	</div>

</main>


<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="./asset/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="./asset/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="./asset/dist/js/adminlte.min.js"></script>
<script>
	$(function() {
		// Check if user is logged in
		function checkLoggedIn() {
			const userData = JSON.parse(localStorage.getItem("user"));

			if (userData) {
				if (userData.role == 1) {
					// Redirect to login page if user data is not found
					window.location.href = "faculty/index.php";
				} else if (userData.role == 2) {
					window.location.href = "student/index.php";
				} else if (userData.role == 0) {
					window.location.href = "index.php";
				}
			}
		}

		// Call the function on page load
		$(document).ready(function() {
			checkLoggedIn();
		});

		let formData;

		$("#login-form").on("submit", function(e) {
			e.preventDefault();

			// Gather form data
			formData = {
				email: $("#email").val().trim(),
				password: $("#password").val().trim(),
			};

			const url = "./php/controller/auth/login.php";
			$.ajax({
				type: "POST",
				url: url,
				data: JSON.stringify(formData),
				contentType: 'application/json',
				success: handleSuccess,
				error: handleError,
			});
		});

		// Success handler
		function handleSuccess(res) {

			if (res.success == true) {
				localStorage.setItem("user", JSON.stringify(res));

				if (res.role == 0) {
					window.location.href = "index.php";
				} else if (res.role == 1) {
					window.location.href = "faculty/index.php";
				} else if (res.role == 2) {
					window.location.href = "student/index.php";
				}

			} else if (res.success == false) {
				// Show error message and retain entered credentials
				$("#error-message").text("Invalid credentials. Please try again.");
				$("#email").val(formData.email);
				$("#password").val(formData.password);
			}
		}

		// Error Handler
		function handleError(err) {
			console.log(err);
		}


	});
</script>

<?php
include(__DIR__ . "/partials/foot.php");
?>