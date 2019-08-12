<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
include_once("bootstrap.php");

$id = null;
if ( !empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}

if ( null==$id ) {
    header("Location: list.php");
}
else {
  $t = new Task();
  $t->setId($id);
  $get_task = $t->getTask();

}

if(!empty($_POST))
{
  try {
    $comment = new Comment();
    $comment->setText($_POST['comment']);
    var_dump($comment->save());
  } catch (\Throwable $th) {
    //throw $th;
  }
}


if(!empty($_POST['delete'])){
  $delete = new Task();
  $delete->setId($id);
  $delete->deleteTask();
}

//altijd alle laatste activiteiten ophalen
$comments = Comment::getAllComments();

 ?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <link rel="stylesheet" href="css/reset.css">
     <link rel="stylesheet" href="css/style.css">
     <title> <?php echo $get_task['title']; ?> | DoobyDo</title>
     <script type="text/javascript"></script>
 </head>

 <body>
   <?php include_once("includes/header.inc.php"); ?>

   <!-- verwijder de taak -->

   <div id="delete_task">
    <h3><?php echo "Are you sure to delete task " . "<span>" . $get_task['title'] . "</span> ?" ?></h3>

    <form id="create_list_form" method="post" action="">
      <input type="submit" name="cancel" value="cancel" class="cancel_button" id="cancel_task_button">
      <input type="submit" name="delete" value="DELETE" class="delete_task_button">
    </form>

   </div>

   <div class="task_info">
   <h1><?php echo $get_task['title']; ?></h1>
   <br>
   <a data-id="<?php echo $get_task['id_task'];?>"href="edit_task.php?id=<?php echo $get_task['id_task']; ?>">Edit</a>
   <a id="delete_task_button" href="#">Delete</a>
   <br>
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
   <br>
   <br>
<div class="comments">
   <h2>Comments</h2>
   <!-- schrijf een comment -->
   <form method="post" action="">

 		<input type="text" placeholder="What's on your mind?" id="comment" name="comment" />
 		<input id="btnSubmit" type="submit" value="Add comment" />

 		<ul id="listupdates">
 		<?php
 			foreach($comments as $c) {
          echo "Eline";
 					echo "<li>". $c->getText() ."</li>";
 			}

 		?>
 		</ul>

 		</div>
 	</form>
 </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script src="js/script.js"></script>
 <script
   src="http://code.jquery.com/jquery-3.3.1.js"
   integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
   crossorigin="anonymous"></script>

 <!--- write comment -->
 <script>

 $("#btnSubmit").on("click", function(e){
   var text = $("#comment").val();
   $.ajax({
   method: "POST",
   url: "ajax/postcomment.php",
   data: { text: text },
   dataType: 'json'
   })
 .done(function( res ) {
   if( res.status == 'succes'){
     var li = "<li>" + text + "</li>";
     $("#listupdates").append(li);
     $("#comment").val("").focus();
     $("#listupdates li").last().slideDown();
   }
 });

   e.preventDefault();
 });


 </script>
<?php include_once("includes/footer.inc.php");?>
 </body>

 </html>
