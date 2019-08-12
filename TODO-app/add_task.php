<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
include_once("bootstrap.php");

// heeft id van de lijst nodig zodat de nieuwe taak terrechtkomt bij juiste lijst

$id = null;
if ( !empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}

if ( null==$id ) {
    header("Location: list.php");
}


// eerst controloren we of alle velden zijn ingevuld

if(!empty($_POST)){

  $title = $_POST['title_task'];
  $about = $_POST['about_task'];
  $deadline_date = $_POST['deadline_date_task'];
  $deadline_hour = $_POST['deadline_hour_task'];
  $time = $_POST['time'];
  $list_id = $id;

  $task = new Task();
  $task->setTitle($title);
  $task->setAbout($about);
  $task->setDeadlineDate($deadline_date);
  $task->setDeadlineHour($deadline_hour);
  $task->setTime($time);
  $task->setListId($list_id);

  if($task->saveTask()){
    header("Location: list.php?id= $list_id");
  }
}

else{
  $error = "fields can not be empty";
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
    <a href="#">Back</a>
    <h1>Add a task</h1>
  </header>
  <form id="add_task_form" method="post" action="">
    <!-- titel -->
    <label>Title</label>
    <input class="input_title" type="text" name="title_task" placeholder="enter a title of your task">

    <!-- about -->
    <label>About</label>
    <textarea class="input_about" name="about_task" placeholder="write some details from your task"></textarea>

    <!-- deadline -->
    <label>Deadline</label>
    <input class="input_deadline"type="date" name="deadline_date_task" placeholder="enter the date of the deadline">
    <input class="input_deadline" type="time" name="deadline_hour_task" placeholder="enter the hour of the deadline">

    <!-- time --->
    <label>Time (in hours)</label>
    <input class="input_time" type="number" name="time" placeholder="how many hours will be your task?">

    <input type="submit" value="Save" class="submit_button">

  </form>
<?php include_once("includes/footer.inc.php");?>
</body>

</html>
