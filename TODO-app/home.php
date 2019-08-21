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

$user->setUserId($user_id);
$u = $user->showUserData();

$get_lists = new Lists();
$get_lists->setUserId($user_id);
$show_lists = $get_lists->getLists();


// submit wanneer je nieuwe lijst maakt

if(isset($_POST['save'])){

  $name = $_POST['name_list'];

  try{
    $list = new Lists();
    $list->setName($name);
    $list->setUserId($user_id);// user_id?
    $list->saveList(); // de lijst wordt opgeslagen in de database
    $show_lists = $list->getLists();
  }
  catch(Throwable $t){
    $error = $t->getMessage();
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
    <title> Home | DoobyDo</title>
</head>

<body>
<?php include_once("includes/header.inc.php"); ?>
<?php if($user->isAdmin($user_id)){
  include_once("includes/admin.inc.php");
}
?>

<div id="create_new_list">
  <h1>Create a new list</h1>
  <form id="create_list_form" method="post" action="">
    <input type="text" name="name_list" class="input_list_title" placeholder="Enter a title">
    <br>
    <input type="submit" name="cancel" value="cancel" class="cancel_button" id="cancel_button">
    <input type="submit" name="save" value="save" class="save_list_button">

  </form>
</div>
<div class="container">
<div id="profile">
<div id="profile_img"></div>
<h1><?php echo e($u['first_name'] . " " . $u['last_name']); ?></h1>
</div>
<!-- create a new list -->
<div class="list_items">

<h1>YOUR TO DO LISTS</h1>

<br>
<br>
<!-- all your  todo lists -->
<div class="create_list" id="create_list_button"> + Create a new list</div>
<?php if(isset($error)): ?>
<div class="error"><?php echo e($error); ?></div>
<?php endif; ?>
<?php foreach($show_lists as $list): ?>
<a href="list.php?id=<?php echo e($list['id_list']); ?>">
<div class="list" data-id="<?php echo e($list['id_list'])?>">
  <?php echo e($list['name']); ?>
  </div>
  </a>

<?php endforeach; ?>
</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="js/script.js"></script>

<?php include_once("includes/footer.inc.php");?>
</body>

</html>
