<?php
  include("common.php"); 
  if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $res = mysqli_query($con, "SELECT * from studies WHERE id='$id';");
    if(!$res) {
      exit();
    }
    $res2 = mysqli_query($con, "SELECT * from completed WHERE subject='$subject';");
    $tmp = mysqli_fetch_array($res2);
    if ($tmp && $tmp['subject']) {
      // This subject was already completed. Don't re-complete it.
      exit();  
    }
    $subjectInfo = mysqli_fetch_array($res);
    date_default_timezone_set('US/Eastern');
    $curdate = date("Y-m-d");
    $subjectName = $subjectInfo['subject'];
    $section = explode(',',$subjectInfo['sections'])[$subjectInfo['cur_section'] - 1];
    $query = "INSERT INTO completed (subject, section, date, subj_id) VALUES ('$subjectName','$section', '$curdate', '$id');";
    if (isset($_GET["score"])) {
      $score = $_GET["score"];
      $query = "INSERT INTO completed (subject, section, date, subj_id, score) VALUES ('$subjectName','$section', '$curdate', '$id', '$score');";
    }
    mysqli_query($con,$query) or die(mysqli_error($con));
  }
?>