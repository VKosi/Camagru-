<?php
//session_start();
if (!isset($_SESSION['LOGGED_ON']))
header("logout.php");
?>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
.header {
   position: top;
   left: 0;
   top: 0;
   width: 100%;
   background-color: white;
   color: white;
   text-align: left;
   padding-left: 10px;
}
</style><title>Camagru</title>
</head>

<header>

</header>
<div class="header">
<nav>
<a href="#">
<head>
		<meta charset="utf-8">
		<style>
      .header-basic-light{
	padding: 20px 40px;
	box-sizing:border-box;
	box-shadow: 0 0 7px 0 rgba(0, 0, 0, 0.15);
	height: 80px;
	background-color: #fff;
}

.header-basic-light .header-limiter {
	max-width: 1200px;
	text-align: center;
	margin: 0 auto;
}

/* Logo */

.header-basic-light .header-limiter h1{
	float: left;
	font: normal 28px Cookie, Arial, Helvetica, sans-serif;
	line-height: 40px;
	margin: 0;
}

.header-basic-light .header-limiter h1 span {
	color: #5383d3;
}

/* The header links */

.header-basic-light .header-limiter a {
	color: #5c616a;
	text-decoration: none;
}

.header-basic-light .header-limiter nav{
	font:15px Arial, Helvetica, sans-serif;
	line-height: 40px;
	float: right;
}

.header-basic-light .header-limiter nav a{
	display: inline-block;
	padding: 0 5px;
	opacity: 0.9;
	text-decoration:none;
	color: #5c616a;
	line-height:1;
}

.header-basic-light .header-limiter nav a.selected {
	background-color: #86a3d5;
	color: #ffffff;
	border-radius: 3px;
	padding:6px 10px;
}

/* Making the header responsive. */

@media all and (max-width: 600px) {

	.header-basic-light {
		padding: 20px 0;
		height: 85px;
	}

	.header-basic-light .header-limiter h1 {
		float: none;
		margin: -8px 0 10px;
		text-align: center;
		font-size: 24px;
		line-height: 1;
	}

	.header-basic-light .header-limiter nav {
		line-height: 1;
		float:none;
	}

	.header-basic-light .header-limiter nav a {
		font-size: 13px;
	}

}

/* For the headers to look good, be sure to reset the margin and padding of the body */

body {
	margin:0;
	padding:0;
}
      </style>
      <title>Camagru</title>
	</head>
</body>
</html> <html>

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Camagru</title>

</head>

<body>

<header class="header-basic-light">

	<div class="header-limiter">

    <h1><a href="login.php">Cama<span>gru</span></a></h1>
    <nav>
    <?php

 			if (isset($_SESSION['LOGGED_ON']))
 			{
				echo '<a href="settings.php">settings</a>';
				echo '<a href="Galery.php">gallery</a>';
        echo '<a href="logout.php">logout</a>';
        echo '<a href="index2.php">upload</a>';
      }
      else
 			{
				echo '<a href="login.php">Log in</a>';
				echo '<a href="Signup.php" class="selected">SignUp</a>';
				echo '<a href="Galery.php">gallery</a>';
 			}

 			?>
</nav>
	</div>

</header>
