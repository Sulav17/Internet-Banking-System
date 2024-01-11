<?php
function check_login()
{
	// Check if staff_id is not set or has a length of 0
if(strlen($_SESSION['client_id'])==0)
	{
		  // If not set, redirect to the login page
		$host = $_SERVER['HTTP_HOST'];
		$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$extra="pages_client_index.php";
		// Clear staff_id in session (optional)
		$_SESSION["client_id"]="";
		header("Location: http://$host$uri/$extra");
	}
}
/* This PHP code defines a function named check_login. The purpose of this function is to check 
if the length of the client_id stored in the $_SESSION superglobal is equal to 0. If the length 
is indeed 0, it indicates that the user is not logged in, and the code performs 
a redirect to a login page.

Session Check:

The function checks if the staff_id key in the $_SESSION array is either not set or has a length of 0.
Redirect to Login Page:

If the staff_id is not set or has a length of 0, 
the function constructs a redirect URL to the login page (pages_staff_index.php).
The header() function is then used to send a raw HTTP header to perform the redirection.
Optional: Clear Session Variable:

The $_SESSION["staff_id"] is set to an empty string. 
This is optional and depends on your application's logic. 
If you want to clear the staff_id from the session, you can include this line.
*/