<?php
session_start();
$_SESSION['message'] = 'on';
?>
<?php
include("header.php");?>
<?php
session_start();
$_SESSION['message'] = 'on';
?>
<html>
	<head>
		<title>Gallery</title>
	</head>
	<body onload="setInterval('scroll();', 250);">
			<div class="header">
 			</div>
		</div>

		<div class="main">
		<?php

		if (isset($_GET['p']))
			$page = $_GET['p'];
		else
			$page = 1;

		$items = 10;

		try
		{
			$connection = new PDO("mysql:host=localhost;dbname=camagru2", "root", "VuyoKosi");
			$req = $connection->prepare('SELECT COUNT(image_id) FROM images');
			$req->execute();
			$total = $req->fetchColumn();
		}
		catch(Exception $e)
		{
			echo "No count: " . $e->getMessage();
		}

		try
		{
			$connection = new PDO("mysql:host=localhost;dbname=camagru2", "root", "VuyoKosi");
			$req = $connection->prepare('SELECT link, image_id FROM images ORDER BY time_stamp DESC LIMIT ' . (($page - 1)) * $items .' , ' . $items . '');
			$req->execute();
			$result = $req->fetchAll();
		}
		catch (Exception $e)
		{
			echo "Couldn't read in Database: " . $e->getMessage();
		}


			echo "<div class='galleryview'>";
			foreach ($result as $value)
			{
				echo "<div id='container'>
				<img class='gallery' style='float: right; border: 1px solid #ddd; border-radius: 4px; padding: 5px; width: 150px;;' src='./pics/" . $value['link'] . "'/>";
			echo "</div>";
			}
		echo "</div>";
		$pagenumber = ceil($total / $items);
		for($i = 1; $i <= $pagenumber; $i++)
		{
			echo "<a href='galery.php?p=". $i  ."'>" . $i . " / </a>";
		}
		?>
		<div id='block'>
				<img class='gallery' src='./pics/" . $value["link"] . "' />";
				<?php 
				if (isset($_SESSION['LOGGED_ON']))
				{
					echo "<div class='likebutton'>
					<a alt='like' href='like.php?pic='</a>
					<a alt='like' href='comment.php?pic='</a>
					</div>";
				}
				?>
		<div class="socials links">
    <a href="https://twitter.com/intent/tweet?text=http%3A//localhost%3A8080/'.WEBROOT.'/signup.php%20%23TheGru%20is%20waiting%20,Join%20now%20!%20%23IDidItForTheGru%20!">Share All the moments<img float: bottom; border="0" alt="W3Schools" src="include/twitter_PNG29.png" width="150" height="140">
</a></div>
		<?php include("footer.php")?>
