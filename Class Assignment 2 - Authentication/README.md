## Files Overview
### 1. connection.php
- Purpose: Establishes a connection to the MySQL database server.
- Sequence:
  - Defines database connection parameters such as hostname, username, password, and database name.
  - Creates a new MySQLi object ($conn) representing the database connection.
  - Checks the connection status. If the connection fails, it terminates the script and displays an error message.
- Validation: Ensures that the connection to the database server is successful.
```sql
CREATE DATABASE students;
USE students;

CREATE TABLE student_records (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    matric_no VARCHAR(10) NOT NULL,
    email VARCHAR(255) NOT NULL,
    address VARCHAR(255) NOT NULL,
    phone VARCHAR(12) NOT NULL
);
```
```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

```
### 2. index.php
- Purpose: Allow users to view, edit, and delete student records.
- Sequence:
  - It checks if the user is authenticated (logged in). If not, it redirects the user to the login page (login.php).
  - PHP code retrieves records from the database and dynamically generates table rows and cells to display the records.
  - Clicking on the edit icon redirects the user to the edit page (edit.php) with the record's ID in the URL.
  - Clicking on the delete icon triggers the deletion of the corresponding record from the database.


### 3. add.php
- Purpose: Allows users to add a new student record.
- Sequence:
  - Retrieves form data (name, matriculation number, email, address, phone) via POST method.
  - Validates the format of input fields (name, email, address, phone, matriculation number).
  - Inserts the new record into the database if validation passes.
  
- Validation:
  - Name: Only alphabetic characters and spaces are allowed. ```'/^[a-zA-Z\s]+$/'```
  - Matriculation Number: Must consist of exactly 7 digits. ```'/^\d{7}$/'```
  - Email: Must adhere to the standard email format. ```'^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$'```
  - Address: Allows alphanumeric characters, spaces, commas, and hyphens. ```'/^[a-zA-Z0-9\s,]+$/'```
  - Phone Number: Must be in the format XXX-XXX-XXXX (e.g., 123-456-7890). ```'/^\d{3}-\d{3}-\d{4}$/'```

### 4. edit.php
- Purpose: Allows users to edit an existing student record.
- Sequence:
  1. Retrieves the ID of the student record to be edited from the URL query parameters.
  2. Retrieves the existing record from the database based on the ID.
  3. Populates the edit form with the existing record data.
  4. Updates the record in the database with the new data upon form submission.

- Validation:
  - Name: Only alphabetic characters and spaces are allowed. ```'/^[a-zA-Z\s]+$/'```
  - Matriculation Number: Must consist of exactly 7 digits. ```'/^\d{7}$/'```
  - Email: Must adhere to the standard email format. ```'^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$'```
  - Address: Allows alphanumeric characters, spaces, commas, and hyphens. ```'/^[a-zA-Z0-9\s,]+$/'```
  - Phone Number: Must be in the format XXX-XXX-XXXX (e.g., 123-456-7890). ```'/^\d{3}-\d{3}-\d{4}$/'```
  
### 5. delete.php
- Purpose: Allows users to delete an existing student record.
- Sequence:
  1. Retrieves the ID of the student record to be deleted from the URL query parameters.
  2. Deletes the record from the database based on the ID.

### 6. login.php
- Purpose: Provides user authentication functionality.
- Sequence:
  1. Retrieves username and password from the login form via POST method.
  2. Validates the username's existence and verifies the hashed password against the stored hash in the database.
  3. Sets session variables upon successful authentication and redirects to index.php.

