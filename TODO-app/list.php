<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
include_once("bootstrap.php");


$id = null;
if ( !empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}

if ( null==$id ) {
    header("Location: index.php");
}
else {
  $l = new Lists();
  $l->setId($id);
  $show_list = $l->showList();
  $t = new Task();
  $t->setListId($id);
  $show_tasks = $t->showTasks();
}

if(!empty($_POST['delete'])){
  $delete = new Lists();
  $delete->setId($id);
  $delete->deleteList();
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
    <title> <?php echo $show_list['name']; ?> | DoobyDo</title>
</head>

<body>
<?php include_once("includes/header.inc.php"); ?>

<div id="delete_list">
  <h3><?php echo "Are you sure to delete " . "<span>" .  $show_list['name'] . "</span> ?"?></h3>
  <form id="delete_list_form" method="post" action="">
    <input type="submit" name="cancel" value="cancel" class="cancel_button" id="cancel_button">
    <input type="submit" name="delete" value="DELETE" class="delete_list_button">
  </form>
</div>

  <div id="list_items">

    <h1><?php echo $show_list['name']; ?></h1>
    <a id="delete_list_button" href="#">Delete</a>

    <div id="to_do">
      <h2>To Do</h2>
      <div>
      <a class="add_task_button" href="add_task.php?id=<?php echo $show_list['id_list']; ?>">+ Add new task</a>
      <br>
      <br>
      <br>
      <!-- toon titel, deadline, "done button", edit, delete -->
      <?php foreach($show_tasks as $show_task): ?>
        <a href="read_task.php?id=<?php echo $show_task['id_task']; ?>">
      <table data-id="<?php echo $show_task['id_task']; ?>" class="to_dos">
        <tr>
          <td class="deadline"><?php echo $show_task['deadline_date']; ?></td>
          <td class="task_title"><?php echo $show_task['title']; ?></td>
          </a>
            <!-- wanneer je op "done" klikt, wordt de lijst geplaats naar de "done" plaats -->
          <td><a href="#" data-id="<?php echo $show_task['id_task']; ?>" id="done_button" class="done_button" name="done">DONE</a></td>
        </tr>
      </table>
      <br>
      <?php endforeach; ?>
    </div>
    </div>

    <div id="done">
      <h2>Done</h2>
      <?php // hier staan de taak items die gemarkeert zijn als "done"

      ?>
    </div>

  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="js/script.js"></script>

  <script
    src="http://code.jquery.com/jquery-3.3.1.js"
    integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
    crossorigin="anonymous"></script>

  <!--- write comment -->
  <script>
   $("#done_button").on("click", function(e){
     //$("#done_button").hide();
     //var taskId = $(this).data('id');
     $(this).data('id');
      $(this).hide();// welke taak?
     //$(taskId).hide();
     $.ajax({
     method: "POST",
     url: "ajax/done.php",
     data: { taskId: taskId },
     dataType: 'json'
     })
    .done(function( res ) {
      if( res.status == 'succes'){
        $(taskId).remove(); // verwijder de taak uit zone "todo"
       $("#done").append(taskId); // de taak wordt verplaatst naar de "done" zone
       $("#to_do ").last().slideDown();
     }

    });

     e.preventDefault();
   });

  </script>
<?php include_once("includes/footer.inc.php");?>
</body>


</html>
