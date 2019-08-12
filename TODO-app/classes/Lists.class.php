<?php

class Lists {
    private $name;
    private $id; // id van de lijst
    private $user_id;

///// id van de lijst
    public function getId(){
        return $this->id;
      }

    public function setId($id){
        $this->id = $id;
        return $this;
      }

///// name
    public function getName(){
      return $this->name;
    }

    public function setName($name){
      $this->name = $name;
      return $this;
    }

///// slaag de lijst op in de database
    public function saveList(){

      try{
          $conn = Db::getInstance();
          $statement = $conn->prepare("insert into list(name) values(:name)");

          $statement->bindValue(':name', $this->getName());
          $statement->execute();
          header("Location: list.php");
      }
      catch(Throwable $t){
        echo "mislukt";
      }

    }

//// toon alle lijsten in de homepage
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

////// toon de naam van de lijst
    public function showList(){

      try{
        $conn = Db::getInstance();
        $statement = $conn->prepare("select * from list where id_list= :id");
        $statement->bindValue(':id', $this->getId());
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
      }
      catch(Throwable $t){
        echo "mislukt";
      }
    }

///// delete lijst
    public function deleteList(){
      $conn = Db::getInstance();
      $statement = $conn->prepare("delete from list where id_list = :id");
      $statement->bindValue(':id', $this->getId());
      $statement->execute();
      header("Location: index.php");
      return true;
    }


}

?>
