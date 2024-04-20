## Files Overview

### 1. login.php

- Authorization Check: There's no authorization check for this page.
- Authorized Users: Anyone can access this page, regardless of their login status. It's designed for users to log in and gain access to the system.
- Permissions: Users can enter their email and password to attempt login. Upon successful login, they are redirected to appropriate pages based on their role (```'admin'``` or ```'user'```).
  
### 2. admin_dashboard.php

- Authorization Check: This file performs a stricter session check compared to others:
  - Checks if the user is logged in ```(isset($_SESSION['loggedin']))```.
  - Checks if the session have email and password.
  - Checks if the user has the 'admin' role ```($_SESSION['role'] !== 'admin')```.
 - If either check fails, it redirects to the login page (login.php).
- Authorized Users: This script can only be accessed by logged-in users with the role 'admin'.
- Permissions: Users with the ```'admin'``` role can view a list of all student records, including details like name, matriculation number, email, address, and phone number. They -can also see edit and delete buttons for each record, allowing them to manage student information.
```php
// Check if the user is authenticated and is an admin
if (!isset($_SESSION['loggedin']) && !isset($_SESSION['email']) && !isset($_SESSION['password']) && $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}
```
### 3. student_details.php

- Authorization Check: This file performs a session check to verify if the user is logged in and has the role ```'user'```.
  - If not logged in, it redirects to the login page (login.php).
- Authorized Users: This script can be accessed by users with the role 'user' who have successfully logged in.
- Permissions: Logged-in users can view the records that they had created, including name, matriculation number, email, address, and phone. They can also edit and delete the records.

```php
// Check if the user is not authenticated (not logged in)
if (!isset($_SESSION['loggedin']) && !isset($_SESSION['email']) && !isset($_SESSION['password']) && $_SESSION['role'] !== 'user') {
    header("Location: login.php"); // Redirect to login.php
    exit; // Stop script execution
}
```
### 4. add.php

- Authorization Check: The file performs a session check for email and password. It will redirect unauthenticated users to the login page (login.php).
- Authorized Users: The ideal scenario is for this page to be accessible only to logged-in users with the ```'admin'``` role. They can add new student records.
- Permissions: Users with the ```'admin'``` and ```'user'``` role can add new student entries. User's session will be used to determine who created the data (creator_id). After submit the data, admin account will redirect to ```admin_dashboard.php``` meanwhile user account will redirect to ```student_details.php```.
```php
if (!isset($_SESSION['loggedin']) && !isset($_SESSION['email']) && !isset($_SESSION['password'])){
    header("Location: login.php");
    exit;
}
```
### 5. edit.php

- Authorization Check: This file performs a session check to verify if the user is logged in.
  - If not logged in, it redirects to the login page (login.php).
  - It also checks the user's role. If the user is a ```'user'```, it fetches their own student records. If it's an ```'admin'```, it fetches every records.
- Authorized Users: This script can be accessed by logged-in users with roles 'user' and 'admin'.
- Permissions:
  - Users with role 'user' can only access and edit their own student record details. Edit thru URL is not allowed for other records that is not owned by the users.
  - Users with role 'admin' can access and edit any student record.
```php
if ($_SESSION['role'] == 'admin') {
    $sql = "SELECT * FROM student_records WHERE student_id = $id";
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
```
### 6. delete.php

- Authorization Check: This file performs a session check to verify if the user is logged in and has the role ```'admin'``` or ```'user'```.
  - If not logged in, it redirects to the login page (login.php).
  - It also checks user role. If the user is a ```'user'```, it fetches their own student records.
```php
// Check if the user is authenticated and is an admin
if (!isset($_SESSION['loggedin']) && !isset($_SESSION['email']) && !isset($_SESSION['password'])) {
    header("Location: login.php");
    exit;
```
- Authorized Users: This script can be accessed by logged-in users with roles 'user' and 'admin'.
- Permissions:
 - Users with role ```'user'``` only can delete the records that they created (same creator_id). Delete thru URL is not allowed for other records that is not owned by the users.
 - Users with role ```'admin'``` can delete any student record.

