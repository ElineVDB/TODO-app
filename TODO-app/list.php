<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once("classes/Lists.class.php");
require_once("classes/Task.class.php");
require_once("classes/Db.class.php");


$id = null;
if ( !empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}

if ( null==$id ) {
    header("Location: index.php");
}
else {
  $l = new Lists();
  $show_list = $l->showList($id);
  $t = new Task();
  $show_tasks = $t->showTasks();

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
    <title> <?php echo $show_list['title']; ?> | TODO app</title>
</head>

<body>

  <div id="list_items">

    <h1><?php echo $show_list['title']; ?></h1>

    <div id="to_do">
      <h2>To Do</h2>
      <div>
      <a class="add_task_button"href="add_task.php">+ Add new task</a>
      <br>
      <br>
      <br>
      <!-- toon titel, deadline, "done button", edit, delete -->
      <?php foreach($show_tasks as $show_task): ?>
        <a href="read_task.php?id=<?php echo $show_task['id']; ?>">
      <table data-id="<?php echo $show_task['id']; ?>"class="to_dos">
        <tr>
          <td class="deadline"><?php echo $show_task['deadline_date']; ?></td>
          <td class="task_title"><?php echo $show_task['title']; ?></td>
          <td><button class="done_button">DONE</button></td>
          </a>
        </tr>
      </table>
      <br>
      <?php endforeach; ?>

    </div>
    </div>

    <div id="done">
      <h2>Done</h2>
    </div>

  </div>

</body>


</html>
