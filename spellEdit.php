<?php
require_once 'checkLogin.php';
require_once 'functions.php';
require_once 'connect.php';

$spell_id = $_REQUEST['id'];

//Debug Data, REMOVE THIS WHEN RELEASED!!!

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_REQUEST['update'] == "true") {
	if (!checkLevel(3)) { echo "You don't have access to this!"; break; }

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
	$at_higher = $_REQUEST['at_higher'];
	$at_higher = addslashes($athigher);
	$at_higher = nl2br($at_higher);
	//Prepares SQL Statement
	$stmt = $conn->prepare("UPDATE spells SET name=:name,school=:school,level=:level,ritual=:ritual,concentration=:concentration,spell_class=:spell_class,casting_time=:casting_time,v_comp=:v_comp,s_comp=:s_comp,m_comp=:m_comp,m_comp_desc=:m_comp_desc,focus=:focus,consumable=:consumable,spell_range=:spell_range,duration=:duration,page=:page,saving_throw=:saving_throw,damage_type=:damage_type,damage=:damage WHERE _id=:spell_id");
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
	//$stmt->bindParam(':description',$description);
	//$stmt->bindParam(':at_higher',$at_higher);
	$stmt->bindParam(':spell_id',$spell_id);



	//Executes SQL Statement
	if ($stmt->execute())
	{
		header("location:spellDesc.php?id=" . $spell_id);
	}
	else
	{
		$error = $stmt->errorInfo();
		print_r($error);
	}

}
else {

	$stmt = $conn->prepare('SELECT * FROM spells WHERE _id = :spell_id');
	$stmt->execute(array('spell_id' => $spell_id));
	while ($row = $stmt->fetch()) {

		$spell_id = $row['_id'];
		$name = $row['name'];
		$level = $row['level'];
		$school = $row['school'];
		$ritual = $row['ritual'];
		$concentration= $row['concentration'];
		$classes = $row['spell_class'];
		$casting_time = $row['casting_time'];
		$v_comp = $row['v_comp'];
		$s_comp = $row['s_comp'];
		$m_comp = $row['m_comp'];
		$m_comp_desc = $row['m_comp_desc'];
		$focus = $row['focus'];
		$consumable = $row['consumable'];
		$spell_range = $row['spell_range'];
		$duration = $row['duration'];
		$page = $row['page'];
		$saving_throw = $row['saving_throw'];
		$damage_type = $row['damage_type'];
		$damage = $row['damage'];
		$description = $row['description'];
		$at_higher = $row['at_higher'];

    	$breaks = array("<br />","<br>","<br/>");
    	$description = str_ireplace($breaks, "\n", $description);
		$at_higher = str_ireplace($breaks, "\n", $at_higher);
		$at_higher = stripslashes($at_higher);
		$description = stripslashes($description);
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
		<form name="spell_insert" method="post" action="spellEdit.php">
			<input type="hidden" name="update" value="true">
			<input type="hidden" name="id" id="id" value="<?php echo $spell_id; ?>"><br />
			<strong>Insert New Spell</strong><br />
			Name:<input name="name" type="text" id="name" value="<?php echo $name; ?>"><br />
			School:<input name="school" type="text" id="school" value="<?php echo $school; ?>"><br />
			Level:<input name="level" type="number" id="level" min=0 max=9 value="<?php echo $level; ?>"><br />
			Ritual:<input name="ritual" type="checkbox" id="ritual" <?php if($ritual) {echo "checked";} ?>><br />
			Concentration:<input name="concentration" type="checkbox" id="concentration" <?php if($concentration) {echo "checked";} ?>><br />
			Used By:
			<input name="bard" type="checkbox" id="bard" <?php if (preg_match('/Bard/',$classes)) { echo "checked"; } ?>>Bard
			<input name="cleric" type="checkbox" id="cleric" <?php if (strpos($classes,"Cleric")) { echo "checked"; } ?>>Cleric
			<input name="druid" type="checkbox" id="druid" <?php if (strpos($classes,"Druid")) { echo "checked"; } ?>>Druid
			<input name="paladin" type="checkbox" id="paladin" <?php if (strpos($classes,"Paladin")) { echo "checked"; } ?>>Paladin
			<input name="ranger" type="checkbox" id="ranger" <?php if (strpos($classes,"Ranger")) { echo "checked"; } ?>>Ranger
			<input name="sorcerer" type="checkbox" id="sorcerer" <?php if (strpos($classes,"Sorcerer")) { echo "checked"; } ?>>Sorcerer
			<input name="warlock" type="checkbox" id="warlock" <?php if (strpos($classes,"Warlock")) { echo "checked"; } ?>>Warlock
			<input name="wizard" type="checkbox" id="wizard" <?php if (strpos($classes,"Wizard")) { echo "checked"; } ?>>Wizard<br />
			Casting Time:<input name="casting_time" type="text" id="casting_time" value="<?php echo $casting_time; ?>"><br />
			Verbal Component:<input name="v_comp" type="checkbox" id="v_comp" <?php if($v_comp) {echo "checked";} ?>><br />
			Semantic Component:<input name="s_comp" type="checkbox" id="s_comp" <?php if($s_comp) {echo "checked";} ?>><br />
			Material Component:<input name="m_comp" type="checkbox" id="m_comp" <?php if($m_comp) {echo "checked";} ?>><br />
			Material Component Description:<input name="m_comp_desc" type="text" id="m_comp_desc" value="<?php echo $m_comp_desc; ?>"><br />
			Focus:<input name="focus" type="text" id="focus" value="<?php echo $focus; ?>"><br />
			Material Consumed:<input name="consumable" type="checkbox" id="consumable"<?php if($consumable) {echo "checked";} ?>><br />
			Spell Range:<input name="spell_range" type="text" id="spell_range" value="<?php echo $spell_range; ?>"><br />
			Duration:<input name="duration" type="text" id="duration" value="<?php echo $duration; ?>"><br />
			Page # in PHB:<input name="page" type="text" id="page" value="<?php echo $page; ?>"><br />
			Saving Throw:<input name="saving_throw" type="text" id="saving_throw" value="<?php echo $saving_throw; ?>"><br />
			Damage Type:<input name="damage_type" type="text" id="damage_type" value="<?php echo $damage_type; ?>"><br />
			Damage:<input name="damage" type="text" id="damage" value="<?php echo $damage; ?>"><br />
			<!--Description:<textarea name="description" type="text" id="description" rows="25" cols="100"><?php echo $description; ?></textarea><br />
			At Higher Levels:<textarea name="atHigher" type="text" id="atHigher" rows="25" cols="100"><?php echo $at_higher; ?></textarea><br />-->
			<input type="submit" name="Submit" value="Submit">
		</form>
		<!-- END FORM -->
	</div><!-- /.container -->
	<!-- Bootstrap core JavaScript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="js/bootstrap.js"></script>
</body>
</html>
