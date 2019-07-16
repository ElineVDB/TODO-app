<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once("classes/User.class.php");
require_once("classes/Db.class.php");

// checken of de velden niet leeg zijn
if(!empty($_POST)){

  session_start();

  $email = $_POST['email'];
  $password = $_POST['password'];

  $user = new User();
  $user->setEmail($email);
  $user->getEmail();
  $user->setPassword($password);
  $user->getPassword();
  try{
      $user->login();
  }
  catch(Exception $t){
    $error =  $t->getMessage();
  }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Log in | TODO app</title>
</head>

<body>
<div class="container">

<form id="sign_up_form" method="post" action="">
  <h1>Log in</h1>

  <?php if(isset($error)): ?>
  <div class="error_signup"><?php echo $error; ?></div>
  <?php endif; ?>

  <!-- email -->
  <input type="email" name="email" class="input_account" placeholder="E-mail">

  <!-- password -->
  <input type="password" name="password" class="input_account" placeholder="Password">


  <input type="submit" name="submit" class="submit_button" value="Log in">
<p>Not an account yet?</p> <a href="signup.php">Sign up</a>
</form>


</div>

</body>

</html>
