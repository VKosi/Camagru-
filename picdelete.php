<?php
session_start();
?>
<?php

if (isset($_GET))
	header('location:index2.php');
	echo"1";

$pic = explode(" ", $_GET['Snap']);
$path = "./pics/";
if ($_SESSION['ID'] === $pic[0])
{
	$pic = implode(" ", $pic);
	unlink("$path" . "$pic");
	header("location:index2.php");
	echo "$pic";

	try
	{
		$connectionection = new PDO("mysql:host=localhost;dbname=camagru2", "root", "000000");
		$connectionection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$req = $connectionection->prepare('DELETE FROM images WHERE link = :link');
		$req->execute(array(
			':link' => $pic
		));

	}
	catch (Exception $e)
	{
		echo "Cant delete" . $e->getMessage();
	}

}

//else {
//	header( "refresh:2;url=index.php" );
//	echo "Gone ..";
//}
?>
