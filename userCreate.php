<?php
//Checks if user is logged in
require_once 'checkLogin.php';
require_once 'functions.php';

//Debug Data, REMOVE THIS WHEN RELEASED!!!

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (!checkLevel(3)) { echo "You don't have access to this!"; break; }
  require_once 'connect.php';

  $username = $_REQUEST['username'];
  $password = $_REQUEST['password'];
  $level = $_REQUEST['level'];

  $password = password_hash($password, PASSWORD_DEFAULT);

  $stmt = $conn->prepare("INSERT INTO users (username,php_password,level) VALUES (:username,:password,:level)");
  $stmt->bindParam(':username',$username);
  $stmt->bindParam(':password',$password);
  $stmt->bindParam(':level',$level);


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
<title>Add User - DDNDApp</title>
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
<?php if (!checkLevel(3)) { echo "You don't have access to this!"; break; } ?>
<div class="container">
  <!-- BEGIN FORM -->
  <form name="user_insert" method="post" action="">
    <input type="hidden" name="submitted" value="true">
    <strong>Create New User</strong><br />
    Name:<input name="username" type="text" id="username"><br />
    Password:<input name="password" type="password" id="password"><br />
    Level:<input name="level" type="number" id="level" min=0 max=3><br />
    <ul>
      <li>0 = Anyone, no access to anything but spell list</li>
      <li>1 = Player, View Spells</li>
      <li>2 = GM, View Spells, Add Spells, Add Notes, View Notes <b>(DO NOT DO THIS WITHOUT ASKING JAMES FIRST)</b></li>
      <li>3= Admin, Do Anything <b>(If you are not James then you shouldn't be doing this one)</b></li>
    </ul>
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
