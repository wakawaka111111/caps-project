<?php
session_start();

// Destroy all session data to log the user out
session_unset(); // Clears all session variables
session_destroy(); // Destroys the session

// Redirect the user to the admin login page after logout
header('Location: admin_login.html');
exit();
?>
