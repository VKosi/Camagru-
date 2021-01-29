<?php
session_start();
if (!isset($_SESSION['LOGGED_ON']) || !$_GET)
	header('location:index.php');

$_SESSION["message"] = '';

    if ($_SESSION['LOGGED_ON'])
    {
        $id = $_SESSION['ID'];
        $picname = htmlspecialchars($_GET['pic']);
        try{
            $connection = new PDO("mysql:host=localhost;dbname=camagru2", "root", "000000");
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $req = $connection->prepare("SELECT image_id FROM images where link = :link");
            $req->execute(array(
                ':link' => $picname
            ));
            $idphoto = $req->fetch(PDO::FETCH_COLUMN, 0);
        }
        catch(PDOException $e)
        {
            echo "Couldn't write in Database: " . $e->getMessage();
        }
        try
        {
            $connection = new PDO("mysql:host=localhost;dbname=camagru2", "root", "000000");
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $req = $connection->prepare("SELECT Like_id FROM likes WHERE Userid = :UserID AND pic_id = :pic_id");
            $req->execute(array(
                ':UserID' => $id,
                ':pic_id' => $idphoto
            ));
        }
        catch(PDOException $e)
        {
            echo "Couldn't write in Database: " . $e->getMessage();
        }
        if ($req->rowCount() > 0)
        {
            try
            {
                $connection = new PDO("mysql:host=localhost;dbname=camagru2", "root", "000000");
                $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $req = $connection->prepare("DELETE FROM likes WHERE UserID = :UserID AND pic_id = :pic_id");
                $req->execute(array(
                    ':UserID' => $id,
                    ':pic_id' => $idphoto
                ));
            }
            catch(PDOException $e)
            {
                echo "Couldn't write in Database: " . $e->getMessage();
            }
            header( "refresh:0;url=galery.php" );
        }
        else
        {
            try
            {
                $connection = new PDO("mysql:host=localhost;dbname=camagru2", "root", "000000");
                $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $req = $connection->prepare("INSERT INTO likes (UserID, pic_id) VALUES (:UserID, :pic_id)");
                $req->execute(array(
                    ':UserID' => $id,
                    ':pic_id' => $idphoto
                ));
            }
            catch(PDOException $e)
            {
                echo "Couldn't write in Database: " . $e->getMessage();
            }
				header('location:galery.php');
        }
    }
    else
    {
        echo "You need to be Logged in -to use this feature";
    }
 ?>