<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once("classes/User.class.php");
require_once("classes/Db.class.php");

// eerst controleren we of alle velden ingevuld zijn

if(!empty($_POST)){

  session_start();
  $firstname = $_POST['firstname'];
  $lastname = $_POST['lastname'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $password_confirm = $_POST['password_confirm'];

  $user = new User();
  $user->setFirstname($firstname);
  $user->getFirstname();
  $user->setLastname($lastname);
  $user->getLastname();
  $user->setEmail($email);
  $user->getEmail();
  $user->setPassword($password);
  $user->getPassword();
  $user->setPassword_confirm($password_confirm);
  $user->getPassword_confirm();
  try{
    $result = $user->register();
  }
  catch(Exception $t){
    $error =  $t->getMessage();
  }

}
else{
  // foutboodschap tonen
  $empty_field_error = "Please, fill in all the fields";
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
    <title>Sign up | TODO app</title>
</head>

<body>

  <div class="container">


  <form id="sign_up_form" method="post" action="">
    <h1>Sign up </h1>

    <?php if(isset($error)): ?>
    <div class="error_signup"><?php echo $error; ?></div>
    <?php endif; ?>

    <!-- firtsname -->
    <input type="text" name="firstname" class="input_account" placeholder="First name">

    <!-- last name -->
    <input type="text" name="lastname" class="input_account" placeholder="Last name">

    <!-- email -->
    <input type="text" name="email" class="input_account" placeholder="E-mail">

    <!-- password -->
    <input type="password" name="password" class="input_account" placeholder="Password">

    <!-- repeat password -->
    <input type="password" name="password_confirm" class="input_account" placeholder="Repeat your password">

    <input type="submit" name="submit" class="submit_button" value="Sign up">

    <p>Do you already have an account?</p> <a href="login.php">Log in</a>

  </form>



</div>

</body>

</html>
