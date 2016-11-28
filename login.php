<?php
//Checks if the form is submitted or not
if ($_POST['submitted'] == "true") {
	require_once 'connect.php';

	// Grabs username and password from the form
	$username=$_POST['username'];
	$password=$_POST['password'];

	try {
		//Prepares SQL Statement
		$stmt = $conn->prepare('SELECT * FROM users WHERE username = :username');
		$stmt->bindParam(':username',$username);
		$stmt->execute();
		//Grabs the username and password, these will be empty if nothing matched.
		while ($row = $stmt->fetch()) {
			$sqlPassword = $row['php_password'];
			$is_admin = $row['is_admin'];
			$is_verified = $row['is_verified'];
			$userId = $row['_id'];
		}
	} catch(PDOException $e) {
		echo 'Error: ' . $e->getMessage();
	}

	// Tests password.
	if (password_verify($password,$sqlPassword))
	{
		//creates simple session to track user. Stores their username, login time and access level. Also creates a cookie to track auto-login
		
		session_start();
		
		$time = time();
		$expires = $time + 86400;
		$hash_string = $userId + $username + $time + $username + session_id();
		$hash = md5($hash_string);
		
		$_SESSION['username'] = $username;
		$_SESSION['login_time'] = $time;
		if ($is_admin) {
			$accessLevel = 3;
		}
		else {
			$accessLevel = 0;
		}
		$_SESSION['level'] = $accessLevel;
		$_SESSION['userId'] = $userId;
		
		setcookie("expires_time",$hash,time() + 86400);
		
		try {
			$stmt2 = $conn->prepare("UPDATE users SET session_hash=:session_hash,session_expires=:session_expires WHERE _id=:id");
			$stmt2->bindParam(':session_hash',$hash);
			$stmt2->bindParam(':session_expires',$time);
			$stmt2->bindParam(':id',$userId);
			$stmt2->execute();
			
		} catch(PDOException $e) {
		echo 'Error: ' . $e->getMessage();
	}
		
		header('Location: index.php');
	}
	else
	{
		echo "Wrong Username or Password";
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
	<title>Login to DnDApp</title>
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/signin.css" rel="stylesheet">
</head>
<body>
	<div class="container">
		<form class="form-signin" method="POST" action="login.php">
			<h2 class="form-signin-heading">Please sign in</h2>
			<label for="inputEmail" class="sr-only">Username</label>
			<input type="hidden" name="submitted" value="true">
			<input type="text" id="username" name="username" class="form-control" placeholder="Username" required autofocus>
			<label for="inputPassword" class="sr-only">Password</label>
			<input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
			<!-- <div class="checkbox">
			<label>
			<input type="checkbox" value="remember-me"> Remember me
			</label>
			</div> -->
			<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
		</form>
	</div> <!-- /container -->
</body>
</html>
