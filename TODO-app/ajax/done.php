<?php

include_once("../bootstrap.php");
    // ajax/like.php
    if( !empty($_POST) ){
        $taskId = $_POST['taskId'];

        $d = new Task();
        $d->setId($taskId);
        $d->saveTaskDone();

        // JSON
        $result = [
            "status" => "success",
            "message" => "Like has been saved."
        ];

        echo json_encode($result);

    }

		?>
