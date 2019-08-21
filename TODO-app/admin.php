<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
include_once("bootstrap.php");
require_once("security.php");

session_start();
$user = new User();
if(!$user->is_loggedin())
{
 $user->redirect('index.php');
}

$user_id = $_SESSION['user'];

if(!$user->isAdmin($user_id)){
  $user->redirect('home.php');
}


$total_users = Admin::getAllUsers();
$total_lists = Admin::getAllLists();

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <title> Admin | DoobyDo</title>
</head>

<body>
  <?php include_once("includes/header.inc.php"); ?>

<div class="container">
  <!-- hoeveel gebruikers zitten er in de app? -->
  <div id="total_users">
    <img src="img/user.png" alt="user">
    <div>
    <span><?php echo e(count($total_users)); ?></span>
    <br>
    Users
  </div>
  <a href="users.php">user list</a>
  </div>

  <!-- hoeveel lijsten zitten er in de app? -->
  <div id="total_lists">
    <img src="img/list.png"alt="list">
    <div>
    <span><?php echo e(count($total_lists)); ?></span>
    <br>
    Lists
  </div>
  </div>

</div>
</body>

</html>
