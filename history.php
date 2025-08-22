<html>
  <head>
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
    <meta name="viewport" content="width=device-width">
    <link href="https://fonts.googleapis.com/css2?family=Lora&family=Raleway&family=Balsamiq+Sans:wght@700&display=swap" rel="stylesheet">
    <link href="global.css" type="text/css" rel="stylesheet" />
    <link href="history.css" type="text/css" rel="stylesheet" />
    <script src="colorpct.js" type="text/javascript"></script>
    <title>Studies | Completed studies</title>

  </head>
  
  <body >
    <?php
      include("setup.php");
      include("topbar.php"); 
    ?>
    <div class="content">
      <?php
        $res = mysqli_query($con, "SELECT * from `completed` ORDER BY `completed`.`date` DESC;");
        if(!$res) {
          exit();
        } ?>
      <h1>Completed studies:</h1>
      <div class="studies">
        <div class="error">None yet!</div>
        <?php while($row = mysqli_fetch_array($res)){ ?>
          <div class="row">
            <div><?=$row['subject']?>: <?=$row['section']?></div> 
            <div class="rightSection">
              <?php if ($row['score']) { ?>
                <div class="score"><?=$row['score']?>%</div>
              <?php } ?>
              <div><?=$row['date']?></div>
            </div>
        </div> 
        <?php } ?>
      </div>
    </div>
  </body>
</html>
