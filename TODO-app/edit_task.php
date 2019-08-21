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
    //header("Location: list.php");
}
else {
  $t = new Task();
  $t->setId($id);
  $get_task = $t->getTask();
}

if(!empty($_POST['submit'])){

  // file uploads
  $target_dir = "uploads/";
  $allow_types = array('jpg', 'png', 'jpeg', 'pdf');

  if(!empty(array_filter($_FILES['file_upload']['name']))){
    foreach($_FILES['file_upload']['name'] as $key => $val){
      $fileName = basename($_FILES['file_upload']['name'][$key]);
      $target_file = $target_dir . $fileName;
      $fileType = pathinfo($target_file, PATHINFO_EXTENSION);
      if(in_array($fileType, $allow_types)){
        // upload file to server
        if(move_uploaded_file($_FILES['file_upload']['tmp_name'][$key], $target_file)){
          // insert into database
          $upload_file = new Task();
          $upload_file->setFileName($fileName);
          $upload_file->setId($id); // moet id van nieuwe taak zijn
          $upload_file->saveFile();
        }
      }
    }
  }

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
    <title> <?php echo e("Edit " . $get_task['title']); ?> | DoobyDo</title>
</head>

<body>
  <header>
      <a href="read_task.php?id=<?php echo e($id); ?>">Back to Task</a>
      <h1><?php echo e("Edit " . $get_task['title']); ?></h1>
    </header>
  <div class="container">
  <!-- Laat de huidige gegevens tonen bij elk inputveld -->
  <form id="add_task_form" method="post" action="" enctype="multipart/form-data">
    <!-- titel -->
    <label>Title</label>
    <input class="input_title" type="text" name="title_task" value="<?php echo e($get_task['title']); ?>" placeholder="enter a title of your task">

    <!-- about -->
    <label>About</label>
    <textarea class="input_about" name="about_task" placeholder="write some details from your task"><?php echo e($get_task['about']); ?></textarea>

    <!-- file toevoegen-->
    <label>upload a file</label>
    <input class="input_file"type="file" name="file_upload[]" multiple>
    <br>

    <!-- deadline -->
    <label>Deadline</label>
    <input class="input_deadline"type="date" name="deadline_date_task" value="<?php echo e($get_task['deadline_date']); ?>" placeholder="enter the date of the deadline">
    <input class="input_deadline" type="time" name="deadline_hour_task" value="<?php echo e($get_task['deadline_hour']); ?>" placeholder="enter the hour of the deadline">

    <!-- time --->
    <label>Time (in hours)</label>
    <input class="input_time" type="number" name="time" value="<?php echo e($get_task['time']); ?>" placeholder="how many hours will be your task?">

    <input type="submit" name="submit" value="Save" class="submit_button">

  </form>
  </div>
<?php include_once("includes/footer.inc.php");?>
</body>

</html>
