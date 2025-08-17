<?php
  include("common.php"); 
  if (isset($_GET["name"]) and isset($_GET["sections"])) {
    $name = $_GET["name"];
    $sections = $_GET["sections"];
    $answers = 0;
    if (isset($_GET["answers"])) {
      $answers = $_GET["answers"];
    }
    $prelim = 0;
    if (isset($_GET["skipPrelim"])) {
      $prelim = $_GET["skipPrelim"];
    }
    $query = "INSERT INTO studies (subject, sections, enter_answer, prelim_completed) VALUES ('$name','$sections', '$answers', '$prelim');";
    // echo $query;
    mysqli_query($con,$query) or die(mysqli_error($con));
    $res = mysqli_query($con, "SELECT * from studies WHERE `subject` = '$name';");
    if(!$res) {
      exit();
    }
    $row = mysqli_fetch_array($res);
    echo($row['id']);
  }
?>