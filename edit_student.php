<?php
include(__DIR__ . "/partials/head.php");
?>
<div class="wrapper">
	<?php
	include(__DIR__ . "/partials/header.php");
	include(__DIR__ . "/partials/sidebar.php");
	?>
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0">Update Form</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="#">Home</a></li>
							<li class="breadcrumb-item active">Edit Student</li>
						</ol>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.container-fluid -->
		</div>
		<!-- /.content-header -->

		<!-- Main content -->
		<div class="content">
			<div class="container-fluid">
				<div class="px-2">
					<div class="d-flex justify-content-end mb-3">
						<a class="btn-sm" href="student.php">
							Back
							<i class="fas fa-solid fa-arrow-left ml-2 text-center"></i>
						</a>

					</div>
				</div>
				<form id="update-form">
					<div class="row mb-3">
						<label for="firstname" class="col-sm-1 col-form-label">Firstname</label>
						<div class="col-sm-11">
							<input type="text" class="form-control" id="firstname" name="firstname" required>
						</div>
					</div>
					<div class="row mb-3">
						<label for="middlename" class="col-sm-1 col-form-label">Middlname</label>
						<div class="col-sm-11">
							<input type="text" class="form-control" id="middlename" name="middlename" required>
						</div>
					</div>
					<div class="row mb-3">
						<label for="lastname" class="col-sm-1 col-form-label">Lastname</label>
						<div class="col-sm-11">
							<input type="text" class="form-control" id="lastname" name="lastname" required>
						</div>
					</div>
					<div class="row mb-3">
						<label for="gender" class="col-sm-1 col-form-label">Gender</label>
						<div class="col-sm-11">
							<select class="form-control" name="gender" id="gender">
								<option value="male">Male</option>
								<option value="female">Female</option>
							</select>
						</div>
					</div>
					<div class="row mb-3">
						<label for="birthday" class="col-sm-1 col-form-label">Birthday</label>
						<div class="col-sm-11">
							<input type="date" class="form-control" id="birthday" required>
						</div>
					</div>
					<div class="row mb-3">
						<label for="contactNumber" class="col-sm-1 col-form-label">Contact No.</label>
						<div class="col-sm-11">
							<input type="text" class="form-control" id="contactNumber" name="contactNumber" maxlength="11" required>
						</div>
					</div>
					<div class="row mb-3">
						<label for="email" class="col-sm-1 col-form-label">Email</label>
						<div class="col-sm-11">
							<input type="email" class="form-control" id="email" name="email" required>
						</div>
					</div>
					<div class="row mb-3">
						<label for="province" class="col-sm-1 col-form-label">Province</label>
						<div class="col-sm-11">

							<select class="form-control" id="province" name="province" required>
								<option value="default">Select Province</option>
								<option value="Davao Oriental">Davao Oriental</option>
								<option value="Davao De Oro">Davao De Oro</option>
							</select>
						</div>
					</div>
					<div class="row mb-3">
						<label for="municipality" class="col-sm-1 col-form-label">Municipality</label>
						<div class="col-sm-11">
							<select class="form-control" id="municipality" name="municipality" required>
								<option value="default">Select Municipality</option>
							</select>
						</div>
					</div>
					<div class="row mb-3">
						<label for="barangay" class="col-sm-1 col-form-label">Barangay</label>
						<div class="col-sm-11">
							<select class="form-control" id="barangay" name="barangay" required>
								<option value="default">Select Barangay</option>
							</select>
						</div>
					</div>
					<div class="row mb-3">
						<label for="street" class="col-sm-1 col-form-label">Street</label>
						<div class="col-sm-11">
							<input type="street" class="form-control" id="street" name="street" required>
						</div>
					</div>
					<div class="row mb-3">
						<label for="zip_code" class="col-sm-1 col-form-label">Zip Code</label>
						<div class="col-sm-11">
							<input type="zip_code" class="form-control" id="zip_code" name="zip_code" required>
						</div>
					</div>
					<div class="row mb-1">
						<label for="institute" class="col-sm-1 col-form-label">Institute</label>
						<div class="col-sm-11">

							<select class="form-control" id="institute" required>
								<option value="default">Select institute</option>
							</select>
						</div>
					</div>
					<div class="row mb-3">
						<label for="course" class="col-sm-1 col-form-label">Course</label>
						<div class="col-sm-11">
							<select id="course" class="form-control">
								<option value="default">Select course</option>
							</select>
						</div>
					</div>
					<h4>Emergency Contact:</h4>
					<div class="row mb-3">
						<label for="guardian_fullname" class="col-sm-1 col-form-label">Fullname</label>
						<div class="col-sm-11">
							<input type="guardian_fullname" class="form-control" id="guardian_fullname" name="guardian_fullname" required>
						</div>
					</div>
					<div class="row mb-3">
						<label for="guardian_contact" class="col-sm-1 col-form-label">Contact No.</label>
						<div class="col-sm-11">
							<input type="text" class="form-control" id="guardian_contact" required>
						</div>
					</div>
					<div class="row mb-3">
						<label for="guardian_address" class="col-sm-1 col-form-label">Address</label>
						<div class="col-sm-11">
							<input type="text" class="form-control" id="guardian_address" required>
						</div>
					</div>
					<button type="submit" class="btn btn-sm btn-primary mb-3" id="submit">Update Info</button>
				</form>
			</div>
		</div>
	</div>
	<!-- /.col-md-6 -->
