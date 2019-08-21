<?php

 abstract class Db{
   private static $conn;

   public static function getInstance(){
     $config = parse_ini_file( __DIR__ . "/../config/config.ini");
     if(!$config){
       throw new Exception("config file not found");
     }

     if(self::$conn != null){
       return self::$conn;
     }
     else{
       self::$conn = new PDO("mysql:host=localhost;dbname=" . $config['db_name'], $config['db_user'],$config['db_password']);
       return self::$conn;
     }

   }
 }




?>
