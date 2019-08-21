<?php

  require_once("../bootstrap.php");

  if(!empty($_POST)){
    // comment text uitlezen
    $text = $_POST['text'];
    $taskId = $_POST['taskId'];

    // comment opslaan in db
    try{
      $c = new Task();
      $c->setText($text);
      $c->setId($taskId);

      if($c->saveComment()){
        $result = [
          "status" => "succes",
          "message" => "Comment was saved."
        ];
      } else {
        $result = [
          "status" => "error",
          "message" => "Something went wrong while saving."
        ];

      }
    }
    catch(Throwable $t){
      $result = [
        "status" => "error",
        "message" => "Something went wrong." . $t->getMessage()

      ];
    }

    echo json_encode($result);

    // query (insert)
    // antwoord geven aan uw JS frontend (json)
  }


 ?>
