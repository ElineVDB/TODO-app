
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

  $u = new Admin();
  $users = $u->getUserList();
  //$userlist = $u->getUserList();


  /// wanneer je een gebruiker aanvinkt als admin
  if(isset($_POST['save'])){
    // als de checkbox is aangevinkt
    foreach($_POST['add_admin'] as $selected){
    if(!empty($selected)){
      //var_dump($_POST['add_admin']);
      $admin = new Admin();
      var_dump($selected);
      $admin->setUserId($selected);
      $admin->makeAdmin();
      $users = $admin->getUserList();
    }

      else{
        $admin = new Admin();
        $admin->setUserId($selected);
        $admin->deleteAdmin();
      }
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
    <title> Users | DoobyDo</title>
</head>

<style>

#save_users
{
  border: none;
  background-color: #8FE862;
  border-radius: 20px;
  color: #fff;
  padding: 10px;
  font-weight: bold;
  cursor: pointer;
}

#save_users:hover
{
  background-color: #10B01D;
}

</style>

<body>
  <?php include_once("includes/header.inc.php"); ?>
  <div class="container">
    <h1>Users</h1>
    <br>
    <br>
    <form method="post" action="">
      <input id="save_users" type="submit" name="save" value="save changes">
    <table class="user_table">
      <tr>
      <th>Name</th>
      <th>Admin</th>
    </tr>
      <?php foreach($users as $user): ?>
    <tr data-id="<?php echo e($user['id_user']); ?>" name="id">
    <td><?php echo e($user['first_name']) . " " . e($user['last_name']); ?><br> <?php echo e($user['study_abb']) ?></td>
    <td><input data-id="<?php echo e($user['id_user']); ?>" type="checkbox" name="add_admin[]" value="<?php echo e($user['id_user']); ?>" <?php if($user['admin'] == 1):  ?> checked <?php endif; ?>></td> <!-- als gebruiker al admin is, is het aangevinkt -->
  </tr>
  <?php endforeach; ?>
  </table>
  </form>
</div>
</body>

</html>
