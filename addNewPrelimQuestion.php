<?php
  include("common.php"); 
  if (isset($_GET["id"]) and isset($_GET["type"]) and isset($_GET["question"]) and isset($_GET["answers"])) {
    $question = $_GET["question"];
    $answers = $_GET["answers"];
    $id = $_GET["id"];
    $type = $_GET["type"];
    $query = "INSERT INTO prelim_questions (question, valid_answers, subj_id, type) VALUES ('$question','$answers','$id','$type');";
    echo($query);
    mysqli_query($con,$query);
  }
?>