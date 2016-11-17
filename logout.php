<?php
session_start();
// remove all session variables
session_unset();
// destroy the session
setcookie(session_name(), '', time() - 42000);
session_destroy();
header("location:login.php");
?>
