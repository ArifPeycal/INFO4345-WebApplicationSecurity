# Student Reservation Form

This repository contains files for a student reservation form.

## Files:

### **index.html**
- This file serves as the front end of the student reservation form.
- It contains the structure and layout of the form, including input fields for name, matriculation number, phone number, email, and address.
- The form action attribute is set to "process_reservation.php," indicating that when the form is submitted, the data will be sent to the PHP file for processing.
- It also includes a reference to the CSS file (style.css) to apply styling to the form elements and a reference to the JavaScript file (reservation_form_validation.js) for client-side validation.

### **process_reservation.php**
- It retrieves the form data using PHP $_POST superglobal.
- It performs server-side validation on the submitted data to ensure it meets certain criteria, such as valid email format, correct phone number format, etc.
- If the data passes validation, it echoes back the submitted data, confirming the reservation.
- If any validation fails, it echoes an error message back to the user.
  
### **style.css** 
- This CSS file contains styles to enhance the appearance of the reservation form.
- It styles various elements of the form, such as input fields, labels, buttons, etc., to improve readability and user experience.
  
### **reservation_form_validation.js**
- This JavaScript file provides client-side validation for the reservation form.
- It listens for the form submission event and validates the form data before it is sent to the server.
- It uses regular expressions to ensure that the input values meet specific criteria, such as valid email format, correct phone number format, etc.
- If any input fails validation, it prevents the form from being submitted and displays an alert message to the user, indicating the validation error.
  
## Usage:

1. Open `index.html` in a web browser to access the student reservation form.
2. Fill out the form with valid details.
3. Upon submission, the form data is sent to `process_reservation.php` for server-side validation and processing.
4. If the data passes validation, it's displayed back to the user; otherwise, appropriate error messages are shown.
5. Client-side validation is performed using `reservation_form_validation.js` to enhance user experience and reduce server requests.

## Validation:

- **Name**: Alphabets and spaces only.
- **Matric No**: Exactly 7 digits.
- **Phone Number**: XXX-XXXX format.
- **Email**: Valid email format.
- **Address**: Alphanumeric characters and spaces only.

