<? 
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

?>

<html>
<body>
<meta charset="utf-8">
<meta name="description" content="This is an example of a meta descripstion. This will often show up in search results.">
<meta name="viewport" content="width=device-width, initial-scale=4">

<form action="database-load.php" method="POST" style="border:2px solid #fefefe">
  <div class="container">
    <h1>Sign Up</h1>
    <p>Please fill in this form to create an account.</p>
    <hr>

    <label for="email"><b>Email</b></label>
    <input type="text" placeholder="Enter Email" name="email" required/>

    <label for="username"><b>Username</b></label>
    <input type="text" placeholder="Create Username" name="username" required/>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" required/>

    <label for="conf-psw"><b>Confirm Password</b></label>
    <input type="password" placeholder="Repeat Password" name="psw-repeat" required/>

    <label>
      <input type="checkbox" checked="checked" name="remember" style="margin-bottom:15px"> Remember me
    </label>

    <p>By creating an account you agree to our <a href="#" style="color:dodgerblue">Terms & Privacy</a>.</p>

    <div class="clearfix">
    <button onclick="window.location.href = 'index.php';">Cancel</button>
      <button type="submit" class="signupbtn">Sign Up</button>
    </div>
  </div>
</form>

</body>
</html>