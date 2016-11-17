<?php
require_once 'checkLogin.php';
require_once 'connect.php';
require_once 'functions.php';

//Grabs the spell id so we can get it from the db
$spell_id = $_GET['id'];

//Tries to grab the spell from the DB
try {
	$stmt = $conn->prepare('SELECT * FROM spells WHERE _id = :spell_id');
	$stmt->execute(array('spell_id' => $spell_id));
	while ($row = $stmt->fetch()) {
		$html .= "<h3>" . $row['name'];
		$html .= "</h3>";
		if (checkLevel(3)) {$html .= "<a href=\"spellEdit.php?id=" . $row['_id'] . "\">Edit</a><br />"; }
		$html .= "<span class='label label-info'>(" . $row['page'] . ")</span><br />";
		if ($row['level'] == 0) {$html .= "<b>" . $row['school'] . " cantrip</b>";} else {$html .= "<b>" . $row['level'] . " " . $row['school'] . "</b>";}
		if ($row['ritual']) { $html .= "<span class='label label-primary'>(Ritual)</span>";}
		$html .= "<br /><u>Casting Time:</u> " . $row['casting_time'] . "<br />";
		$html .= "<u>Range:</u> " . $row['spell_range'] . "<br />";
		$html .= "<u>Components:</u>";
		if ($row['v_comp']) {$html .= "V";}
		if ($row['s_comp']) {$html .= ",S";}
		if ($row['m_comp']) {$html .= ",M ";}
		if ($row['consumable'] == "Yes") {$html .= " (Consumed)";}
		if ($row['m_comp']) {$html .= "<br /><u>Material Component Description:</u> " . $row['m_comp_desc'];}
		if ($row['focus']) {$html .= "<br /><u>Focus:</u> " . $row['focus'];}
		$html .= "<br /><u>Duration:</u> " . $row['duration'];
		if ($row['damage']) { $html .= "<br /><u>Damage:</u> " . $row['damage']; }
		$html .= "<br /><u>Usable by:</u> " . $row['spell_class'];
		if (checkLevel(2)) {
			$html .= "<br /><u>Description:</u><br /> " . stripslashes(nl2br($row['description'])) . "<br />";
			if ($row['at_higher']) { $html .= "<br /><u>At Higher Levels:</u><br /> " . stripslashes($row['at_higher']) . "<br />"; }
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
