<?php

class Admin{

  private $id_user;


public static function getAllUsers(){
  $conn = Db::getInstance();
  $statement = $conn->query("select * from users");
  return $statement->fetchAll(PDO::FETCH_CLASS, __CLASS__);
}

public static function getAllLists(){
  $conn = Db::getInstance();
  $statement = $conn->query("select * from list");
  return $statement->fetchAll(PDO::FETCH_CLASS, __CLASS__);
}

public function getUserList(){
  $conn = Db::getInstance();
  $statement = $conn->prepare("select * from users,study where study_id = id_study");
  $statement->execute();
  return $statement;
}



  public function getUserId(){
    return $this->id_user;
  }

  public function setUserId($id_user){
    $this->id_user = htmlspecialchars($id_user);
    return $this;
  }

/// maak van een gebruiker een admin
  public function makeAdmin(){
    $conn = Db::getInstance();
    $statement = $conn->prepare("update users set admin = :a where id_user = :id ");
    $statement->bindValue(':a', 1);
    $statement->bindValue(':id', $this->getUserId());
    $statement->execute();
  }

/// verwijder een admin
  public function deleteAdmin(){
    $conn = Db::getInstance();
    $statement = $conn->prepare("update users set admin = :a where id_user = :id ");
    $statement->bindValue(':a', 0);
    $statement->bindValue(':id', $this->getUserId());
    $statement->execute();
  }


}


?>
