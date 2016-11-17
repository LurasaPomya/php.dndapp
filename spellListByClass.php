<?php
require_once 'checkLogin.php';
require_once 'functions.php';
require_once 'connect.php';

$html = null;

	try {
		$field = null;
		$terms = null;
		$level = null;
		$field = $_REQUEST['field'];
		$terms = $_REQUEST['terms'];
		$level = $_REQUEST['level'];
		if ($field = 'class')
		{
			$stmt = $conn->prepare('SELECT * FROM spells WHERE spell_class LIKE ? AND level= ?');
			$stmt->execute(array('%'.$terms.'%',$level));
		}

		while ($row = $stmt->fetch()) {
			if ($row['ritual']) {
				$html .= "<tr><td><a href='spellDesc.php?id=" . $row['_id'] . "'>" . $row['name'] . "</a> <span class='label label-primary'>(Ritual)</span></td></tr>";
			}
			else {
				$html .= "<tr><td><a href='spellDesc.php?id=" . $row['_id'] . "'>" . $row['name'] . "</a></td></tr>";
			}

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
    <h3><?php if ($level == 0) { echo "Cantrip "; } else { echo "Level " . $level; } ?> Spells for a <?php echo $terms; ?></h3>

	<a class='btn btn-default' href="spellListByClass.php?search=y&field=class&terms=Bard&level=0" role="button">Bard</a>
	<a class='btn btn-default' href="spellListByClass.php?search=y&field=class&terms=Cleric&level=0" role="button">Cleric</a>
	<a class='btn btn-default' href="spellListByClass.php?search=y&field=class&terms=Druid&level=0" role="button">Druid</a>
	<a class='btn btn-default' href="spellListByClass.php?search=y&field=class&terms=Paladin&level=0" role="button">Paladin</a>
	<a class='btn btn-default' href="spellListByClass.php?search=y&field=class&terms=Ranger&level=0" role="button">Ranger</a>
	<a class='btn btn-default' href="spellListByClass.php?search=y&field=class&terms=Sorcerer&level=0" role="button">Sorcerer</a>
	<a class='btn btn-default' href="spellListByClass.php?search=y&field=class&terms=Warlock&level=0" role="button">Warlock</a>
	<a class='btn btn-default' href="spellListByClass.php?search=y&field=class&terms=Wizard&level=0" role="button">Wizard</a>
	<br />
	<a class='btn btn-default' href="spellListByClass.php?search=y&field=class&terms=<?php echo $terms; ?>&level=0" role="button">Cantrips</a>
	<a class='btn btn-default' href="spellListByClass.php?search=y&field=class&terms=<?php echo $terms; ?>&level=1" role="button">Level 1</a>
	<a class='btn btn-default' href="spellListByClass.php?search=y&field=class&terms=<?php echo $terms; ?>&level=2" role="button">Level 2</a>
	<a class='btn btn-default' href="spellListByClass.php?search=y&field=class&terms=<?php echo $terms; ?>&level=3" role="button">Level 3</a>
	<a class='btn btn-default' href="spellListByClass.php?search=y&field=class&terms=<?php echo $terms; ?>&level=4" role="button">Level 4</a>
	<a class='btn btn-default' href="spellListByClass.php?search=y&field=class&terms=<?php echo $terms; ?>&level=5" role="button">Level 5</a>
	<a class='btn btn-default' href="spellListByClass.php?search=y&field=class&terms=<?php echo $terms; ?>&level=6" role="button">Level 6</a>
	<a class='btn btn-default' href="spellListByClass.php?search=y&field=class&terms=<?php echo $terms; ?>&level=7" role="button">Level 7</a>
	<a class='btn btn-default' href="spellListByClass.php?search=y&field=class&terms=<?php echo $terms; ?>&level=8" role="button">Level 8</a>
	<a class='btn btn-default' href="spellListByClass.php?search=y&field=class&terms=<?php echo $terms; ?>&level=1" role="button">Level 9</a>
    <table>
    	<?php echo $html; ?>
    </table>
  </div>
  <!-- Bootstrap core JavaScript
  ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script src="js/bootstrap.js"></script>
</body>
</html>
