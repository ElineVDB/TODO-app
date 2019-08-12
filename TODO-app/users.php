
<?php
  error_reporting(E_ALL);
  ini_set('display_errors', '1');
  include_once("bootstrap.php");

  $u = new Admin();
  $users = $u->getAllUsers();

  /// wanneer je een gebruiker aanvinkt als admin
  if(!empty($_POST['add_admin'])){
    $admin = new Admin();
    $admin->setUserId($_POST['id']);
    $admin->makeAdmin();
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

<body>
  <?php include_once("includes/header.inc.php"); ?>
  <div class="container">
    <h1>Users</h1>
    <table class="user_table">
      <tr>
      <th>Name</th>
      <th>Admin</th>
    </tr>
      <?php foreach($users as $user): ?>
    <tr method="post" action="" data-id="<?php echo $user['id_user']; ?>" name="id">
    <td><?php echo $user['first_name'] . " " . $user['last_name']; ?><br> <?php echo $user['study_abb'] ?></td>
    <td><input type="checkbox" name="add_admin"></td> <!-- als gebruiker al admin is, is het aangevinkt -->
  </tr>
  <?php endforeach; ?>
  </table>
</div>
</body>

</html>
