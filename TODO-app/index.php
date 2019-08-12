<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
include_once("bootstrap.php");


$get_lists = new Lists();
$show_lists = $get_lists->getLists();

// controleren of het veld is ingevuld

if(!empty($_POST['save'])){

  $name = $_POST['name_list'];
  // user_id?

  $list = new Lists();

  $list->setName($name);
  $list->saveList(); // de lijst wordt opgeslagen in de database

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
    <title> Home | DoobyDo</title>
</head>

<body>
<?php include_once("includes/header.inc.php"); ?>

<div id="create_new_list">
  <h1>Create a new list</h1>
  <form id="create_list_form" method="post" action="">
    <input type="text" name="name_list" class="input_list_title" placeholder="Enter a title">
    <input type="submit" name="cancel" value="cancel" class="cancel_button" id="cancel_button">
    <input type="submit" name="save" value="save" class="save_list_button">

  </form>
</div>

<!-- create a new list -->
<div class="list_items">

<h1>YOUR TO DO LISTS</h1>
<br>
<br>
<!-- all your  todo lists -->
<div class="create_list" id="create_list_button"> + Create a new list</div>
<?php foreach($show_lists as $list): ?>
<a href="list.php?id=<?php echo $list['id_list']; ?>">
<div class="list" data-id="<?php echo $list['id_list']?>">
  <?php echo $list['name']; ?>
  </div>
  </a>

<?php endforeach; ?>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="js/script.js"></script>

<?php include_once("includes/footer.inc.php");?>
</body>

</html>
