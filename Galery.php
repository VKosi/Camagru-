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
	<link rel="stylesheet" href="style.css">
		<title>Gallery</title>
	</head>
	<body onload="setInterval('scroll();', 250);"</body>
			<div class="footer">
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
			$connection = new PDO("mysql:host=localhost;dbname=camagru2", "root", "000000");
			$req = $connection->prepare('SELECT COUNT(image_id) FROM images');
			$req->execute();
			$total = $req->fetchColumn();
		}
		catch(Exception $e)
		{
			echo "Couldn't count bro: " . $e->getMessage();
		}

		try
		{
			$connection = new PDO("mysql:host=localhost;dbname=camagru2", "root", "000000");
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
				<img class='gallery' style='border: 1px solid #ddd; border-radius: 4px; padding: 5px; width: 150px; margin-left: auto; margin-right: auto;' src='./pics/" . $value["link"] . "'/>";
				if (isset($_SESSION['LOGGED_ON']))
				{
					echo "<div class='likebutton'>
							<a href='like.php?pic=" . $value["link"] . "'> <img src='./include/like.png' style='width:2vw;height=2vw;'/></a>
							<a href='comment.php?pic=" . $value["link"] . "'><img src='./include/comment.png' style='width:2vw;height=2vw;'/></a>
							</div>";

					echo "<div class='likencomment'>";
					try
					{
						$connection = new PDO("mysql:host=localhost;dbname=camagru2", "root", "000000");
						$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						$req = $connection->prepare("SELECT Like_id FROM likes WHERE pic_id = :pic_id");
						$req->execute(array(
							':pic_id' => $value['image_id']
						));
					}
					catch(PDOException $e)
					{
						echo "Couldn't write in Database: " . $e->getMessage();
					}
					try
					{
						$connection = new PDO("mysql:host=localhost;dbname=camagru2", "root", "000000");
						$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						$req = $connection->prepare("SELECT Like_id FROM likes WHERE pic_id = :pic_id");
						$req->execute(array(
							':pic_id' => $value['image_id']
						));
					}
					catch(PDOException $e)
					{
						echo "Couldn't write in Database: " . $e->getMessage();
					}
					echo "</div>";
					$count = $req->rowCount();
					echo $count . '  ❤' ;
					echo "</div>";
				}

				try
					{
					$conn = new PDO("mysql:host=localhost;dbname=camagru2", "root", "000000");
					$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$sql = $conn->prepare("SELECT * FROM comments WHERE pict_id = :pict_id");
        			$sql->execute(array(
						':pict_id' => $value['image_id']
					));
					}
					catch(PDOException $e)
					{
						echo "Couldn't get comment: " . $e->getMessage();
					}
					echo "<div>";
					while($comments = $sql->fetch(PDO::FETCH_ASSOC)){
					echo $comments['Commentator'] . ': ';
					echo $comments['Content']."<br></br>";
					}
			
					echo "</div>";
			}
		echo "</div>";

		$pagenumber = ceil($total / $items);
		for($i = 1; $i <= $pagenumber; $i++)
		{
			echo "<a href='galery.php?p=". $i  ."'>" . $i . " / </a>";
		}
		?>
		
		<?php include("footer.php")?>
