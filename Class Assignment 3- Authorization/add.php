<?php
include 'connection.php';
session_start();

if (!isset($_SESSION['loggedin']) && !isset($_SESSION['email']) && !isset($_SESSION['password'])){
    header("Location: login.php");
    exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user ID from session
    $creator_id = $_SESSION['id'];
    
    $name = $_POST['name'];
    $matric_no = $_POST['matric_no'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format";
        exit;
    }
    // Validate name format
    if (!preg_match('/^[a-zA-Z\s]+$/', $name)) {
        echo "Invalid name format";
        exit;
    }
    // Validate address format
    if (!preg_match('/^[a-zA-Z0-9\s,]+$/', $address)) {
        echo "Invalid address format";
        exit;
    }
    // Validate phone number format
    if (!preg_match('/^\d{3}-\d{3}-\d{4}$/', $phone)) {
        echo "Invalid phone number format";
        exit;
    }
    // Validate matric number format
    if (!preg_match('/^\d{7}$/', $matric_no)) {
        echo "Invalid matric number format";
        exit;
    }
    
    // Insert data into database with creator_id
    $sql = "INSERT INTO student_records (name, matric_no, email, address, phone, creator_id)
            VALUES ('$name', '$matric_no', '$email', '$address', '$phone', $creator_id)";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
        if ($_SESSION['role'] == 'admin') {
            header("Location: admin_dashboard.php");
        } else {
            header("Location: student_details.php");
        }
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h2>Add New Student</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" required pattern="^[A-Za-z0-9 .,\-_]+$" placeholder="Enter your name"><br><br>

        <label for="matric_no">Matric No:</label><br>
        <input type="text" id="matric_no" name="matric_no" required pattern="^\d{7}$" minlength="7" maxlength="7" placeholder="Enter your matriculation number"><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" placeholder="Enter your email address" ><br><br>

        <label for="address">Address:</label><br>
        <input type="text" id="address" name="address" required pattern="^[A-Za-z0-9 .,\-_]+$"><br><br>

        <label for="phone">Phone:</label><br>
        <input type="text" id="phone" name="phone" required pattern="^\d{3}-\d{3}-\d{4}$" placeholder="Enter your phone number (e.g. 012-345-6789)"><br><br>

        <input type="submit" value="Submit">
    </form>
</body>
</html>
