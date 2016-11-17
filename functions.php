<?php
//Place all your menu links here as an array of "linktext"=>"link.php"
$menuLinks = array("Character List" => "charList.php","Spell List"=>"spellList.php","Spells By Class"=>"spellListByClass.php","Insert Spell"=>"spellInsert.php","Task List"=>"taskList.php","Logout"=>"logout.php");

//Place all your menu links here as an array of "linktext"=>"link.php" for admin pages
$adminLinks = array("Create User"=>"userCreate.php","Notes"=>"noteList.php");

//Generates the menu
function getMenu() {
	global $menuLinks;
	foreach ($menuLinks as $title => $link) {
		echo "<li class=\"\"><a href=\"$link\">$title</a></li>";
	}
}

//Generates the admin menu
function getAdminMenu() {
	global $adminLinks;
	foreach ($adminLinks as $title => $link) {
		echo "<li class=\"\"><a href=\"$link\">$title</a></li>";
	}
}

//This Function checks the level of the user. This should be adapated to check the DB, not just the session.
function checkLevel($level) {
	if ($_SESSION['level'] >= $level) {
		return true;
	}
	else {
		return false;
	}
}
?>
