<?php
include 'connection.php';
session_start();

if (!isset($_SESSION['loggedin']) && !isset($_SESSION['email']) && !isset($_SESSION['password']) && $_SESSION['role'] !== 'user'){
    header("Location: login.php");
    exit;
}

if ($_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit;
}
// Function to generate a CSRF token
function generateCSRFToken() {
    return bin2hex(random_bytes(32)); // Generate a 32-byte random token
}
// Generate and store CSRF token in session
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = generateCSRFToken();
}// Validate CSRF token on form submission

$creator_id = $_SESSION['id'];

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        // Invalid CSRF token, handle the error (e.g., redirect or display an error message)
        echo "CSRF token validation failed!";
        exit;
    }
    $id = htmlspecialchars($_POST['id']);
    $name = htmlspecialchars($_POST['name']);
    $matric_no = htmlspecialchars($_POST['matric_no']);
    $email = htmlspecialchars($_POST['email']);
    $address = htmlspecialchars($_POST['address']);
    $phone = htmlspecialchars($_POST['phone']);
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
if(isset($_SESSION['csrf_token'])) {
    unset($_SESSION['csrf_token']);
}
    // Update data in the database
    $sql = "UPDATE student_records
            SET name='$name', matric_no='$matric_no', email='$email', address='$address', phone='$phone'
            WHERE student_id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: student_details.php");
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="Content-Security-Policy" content="default-src 'self'">;
    <title>Edit Student</title>
    <link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
    <h2>Edit Student</h2>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['student_id'])) {
        $id = $_GET['student_id'];
        $sql = "SELECT * FROM student_records WHERE student_id=$id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
    ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="hidden" name="id" value="<?php echo $row['student_id']; ?>">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>" required><br><br>

        <label for="matric_no">Matric No:</label><br>
        <input type="text" id="matric_no" name="matric_no" value="<?php echo $row['matric_no']; ?>" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" value="<?php echo $row['email']; ?>" required><br><br>

        <label for="address">Address:</label><br>
        <input type="text" id="address" name="address" value="<?php echo $row['address']; ?>" required><br><br>

        <label for="phone">Phone:</label><br>
        <input type="text" id="phone" name="phone" value="<?php echo $row['phone']; ?>" required><br><br>

        <input type="submit" value="Update">
    </form>
    <?php
        } else {
            echo "No record found";
        }
    }
    ?>
</body>
</html>
