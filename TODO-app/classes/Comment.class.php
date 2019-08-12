<?php

class Comment{


private $text;


///// toon alle comments
  public static function getAllComments(){
        $conn = Db::getInstance();
        $result = $conn->query("select * from comments order by id_comment desc");

        // fetch all records from the database and return them as objects of this __CLASS__ (Post)
        return $result->fetchAll(PDO::FETCH_CLASS, __CLASS__);
    }

    ///// comment text

    public function getText(){
      return $this->text;
    }

    public function setText($text){
      $this->text = htmlspecialchars($text);
      return $this;
    }


    ///// save comment
    public function save(){
      $conn = Db::getInstance();
      $statement = $conn->prepare("insert into comments (text) values (:text)");
      //$statement->bindValue(":task_id", 1);
      //$statement->bindValue(":user_id", 1);
      $statement->bindValue(':text', $this->getText());
      var_dump($statement);
      header("Location: index.php");
      return $statement->execute();
    }


}

?>
