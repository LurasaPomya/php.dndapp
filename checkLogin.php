<?php
require_once 'connect.php';
session_start();
if ($_SESSION['username'] == '')	//Checks if they have a session username value.
{	
	header("location:login.php");	//Directs to login if they don't have the cookie.
}
?>
