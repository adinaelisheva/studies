<?php
  include("common.php"); 
  if (isset($_GET["id"])) {  
    $id = $_GET["id"];
    if (isset($_GET["answers"])) {
      $answers = $_GET["answers"];
      $query = "UPDATE studies SET enter_answer = '$answers' WHERE id = '$id';";
      mysqli_query($con,$query) or die(mysqli_error($con));
    }
    if (isset($_GET["prelim"])) {
      $prelim = $_GET["prelim"];
      $query = "UPDATE studies SET prelim_completed = '$prelim' WHERE id = '$id';";
      mysqli_query($con,$query) or die(mysqli_error($con));
    }
    if (isset($_GET["section"])) {
      $section = $_GET["section"];
      $query = "UPDATE studies SET cur_section = '$section' WHERE id = '$id';";
      mysqli_query($con,$query) or die(mysqli_error($con));
    }
  }
?>