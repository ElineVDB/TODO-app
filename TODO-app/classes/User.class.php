<?php
class User {
  private $firstname;
  private $lastname;
  private $email;
  private $password;
  private $password_confirm;
  private $study;
  //private $user_id; //is nodig om profiel aan te passen

// toon alle studies in de dropdown van sign up
  public function showAllStudies(){
    $conn = Db::getInstance();
    $statement = $conn->prepare("select * from study");
    $statement->execute();
    return $statement;
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
    /*$this->firstname = $firstname;
    return $this;*/
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
    /*$this->lastname = $lastname;
    return $this;*/
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
  $this->email = $email;
  return $this;
}


// krijgt de waarde van password
public function getPassword(){
  return $this->password;
}

public function setPassword($password){
  $this->password = $password;
  return $this;
}
// voor register2
public function getPassword_confirm(){
  return $this->password_confirm;
}

public function setPassword_confirm($password_confirm){
  $this->password_confirm = $password_confirm;
  return $this;
}



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
    //return $result;
    $_SESSION['first_name'] = $firstname;
    header("Location: index.php");
  }
  catch( Throwable $t){
    echo "mislukt";
  return false;
  }

}

}

public function login(){

  // form validation
  if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
    throw new Exception("Invalid Email");

  }
  if(strlen($this->password) < 8){
    throw new Exception("Your password needs at leats 8 characters");

  }

  // eerst wordt het password gehasht
  else{

  $options = [
    "cost" => 12 // 2^12
    ];
  $password = password_hash($this->password,PASSWORD_DEFAULT,$options);




    $conn = Db::getInstance();
    $statement = $conn->prepare("select * from users where email like :email and password like :password");

    $statement->bindValue(':email', $this->getEmail());
    $statement->bindValue(':password', $password);

    $result = $statement->execute();

    // we controleren of het opgegeven e-mail in de tabel User bestaat
    if($this->getEmail() == 0){
      throw new Exception("e-mail does not excist");
    }
    // we controleren of het password van het e-mail klopt
    if($password != $result['password']){
      throw new Exception("password doesn't match on this e-mail");
    }



    // als het klopt, dan word de gebruiker opgeslagen in de server
    $_SESSION['first_name'] = $firstname;

    // ga naar de index pagina
    header("Location: index.php");
  }


}





}




?>
