<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
include_once("bootstrap.php");
require_once("security.php");

session_start();

$logout = new User();

if($logout->logout()){
  header("Location: index.php");
}
?>
