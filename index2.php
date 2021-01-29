<?php
	session_start();

	if (!isset($_SESSION['LOGGED_ON']))
	{
	header('location:login.php');
}
?>
<?php
include("header.php");
?>
<?php
require_once("config/setup.php");
?>
<html>
	
<style>
#main {
	width : 100%;
}
#camera {
    float:right;
    width:60%;
	height: 90%;
}

#sideview {
	float:left;
	width: 40%;
	display: inline-block;
	overflow: scroll;
	display: block;
	height: 100%;
}
.stickers
{
	position: absolute;
	margin: 2vw 0 0 30vw;

}

{
    width: 8vw;
    height: 7vw;
}
.del
{
	margin: 0 0 0vw 0vw;
	height: 11vw;
	width: 12vw;
	display: inline-block;
}
</style>
	</head>
	<body>
	
		<div class="main">
		<div id="camera">
		<?php include("camera.php");?></div>
		<div id="sideview">
		<?php

		//This will fetch logged in user's photos from database and store them in an assosiative array "result".
		if (isset($_SESSION['LOGGED_ON']))
		{
			try
			{
				$connection = new PDO("mysql:host=localhost;dbname=camagru2", "root", "000000");
				$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$req = $connection->prepare('SELECT link FROM images WHERE user_uploader = :id ORDER BY time_stamp DESC');
				$req->execute(array(
				':id' => $_SESSION['ID']
				));
				$result = $req->fetchAll();
			}
			catch (Exception $e)
			{
				echo "Couldn't load photos : " . $e->getMessage();
			}?>
			<?php
			//Here all the captured pics will be displayed in gallery, displayed with delete button.
			foreach ($result as $value)
			{
				echo "<div class='delete'>
				<img class='gallery' style='border: 1px solid #ddd; border-radius: 4px; padding: 5px; width: 150px;' src='./pics/" . $value['link'] . "'/>
				<div class='delbutton'><a href='picdelete.php?Snap=" . $value['link'] . "'><img src='./include/trash.png' style='width:3vw;height=3vw;'/></a>
				</div>
				</div>";
			}
		}
		?> </div>

	

<?php
if (isset($_SESSION['LOGGED_ON']))
{
?>
<?php
}
?>

<?php
include("footer.php");
?>
</body>
</html>