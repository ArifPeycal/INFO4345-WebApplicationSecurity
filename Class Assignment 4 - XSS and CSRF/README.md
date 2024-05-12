## CSP Implementation
Content Security Policy (CSP) was implemented on several pages to enhance the security of the web application. CSP helps mitigate the risks associated with cross-site scripting (XSS) attacks by defining the sources from which various types of content can be loaded.

```html
// admin_dashboard.php, student_details.php

<meta http-equiv="Content-Security-Policy" content="
  default-src 'self';
  font-src 'self' https://fonts.gstatic.com;
  style-src 'self' https://stackpath.bootstrapcdn.com https://fonts.googleapis.com 'unsafe-inline';
  script-src 'self' https://code.jquery.com https://stackpath.bootstrapcdn.com https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js;
  connect-src 'self' https://api.example.com;
  img-src 'self' data:;
">
```
### Implementation Details

- Default Source: Set to 'self' to allow resources to be loaded from the same origin as the HTML file.

- Font Source: Set to 'self' and https://fonts.gstatic.com as valid sources.

- Style Source: Set to 'self', Bootstrap and Google API as valid sources. Additionally, 'unsafe-inline' is included to allow inline styles. However, the use of 'unsafe-inline' should be minimized to reduce security risks.

- Script Source: The script-src directive specifies the sources from which JavaScript can be loaded. It includes 'self', https://code.jquery.com, https://stackpath.bootstrapcdn.com, and https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js as valid sources. Similar to inline styles, 'unsafe-inline' and 'unsafe-eval' are included for JavaScript.

## XSS Defense
HTML encoding is a technique used to mitigate Cross-Site Scripting (XSS) attacks by converting potentially dangerous characters into their HTML entity equivalents. This prevents the browser from interpreting the input as executable script and can effectively neutralise XSS vulnerabilities.

File included: 
add.php, edit.php, login.php
```php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $id = htmlspecialchars($_POST['id']);
    $name = htmlspecialchars($_POST['name']);
    $matric_no = htmlspecialchars($_POST['matric_no']);
    $email = htmlspecialchars($_POST['email']);
    $address = htmlspecialchars($_POST['address']);
    $phone = htmlspecialchars($_POST['phone']);
}
```
### Implementation Details
```htmlspecialchars``` is a PHP function primarily used for HTML encoding user input data to prevent Cross-Site Scripting (XSS) attacks. It converts special characters in a string to their corresponding HTML entities and makes the string safe to be displayed in an HTML context without being interpreted as HTML or JavaScript code.
```php
< becomes &lt;
> becomes &gt;
" becomes &quot;
' becomes &#39; (or &apos; in XHTML)
& becomes &amp;
```

### CSRF Defense

Shared secrets for CSRF (Cross-Site Request Forgery) involve using a unique token known as CSRF token that is shared between the client and the server to validate the authenticity of requests. A CSRF token serves as a distinctive, confidential, and unpredictable code created by the server-side application and communicated to the client. When the client intends to execute a critical action, like submitting a form, it must include the accurate CSRF token. Without this token, the server will decline to execute the requested action

File included: 
- login.php, add.php, edit.php and admin_edit.php

### Implementation Details

1. Token Generation:
```php
function generateCSRFToken() {
    return bin2hex(random_bytes(32)); // Generate a 32-byte random token
}
```
  - When a user session is initiated (typically during login), the server generates a unique token or secret value.
This token is then associated with the user's session and stored in the session data on the server side.

2. Token Inclusion:
```php
<input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
```
  - Whenever the server renders a form that can potentially modify server-side data (e.g., submitting a form to update user information), it includes this token as a hidden field within the form. The token is also included in the session data associated with the user's session.

3. Form Submission:

  - When the user submits the form, the CSRF token is sent along with the form data to the server. The server receives the form data along with the CSRF token.

4. Token Validation:
```php
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {  
  // Invalid CSRF token, handle the error (e.g., redirect or display an error message)
  echo "CSRF token validation failed!";
  exit;
}
```
  - Upon receiving the form submission, the server compares the CSRF token sent by the client (```$_POST['csrf_token']```) with the one stored in the session data associated with the user's session (```$_SESSION['csrf_token']```).
If the tokens match, the server accepts the request as legitimate and processes it.
If the tokens do not match or if the token is missing, the server rejects the request, considering it potentially fraudulent (a CSRF attack).

5. Token Expiry and Renewal:
```php
if(isset($_SESSION['csrf_token'])) {
  unset($_SESSION['csrf_token']);
}
```
- To enhance security, the CSRF token should have a limited lifespan or be tied to a specific action. After this lifespan expires or the action is completed, the token should be invalidated. Upon expiration or completion, the server generates a new CSRF token for subsequent requests.
