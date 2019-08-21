<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
include_once("bootstrap.php");
require_once("security.php");

$st = new User();
$study = $st->showAllStudies();


// eerst controleren we of alle velden ingevuld zijn

if(isset($_POST['submit'])){

  session_start();
  try{
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $selected_study = $_POST['study'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    //var_dump($selected_study);

    $user = new User();
    $user->setFirstname($firstname);
    $user->getFirstname();
    $user->setLastname($lastname);
    $user->getLastname();
    $user->setStudy($selected_study);
    $user->getStudy();
    $user->setEmail($email);
    $user->getEmail();
    $user->setPassword($password);
    $user->getPassword();
    $user->setPassword_confirm($password_confirm);
    $user->getPassword_confirm();
  }
  catch(Exception $t){
    $error = $t->getMessage();  // foutboodschap tonen
  }

  try{
    //$result = $user->register();
    if($user->register()){
      header("Location: index.php");
    }

  }
  catch(Exception $t){
    $error =  $t->getMessage();  // foutboodschap tonen
  }

}
/*
else{
  $error = "You can not sign up with empty fields, du-uh";
}*/

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Sign up | DoobyDo</title>
</head>

<body>

  <div class="container">

  <img src="img/logo.png" alt="logo">

  <form id="sign_up_form" method="post" action="">
    <h1>Sign up </h1>

    <?php if(isset($error)): ?>
    <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>

    <!-- firtsname -->
    <div class="sign_up_fields">
    <input type="text" name="firstname" class="input_account" placeholder="First name" value="<?php if(isset($error)){echo $firstname;} ?>">
    </div>
    <!-- last name -->
    <div class="sign_up_fields">
    <input type="text" name="lastname" class="input_account" placeholder="Last name" value="<?php if(isset($error)){echo $lastname;}?>">
    </div>
    <!-- study -->
    <div class="sign_up_fields">
    <select class="select_study">
      <option name="study">Select your study</option>
      <?php foreach($study as $st): ?>
      <option name = "study" value="<?php echo $st['id_study'];?>"><?php echo $st['study'] . " (" . $st['study_abb'] . ")" ; ?></option>
    <?php endforeach; ?>
    </select>
    </div>
    <!-- email -->
    <div class="sign_up_fields">
    <input type="text" name="email" class="input_account" placeholder="E-mail">
    </div>
    <!-- password -->
    <div class="sign_up_fields">
    <input type="password" name="password" class="input_account" placeholder="Password">
    <br>
    <p>Your password needs at least 8 characters</p>
    </div>
    <!-- repeat password -->
    <div class="sign_up_fields">
    <input type="password" name="password_confirm" class="input_account" placeholder="Repeat your password">
    </div>

    <!-- submit -->
    <div class="sign_up_fields">
    <input type="submit" name="submit" class="submit_button" value="Sign up">
    </div>
    <p>Do you already have an account?</p> <a href="index.php">Log in</a>

  </form>

</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="js/script.js"></script>

<?php include_once("includes/footer.inc.php");?>
</body>

</html>
