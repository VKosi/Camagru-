<?php
  include("database.php");
?>
<?php
  //include("../camera_stills_folder.php");
?>
<?php
  include("../make_pics_folder.php");
?>
<?php
    
    try {
        $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
      
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //echo "Connected successfully";
        $sql = "CREATE DATABASE IF NOT EXISTS camagru2;";
        $conn->exec($sql);
        //echo "database Users made";
        }
    catch(PDOException $e)
        {
        echo "Connection failed: " . $e->getMessage();
        }

        try {
            $db = new PDO("mysql:host=localhost;dbname=camagru2", "root", "VuyoKosi");
            
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo "Connected successfully";
            $sql = "CREATE TABLE IF NOT EXISTS Users (
            userid int(10) AUTO_INCREMENT PRIMARY KEY NOT NULL,
            Username varchar(255) NOT NULL,
            Email_addy varchar(255) NOT NULL,
            verified INT NOT NULL DEFAULT 0,
            Pass_word varchar(255) NOT NULL,
            confirmlink varchar(255),
            reset_psw INT NOT NULL DEFAULT 0,
            Comment_email INT NOT NULL DEFAULT 0
            )";
            $db->exec($sql);
            //echo "table Users made";
            }
        catch(PDOException $e)
            {
            echo "Couldn't Create Table " . $e->getMessage();
            }
            $conn = null;

            try {
                $db = new PDO("mysql:host=localhost;dbname=camagru2", "root", "VuyoKosi");
            
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo "Connected successfully";
                $sql = "CREATE TABLE IF NOT EXISTS comments (
                Commentator varchar(255) NOT NULL,
                pict_id INT NOT NULL,
                CommentID INT NOT NULL PRIMARY KEY,
                Comment_time DATETIME NOT NULL,
                Content TEXT NOT NULL
                )";
                $db->exec($sql);
                //echo "table comments made ";
                }
            catch(PDOException $e)
                {
                echo "Couldn't Create Table" . $e->getMessage();
                }
            
                try {
                    $db = new PDO("mysql:host=localhost;dbname=camagru2", "root", "VuyoKosi");
            
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo "Connected successfully";
                    $sql = "CREATE TABLE IF NOT EXISTS likes(
                    UserID varchar(100) NOT NULL,
                    pic_id varchar(100) NOT NULL,
                    Like_id int(100) NOT NULL PRIMARY KEY
                    )";
                    $db->exec($sql);
                    //echo "table likes made ";
                    }
                catch(PDOException $e)
                    {
                    echo "Couldn't Create Table" . $e->getMessage();
                    }
                
                    try {
                        $db = new PDO("mysql:host=localhost;dbname=camagru2", "root", "VuyoKosi");
            
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo "Connected successfully";
                        $sql = "CREATE TABLE IF NOT EXISTS images(
                        image_id int(100) AUTO_INCREMENT NOT NULL PRIMARY KEY,
                        username VARCHAR(255) NOT NULL,
                        link VARCHAR(1000) NOT NULL,
                        user_uploader varchar(100),
                        time_stamp DATETIME NOT NULL
                        )";
                        $db->exec($sql);
                        //echo "table images made ";
                        }
                    catch(PDOException $e)
                        {
                        echo "Couldn't Create Table" . $e->getMessage();
                        }
?>