</div>
<script>
	$(function() {
		const provincesData = {
			"Davao Oriental": {
				municipalities: ["Lupon", "Banaybanay", "Mati", "San Isidro"],
				barangays: {
					Lupon: ["Poblacion", "Corporacion", "Ilangay", "Limbahan", "Bagumbayan"],
					Mati: ["Poblacion", "Matiao", "Dahican", "Libudon", "Dawan"],
					Banaybanay: ["Poblacion", "Rang Ay", "Mogbongcogon", "Caganganan"],
					"San Isidro": ["Bato-bato", "Manikling", "Dugmanon", "La Union"]
				}
			},
			"Davao De Oro": {
				municipalities: ["Municipality1", "Municipality2", "Municipality3"],
				barangays: {
					Municipality1: ["Barangay1", "Barangay2", "Barangay3"],
					Municipality2: ["Barangay4", "Barangay5", "Barangay6"],
					Municipality3: ["Barangay7", "Barangay8", "Barangay9"]
				}
			},
			// Add more provinces as needed
		};

		$("#province").on('change', function() {
			const selectedProvince = $(this).val();

			if (selectedProvince == "default") {
				$('#municipality').empty();
			} else {
				const selectedProvinceData = provincesData[selectedProvince];

				if (selectedProvinceData) {
					// Populate municipalities
					$('#municipality').empty();
					for (const municipality of selectedProvinceData.municipalities) {
						$("#municipality").append('<option value="' + municipality + '">' + municipality + '</option>');
					}

					// Populate barangays based on the first municipality
					const selectedMunicipality = selectedProvinceData.municipalities[0];
					populateBarangays(selectedProvince, selectedMunicipality);
				}
			}
		});

		// Function to populate barangays
		function populateBarangays(province, municipality) {
			const selectedProvinceData = provincesData[province];
			const barangays = selectedProvinceData.barangays[municipality];

			$('#barangay').empty();
			for (const barangay of barangays) {
				$("#barangay").append('<option value="' + barangay + '">' + barangay + '</option>');
			}
		}

		// Call the populateBarangays function when the municipality changes
		$("#municipality").on('change', function() {
			const selectedProvince = $("#province").val();
			const selectedMunicipality = $(this).val();
			populateBarangays(selectedProvince, selectedMunicipality);
		});

		$.ajax({
			type: "GET",
			url: `./php/controller/admin/institute.php`,
			success: function(res) {
				console.log(res);
				res.data.map((data) => {
					$("#institute").append(`<option value="${data.slug}">${data.slug}</option>`);
				});
			},
			error: handleError,
		});

		$('#institute').on('change', function() {
			const slug = $(this).val();

			if (slug == "default") {
				// Clear existing options
				$('#course').empty();
			} else {
				$.ajax({
					url: './php/controller/admin/course.php?action=course_institute',
					type: "GET",
					data: {
						institute: slug
					},
					success: function(res) {

						// Clear existing options
						$('#course').empty();
						res.data.map((course) => {
							$("#course").append('<option value="' + course.slug + '">' + course.slug + '</option>');
						})
					}
				})
			}
		})

		// Function to get URL parameters
		function getUrlParameter(name) {
			name = name.replace(/[[]/, '\\[').replace(/[\]]/, '\\]');
			var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
			var results = regex.exec(location.search);
			return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
		}

		// Get the student ID from the URL parameter
		const studentId = getUrlParameter('id');

		const url = `./php/controller/admin/student.php?id=${studentId}`;
		$.ajax({
			type: "GET",
			url: url,
			success: function(res) {
				$("#firstname").val(res.first_name);
				$("#middlename").val(res.middle_name);
				$("#lastname").val(res.last_name);
				$("#birthday").val(res.birthday);
				$("#contactNumber").val(res.contact_number);
				$("#email").val(res.email);
				$("#course").val(res.course);
				$("#institute").val(res.institute);
				$("#street").val(res.street);
				$("#barangay").val(res.barangay);
				$("#municipality").val(res.municipality);
				$("#province").val(res.province);
				$("#zip_code").val(res.zipcode);
				$("#guardian_fullname").val(res.guardian_name);
				$("#guardian_contact").val(res.guardian_contact);
				$("#guardian_address").val(res.guardian_address);
			},
			error: handleError,
		});

		$("#update-form").on("submit", function(e) {
			e.preventDefault();

			//gather form data
			const formData = {
				firstname: $("#firstname").val().trim(),
				lastname: $("#lastname").val().trim(),
				middlename: $("#middlename").val().trim(),
				email: $("#email").val().trim(),
				gender: $("#gender").val(),
				birthday: $("#birthday").val(),
				contact: $("#contactNumber").val().trim(),
				course: $("#course").val().trim(),
				institute: $("#institute").val().trim(),
				street: $("#street").val().trim(),
				barangay: $("#barangay").val().trim(),
				municipality: $("#municipality").val().trim(),
				province: $("#province").val().trim(),
				zipcode: $("#zip_code").val().trim(),
				guardian_name: $("#guardian_fullname").val().trim(),
				guardian_address: $("#guardian_address").val().trim(),
				guardian_contact: $("#guardian_contact").val().trim()
			};


			const url = `./php/controller/admin/student.php?id=${studentId}`;
			$.ajax({
				type: "PATCH",
				url: url,
				contentType: "application/json",
				data: JSON.stringify(formData),
				success: function(res) {
					showToast("success", "Update successfull");
				},
				error: handleError,
			});
		});
		// Success handler
		function handleSuccess(res) {


			if (res.success == true) {
				showToast("success", "Registered successfully!");
			} else if (res.success == false) {
				showToast("error", res.message);
			}
		}
		// Error Handler
		function handleError(err) {
			console.log(err);
		}

		function showToast(icon, title) {
			Toast.fire({
				icon: icon,
				title: title,
			});
		}

	});
</script>



<?php
include(__DIR__ . "/partials/foot.php");
?>