<?php

class List {

    private $title;
    private $user_id;


    public function getTitle(){
      return $this->title;
    }

    public function setTitle($title){
      $this->title = $title;
      return $this;
    }

    public function saveList(){

      try{
          $conn = Db::getInstance();
          $statement = $conn->prepare("insert into list(title) values(:title)");

          $statement->bindValue(':title', $this->getTitle());
          $statement->execute();
          header("Location: list.php");
      }
      catch(Throwable $t){
        echo "mislukt";
      }

    }


}

?>
