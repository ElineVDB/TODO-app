<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <title> Add a task | TODO app</title>
</head>

<body>


  <form id="add_task_form">
    <h1>Add a task</h1>
    <!-- titel -->
    <label>Title</label>
    <input class="input_title" type="text" name="title_task" placeholder="enter a title of your task">

    <!-- about -->
    <label>About</label>
    <textarea class="input_about" name="about_task" placeholder="write some details from your task"></textarea>

    <!-- deadline -->
    <label>Deadline</label>
    <input class="input_deadline"type="date" name="deadlinedate_task" placeholder="enter the date of the deadline">
    <input class="input_deadline" type="time" name="deadlinehour_task" placeholder="enter the hour of the deadline">

    <!-- time --->
    <label>Time (in hours)</label>
    <input class="input_time" type="number" name="time" placeholder="how many times is your task?">

    <input type="submit" value="Save" class="submit_button">

  </form>

</body>

</html>
