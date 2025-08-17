<?php
  include("common.php"); 
  if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $query = "UPDATE tasks SET completed = '1' WHERE id = '$id';";
    mysqli_query($con,$query);
    if (isset($_GET["correct"]) and $_GET["correct"]) {
      $query = "UPDATE tasks SET correct = '1' WHERE id = '$id';";
      mysqli_query($con,$query);
    }
  }
?>