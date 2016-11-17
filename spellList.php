<?php
require_once 'checkLogin.php';
require_once 'connect.php';
require_once 'functions.php';

$search = null;
$html = null;

if ($_REQUEST['search'] == 'y') {

	//Tries to grab the list of spells
	try {
		//This is if search was selected
		$field = $_REQUEST['field'];
		$terms = $_REQUEST['terms'];
		if ($field = 'class')
		{
			$stmt = $conn->prepare('SELECT * FROM spells WHERE spell_class LIKE ? ORDER BY name');
			$stmt->execute(array('%'.$terms.'%'));
		}
	} catch(PDOException $e) {
		echo 'Error: ' . $e->getMessage();
	}
}
else //If no search was given
{
	$stmt = $conn->prepare('SELECT * FROM spells ORDER BY name');
	$stmt->execute();
}

// output data of each row
while($row = $stmt->fetch()) {

	if ($row['ritual']) {
		$html .= "<tr><td><a href='spellDesc.php?id=" . $row['_id'] . "'>" . $row['name'] . "</a> <span class='label label-primary'>(Ritual)</span></td><td>" . $row['level'] . "</td><td>" . $row['school'] . "</td></tr>";
	}
	else {
		$html .= "<tr><td><a href='spellDesc.php?id=" . $row['_id'] . "'>" . $row['name'] . "</a></td><td>" . $row['level'] . "</td><td>" . $row['school'] . "</td></tr>";
	}
}
$html .= "</tr></table>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Dectala's DnD GM App">
	<meta name="author" content="James McGrew (jemcgrew@gmail.com)">

	<title>Dectala's DnDApp - Spell List</title>
	<!-- Bootstrap core CSS -->
	<link href="css/bootstrap.css" rel="stylesheet">
	<script type="text/javascript" src="js/jquery-1.11.2.js"></script>
	<!-- TableSorter js File -->
	<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
	<!-- My Customer js File -->
	<script type="text/javascript" src="js/functions.js"></script>
	<!-- Table Sorter Plugin -->
	<script type="text/javascript" id="js">
		$(document).ready(function() {
			$("table").tablesorter();
			$("#level-link").click(function() {
				var sorting = [[1,0]];
				sortTableBy(sorting);
				setCookie("lastSort", "level", 365)
				return false;
			});
			$("#name-link").click(function() {
				var sorting = [[0,0]];
				sortTableBy(sorting);
				setCookie("lastSort", "name", 365)
				return false;
			});
			$("#school-link").click(function() {
				var sorting = [[2,0],[1,0],[0,0]];
				sortTableBy(sorting);
				setCookie("lastSort", "school", 365)
				return false;
			});
		});
	</script>
</head>

<body onload="checkLastSort()">
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
			Sort By Class:<br />
			<div class="btn-group" role="group" aria-label="...">
				<a class='btn btn-default' href="spellList.php" role="button">All Spells</a>
				<a class='btn btn-default' href="spellList.php?search=y&field=class&terms=Bard" role="button">Bard</a>
				<a class='btn btn-default' href="spellList.php?search=y&field=class&terms=Cleric" role="button">Cleric</a>
				<a class='btn btn-default' href="spellList.php?search=y&field=class&terms=Druid" role="button">Druid</a>
				<a class='btn btn-default' href="spellList.php?search=y&field=class&terms=Paladin" role="button">Paladin</a>
				<a class='btn btn-default' href="spellList.php?search=y&field=class&terms=Ranger" role="button">Ranger</a>
				<a class='btn btn-default' href="spellList.php?search=y&field=class&terms=Sorcerer" role="button">Sorcerer</a>
				<a class='btn btn-default' href="spellList.php?search=y&field=class&terms=Warlock" role="button">Warlock</a>
				<a class='btn btn-default' href="spellList.php?search=y&field=class&terms=Wizard" role="button">Wizard</a>
			</div>
			<br />
			<div class="btn-group" role="group" aria-label="...">
				<a class='btn btn-default' id="level-link" href="#" role="button">By Level</a>
				<a class='btn btn-default' id="name-link" href="#" role="button">By Name</a>
				<a class='btn btn-default' id="school-link" href="#" role="button">By School</a>
			</div>
			<br />
			<table id="table" class="tablesorter table">
				<thead>
					<tr>
						<th>Name</th>
						<th>Level</th>
						<th>School</th>
					</tr>
				</thead>
				<tbody>
					<?php echo $html; ?>
				</tbody>
			</table>
		</div>
		<!-- Bootstrap core JavaScript
		================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<script src="js/bootstrap.js"></script>
	</body>
</html>
