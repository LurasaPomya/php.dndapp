<?php
require_once 'checkLogin.php';
require_once 'connect.php';
require_once 'functions.php';
//Grabs the spell id so we can get it from the db
$task_id = $_GET['id'];
//Tries to grab the spell from the DB
try {
	$stmt = $conn->prepare('SELECT * FROM tasks WHERE _id = :task_id');
	$stmt->execute(array('task_id' => $task_id));
	while ($row = $stmt->fetch()) {
		$title = $row['title'];
		$priority = $row['priority'];
		$desc = nl2br($row['description']);

		$html = "<div class=\"panel panel-primary\"><div class=\"panel-heading\">" . $title . "<span class=\"label";
		if ($priority == "High") {
			$html .=" label-danger";
		}
		elseif ($priority == "Medium") {
			$html .=" label-warning";
		}
		else {
			$html .=" label-default";
		}
		$html .= " pull-right \">" . $priority . "</span></div>";
		$html .= "<div class=\"panel-body\">" . $desc . "</div></div>";
	}
} catch(PDOException $e) {
	echo 'Error: ' . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<!-- <meta charset="utf-8"> -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Dectala's DnD GM App">
	<meta name="author" content="James McGrew (jemcgrew@gmail.com)">
	<title>Dectala's DnDApp</title>
	<!-- Bootstrap core CSS -->
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
		<?php echo $html; ?>
	</div><!-- /.container -->
	<!-- Bootstrap core JavaScript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="js/bootstrap.js"></script>
</body>
</html>
