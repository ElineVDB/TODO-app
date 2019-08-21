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


$id = null;
if ( !empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}

if ( null==$id ) {
    header("Location: list.php");
}
else {
  $t = new Task();
  $t->setId($id); // id van de taak
  $get_task = $t->getTask(); // de informatie van de taak ophalen
  //$t->setId($id);
  $get_files = $t->getFiles(); // de files van de taak ophalen

}

if(!empty($_POST))
{/*
  try {
    $comment = new Task();
    $comment->setText($_POST['comment']);
    var_dump($comment->save());
  } catch (\Throwable $th) {
    //throw $th;
  }*/
}

// taak verwijderen
if(!empty($_POST['delete'])){
  $delete = new Task();
  $delete->setId($id);
  $delete->deleteTask();
}

//altijd alle laatste activiteiten ophalen
$comments = Task::getAllComments();

 ?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <link rel="stylesheet" href="css/reset.css">
     <link rel="stylesheet" href="css/style.css">
     <title> <?php echo e($get_task['title']); ?> | DoobyDo</title>
     <script type="text/javascript"></script>
 </head>

 <body>
   <?php include_once("includes/header.inc.php"); ?>

   <!-- verwijder de taak -->
   <div class="container">
   <div id="delete_task">
    <h3><?php echo "Are you sure to delete task " . "<span>" . e($get_task['title']) . "</span> ?" ?></h3>

    <form id="create_list_form" method="post" action="">
      <input type="submit" name="cancel" value="cancel" class="cancel_button" id="cancel_task_button">
      <input type="submit" name="delete" value="DELETE" class="delete_task_button">
    </form>

   </div>

   <div class="task_info">
   <h1><?php echo e($get_task['title']); ?></h1>
   <br>
   <a data-id="<?php echo e($get_task['id_task']);?>"href="edit_task.php?id=<?php echo e($get_task['id_task']); ?>">Edit</a>
   <a id="delete_task_button" href="#">Delete</a>
   <br>
   <br>
   <br>
   <h2>Description</h2>
   <br>
   <p><?php echo e($get_task['about']); ?></p>
   <br>
   <h2>Files</h2>
   <br>
   <?php foreach($get_files as $get_file):?>
     <a href= "<?php echo "uploads/" . e($get_file['file_name']); ?>" download><?php echo e($get_file['file_name']); ?></a>
   <?php endforeach; ?>
   <table class="deadline_and_time">
     <tr>
       <th>Deadline</th>
       <td><?php echo e($get_task['deadline_date']) . " " . e($get_task['deadline_hour']); ?></td>
     </tr>
     <tr>
       <th>Estimated time</th>
       <td><?php echo e($get_task['time']) . " hours"; ?></td>
     </tr>
   </table>
   <br>
   <br>
<div class="comments">
   <h2>Comments</h2>
   <!-- schrijf een comment -->
   <form method="post" action="">

    <textarea id="comment" placeholder="Say something about that task" name="comment"></textarea>
    <br>
 		<input data-id="<?php echo e($get_task['id_task']); ?>" id="Send_btn" type="submit" value="Send" />

 		<ul id="listupdates">
 		<?php
 			foreach($comments as $c) {
          echo "Eline";
 					echo "<li>". e($c->getText()) ."</li>";
 			}

 		?>
 		</ul>

 		</div>
 	</form>
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

 $("#Send_btn").on("click", function(e){
   var text = $("#comment").val(); // waarde van de tekst
   var taskId = $("#Send_btn").data('id'); // welke taak?

   $.ajax({
   method: "POST",
   url: "ajax/postcomment.php",
   data: { text: text,
           taskId: taskId
          },
   dataType: 'json'
   })
 .done(function( res ) {
   if( res.status == 'succes'){
     var li = "<li>" + text + "</li>";
     $("#listupdates").append(li);
     $("#comment").val("").focus();
     $("#listupdates li").last().slideDown();
   }
   else{
     alert(res.status + ": " + res.message);
   }
 })
   .fail(function(jqXHR, textStatus){
     alert("failed: " + textStatus);
   })
 ;

   e.preventDefault();
 });

 </script>


<?php include_once("includes/footer.inc.php");?>
 </body>

 </html>
