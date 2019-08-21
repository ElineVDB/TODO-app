<?php

include_once("../bootstrap.php");

    if( !empty($_POST) ){
        $taskId = $_POST['taskId'];
        //$title = $_POST['title'];
        //$date = $_POST['date'];

        $d = new Task();
        $d->setId($taskId);
        $d->saveTaskDone();


        // JSON
        $result = [
            "status" => "success",
            "message" => "Task " . $taskId . " is done."
        ];

        echo json_encode($result);

    }

		?>
