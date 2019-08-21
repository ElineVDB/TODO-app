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
    private $file_name;
    private $text;


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
      if(empty($title)){
        throw new Exception("A task needs a title. ALWAYS.");
      }
      else{
        $this->title = htmlspecialchars($title);
        return $this;
          }
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

    //// file name

    public function getFileName(){
      return $this->file_name;
    }

    public function setFileName($file_name){
      $this->file_name = htmlspecialchars($file_name);
      return $this;
    }

    public function saveFile(){
      $conn = Db::getInstance();
      $statement = $conn->prepare("insert into upload_files(file_name, task_id) values(:name, :id)");
      $statement->bindValue(':name', $this->getFileName());
      $statement->bindValue(':id', $this->getId());
      $statement->execute();
    }


    //// save task

    public function saveTask(){

      $conn = Db::getInstance();
      // selecteer de taak met de ingegeven titel van een specifieke lijst
      $statement = $conn->prepare("select title from task where title = :t and list_id = :id");
      $statement->bindValue(':t', $this->getTitle());
      $statement->bindValue(':id', $this->getListId());
      $statement->execute();
      $result_title = $statement->fetch(PDO::FETCH_ASSOC);

      if($statement->rowCount() > 0){
        throw new Exception("There is another task with the same title in this list. Try another one. ");
      }
      else{
        // als de taak een unieke title heeft, word deze opgeslagen in de databank
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

    }

    //////// toon al de taken van de lijst die gemarkeerd staan als todo
    public function showTasks(){
      try{
        $conn = Db::getInstance();
        $statement = $conn->prepare("select * from task, list where task.list_id = id_list and list_id = :list_id and done = :i order by deadline_date asc");
        $statement->bindValue(':list_id', $this->getListId());
        $statement->bindValue(':i', 0);
        $statement->execute();
        $result = $statement->fetchAll();
        return $result;

      }
      catch(Throwable $t){
        echo "mislukt";
      }
    }

    public function showDoneTasks(){
      $conn = Db::getInstance();
      $statement = $conn->prepare("select * from task, list where task.list_id = id_list and list_id = :list_id and done = :i");
      $statement->bindValue(':list_id', $this->getListId());
      $statement->bindValue(':i', 1);
      $statement->execute();
      $result = $statement->fetchAll();
      return $result;

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

    ////// toon de file(s) in de detail page van een taak

    public function getFiles(){
      $conn = Db::getInstance();
      $statement = $conn->prepare("select * from upload_files where task_id = :id");
      $statement->bindValue(':id', $this->getId());
      $statement->execute();
      $result = $statement->fetchAll();
      return $result;

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
      header("Location: home.php");
      return true;
    }


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
        public function saveComment(){
          $conn = Db::getInstance();
          $statement = $conn->prepare("insert into comments (text, task_id, date) values (:text, :task, NOW())");
          $statement->bindValue(':text', $this->getText());
          $statement->bindValue(":task", $this->getId());
          $res = $statement->execute();
          if (!$res){
            throw new \Exception("Error saving comment: " . implode(" ", $statement->errorInfo()), 1);
          }
          return $res;
        }



}

?>
