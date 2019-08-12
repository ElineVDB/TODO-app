<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
include_once("bootstrap.php");

$id = null;
if ( !empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}

if ( null==$id ) {
    //header("Location: list.php");
}
else {
  $t = new Task();
  $t->setId($id);
  $get_task = $t->getTask();
}

if(!empty($_POST)){
  $title = $_POST['title_task'];
  $about = $_POST['about_task'];
  $deadline_date = $_POST['deadline_date_task'];
  $deadline_hour = $_POST['deadline_hour_task'];
  $time = $_POST['time'];

  $edit = new Task();
  $edit->setId($id);
  $edit->setTitle($title);
  $edit->setAbout($about);
  $edit->setDeadlineDate($deadline_date);
  $edit->setDeadlineHour($deadline_hour);
  $edit->setTime($time);

  if($edit->editTask()){
      header("Location: read_task.php?id=$id");
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
    <title> <?php echo "Edit " . $get_task['title']; ?> | DoobyDo</title>
</head>

<body>
  <!-- Laat de huidige gegevens tonen bij elk inputveld -->
  <form id="add_task_form" method="post" action="">
    <h1><?php echo "Edit ". $get_task['title']; ?></h1>
    <!-- titel -->
    <label>Title</label>
    <input class="input_title" type="text" name="title_task" value="<?php echo $get_task['title']; ?>" placeholder="enter a title of your task">

    <!-- about -->
    <label>About</label>
    <textarea class="input_about" name="about_task" placeholder="write some details from your task"><?php echo $get_task['about']; ?></textarea>

    <!-- deadline -->
    <label>Deadline</label>
    <input class="input_deadline"type="date" name="deadline_date_task" value="<?php echo $get_task['deadline_date']; ?>" placeholder="enter the date of the deadline">
    <input class="input_deadline" type="time" name="deadline_hour_task" value="<?php echo $get_task['deadline_hour']; ?>" placeholder="enter the hour of the deadline">

    <!-- time --->
    <label>Time (in hours)</label>
    <input class="input_time" type="number" name="time" value="<?php echo $get_task['time']; ?>" placeholder="how many hours will be your task?">

    <input type="submit" value="Save" class="submit_button">

  </form>
<?php include_once("includes/footer.inc.php");?>
</body>

</html>
