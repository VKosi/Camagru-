<?php
include("header.php");?>
<?php
session_start();

if (!isset($_SESSION['LOGGED_ON']) || !$_GET)
    header('location:index.php');

$pic = $_GET['pic'];
?>

<html>

<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="utf-8">
    <title>Comments</title>
</head>

<body>
    <div id="global">
        <div id="freestyle1">
            <?php
				echo '<img src="./pics/' . $pic . ' "alt="missing" style="height:20vw;width:20vw;margin-top:3vw;" />';
				echo '<form id="addcomment" action="putComment.php" method="post">
					<input type="text" placeholder="Your comment here" name="comment" style="width:20vw;" required>
					<input type="hidden" name="pic" value="' . $pic . '"/>';
				echo '<br>
					<input type="submit" value="submit">
					</form>';
				?>
        </div>
        <div id="freestyle2">
            <?php
			if ($_SESSION['LOGGED_ON'])
			{
				try{
					$connection = new PDO("mysql:host=localhost;dbname=camagru2", "root", "000000");
					$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$req = $connection->prepare("SELECT image_id FROM images where link = :link");
					$req->execute(array(
						':link' => $pic
					));
					$idphoto = $req->fetch(PDO::FETCH_COLUMN, 0);
				}
				catch(PDOException $e)
				{
					echo "Couldn't write in Database: " . $e->getMessage();
				}
				try{
					$connection = new PDO("mysql:host=localhost;dbname=camagru2", "root", "000000");
					$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$req = $connection->prepare("SELECT Content, Commentator FROM comments where pict_id = :pict_id");
					$req->execute(array(
						':pict_id' => $idphoto
					));
					$comment = $req->fetchall();
				}
				catch(PDOException $e)
				{
					echo "Couldn't write in Database: " . $e->getMessage();
				}
				foreach ($comment as $value)
				{
					echo htmlspecialchars($value['Commentator'] . ": " . $value['Content']);
					echo "<br>";
				}
			}
			?>
        </div>
    </div>
    <?php include("footer.php")?>