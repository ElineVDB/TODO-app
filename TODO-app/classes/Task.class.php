<?php
  class Task {

    private $title;
    private $about;
    private $deadline_date;
    private $deadline_hour;
    private $time;
    private $id;
    // private $list_id (bij welke lijst hoort de taak)

///////////// title
    public function getTitle(){
      return $this->title;
    }

    public function setTitle($title){
      $this->title = htmlspecialchars($title);
      return $this;
    }

///////// About
    public function getAbout(){
      return $this->about;
    }

    public function setAbout($about){
      $this->about = htmlspecialchars($about);
      return $this;
    }

  /////// deadline date
    public function getDeadlineDate(){
      return $this->deadline_date;
    }

    public function setDeadlineDate($deadline_date){
      $this->deadline_date = htmlspecialchars($deadline_date);
      return $this;
    }

    /////////// deadline hour
    public function getDeadlineHour(){
      return $this->deadline_hour;
    }

    public function setDeadlineHour($deadline_hour){
      $this->deadline_hour = htmlspecialchars($deadline_hour);
      return $this;
    }

    ///////// time
    public function getTime(){
      return $this->time;
    }

    public function setTime($time){
      $this->time = htmlspecialchars($time);
      return $this;
    }

    //// save task

    public function saveTask(){

      try{
        $conn = Db::getInstance();
        $statement = $conn->prepare("insert into task(title, about, deadline_date, deadline_hour, time) values(:title, :about, :deadline_date, :deadline_hour, :time)");

        $statement->bindValue(':title', $this->getTitle());
        $statement->bindValue(':about', $this->getAbout());
        $statement->bindValue(':deadline_date', $this->getDeadlineDate());
        $statement->bindValue(':deadline_hour', $this->getDeadlineHour());
        $statement->bindValue(':time', $this->getTime());
        $statement->execute();
        header("Location: list.php");
        return true;
      }
      catch(Throwable $t){
        echo "mislukt";
      }

    }

    //////// toon al de taken van de lijst
    public function showTasks(){
      try{
        $conn = Db::getInstance();
        $statement = $conn->prepare("select * from task");
        $statement->execute();
        $result = $statement->fetchAll();
        return $result;

      }
      catch(Throwable $t){
        echo "mislukt";
      }
    }

    ///// toon alle details van de taak

    public function getTask($id){
      try{
        $conn = Db::getInstance();
        $statement = $conn->prepare("select * from task where id='$id'");
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
