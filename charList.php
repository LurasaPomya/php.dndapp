<?php
require_once 'checkLogin.php';
require_once 'connect.php';
require_once 'functions.php';
if (!checkLevel(3)) {
	echo "You don't have access to this!"; break;
}

$html = null;
//Grabs the username
$user = $_SESSION['username'];
$userId = $_SESSION['userId'];

//Tries to grab all the users notes, shows error if it can't
try {
	$stmt = $conn->prepare('SELECT * FROM characters WHERE owner_id = ?');
	$stmt->execute(array($userId));
	
	if ($stmt->rowCount()!= 0)
	{
		while ($row = $stmt->fetch()) {
			$html .= "<tr><td><a href='CharDetails.php?id=" . $row['_id'] . "'>" . $row['name'] . "</a> (Level " . $row['level'] . " " . $row['class'] . ")</td></tr>";
		}
	} else {
		$html .= "<center><b>No Characters Found</b></center>";
	}
} catch(PDOException $e) {
	echo 'Error: ' . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Dectala's DnD GM App">
	<meta name="author" content="James McGrew (jemcgrew@gmail.com)">
	<title>Dectala's DnDApp</title>
	<link href="css/bootstrap.css" rel="stylesheet">
	<script type="text/javascript" src="js/jquery-1.11.2.js"></script>
	<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
	<script type="text/javascript" src="js/functions.js"></script>
	<script type="text/javascript" id="js">
		$(document).ready(function() {
			$("table").tablesorter();
				var sorting = [[0,0]];
				sortTableBy(sorting);
			});
	</script>
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
		<table class="tablesorter table">
			<tbody>
		<?php echo $html; ?>
			</tbody>
		</table>
	</div><!-- /.container -->
	<!-- Bootstrap core JavaScript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="js/bootstrap.js"></script>
</body>
</html>
