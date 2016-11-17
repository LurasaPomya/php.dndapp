<?php
require_once 'checkLogin.php';
require_once 'connect.php';
require_once 'functions.php';
//Grabs the username
$user = $_SESSION['username'];

/* 
$html = null;

//Grabs Tasks
try {
  $stmt = $conn->prepare('SELECT tasks._id,tasks.author_id,tasks.added,tasks.title,tasks.priority,users.username FROM tasks INNER JOIN users ON tasks.author_id=users._id ORDER BY added');
  $stmt->execute();

  while ($row = $stmt->fetch()) {
  	$added = $row['added'];
	$id = $row['_id'];
	$title = $row['title'];
	$priority = $row['priority'];
	$username = $row['username'];

    $html .= "<tr><td>" . $added . "</td><td><a href=\"taskDesc.php?id=" . $id . "\">" . $title . "</a></td><td><span class=\"label";
	if ($priority == "High") {
			$html .=" label-danger";
		}
		elseif ($priority == "Medium") {
			$html .=" label-warning";
		}
		else {
			$html .=" label-default";
		}
		$html .= "\">" . $priority . "</span></td><td>" . $username . "</td></tr>";
  }
} catch(PDOException $e) {
  echo 'Error: ' . $e->getMessage();
}
*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Dectala's DnD GM App">
  <meta name="author" content="James McGrew (jemcgrew@gmail.com)">
  <title>Dectala's DnDApp - Task List</title>
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
        var sorting = [[1,0]];
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
  	<div class="container">
    <table id="table" class="tablesorter table">
      <thead>
        <tr>
          <th>Date Added</th>
          <th>Name</th>
          <th>Priority</th>
          <th>Added By</th>
        </tr>
      </thead>
      <tbody>
      	<tr><td colspan="4"><h2><center>This has been moved to GitLab at <a href="http://gitlab.dectala.net/websites/dndapp/issues" target="_blank">here</a></center></h2></td></tr>
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
