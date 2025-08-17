<?php
  include("common.php"); 
  if (isset($_GET["id"]) and isset($_GET["answer"])) {  
    $id = $_GET["id"];
    $answer = $_GET["answer"];
    $query = "UPDATE prelim_questions SET answer = '$answer' WHERE id = '$id';";
    mysqli_query($con,$query) or die(mysqli_error($con));
  }
?>