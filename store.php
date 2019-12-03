<?php
	session_start();
	if (!isset($_SESSION['LOGGED_ON']) || !$_POST)
	{	
		header("refresh:3;url=index2.php");
		echo "err 1";
	}
	if (isset($_SESSION['LOGGED_ON']) && isset($_POST['data']))
	{
		if (!file_exists("./pics"))
			mkdir("./pics");
		$img = $_POST['data'];

		$img = str_replace('data:image/png;base64,', '', $img);
		$img = str_replace(' ', '+', $img);
		$filedata = base64_decode($img);
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
	}
	else
	{
		header("refresh:3;url=index2.php");
	}

?>