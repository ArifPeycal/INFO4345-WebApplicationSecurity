<?php
include 'connection.php';
session_start();

// Check if the user is authenticated and is an admin
if (!isset($_SESSION['loggedin']) && !isset($_SESSION['email']) && !isset($_SESSION['password'])) {
    header("Location: login.php");
    exit;
}
$creator_id = $_SESSION['id'];
$id = $_GET['id'];

if ($_SESSION['role'] == 'admin') {
    $sql = "SELECT * FROM student_records WHERE student_id = $id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            continue;
        }
	}	 
}
else {
    $sql = "SELECT * FROM student_records WHERE creator_id = $creator_id";
    $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                continue;
            }
        }	 
        else {
            header("Location: student_details.php");
            exit; 
            }
}
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete the record from the database
    $sql = "DELETE FROM student_records WHERE student_id=$id";

    if ($conn->query($sql) === TRUE) {
        if ($_SESSION['role'] == 'admin') {
            header("Location: admin_dashboard.php");
        } else {
            header("Location: student_details.php");
        }
        exit;
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $conn->close();
}
?>
