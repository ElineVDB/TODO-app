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

// id van een lijst, die is nodig om de nieuwe taak bij de juiste lijst te plaatsen
$id = null;
if ( !empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}

if ( null==$id ) {
    header("Location: list.php");
}


// eerst controloren we of alle velden zijn ingevuld

if(isset($_POST['submit'])){

  $title = $_POST['title_task'];
  $about = $_POST['about_task'];
  $deadline_date = $_POST['deadline_date_task'];
  $deadline_hour = $_POST['deadline_hour_task'];
  $time = $_POST['time'];
  $list_id = $id;
  try{
  $task = new Task();
  $task->setTitle($title); // title mag niet leeg zijn
  $task->setAbout($about);
  $task->setDeadlineDate($deadline_date);
  $task->setDeadlineHour($deadline_hour);
  $task->setTime($time);
  $task->setListId($list_id);

  // controleren of je niet een taak met dezelfde titel van andere taak hebt
    if($task->saveTask()){
      header("Location: list.php?id= $list_id");
    }
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
    <title> Add a task | DoobyDo</title>
</head>

<body>
<header>
    <a href="list.php?id=<?php echo e($id); ?>">Back to list</a>
    <h1>Add a task</h1>
  </header>
  <div class="container">
  <form id="add_task_form" method="post" action="" enctype="multipart/form-data" >
    <?php if(isset($error)): ?>
    <div class="error"><?php echo e($error); ?></div>
    <?php endif; ?>

    <!-- titel -->
    <label>Title</label>
    <input class="input_title" type="text" name="title_task" placeholder="enter a title of your task" value="<?php if(isset($error)){echo $title;} ?>">

    <!-- about -->
    <label>About</label>
    <textarea class="input_about" name="about_task" placeholder="write some details from your task"><?php if(isset($error)){echo $about;} ?></textarea>

    <!-- deadline -->
    <label>Deadline</label>
    <input class="input_deadline"type="date" name="deadline_date_task" placeholder="enter the date of the deadline" value="<?php if(isset($error)){echo $deadline_date;} ?>">
    <input class="input_deadline" type="time" name="deadline_hour_task" placeholder="enter the hour of the deadline" value="<?php if(isset($error)){echo $deadline_hour;} ?>">
    <br>
    <!-- time --->
    <label>Time (in hours)</label>
    <input class="input_time" type="number" name="time" placeholder="how many hours will be your task?"value="<?php if(isset($error)){echo $time;} ?>">

    <input type="submit" name="submit" value="Save" class="submit_button">

  </form>
</div>
<?php include_once("includes/footer.inc.php");?>
</body>

</html>
