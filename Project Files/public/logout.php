<?php
// Starts the session
session_start();
 
// Clears the session variables
$_SESSION = array();
 
// Destroys the session.
session_destroy();
 
// Redirect back to the login page
header("location: login.php");
exit;
?>
