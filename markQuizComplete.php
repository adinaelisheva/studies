<?php
  include("common.php"); 
  if (isset($_GET["id"])) {  
    $id = $_GET["id"];
    $query = "UPDATE studies SET prelim_completed = '1' WHERE id = '$id';";
    mysqli_query($con,$query);
  }
?>