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
        $this->id = htmlspecialchars($id);
        return $this;
      }

//// id van de gebruiker
    public function getUserId(){
        return $this->user_id;
      }

    public function setUserId($user_id){
        $this->user_id = htmlspecialchars($user_id);
        return $this;
      }


///// name
    public function getName(){
      return $this->name;
    }

    public function setName($name){
      if(empty($name)){
        throw new Exception("A list needs a name. ALWAYS");
      }
      $this->name = htmlspecialchars($name);
      return $this;
    }

///// slaag de lijst op in de database
    public function saveList(){

      try{
          $conn = Db::getInstance();
          $statement = $conn->prepare("insert into list(name, user_id) values(:name, :id)");

          $statement->bindValue(':name', $this->getName());
          $statement->bindValue(':id', $this->getUserId());
          $statement->execute();
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
        $statement = $conn->prepare("select * from list where user_id = :id order by name asc");
        $statement->bindValue(':id', $this->getUserId());
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
      header("Location: home.php");
      return true;
    }


}

?>
