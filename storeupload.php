<?php
	session_start();
	if (!isset($_SESSION['LOGGED_ON']) || !$_GET)
	{	
		//header("refresh:3;url=index2.php");
		echo "err 1";
	}
	if (isset($_SESSION['LOGGED_ON']) && isset($_GET))
	{
		if (!file_exists("./pics"))
			mkdir("./pics");
		$filedata = file_get_contents("./pics/" . $_GET['data']);
		$filepath = "./pics/";
		$filesql = $_SESSION['ID'] . " " . time() . '.png';
		$filename = $filepath . $_SESSION['ID'] . " " . time() . '.png';
		file_put_contents($filename, $filedata);
		try
		{
			$connection = new PDO("mysql:host=localhost;dbname=camagru2", "root", "VuyoKosi");
			$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$req = $connection->prepare('INSERT INTO images (username, time_stamp, link, user_uploader) VALUES (:username, NOW() , :link, :user_uploader)');
			$req->execute(array(
				':username' => $_SESSION['LOGGED_ON'],
				':link' => $filesql,
				':user_uploader' => $_SESSION['ID']
			));
		}
		catch(PDOException $e)
		{
			echo "Couldn't write in Database: " . $e->getMessage();
		}
		echo $filename;
		header("refresh:3;url=index2.php");
	}
	else
	{
		echo "err 2";
	}
?>