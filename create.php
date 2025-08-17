<html>
  <?php
    include("setup.php");
  ?>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
    <link href="https://fonts.googleapis.com/css2?family=Lora&family=Raleway&family=Balsamiq+Sans:wght@700&display=swap" rel="stylesheet">
    <link href="global.css" type="text/css" rel="stylesheet" />
    <link href="create.css" type="text/css" rel="stylesheet" />
    <script src="create.js" type="text/javascript"></script>
    <title>Studies | Create new study</title>
  </head>
  
  <body >
    <?php
      include("topbar.php");
      $res = mysqli_query($con, "SELECT * from studies WHERE id='$g_currentSubjId';");
      if(!$res) {
        echo("Failed to find studies: ");
        if(count($res) === 0) {
          echo("None exist.");
        } else {
          echo(mysqli_connect_error());
        }
        exit();
      }
    ?>
    <div class="content">
      <form class="form">
        <h1>Create new course of study</h1>
        <h3>Basic info</h3>
        <div class="item">
          <div>Name: </div><input type="text" id="courseName" class="required">
        </div>
        <div class="wideitem">
          <div>All section names (comma separated): </div>
          <br/> 
          <textarea id="sections" class="required"></textarea>  
        </div>

        <div class="divider main"></div>
      </form>
      <button class="create">Create new course</button>
      <div class="hidden invalid">Not all fields filled out!</div>
      <div class="hidden valid">New course created!</div>
    </div>
  </body>
</html>
