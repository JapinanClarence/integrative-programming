<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
	<!-- Brand Logo -->
	<a href="#" class="brand-link">
		<img src="./asset/img/time.png" alt="" class="brand-image img-circle">
		<span class="brand-text font-weight-light">ITPE130 Web System</span>
	</a>

	<!-- Sidebar -->
	<div class="sidebar">
		<!-- Sidebar user panel (optional) -->
		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
			<div class="image">
				<img src="./asset/img/user-profile.png" class="img-circle elevation-2" alt="User Image">
			</div>
			<div class="info">
				<a id="user-profile" href="#" class="d-block">Admin</a>
			</div>
		</div>
		<!-- Sidebar Menu -->
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				<li class="nav-item">
					<a href="index.php" class="nav-link">
						<i class="nav-icon fas fa-tachometer-alt"></i>
						<p>
							Dashboard
						</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="faculty.php" class="nav-link">
						<i class="nav-icon fas fa-solid fa-user"></i>
						<p>
							Faculty
						</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="student.php" class="nav-link">
						<i class="nav-icon fas fa-solid fa-user-graduate"></i>
						<p>
							Student
						</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="subjects.php" class="nav-link">
						<i class="nav-icon fas fa-solid fa-book"></i>
						<p>
							Subjects
						</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="course.php" class="nav-link">
						<i class="nav-icon fas fa-solid fa-graduation-cap"></i>
						<p>
							Course
						</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="institute.php" class="nav-link">
						<i class="nav-icon fas fa-solid fa-building"></i>
						<p>
							Institute
						</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="school_year.php" class="nav-link">
						<i class="nav-icon fas fa-solid fa-calendar"></i>
						<p>
							School Year
						</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="grade.php" class="nav-link">
						<i class="nav-icon fas fa-solid fa-chart-line"></i>
						<p>
							Grade
						</p>
					</a>
				</li>
			</ul>
		</nav>

	</div>
	<div class="border-top border-secondary" style="position: fixed; bottom:0px;">
		<a href="#" class="nav-link text-light logout-link">
			<i class="nav-icon fas fa-sign-out-alt "></i>
			Logout
		</a>
	</div>
	<!-- /.sidebar -->
</aside>

<script src="./asset/plugins/jquery/jquery.min.js"></script>
<script>
	$(document).ready(function() {
		// Get the current page URL
		var currentUrl = window.location.href;

		// Loop through each navigation link
		$('.nav-link').each(function() {
			// Get the href attribute of the link
			var linkUrl = $(this).attr('href');

			// Check if the current URL contains the link URL
			if (currentUrl.includes(linkUrl)) {
				// Add the 'active' class to the current navigation link
				$(this).addClass('active');
			}
		});

		// Logout function
		$(".logout-link").on("click", function(e) {
			e.preventDefault();

			// Add a confirmation before logging out
			Swal.fire({
				title: "Are you sure?",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: "Logout"
			}).then((result) => {
				if (result.isConfirmed) {
					// Check if "user" key exists in localStorage
					if (localStorage.getItem("user")) {
						// Remove the "user" key from localStorage
						localStorage.removeItem("user");
					}
					// Redirect to the login page
					window.location.href = "login.php";
				}
			});
		});


		// const username = JSON.parse(localStorage.user);
		// $("#user-profile").text(username.username);

	});
</script>