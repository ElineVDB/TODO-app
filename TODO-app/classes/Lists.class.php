<?php

class Lists {
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

    public function getLists(){

      try{
        $conn = Db::getInstance();
        // toon de lijsten van de ingelogde gebruiker
        $statement = $conn->prepare("select * from list");
        $statement->execute();
        $result = $statement->fetchAll();
        return $result;
      }
      catch(Throwable $t){
        echo "mislukt";
      }
    }

    public function showList($id){

      try{
        $conn = Db::getInstance();
        $statement = $conn->prepare("select * from list where id= '$id'");
        $statement->execute(array($id));
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
      }
      catch(Throwable $t){
        echo "mislukt";
      }
    }


}

?>
