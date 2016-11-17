<?php
require_once 'checkLogin.php';
require_once 'connect.php';
require_once 'functions.php';
if (!checkLevel(3)) { echo "You don't have access to this!"; break; }
//Gets info needed to grab the note
$noteid = $_REQUEST['id'];
$user = $_SESSION['username'];

//Tries to grab the note from the DB
try {
	$stmt = $conn->prepare('SELECT * FROM notes WHERE _id = ?');
	$stmt->execute(array($noteid));

	while ($row = $stmt->fetch()) {
		//If the username doesn't match the username on the note, errors as they shouldn't be able to read this note.
		if ($row['username'] != $user) {
			$html .="You don't have access to this note!";
		}
		else {
			$html .= "<div class=\"panel panel-default\"><div class=\"panel-heading\"><h3 class=\"panel-title\">" . $row['name'] . "</h3></div><div class=\"panel-body\">" . nl2br($row['content']) . "</div></div>";
		}
	}
} catch(PDOException $e) {
	echo 'Error: ' . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Dectala's DnD GM App">
	<meta name="author" content="James McGrew (jemcgrew@gmail.com)">
	<title>Dectala's DnDApp</title>
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
	<?php checkLevel(3); ?>
	<div class="container">
		<?php echo $html; ?>
	</div><!-- /.container -->
	<!-- Bootstrap core JavaScript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="js/bootstrap.js"></script>
</body>
</html>
