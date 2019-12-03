<?php
session_start();
session_destroy();
{
    header("Location:login.php"); // Redirecting To Home Page
}
?>