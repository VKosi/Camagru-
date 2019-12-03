
<?php
	session_start();

	//if(!isset($_SESSION['LOGGED_ON']))
	//	header('location:index.php');


	//if (isset($_SESSION['LOGGED_ON']))
?>
<?php include("header.php");
?>
<html>
	<head>
		<meta charset="utf-8">
		<title>Settings</title>
	</head>
	<body>
			<form class="" action="new_username.php" method="post">
				<input type="text" name="newname" value="" placeholder="New Username" required>
				<input type="submit" name="submit" value="change username">
			</form>
			<form class="" action="new_email.php" method="post">
				<input type="text" name="newmail" value="" placeholder="New Email"  required>
				<input type="submit" name="submit" value="change email">
			</form>
			<form class="" action="forgotpassword.php" method="post">
				<input type="submit" name="submit" value="change password">
			</form>
			<form class="" action="index.html" method="post">
				<br>
					<?php
						if ($_SESSION['mailcomm'] == 1)
							echo "<a href='Comment-email-off.php'><button type='button' name='commentson'>I don't want to receive emails when my photos are commented anymore</button></a>";
						else if ($_SESSION['mailcomm'] == 0)
                           echo "<a href='Comment-email-on.php'><button type='button' name='commentsoff'>I want to receive emails when my photos are commented </button></a>";
					?>
			</form>
    
	</body>
</html>

<?php include("footer.php");?>