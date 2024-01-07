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
						<h1 class="m-0">Registered Faculty</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="#">Home</a></li>
							<li class="breadcrumb-item active">Registered Faculty</li>
						</ol>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.container-fluid -->
		</div>
		<!-- /.content-header -->

		<!-- Main content -->
		<div class="content">
			<div class="container-fluid">
				<div class="table-responsive-sm rounded" style="height: 500px; overflow-y: auto;">
					<table class="table table-light table-striped rounded table-hover ">
						<caption>List of faculties</caption>
						<thead class="thead-dark">
							<tr>
								<th scope="col">Fullname</th>
								<th scope="col">Contact No.</th>
								<th scope="col">Email</th>
								<th scope="col">Institute</th>
								<th scope="col">Course</th>
							</tr>
						</thead>
						<form id="delete-form">
							<tbody id="table-body">
								<!-- table data -->

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

			return `<tr onclick=window.location='faculty_load.php?id=${data.faculty_id}'>
                    <td class="align-middle">${fullname}</td>
                    <td class="align-middle">${data.contact_number}</td>
                    <td class="align-middle">${data.email}</td>
                    <td class="align-middle">${data.institute}</td>
                    <td class="align-middle">${data.course}</td>
                </tr>`;


		};

		// Your existing error handler
		function handleError(err) {
			console.log(err);
		}

	});
</script>

<?php
include(__DIR__ . "/partials/foot.php");
?>