<?php

  require_once("../bootstrap.php");

  if(!empty($_POST)){
    // comment text uitlezen
    $text = $_POST['text'];

    // comment opslaan in db
    try{
      $c = new Comment();
      $c->setText($text);
      $c->save();

      $result = [
        "status" => "succes",
        "message" => "Comment was saved."
      ];
    }
    catch(Throwable $t){
      $result = [
        "status" => "error",
        "message" => "Something went wrong."
      ];
    }

    echo json_encode($result);

    // query (insert)
    // antwoord geven aan uw JS frontend (json)
  }


 ?>




 ?>
