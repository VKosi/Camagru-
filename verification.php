<?php 
include('webroot.php');
if(isset($_GET['confirmlink'])){
    $confirmlink = $_GET['confirmlink'];
}
if(isset($_GET['email'])){
    $emails = $_GET['email'];
}
?>
<?php
session_start();
if (isset($_GET['email']) && isset($_GET['confirmlink']))
{
    $email = $_GET['email'];
    $confirmlink = $_GET['confirmlink'];
	try
	{
        $con = new PDO("mysql:host=localhost;dbname=camagru2", "root", "VuyoKosi");
        
		$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$request = $con->prepare("SELECT Email_addy, confirmlink, verified FROM users WHERE Email_addy = :email AND confirmlink = :confirmlink AND verified = '0'");
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
        try
        {
            $update = $con->prepare("UPDATE users SET verified = '1', confirmlink = NULL WHERE Email_addy = :email AND confirmlink = :confirmlink AND verified = '0'");
            $update->execute(array(
                ':email' => $email,
                ':confirmlink' => $confirmlink
            ));
            $con = new PDO("mysql:host=localhost;dbname=camagru2", "root", "VuyoKosi");

            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $result = $con->query("SELECT Username, userid, Comment_email FROM users WHERE Email_addy = " . "'" . $email . "'");
            $cap = $result->fetch();
            $_SESSION['LOGGED_ON'] = $cap['Username'];
            $_SESSION['ID'] = $cap['userid'];
            $_SESSION['mailcomm'] = $cap['Comment_email'];
        }
        catch(PDOexception $e)
        {
            echo "Couldn't write in database: " . $e->getMessage();
        }
        
    }
    echo "Activated Account. Proceed back to login Page .<br>This message will Self-Destruct in 5... 4...
     3... 2.. 1.";
    header("Refresh:5; url=windowclose.php");
    
}
else
{
    
    echo "Bust . Retry Signup Process.";
    header("Refresh:5; url=windowclose.php");
}

    

?>
 <html>
 	<head>

 		<meta charset="utf-8">
 		<title></title>
 	</head>
 	<body>
		<?php include("footer.php")?>
 	</body>
 </html>