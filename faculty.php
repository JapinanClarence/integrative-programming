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
						<h1 class="m-0">Faculty</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="#">Home</a></li>
							<li class="breadcrumb-item active">Faculty</li>
						</ol>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.container-fluid -->
		</div>
		<!-- /.content-header -->

		<!-- Main content -->
		<div class="content">
			<div class="container-fluid">
				<div class="d-flex justify-content-end mb-3">
					<a class="btn-sm btn-info" href="register_faculty.php">
						Register Faculty
					</a>
				</div>
				<div class="table-responsive-sm rounded" style="height: 500px; overflow-y: auto;">
					<table class="table table-light table-striped rounded table-hover ">
						<caption>List of employees</caption>
						<thead class="thead-dark">
							<tr>
								<th scope="col">Fullname</th>
								<th scope="col">Contact No.</th>
								<th scope="col">Email</th>
								<th scope="col">Institute</th>
								<th scope="col">Course</th>
								<th scope="col">Action</th>
							</tr>
						</thead>
						<form id="delete-form">
							<tbody id="table-body">
								<!-- table data -->
								<tr>
									<td scope="col">Fullname</td>
									<td scope="col">Contact No.</td>
									<td scope="col">Email</td>
									<td scope="col">Address</td>
									<td scope="col">Registered At</td>
									<td scope="col">Action</td>
								</tr>
								<tr>
									<td scope="col">Fullname</td>
									<td scope="col">Contact No.</td>
									<td scope="col">Email</td>
									<td scope="col">Address</td>
									<td scope="col">Registered At</td>
									<td scope="col">Action</td>
								</tr>
							</tbody>
						</form>
					</table>
				</div>
			</div>
		</div>
		<!-- /.col-md-6 -->
	</div>
	<!-- /.row -->
</div><!-- /.container-fluid -->
</div>

</div>
<!-- ./wrapper -->

<script>
	$(function() {
		// Initial load of table data
		refreshTable();

		// Function to refresh the table
		function refreshTable() {
			const url = "./php/controller/admin/faculty.php";

			$.ajax({
				type: "GET",
				url: url,
				success: function(res) {

					// Clear existing table rows
					$("#table-body").empty();

					if (res.success) {

						res.data.map((data) => {
							$("#table-body").append(generateRowMarkup(data));
						});
					} else {
						$("#table-body").append(`
                        <tr>
                            <td colspan="6" class="text-center">
                                <p class="card-text">No Registered Faculties!</p>
                            </td>
                        </tr>
                    `);
					}
				},
				error: handleError
			});
		}

		const generateRowMarkup = (data) => {
			const fullname = data.first_name + " " + data.middle_name.charAt(0) + ". " + data.last_name;

			// const registeredDate = formatDateTime(data.created_at);

			return `<tr>
                    <td class="align-middle">${fullname}</td>
                    <td class="align-middle">${data.contact_number}</td>
                    <td class="align-middle">${data.email}</td>
                    <td class="align-middle">${data.institute}</td>
                    <td class="align-middle">${data.course}</td>
                    <td class="align-middle d-flex align-items-center">
                        <a href="edit_faculty.php?id="${data.id}" class="mr-2">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form class="delete-form">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="id" value="${data.id}">
                            <button class="btn delete-btn" type="submit">
                                <i class="fas fa-trash text-danger"></i>
                            </button>
                        </form>
                    </td>
                </tr>`;
		};

		// Success handler
		function handleSuccess(res) {
			const data = JSON.parse(res);

			if (data.success == true) {
				showToast("success", data.message);
			} else if (data.success == false) {
				showToast("error", data.message);
			}
		}

		// Your existing error handler
		function handleError(err) {
			console.log(err);
		}

		function showToast(icon, title) {
			Toast.fire({
				icon: icon,
				title: title,
			});
		}

		//format date time
		function formatDateTime(inputDateTime) {
			// Parse the input datetime string
			const parsedDateTime = new Date(inputDateTime);

			// Extract components of the date and time
			const year = parsedDateTime.getFullYear();
			const month = (parsedDateTime.getMonth() + 1).toString().padStart(2, "0"); // Month is zero-indexed, so add 1
			const day = parsedDateTime.getDate().toString().padStart(2, "0");
			const hours = parsedDateTime.getHours().toString().padStart(2, "0");
			const minutes = parsedDateTime.getMinutes().toString().padStart(2, "0");
			const ampm = parsedDateTime.getHours() >= 12 ? "pm" : "am";

			// Adjust hours for 12-hour format
			const formattedHours = parsedDateTime.getHours() % 12 || 12;

			// Construct the formatted datetime string
			const formattedDateTime = `${month}/${day}/${year} ${formattedHours}:${minutes}${ampm}`;

			return formattedDateTime;
		}

		function formatDate(inputDate) {
			const date = new Date(inputDate);
			const month = (date.getMonth() + 1).toString().padStart(2, '0'); // Month is zero-based
			const day = date.getDate().toString().padStart(2, '0');
			const year = date.getFullYear();

			return `${month}/${day}/${year}`;
		}
	});
</script>

<?php
include(__DIR__ . "/partials/foot.php");
?>