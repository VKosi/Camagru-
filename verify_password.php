<?php
    session_start();
    $_SESSION['message'] = '';
    $_SESSION['loginerror'] = '';
    $_SESSION['loginSuccess'] = '';
    $resetok = 0;
	if (isset($_GET['email']) && isset($_GET['confirmlink']))
	{
		$email = $_GET['email'];
		$confirmlink = $_GET['confirmlink'];
		try
		{
			$con = new PDO("mysql:host=localhost;dbname=camagru2", "root", "000000");
			$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$request = $con->prepare("SELECT Email_addy, confirmlink FROM users WHERE Email_addy = :email AND confirmlink = :confirmlink AND reset_psw = '1'");
			$request->execute(array(
				':email' => $email,
				':confirmlink' => $confirmlink
			));
		}
		catch(PDOexception $e)
		{
			echo "Couldn't write in database: " . $e->getMessage();
		}
		if ($request->rowCount() > 0)
		{
			$resetok = 1;
        }
        else
        {
            $_SESSION['message'] = "Seems something went wrong please contact the webmaster & include this information: " .$confirmlink .$email;
        }
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $email = $_GET['email'];
		$confirmlink = $_GET['confirmlink'];
        if ($_POST['password'] == $_POST['psw-repeat'])
        {
            try
            {
                $password = sha1($_POST['password']);
                $con = new PDO("mysql:host=localhost;dbname=camagru2", "root", "000000");
				$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$update = $con->prepare("UPDATE users SET reset_psw = '0', confirmlink = NULL, Pass_word = :Pasword WHERE Email_addy = :email AND confirmlink = :confirmlink AND verified = '1' AND reset_psw = '1'");
				$update->execute(array(
					':email' => $email,
                    ':confirmlink' => $confirmlink,
                    ':Pasword' => $password
                ));
                echo "Successfull Login at Login page";
                header( "refresh:5;url=login.php" );
            }
            catch (PDOexception $e)
            {
                echo "Couldn't write in database: " . $e->getMessage();
            }

        }
        else
        {
            $_SESSION['message'] = "Password doesn't match";
        }
    }


 ?>
 <html>
 	<head>
 		<meta charset="utf-8">
 		<title></title>
 	</head>
 	<body>
         <?php
         if ($resetok == 1)
         {
            echo $_SESSION["message"];
            echo '<label><b> New password</b></label>
            <form class="modal-content" action="verify_password.php?email='.$email.'&confirmlink='.$confirmlink.'" method="post">
               <div class="container">

                	<input type="password" placeholder="Enter Password" name="password" required>
                   <label><b>Repeat new password</b></label>
                   <input type="password" placeholder="Repeat Password" name="psw-repeat" required>
                   <button type="submit" class="signup" name="clickme" ;>Confirm</button>
           </div>

           </form>';
         }
         ?>
        <?php include("footer.php")?>
 	</body>
 </html>