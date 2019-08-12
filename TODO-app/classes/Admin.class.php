<?php

class Admin{

  private $id_user;


//// toon alle gebruikers
public function getAllUsers(){
      $conn = Db::getInstance();
      $statement = $conn->prepare("select * from users,study where study_id = id_study");
      $statement->execute();
      return $statement;
  }

  public function getUserId(){
    return $this->id_user;
  }

  public function setUserId($id_user){
    $this->id_user = $id_user;
    return $this;
  }

  public function makeAdmin(){
    $conn = Db::getInstance();
    $statement = $conn->prepare("update users set admin = :a where id_user = :id ");
    $statement->bindValue(':a', 1);
    $statement->bindValue(':id', $this->getUserId());
    $statement->execute();
  }


}


?>
