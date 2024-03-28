<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
    echo "Name: $name <br>";
    echo "Phone Number: $phone <br>";
    echo "Email: $email <br>";
    echo "Address: $address <br>";
    echo "Matric Number: $matric_no <br>";
}
?>
