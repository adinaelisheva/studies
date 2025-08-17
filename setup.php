<?php
  include("common.php"); 
  
  // Set the global vars for the subject
  if (isset($_GET["id"])) {
    $g_currentSubjId = $_GET["id"];
    $res = mysqli_query($con, "SELECT * from studies WHERE id='$g_currentSubjId';");
    $subjInfo = mysqli_fetch_array($res);
    $g_currentSubjTitle = $subjInfo['subject'];
    $g_currentSubjSNum = $subjInfo['cur_section'];
    $g_currentSubjSections = explode(',', $subjInfo['sections']);
    $g_currentSubjSection = $g_currentSubjSections[$g_currentSubjSNum - 1];
    $g_prelimCompleted = $subjInfo['prelim_completed'];
    $g_currentSubjAnswers = $subjInfo['enter_answer'];
  }
?>