<?php
  class Task {

    private $title;
    private $about;
    private $deadline_date;
    private $deadline_hour;
    private $time;
    private $id;
    private $list_id;
    private $comment;


///////// id van de taak

    public function getId(){
        return $this->id;
    }

    public function setId($id){
      $this->id = htmlspecialchars($id);
      return $this;
    }

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

    public function getListId(){
      return $this->list_id;
    }

    public function setListId($list_id){
      $this->list_id = htmlspecialchars($list_id);
      return $this;
    }



    //// save task

    public function saveTask(){

      try{
        $conn = Db::getInstance();
        $statement = $conn->prepare("insert into task(title, about, deadline_date, deadline_hour, time, list_id) values(:title, :about, :deadline_date, :deadline_hour, :time, :list_id)");

        $statement->bindValue(':title', $this->getTitle());
        $statement->bindValue(':about', $this->getAbout());
        $statement->bindValue(':deadline_date', $this->getDeadlineDate());
        $statement->bindValue(':deadline_hour', $this->getDeadlineHour());
        $statement->bindValue(':time', $this->getTime());
        $statement->bindValue(':list_id', $this->getListId());
        $statement->execute();
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
        $statement = $conn->prepare("select * from task, list where task.list_id = id_list and list_id = :list_id order by deadline_date asc");
        $statement->bindValue(':list_id', $this->getListId());
        $statement->execute();
        $result = $statement->fetchAll();
        return $result;

      }
      catch(Throwable $t){
        echo "mislukt";
      }
    }

    ///// toon alle details van de taak

    public function getTask(){
      try{
        $conn = Db::getInstance();
        $statement = $conn->prepare("select * from task where id_task = :id");
        $statement->bindValue(':id', $this->getId());
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;

      }
      catch(Throwable $t){
        echo "mislukt";
      }
    }

    ///// markeer een taak als "done"

    public function saveTaskDone(){
      $conn = Db::getInstance();
      $statement = $conn->prepare("update task set done = 1 where id_task = :id");
      $statement->bindValue(':id', $this->getId());
      return $statement->execute();
    }




    //// edit task
    public function editTask(){
      $conn = Db::getInstance();
      $statement = $conn->prepare("update task set title = :title, about = :about, deadline_date = :deadline_date, deadline_hour = :deadline_hour, time = :time where id_task = :id");
      $statement->bindValue(':id', $this->getId());
      $statement->bindValue(':title', $this->getTitle());
      $statement->bindValue(':about', $this->getAbout());
      $statement->bindValue(':deadline_date', $this->getDeadlineDate());
      $statement->bindValue(':deadline_hour', $this->getDeadlineHour());
      $statement->bindValue(':time', $this->getTime());
      $statement->execute();
      return true;
    }

    ///// delete task
    public function deleteTask(){
      $conn = Db::getInstance();
      $statement = $conn->prepare("delete from task where id_task = :id");
      $statement->bindValue(':id', $this->getId());
      $statement->execute();
      header("Location: index.php");
      return true;
    }



}

?>
