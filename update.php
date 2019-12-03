<?php
	session_start();
	if (!isset($_SESSION['LOGGED_ON']))
		try
		{
			$connection = new PDO("mysql:host=localhost;dbname=camagru2", "root", "vuyokosi");
			$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$update = $connection->prepare("SELECT * FROM users WHERE username = :username");
			$update->execute(array(
				':username' => $_POST['newname']));
		}
		catch (Exception $e)
		{
			echo "Couldn't update : " . $e->getMessage();
		}
		if ($update->rowCount() == 0 && $_POST['newname'])
		{
			try
			{
				$connection = new PDO("mysql:host=localhost;dbname=camagru2", "root", "vuyokosi");
				$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$update = $connection->prepare("UPDATE Photos SET username = :newusername WHERE username = :username");
				$update->execute(array(
					':newusername' => htmlspecialchars($_POST['newname']),
					':username' => $_SESSION['LOGGED_ON']
				));
			}
			catch (Exception $e)
			{
				echo "Couldn't update : " . $e->getMessage();
			}
			try
			{
				$connection = new PDO("mysql:host=localhost;dbname=camagru2", "root", "vuyokosi");
				$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$update = $connection->prepare("UPDATE users SET username = :newusername WHERE username = :username");
				$update->execute(array(
					':newusername' => htmlspecialchars($_POST['newname']),
					':username' => $_SESSION['LOGGED_ON']
				));
			}
			catch (Exception $e)
			{
				echo "Couldn't update : " . $e->getMessage();
			}
			$_SESSION['LOGGED_ON'] = htmlspecialchars($_POST['newname']);
			header('settings.php');
		}
		else {
			echo "Update username in settings";
		}
 ?>

<?php
	session_start();
	if (!isset($_SESSION['LOGGED_ON']))
		header('location:index.php');
		try
		{
			$connection = new PDO("mysql:host=localhost;dbname=camagru2", "root", "vuyokosi");
			$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$update = $connection->prepare("SELECT * FROM users WHERE email = :newmail");
			$update->bindParam(':newmail', $_POST['newmail']);
			$update->execute();
		}
		catch (Exception $e)
		{
			echo "Couldn't update : " . $e->getMessage();
		}
		if ($update->rowCount() == 0 && $_POST['newmail'] && filter_var($email = $_POST['newmail'], FILTER_VALIDATE_EMAIL))
		{
		try
		{
			$connection = new PDO("mysql:host=localhost;dbname=camagru2", "root", "vuyokosi");
			$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$update = $connection->prepare("UPDATE users SET email = :newmail WHERE username = :username");
			$update->execute(array(
				':newmail' => $_POST['newmail'],
				':username' => $_SESSION['LOGGED_ON']
			));
		}
		catch (Exception $e)
		{
			echo "Couldn't update : " . $e->getMessage();
		}
		header('location:settings.php');
		}
		else
		{
			echo "Update email in settings";
			header( "refresh:2;url=settings.php" );
		}
 ?>