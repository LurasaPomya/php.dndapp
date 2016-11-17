<?php

//Requires stuff we need to get things working
require_once 'checkLogin.php';
require_once 'functions.php';
$pageName = basename($_SERVER['PHP_SELF']);	//This isn't used, but grabs the page name for easy use. Should be used in memory.
header("Location: spellList.php");
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="Dectala's DnD GM App">
		<meta name="author" content="James McGrew (jemcgrew@gmail.com)">
		<title>Welcome - Dectala's DnD App</title>
		<link href="css/bootstrap.css" rel="stylesheet">
	</head>
	<body>
		<!-- BEGIN NAVIGATION -->
		<nav class="navbar navbar-inverse navbar-fluid-top">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
						<span class="sr-only">Toggle navigation</span>
						<span class="navbar-brand">Dec's DnDApp</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="index.php">Dec's DnDApp</a>
				</div>
				<div id="navbar" class="collapse navbar-collapse">
					<ul class="nav navbar-nav">
					<?php
						getMenu();
						if (checkLevel(3)) {
							getAdminMenu();
						}
					?>
					</ul>
				</div>
			</div>
		</nav>
		<!-- END NAVIGATION -->
		<!-- BEGIN MAIN CONTAINER -->
		<div class="container">
			<h1>Welcome to the Dectala's DnD App!</h1>
			<p class="lead">This is a VERY HEAVY WORK IN PROGRESS and some things may look ugly, or not work at all. Please be patient. I'm working on it.</p>
			<p>You prolly want the spell list, so get started there <a href="spellList.php">CLICK!</a></p>
		</div>
		<!-- END MAIN CONTAINER -->
		<!-- Bootstrap core JavaScript -->
		<script src="js/bootstrap.js"></script>
	</body>
</html>
