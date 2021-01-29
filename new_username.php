<?php
include("header.php");
?><?php
	session_start();
	if (!isset($_SESSION['LOGGED_ON']))
		header('location:index.php');
		try
		{
			$connection = new PDO("mysql:host=localhost;dbname=camagru2", "root", "000000");
			$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$update = $connection->prepare("SELECT * FROM users WHERE Username = :username");
			$update->execute(array(
				':username' => $_POST['newname']));
		}
		catch (Exception $e)
		{
			echo "Couldn't update : " . $e->getMessage();
		}
		if ($update->rowCount() == 0 && $_POST['newname'])
		{
			try
			{
				$connection = new PDO("mysql:host=localhost;dbname=camagru2", "root", "000000");
				$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$update = $connection->prepare("UPDATE images SET username = :newusername WHERE username = :username");
				$update->execute(array(
					':newusername' => htmlspecialchars($_POST['newname']),
					':username' => $_SESSION['LOGGED_ON']
				));
			}
			catch (Exception $e)
			{
				echo "Couldn't update : " . $e->getMessage();
			}
			try
			{
				$connection = new PDO("mysql:host=localhost;dbname=camagru2", "root", "000000");
				$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$update = $connection->prepare("UPDATE users SET Username = :newusername WHERE Username = :username");
				$update->execute(array(
					':newusername' => htmlspecialchars($_POST['newname']),
					':username' => $_SESSION['LOGGED_ON']
				));
			}
			catch (Exception $e)
			{
				echo "Couldn't update : " . $e->getMessage();
			}
			$_SESSION['LOGGED_ON'] = htmlspecialchars($_POST['newname']);
			header('location:settings.php');
		}
		else {
			echo "Please update username in settings";
			header( "refresh:2;url=settings.php" );
		}
 ?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Change-Username</title>
	</head>
    <?php
include("footer.php");
?>
	<body>
	</body>
</html>