<?php

include("database.php");

try {
    $conn = new PDO("mysql:host=$servername;dbname=camagru2", $username, $password);
  
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
    $sql = "CREATE DATABASE camagru2";
    echo "database Users made";
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
?>