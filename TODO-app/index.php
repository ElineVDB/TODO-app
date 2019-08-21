<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
include_once("bootstrap.php");

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
      $user->login($password);
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
    <title>Log in | DoobyDo</title>
</head>

<body>
<div class="container">
<img src="img/logo.png" alt="logo">
<form id="sign_up_form" method="post" action="">
  <h1>Log in</h1>

  <?php if(isset($error)): ?>
  <div class="error"><?php echo $error; ?></div>
  <?php endif; ?>

  <div class="sign_up_fields">
  <input type="email" name="email" class="input_account" placeholder="E-mail" value="<?php if(isset($error)){echo $email;} ?>">
  </div>

  <!-- password -->
  <div class="sign_up_fields">
  <input type="password" name="password" class="input_account" placeholder="Password">
  <br>
  <p>Your password needs at least 8 characters</p>
  </div>


  <div class="sign_up_fields">
  <input type="submit" name="submit" class="submit_button" value="Log in">
  </div>
<p>Not an account yet?</p> <a href="signup.php">Sign up</a>

</form>


</div>
<?php include_once("includes/footer.inc.php");?>
</body>

</html>
