<?php
	session_start();

	if (!isset($_SESSION['LOGGED_ON']))
		header('location:login.php');
		$username = $_GET['username'];
	try
	{
		$connection = new PDO("mysql:host=localhost;dbname=camagru2", "root", "000000");
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$update = $connection->prepare("UPDATE users SET Comment_email = '0' WHERE Username = :username");
		$update->execute(array(
			':username' => $_SESSION['LOGGED_ON']
		));
	}
	catch (Exception $e)
	{
		echo "Couldn't update : " . $e->getMessage();
	}
	$_SESSION['mailcomm'] = 0;
	header('location:settings.php');
?>