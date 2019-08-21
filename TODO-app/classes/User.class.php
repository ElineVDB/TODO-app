<?php
class User {
  private $firstname;
  private $lastname;
  private $email;
  private $password;
  private $password_confirm;
  private $study;
  private $id_user;
  //private $user_id; //is nodig om profiel aan te passen

// toon alle studies in de dropdown van sign up
  public function showAllStudies(){
    $conn = Db::getInstance();
    $statement = $conn->prepare("select * from study");
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


  // krijg de waarde van firstname
  public function getFirstname(){
    return $this->firstname;
  }

  public function setFirstname($firstname){
    if (empty($firstname)) {
      throw new Exception("Firstname cannot be empty");
    }
    else {
      $this->firstname = htmlspecialchars($firstname);
      return $this;
    }

  }

  public function getLastname(){
    return $this->lastname;
  }

  public function setLastname($lastname){
    if (empty($lastname)) {
      throw new Exception("Lastname cannot be empty");
    }
    else {
      $this->lastname = htmlspecialchars($lastname);
      return $this;
    }

  }

/// study
  public function getStudy(){
    return $this->study;
  }

  public function setStudy($study){
      $this->study = htmlspecialchars($study);
      return $this;
  }


// krijg de waarde Email
public function getEmail(){
  return $this->email;
}

public function setEmail($email){
  $this->email = htmlspecialchars($email);
  return $this;
}

// krijgt de waarde van password
public function getPassword(){
  return $this->password;
}

public function setPassword($password){
  $this->password = htmlspecialchars($password);
  return $this;
}
// voor register2
public function getPassword_confirm(){
  return $this->password_confirm;
}

public function setPassword_confirm($password_confirm){
  $this->password_confirm = htmlspecialchars($password_confirm);
  return $this;
}


///// registeren
public function register(){
  // form validation
  if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
    throw new Exception("Invalid Email");

  }
  if(strlen($this->password) < 8){
    throw new Exception("Your password needs at leats 8 characters");

  }
  if($this->password != $this->password_confirm){
    throw new Exception("Passwords don't match");
  }
  else{

  $options = [
    "cost" => 12 // 2^12
    ];
  $password = password_hash($this->password,PASSWORD_DEFAULT,$options);
  try{
    $conn = Db::getInstance();
    $statement = $conn->prepare("insert into users(first_name, last_name, study_id, email, password) values(:firstname, :lastname, :study_id, :email, :password)");

    $statement->bindValue(':firstname', $this->getFirstname());
    $statement->bindValue(':lastname', $this->getLastname());
    $statement->bindValue(':study_id', $this->getStudy());
    $statement->bindValue(':email', $this->getEmail());
    $statement->bindValue(':password', $password);
    $result = $statement->execute();
    return $result;
    //$_SESSION['first_name'] = $firstname;
    //header("Location: index.php");

  }
  catch( Throwable $t){
    echo "mislukt";
  return false;
  }

}

}

public function login($password){

  // form validation
  if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
    throw new Exception("Invalid Email");
  }
  if(strlen($this->password) < 8){
    throw new Exception("Your password needs at least 8 characters");
  }

  else{

  try
     {
       $conn = Db::getInstance();
       $statement = $conn->prepare("select * from users where email = :email");
       $statement->bindValue(':email', $this->getEmail());
       //$statement->bindValue(':password', $password);

        $statement->execute(array(':email'=>$this->getEmail()));
        $userRow = $statement->fetch(PDO::FETCH_ASSOC);


        if($statement->rowCount() > 0)
        {
           if(password_verify($password, $userRow['password']))
           {
              $_SESSION['user'] = $userRow['id_user'];
              header("Location: home.php");
              return true;
           }
           else
           {
              throw new Exception("Wrong password or email");
              return false;
           }
        }
     }
     catch(PDOException $t)
     {
         echo $t->getMessage();
     }
 }


  }


//// ingelogd?
  public function is_loggedin()
     {
        if(isset($_SESSION['user']))
        {
           return true;
        }

     }

  public function redirect($url)
   {
       header("Location: $url");
   }

  ///// is de gebruiker een admin?

  public function isAdmin($user_id){

    $conn = Db::getInstance();
    $statement = $conn->prepare("select * from users where id_user = :id");
    $statement->bindValue(':id', $user_id);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);

    if($result['admin'] == 1){
      return true;
    }
    else{
      return false;
    }
  }

//// toon de gegevens van de gebruiker
  public function showUserData(){
    $conn = Db::getInstance();
    $statement = $conn->prepare("select * from users where id_user = :id");
    $statement->bindValue(':id', $this->getUserId());
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    return $result;
  }

/// uitloggen
  public function logout(){
      session_destroy();
      unset($_SESSION['user']);
      return true;
  }


}


?>
