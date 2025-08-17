<?php
  include("common.php"); 
  if (isset($_GET["id"])) {  
    $id = $_GET["id"];
    $query = "DELETE FROM tasks WHERE subj_id = '$id';";
    mysqli_query($con,$query) or die(mysqli_error($con));
    $query = "DELETE FROM prelim_questions WHERE subj_id = '$id';";
    mysqli_query($con,$query) or die(mysqli_error($con));
  }
?>