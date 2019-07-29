<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once("classes/Lists.class.php");
require_once("classes/Db.class.php");


$get_lists = new Lists();
$show_lists = $get_lists->getLists();

// controleren of het veld is ingevuld

if(!empty($_POST['save'])){

  $title = $_POST['title_list'];
  // user_id?

  $list = new Lists();

  $list->setTitle($title);
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
    <title> Home | TODO app</title>
</head>

<body>
<?php include_once("includes/header.inc.php"); ?>

<div id="create_new_list">
  <h1>Create a new list</h1>
  <form id="create_list_form" method="post" action="">
    <input type="text" name="title_list" class="input_list_title" placeholder="Enter a title">
    <input type="submit" name="cancel" value="cancel" class="cancel_list_button" id="cancel_button">
    <input type="submit" name="save" value="save" class="save_list_button">

  </form>
</div>

<!-- create a new list -->
<div class="list_items">
<div class="create_list" id="create_list_button"> + Create a new list</div>
<h1>Your to-do lists</h1>
<!-- all your  todo lists -->
<?php foreach($show_lists as $list): ?>

<div class="list" data-id="<?php echo $list['id']?>">
  <a href="list.php?id=<?php echo $list['id']; ?>"><?php echo $list['title']; ?>
  </div>

<?php endforeach; ?>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="js/script.js"></script>

</body>

</html>
