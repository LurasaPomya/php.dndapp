<?php
require_once 'checkLogin.php';
require_once 'functions.php';

//Debug Data, REMOVE THIS WHEN RELEASED!!!
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (!checkLevel(3)) { echo "You don't have access to this!"; break; }
	require_once 'connect.php';
	echo "<table>";
    	foreach ($_POST as $key => $value) {
        	echo "<tr>";
        	echo "<td>";
	        echo $key;
	        echo "</td>";
	        echo "<td>";
	        echo $value;
	        echo "</td>";
	        echo "</tr>";
	}
	echo "</table>";

	//Grabs all fields from the form
	$name = $_REQUEST['name'];
	$school = $_REQUEST['school'];
	$level = $_REQUEST['level'];
	if ($_REQUEST['ritual']) { $ritual = "Yes"; }
	if ($_REQUEST['concentration']) { $concentration = "Yes"; }
	if ($_REQUEST['bard']) { $classes .= "Bard"; }
	if ($_REQUEST['cleric']) { $classes .= ",Cleric"; }
	if ($_REQUEST['druid']) { $classes .= ",Druid"; }
	if ($_REQUEST['paladin']) { $classes .= ",Paladin"; }
	if ($_REQUEST['ranger']) { $classes .= ",Ranger"; }
	if ($_REQUEST['sorcerer']) { $classes .= ",Sorcerer"; }
	if ($_REQUEST['warlock']) { $classes .= ",Warlock"; }
	if ($_REQUEST['wizard']) { $classes .= ",Wizard"; }
	$casting_time = $_REQUEST['casting_time'];
	if ($_REQUEST['v_comp']) { $v_comp = "V"; }
	if ($_REQUEST['s_comp']) { $s_comp = "S"; }
	if ($_REQUEST['m_comp']) { $m_comp = "M"; }
	$m_comp_desc = $_REQUEST['m_comp_desc'];
	$m_comp_desc = addslashes($m_comp_desc);
	$m_comp_desc = nl2br($m_comp_desc);
	$focus = $_REQUEST['focus'];
	$consumable = $_REQUEST['consumable'];
	$spell_range = $_REQUEST['spell_range'];
	$duration = $_REQUEST['duration'];
	$page = $_REQUEST['page'];
	$saving_throw = $_REQUEST['saving_throw'];
	$damage_type = $_REQUEST['damage_type'];
	$damage = $_REQUEST['damage'];
	$description = $_REQUEST['description'];
	$description = addslashes($description);
	$description = nl2br($description);
	$atHigher = $_REQUEST['atHigher'];
	$atHigher = addslashes($atHigher);
	$atHigher = nl2br($atHigher);

	//Prepares SQL Statement
	$stmt = $conn->prepare("INSERT INTO spells (name,school,level,ritual,concentration,spell_class,casting_time,v_comp,s_comp,m_comp,m_comp_desc,focus,consumable,spell_range,duration,page,saving_throw,damage_type,damage,description,at_higher) VALUES (:name,:school,:level,:ritual,:concentration,:spell_class,:casting_time,:v_comp,:s_comp,:m_comp,:m_comp_desc,:focus,:consumable,:spell_range,:duration,:page,:saving_throw,:damage_type,:damage,:description,:atHigher)");
	$stmt->bindParam(':name',$name);
	$stmt->bindParam(':school',$school);
	$stmt->bindParam(':level',$level);
	$stmt->bindParam(':ritual',$ritual);
	$stmt->bindParam(':concentration',$concentration);
	$stmt->bindParam(':spell_class',$classes);
	$stmt->bindParam(':casting_time',$casting_time);
	$stmt->bindParam(':v_comp',$v_comp);
	$stmt->bindParam(':s_comp',$s_comp);
	$stmt->bindParam(':m_comp',$m_comp);
	$stmt->bindParam(':m_comp_desc',$m_comp_desc);
	$stmt->bindParam(':focus',$focus);
	$stmt->bindParam(':consumable',$consumable);
	$stmt->bindParam(':spell_range',$spell_range);
	$stmt->bindParam(':duration',$duration);
	$stmt->bindParam(':page',$page);
	$stmt->bindParam(':saving_throw',$saving_throw);
	$stmt->bindParam(':damage_type',$damage_type);
	$stmt->bindParam(':damage',$damage);
	$stmt->bindParam(':description',$description);
	$stmt->bindParam(':atHigher',$atHigher);

	//Executes SQL Statement
	if ($stmt->execute())
	{

		echo "Success";
	}
	else
	{
		$error = $stmt->errorInfo();
		print_r($error);
	}

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
	<?php if (!checkLevel(3)) { echo "You don't have access to this!"; break;} ?>
	<div class="container">
		<!-- BEGIN FORM -->
		<form name="spell_insert" method="post" action="spellInsert.php">
			<input type="hidden" name="submitted" value="true">
			<strong>Insert New Spell</strong><br />
			<table class="table-bordered">
			<tr><td>Name</td><td><input name="name" type="text" id="name"></td></tr>
			<tr><td>School</td><td><input name="school" type="text" id="school"></td></tr>
			<tr><td>Level</td><td><input name="level" type="number" id="level" min=0 max=9></td></tr>
			<tr><td>Ritual</td><td><input name="ritual" type="checkbox" id="ritual"></td></tr>
			<tr><td>Concentration</td><td><input name="concentration" type="checkbox" id="concentration"></td></tr>
			<tr><td>Used By</td><td>
			<input name="bard" type="checkbox" id="bard">Bard
			<input name="cleric" type="checkbox" id="cleric">Cleric
			<input name="druid" type="checkbox" id="druid">Druid
			<input name="paladin" type="checkbox" id="paladin">Paladin
			<input name="ranger" type="checkbox" id="ranger">Ranger
			<input name="sorcerer" type="checkbox" id="sorcerer">Sorcerer
			<input name="warlock" type="checkbox" id="warlock">Warlock
			<input name="wizard" type="checkbox" id="wizard">Wizard</td></tr>
			<tr><td>Casting Time</td><td><input name="casting_time" type="text" id="casting_time"></td></tr>
			<tr><td>Verbal Component</td><td><input name="v_comp" type="checkbox" id="v_comp"></td></tr>
			<tr><td>Semantic Component</td><td><input name="s_comp" type="checkbox" id="s_comp"></td></tr>
			<tr><td>Material Component</td><td><input name="m_comp" type="checkbox" id="m_comp"></td></tr>
			<tr><td>Material Component Description</td><td><input name="m_comp_desc" type="text" id="m_comp_desc"></td></tr>
			<tr><td>Material Consumed</td><td><input name="consumable" type="checkbox" id="consumable"></td></tr>
			<tr><td>Focus</td><td><input name="focus" type="text" id="focus"></td></tr>
			<tr><td>Spell Range</td><td><input name="spell_range" type="text" id="spell_range"></td></tr>
			<tr><td>Duration</td><td><input name="duration" type="text" id="duration"></td></tr>
			<tr><td>Page # in PHB</td><td><input name="page" type="text" id="page"></td></tr>
			<tr><td>Saving Throw</td><td><input name="saving_throw" type="text" id="saving_throw"></td></tr>
			<tr><td>Damage Type</td><td><input name="damage_type" type="text" id="damage_type"></td></tr>
			<tr><td>Damage</td><td><input name="damage" type="text" id="damage"></td></tr>
			<tr><td>Description</td><td><textarea name="description" id="description" rows="25" cols="100"></textarea></td></tr>
			<tr><td>At Higher Levels</td><td><textarea name="atHigher" id="atHigher" rows="25" cols="100"></textarea></td></tr>
			<tr><td><input type="submit" name="Submit" value="Submit"></td></tr>
			</table>
		</form>
		<!-- END FORM -->
	</div><!-- /.container -->
	<!-- Bootstrap core JavaScript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="js/bootstrap.js"></script>
</body>
</html>
