## add.php

Authorization Check: There's likely a session check similar to student_details.php. However, the specific logic might differ.
Two possibilities exist:

No Specific Check: Users might be able to access the page regardless of login status. However, form submission for adding new students might be restricted to logged-in users (especially those with the 'admin' role).

Login Check: The script might perform a session check and redirect unauthenticated users to the login page (login.php).

Authorized Users: The ideal scenario is for this page to be accessible only to logged-in users with the 'admin' role. They can add new student records.

Permissions: Users with the 'admin' role can add new student entries. Regular users (without the 'admin' role) might be able to access the page but wouldn't be able to submit the form to create new student records (not implemented in the provided code).

## admin_dashboard.php

Authorization Check: This file likely performs a stricter session check compared to others:
 - Checks if the user is logged in (isset($_SESSION['loggedin'])).
 - Checks if the user has the 'admin' role ($_SESSION['role'] !== 'admin').
 - If either check fails, it redirects to the login page (login.php).

Authorized Users: This script can only be accessed by logged-in users with the role 'admin'.

Permissions: Users with the 'admin' role can view a list of all student records, including details like name, matriculation number, email, address, and phone number. They can also see edit and delete buttons for each record, allowing them to manage student information.

## login.php

Authorization Check: There's likely no specific authorization check for this page.

Authorized Users: Anyone can access this page, regardless of their login status. It's designed for users to log in and gain access to the system.

Permissions: Users can enter their email and password to attempt login. Upon successful login, they are redirected to appropriate pages based on their role ('admin' or 'user').

## student_details.php

Authorization Check: This file performs a session check to verify if the user is logged in and has the role 'user'.

If not logged in, it redirects to the login page (login.php).

Authorized Users: This script can be accessed by users with the role 'user' who have successfully logged in.

Permissions: Logged-in users can view their own student records, including name, matriculation number, email, address, and phone. They can also see edit and delete buttons but clicking them might redirect them to a permission denied page (not implemented).

## edit.php

Authorization Check: This file performs a session check to verify if the user is logged in.
- If not logged in, it redirects to the login page (login.php).
- It also checks the user's role. If the user is a 'user', it fetches their own student records. If it's an 'admin', it fetches any record.

Authorized Users: This script can be accessed by logged-in users with roles 'user' and 'admin'.

Permissions:
- Users with role 'user' can only access and edit their own student record details.
- Users with role 'admin' can access and edit any student record.

## delete.php

Authorization Check: This file performs a session check to verify if the user is logged in and has the role 'admin' or 'user'.
- If not logged in, it redirects to the login page (login.php).
- It also checks user role. If the user is a 'user', it fetches their own student records.

Authorized Users: This script can be accessed by logged-in users with roles 'user' and 'admin'.

Permissions:
- Users with role 'user' cannot delete any records. Clicking the delete button might redirect them to a permission denied page (not implemented).
- Users with role 'admin' can delete any student record.
