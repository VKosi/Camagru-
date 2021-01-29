<?php
include("header.php");

?>

<html>
	<head>
		<meta charset="utf-8">
		<link rel="icon" type="image/png" href="./sources/icons/camagru.ico" />
		<title>Password-Reset</title>
	</head>
	<body>
		<div class="main">
		<form class="modal-content" action="forgotpassword.php" method="post">
            <div style = "padding:14%">
                <label><b>Email</b></label>
                <input type="text" placeholder="Enter Email Address" name="Email" required>
                <div class="clearfix" style="text-align: center;">
                    <button type="submit" class="signup" name="clickme" style= "margin-right: 3%">Reset Password</button>
                </div>
            </div>
        </form>
		</div>
		<?php include("footer.php")?>

	</body>
</html>
<?php
session_start();
$_SESSION['message'] = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	try
	{
        $email = $_POST["Email"];
		$con = new PDO("mysql:host=localhost;dbname=camagru2", "root", "000000");
		$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$req = $con->prepare("SELECT Username FROM users WHERE Email_addy = :email");
        $req->execute(array(':email' => $email));
		if ($req->rowCount() > 0)
		{
            $datauser = $req->fetch();
            $username =	$datauser['Username'];
            try
            {
                $result = $con->query("SELECT verified FROM users WHERE Email_addy = " . "'" . $email . "'");
            }
            catch (PDOexception $e)
            {
                echo "Error Database : " . $e->getMessage();
            }

            $dataresetstate = $result->fetch();
            $activated = $dataresetstate['verified'];
            if ($activated == 1)
            {
                try
                {
                    $confirmlink = md5( rand(0,1000) );
                    $update = $con->prepare("UPDATE users SET reset_psw = '1', confirmlink = :confirmlink WHERE Email_addy = :Email_addy");
                    $update->execute(array(
                        ':Email_addy' => $email,
                        ':confirmlink' => $confirmlink
                    ));
                }
                catch(PDOexception $e)
                {
                    echo "Error Database : " . $e->getMessage();
                }
                $to       =  $email;
                $subject  = 'Camagru | Reset your password';
                $message  = '

                Hi, '.$username.'

                This email has been sent automatically by Camagru to your request to recorver your password.

                ------------------------
                Username: '.$username.'
                ------------------------

                Please click this link to reset your account password:
                http://localhost/Camagru-/verify_password.php?email='.$email.'&confirmlink='.$confirmlink.'';
                $headers = 'From:automsg@thegru.com' . "\r\n";
                mail($to, $subject, $message, $headers);
                $_SESSION['login_success'] = "Reset Email has been sent";
                header("refresh:5;url=logout.php" );
                echo "Reset Email has been sent";
            }
            else
            {
                $_SESSION['login_err'] = "Your account is not activated yet, please check your Inbox or Spam";
                echo("Your account is not activated yet, please check your Inbox or Spam");
                echo "no such email";
            }

        }
		else
		{
            $_SESSION['login_err'] = "Email doesn't exist";
		}
	}
	catch (PDOexception $e)
	{
		echo "Error Database : " . $e->getMessage();
	}
}
 ?>