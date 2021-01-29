<?php
//if (isset($_SESSION['LOGGED_ON']))
session_start();
?>
<?php

if (isset($_SESSION['LOGGED_ON']))
	header('location:index2.php');
else
{
	$_SESSION['message'] = '';
	$_SESSION['login_OK'] = '';
	$_SESSION['login_Fail'] = '';
	$_SESSION['ID'] = '';
	$_SESSION['LOGGED_ON'] = NULL;
	$_SESSION['mailcomm'] = '';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	try
	{
        $password = sha1($_POST['psw']);
		$con = new PDO("mysql:host=localhost;dbname=camagru2", "root", "000000");
		$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$req = $con->prepare("SELECT Username FROM users WHERE Username = :username AND Pass_word = :password AND verified = '1'");
		$req->execute(array(
			':username' => $_POST['uname'],
			':password' => $password
			));
		if ($req->rowCount() > 0)
		{

            $_SESSION['login_OK'] = "You are logged on " . htmlentities($_POST['uname'], ENT_QUOTES, 'UTF-8');
            echo "You are logged on";
			$_SESSION['LOGGED_ON'] = htmlentities($_POST['uname'], ENT_QUOTES, 'UTF-8');
			try
			{
				$connection = new PDO("mysql:host=localhost;dbname=camagru2", "root", "000000");
				$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$req = $connection->prepare("SELECT userid FROM users where Username = :username");
				$req->execute(array(
					':username' => $_SESSION['LOGGED_ON']
				));
				$id = $req->fetch(PDO::FETCH_COLUMN, 0);
			}
			catch(PDOException $e)
			{
				echo "Couldn't write in Database: " . $e->getMessage();
				$_SESSION['login_good'] = '';
				$_SESSION['LOGGED_ON'] =	NULL;
			}
			$_SESSION['ID'] = $id;
			try
			{
				$connection = new PDO("mysql:host=localhost;dbname=camagru2", "root", "000000");
				$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$req = $connection->prepare("SELECT Comment_email FROM users where userid = :userid");
				$req->execute(array(
					':userid' => $_SESSION['ID']
				));
				$emailcomment = $req->fetch(PDO::FETCH_COLUMN, 0);
			}
			catch (Exception $e)
			{
				echo "Couldn't get variable : " . $e->getMessage();
			}
			$_SESSION['mailcomm'] = $emailcomment;
			header('location:index.php');
        }
		else
		{
            $_SESSION['login_err'] = "Username or password incorrect";
            echo "Username or password incorrect or you havent verified your email yet";
        }
    }
	catch (PDOexception $e)
	{
		echo "couldn't log you in : " . $e->getMessage();
	}
}
?>
<?php
  include("header.php");
?>

<html>
<head>
<meta charset="utf-8">
<meta name="description" content="This is an example of a meta descripstion. This will often show up in search results.">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Camagru</title>

<style>
.signup {
   text-align: center;
}
.container {
   text-align: center;
}
.imgcontainer {
   text-align: center;
}
</style>
</head>
<body>

<form action="login.php" method="post">
  <div class="imgcontainer">
    <img src="include/Camagru.png" alt="Avatar" class="avatar">
  </div>

<h1>Welcome to the Gru.</h1>
<div class="log_error"><?= $_SESSION['login_Fail'] ?></div>
<div class="log_succes"><?= $_SESSION['login_OK'] ?></div>

  <div class="container">
    <label for="uname"><b></b></label>
    <input type="text" placeholder="Username" name="uname" pattern="^[A-Za-z][A-Za-z0-9]{2,49}$" required>

    <div class="container">
    <label for="psw"><b></b></label>
    <input type="password" placeholder="Password" name="psw" required>

    <div class="container" style="background-color:powderblue">
    <button type="submit" onclick="window.location.href = 'login.php';">Login</button>
    <label>
      <input type="checkbox" checked="checked" name="remember" style="background-color:#f1f1f1">Remember me
    </label>
  </div>

  <div class="container" style="background-color:peargreen">
    <button type="button" class="cancelbtn">Cancel</button>
    <span class="psw"><a href="forgotpassword.php">Forgot password?</a></span>
  </div>

  <div class="signup" style="background-color:limegreen">
  <button onclick="window.location.href = 'signup.php';">Sign Up</button>
  </div>
</form>
<?php
  include("footer.php");
?>

</body>
</html>
