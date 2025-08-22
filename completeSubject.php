<?php
  include("common.php"); 
  if (isset($_GET["id"])) {  
    $id = $_GET["id"];
    $query = "UPDATE studies SET active = 0 WHERE id = '$id';";
    mysqli_query($con,$query) or die(mysqli_error($con));
  }
?>