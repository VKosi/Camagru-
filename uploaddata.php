<?php
session_start();

if (!isset($_SESSION['LOGGED_ON']) || !$_GET)
	header('location:index2.php');

if ($_SESSION['LOGGED_ON'] && $_GET)
{
	if (!file_exists("./pics"))
		mkdir("./pics");
	$filter = "./include/stickers/" . $_GET['sticker'] . ".png";
	$filedata = file_get_contents("./pics/" . $_GET['data']);
	$filepath = "./pics/";
	$filesql = $_SESSION['ID'] . " " . time() . '.png';
	$filename = $filepath . $_SESSION['ID'] . " " . time() . '.png';
	file_put_contents($filename, $filedata);

	if (file_exists($filter))
	{
		$dest = imagecreatefromstring($filedata);
		$src = imagecreatefrompng($filter);
		$src = imagescale($src, imagesx($dest) * 0.5);
		imagecopy($dest, $src, 0, 0, 0, 0, imagesx($src) - 1, imagesy($src) - 1);
		imagepng($dest, $filename);
	}
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

	header("location:index2.php");
	echo "error";
}
echo "loaded on db"
 ?>