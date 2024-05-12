<?php
session_start();
include 'connection.php';

// Check if the user is authenticated and is an admin
if (!isset($_SESSION['loggedin']) && !isset($_SESSION['email']) && !isset($_SESSION['password']) && $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	
    <meta charset="UTF-8">
    <meta name="viewport" content="wstudent_idth=device-wstudent_idth, initial-scale=1.0">
    <title>Student Records</title>

	<meta http-equiv="Content-Security-Policy" content="
        default-src 'self';
        font-src 'self' https://fonts.gstatic.com;
        style-src 'self' https://stackpath.bootstrapcdn.com https://fonts.googleapis.com 'unsafe-inline';
        script-src 'self' https://code.jquery.com https://stackpath.bootstrapcdn.com https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js;
        connect-src 'self' https://api.example.com;
        img-src 'self' data:;
    ">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container-xl">
	<div class="table-responsive">
		<div class="table-wrapper">
			<div class="table-title">
				<div class="row">
					<div class="col-sm-6">
						<h2>Manage <b>Students</b></h2>
					</div>
					<div class="col-sm-6">
						<a href="logout.php" class="btn btn-danger"><i class="material-icons">&#xE147;</i> <span>Logout</span></a>	
						<a href="add.php" class="btn btn-success"><i class="material-icons">&#xE147;</i> <span>Add New Employee</span></a>
															
					</div>
				</div>
			</div>
			<table class="table table-striped table-hover">
				<thead>
					<tr>
                        <th>Name</th>
                        <th>Matric No</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Phone</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<tr>
                    <?php
                $sql = "SELECT * FROM student_records";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . $row['matric_no'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['address'] . "</td>";
                        echo "<td>" . $row['phone'] . "</td>";
						echo '<td>';
						$student_id = $row['student_id'];
						echo '<a href="admin_edit.php?student_id=' . $student_id . '" class="edit"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>';
						echo '<a href="delete.php?student_id='. $student_id . '" class="delete"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>';
						echo '</td>';
						echo "</tr>";
              		}
				}	 
				else {
                    echo "<tr><td colspan='5'>No records found</td></tr>";
                }
                ?>
                    </tr>
				</tbody>
			</table>
			<!-- <div class="clearfix">
				<div class="hint-text">Showing <b>5</b> out of <b>25</b> entries</div>
				<ul class="pagination">
					<li class="page-item disabled"><a href="#">Previous</a></li>
					<li class="page-item"><a href="#" class="page-link">1</a></li>
					<li class="page-item"><a href="#" class="page-link">2</a></li>
					<li class="page-item active"><a href="#" class="page-link">3</a></li>
					<li class="page-item"><a href="#" class="page-link">4</a></li>
					<li class="page-item"><a href="#" class="page-link">5</a></li>
					<li class="page-item"><a href="#" class="page-link">Next</a></li>
				</ul> -->
			</div>
		</div>
	</div>        
</div>
</body>
</html>
