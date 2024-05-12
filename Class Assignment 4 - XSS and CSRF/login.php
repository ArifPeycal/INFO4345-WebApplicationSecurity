<?php
session_start();
include 'connection.php';

// Function to generate a CSRF token
function generateCSRFToken() {
    return bin2hex(random_bytes(32)); // Generate a 32-byte random token
}

// Generate and store CSRF token in session
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = generateCSRFToken();
}// Validate CSRF token on form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verify CSRF token
    if (!empty($_POST['csrf_token']) && hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        // CSRF token is valid, proceed with login process
        $email = $_POST['email'];
        $password = $_POST['password'];
        if(isset($_SESSION['csrf_token'])) {
            unset($_SESSION['csrf_token']);
        }
        // Check if the provided credentials are valid
        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            // User found, verify the password
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                // Password verification successful, set session variables
                $_SESSION['loggedin'] = true;
                $_SESSION['id'] = $row['id']; // Add id to session
                $_SESSION['email'] = $email;
                $_SESSION['role'] = $row['role']; // Add role to session
                        // Unset the existing CSRF token if it exists
                // Redirect based on user role
                if ($_SESSION['role'] == 'admin') {
                    header("Location: admin_dashboard.php");
                } else {
                    header("Location: student_details.php");
                }
                exit;
            } else {
                // Password verification failed
                $error = "Invalid email or password";
            }
        } else {
            // User not found
            $error = "Invalid email or password";
        }

    } else {
        // CSRF token validation failed
        $error = "CSRF token validation failed";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <?php if (isset($error)) { ?>
            <div class="error"><?php echo $error; ?></div>
        <?php } ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <label for="email">Email:</label><br>
            <input type="text" id="email" name="email" required><br><br>

            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required><br><br>

            <input type="submit" value="Login">
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a>.</p>
    </div>
</body>
</html>
