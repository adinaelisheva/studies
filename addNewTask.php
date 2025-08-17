<?php
  // Insert 1 or multiple tasks into a db 
  // If inserting multiple, they will all be basic tasks
  include("common.php"); 
  if (!isset($_GET["id"])) {
    die("No id set");
  }

  $hasTask = isset($_GET["task"]);
  $hasTaskSet = isset($_GET["taskstart"]) and isset($_GET["taskcount"]);
  if (!$hasTask and !$hasTaskSet) {
    die("No tasks specified");
  }

  $id = $_GET["id"];

  if ($hasTask) {
    $basic = 0;
    if (isset($_GET["basic"])) {
      $basic = $_GET["basic"];
    }
    $task = $_GET["task"];
    $query = "INSERT INTO tasks (subj_id, name, is_basic) VALUES ('$id','$task', '$basic');";
    echo($query);
    mysqli_query($con,$query) or die(mysqli_error($con));
    echo "Success";
  }

  if ($hasTaskSet) {
    $sql = "INSERT INTO tasks (subj_id, name, is_basic) VALUES ";
    $num = $_GET["taskstart"];
    $count = $_GET["taskcount"];
    for ($i = 0; $i < $count ; $i++) {
      if ($i > 0) {
        $sql = $sql . ', ';
      }
      $sql = $sql . "('$id', 'Task $num', '1')";
      $num++;
    }
    $sql = $sql . ';';
    echo($sql);
    mysqli_query($con,$sql) or die(mysqli_error($con));
    echo "Success";
  }
?>