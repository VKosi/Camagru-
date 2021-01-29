<?php
	session_start();

	if (!isset($_SESSION['LOGGED_ON']))
		header('location:Galery.php');

	if ($_SESSION['LOGGED_ON'])
	{
		$pic = $_POST['pic'];
		try{
			$connection = new PDO("mysql:host=localhost;dbname=camagru2", "root", "000000");
			$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$req = $connection->prepare("SELECT image_id, username FROM images  where link = :link");
			$req->execute(array(
				':link' => $_POST['pic']
			));
			$idphoto = $req->fetch();
		}
		catch(PDOException $e)
		{
			echo "Couldn't write in Database: " . $e->getMessage();
		}
		try
		{
			$connection = new PDO("mysql:host=localhost;dbname=camagru2", "root", "000000");
			$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$req = $connection->prepare('SELECT email FROM users  where username = :username');
			$req->execute(array(
				':username' => $idphoto['username']
			));
			$email = $req->fetch();
		}
		catch(PDOException $e)
		{
			echo "Couldn't write in Database: " . $e->getMessage();
		}
		if (!isset($idphoto['PhotoID']))
			header('location:Galery.php');
		try
		{
			$connection = new PDO("mysql:host=localhost;dbname=camagru2", "root", "000000");
			$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$req = $connection->prepare('INSERT INTO comments (pict_id, Commentator, Comment_time, Content) VALUES (:pict_id, :Commentator , NOW(), :Content)');
			$req->execute(array(
				':pict_id' => $idphoto['image_id'],
				':Commentator' => $_SESSION['LOGGED_ON'],
				':Content' => $_POST['comment']
			));
		}
		catch(PDOException $e)
		{
			echo "Couldn't write in Database: " . $e->getMessage();
		}
		$to       =  $email['email'];
		$subject  = 'Your a hit ! Someone commented on your Picture !';
		$message  = '

		Your picture has been commented,

		'.$_SESSION['LOGGED_ON'].' : '.$_POST['comment'].'

		Click on this link to see more: http://localhost/Camagru-/comment.php?pic= '.$pic.'
		';

		$headers = 'From:automsg@thegru.com' . "\r\n";

		if($_SESSION['Comment_email'] == 1)
		{
			mail($to, $subject, $message, $headers);
			header('refresh:10;url=comment.php?pic=' . $pic . '');
		}
		header('refresh:10;url=comment.php?pic=' . $pic . '');

	}

 ?>