<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once("classes/Task.class.php");
require_once("classes/Db.class.php");

$id = null;
if ( !empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}

if ( null==$id ) {
    header("Location: list.php");
}
else {
  $t = new Task();
  $get_task = $t->getTask($id);

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
     <title> <?php echo $get_task['title']; ?> | TODO app</title>
 </head>

 <body>
   <?php include_once("includes/header.inc.php"); ?>
   <div class="task_info">
   <h1><?php echo $get_task['title']; ?></h1>
   <br>
   <a href="edit_task">Edit</a><a href="delete_task">Delete</a>
   <br>
   <br>
   <h2>Description</h2>
   <br>
   <p><?php echo $get_task['about']; ?></p>
   <table class="deadline_and_time">
     <tr>
       <th>Deadline</th>
       <td><?php echo $get_task['deadline_date'] . " " . $get_task['deadline_hour']; ?></td>
     </tr>
     <tr>
       <th>Estimated time</th>
       <td><?php echo $get_task['time'] . " hours"; ?></td>
     </tr>
   </table>
<div class="comments">
   <h2>Comments</h2>
   <div class="comment">
     <h3>Naam</h3>
     <p>lorem ipsum dolor sit amet, consectetur adipisicing elit</p>
   </div>
 </div>


 </div>

 </body>

 </html>
