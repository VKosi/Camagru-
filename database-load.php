<?php
session_start();
include 'include/webroot.php';
  
if(isset($_POST['username'])){
$Username = $_POST['username'];
}
if(isset($_POST['psw-repeat'])){
$password = sha1($_POST['psw-repeat']);
}
if(isset($_POST['psw'])){
$passwordconf = sha1($_POST['psw']);
}
if(isset($_POST['email'])){
$emails = $_POST['email'];
}

?>
<?php
include("config/database.php");
?>
<?php

$_SESSION["message"] = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if ($_POST['psw'] == $_POST['psw-repeat'])
    {
        if (preg_match("/^[a-zA-Z0-9]*$/", $Username = $_POST['username']))
        {
            if(strlen($_POST['psw']) > 8)
            {
                if(preg_match("#[0-9]+#", $_POST['psw']))
                {
                    if(preg_match("#[a-zA-Z]+#", $_POST['psw']))
                    {
                        try
                        {
                            $emails = $_POST['email'];
                            $con = new PDO("mysql:host=localhost;dbname=camagru2", "root", "000000");
							$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
							$request = $con->prepare("SELECT Email_addy FROM users WHERE Email_addy = :Email_addy;");
                            $request->bindParam(':Email_addy', $emails);
                            $request->execute();
                        }
                        catch(PDOException $e)
                        {
                            echo "Couldn't write in database: " . $e->getMessage();
                        }
                        if ($request->rowCount() == 0)
                        {
                            if (filter_var($emails = $_POST['email'], FILTER_VALIDATE_EMAIL))
                            {
                                try
                                {
                                    $con = new PDO("mysql:host=localhost;dbname=camagru2", "root", "000000");
                                    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                    $request = $con->prepare("SELECT Username FROM users WHERE Username = :name;");
                                    $request->bindParam(':name', $Username);
                                    $request->execute();
                                }
                                catch(PDOException $e)
                                {
                                    echo "Couldn't write in database: " . $e->getMessage();
                                }
                                if ($request->rowCount() == 0)
                                {
                                    try
                                    {
                                        $confirmlink = md5( rand(0,1000) );
                                        $password = sha1($_POST['psw-repeat']);
                                        $bdd = new PDO("mysql:host=localhost;dbname=camagru2", "root", "000000");
                                        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                        $req = $bdd->prepare('INSERT INTO users (Username, Pass_word, Email_addy, confirmlink, Comment_email) VALUES (:Username, :Pass_word, :Email_addy, :confirmlink, :Comment_email)');
                                        $req->execute(array(
                                            ':Username' => $_POST['username'],
                                            ':Pass_word' => $password,
                                            ':Email_addy' => $emails,
                                            ':confirmlink' => $confirmlink,
                                            ':Comment_email' => 1));
                                    }
                                    catch(PDOException $e)
                                    {
                                        echo "Couldn't write in database: " . $e->getMessage();
                                    }
                                    $to       =  $emails = $_POST['email'];
                                    $subject  = 'Signup | Verification';
                                    $message  = '

                                    Hello, '.$Username.'

                                    Thanks for signing up!
                                    Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.

                                    ------------------------
                                    Username: '.$Username.'
                                    ------------------------

                                    Please click this link to activate your account:
                                    http://localhost/Camagru-/verification.php?email='.$emails = $_POST['email'].'&confirmlink='.$confirmlink.'';

                                    $headers = 'From:automsg@thegru.com' . "\r\n";
                                    mail($to, $subject, $message, $headers);
                                    echo("Mail Is on the Way !");
                                    header( "refresh:1;url=created_success.php" );
                                }
                                else
                                {
                                    $_SESSION['message'] ='Username already taken';
                                    echo("Username already taken");
                                    header( "refresh:10;url=signup.php" );

                                }
                            }
                            else
                            {
                                $_SESSION['message'] ='Invalid email format';
                                echo("invalid email format");
                                header( "refresh:10;url=signup.php" );
                            }
                        }
                        else
                        {
                            $_SESSION['message'] = 'Email already used';
                            echo("Email already used");
                            header( "refresh:10;url=signup.php" );
                        }
                    }
                    else
                    {
                        $_SESSION['message'] = 'Password must include at least one letter';
                        echo("Password must include at least one letter");
                        header( "refresh:10;url=signup.php" );
                    }
                }
                else
                {
                    $_SESSION['message'] = 'Password must include at least one number';
                    echo("Password must include at least one number");
                    header( "refresh:10;url=signup.php" );
                }
            }
            else
            {
                $_SESSION['message'] = 'Password must be at least 8 characters long';
                echo("Password must be at least 8 characters long");
                header( "refresh:10;url=signup.php" );
            }
        }
        else
        {
            $_SESSION['message'] = 'Invalid username use only letters or numbers';
            echo("Invalid username use only letters or numbers");
            header( "refresh:10;url=signup.php" );
        }
    }
    else
    {
        $_SESSION["message"] = "Your password must match";
        echo("Your password must match");
        header( "refresh:10;url=signup.php" );
    }
}
?>