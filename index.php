<html>
  <head>
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
    <meta name="viewport" content="width=device-width">
    <link href="https://fonts.googleapis.com/css2?family=Lora&family=Balsamiq+Sans:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="global.css" type="text/css" rel="stylesheet" />
    <link href="index.css" type="text/css" rel="stylesheet" />
    <script src="colorpct.js" type="text/javascript"></script>
    <title>Studies | Home</title>

  </head>
  
  <body >
    <?php
      include("setup.php");
      include("topbar.php"); 
    ?>
    <div class="content">
      <?php
        $res = mysqli_query($con, "SELECT * from studies ORDER BY id DESC;");
        if(!$res) {
          exit();
        } ?>
      <h1>Currently studying:</h1>
      <div class="subjects">
        <div class="error">Couldn't find any subjects!</div>
        <?php while($row = mysqli_fetch_array($res)){
                $id = $row['id'];
                $sNum = $row['cur_section']; ?>
          <div class="subject">
            <a class="overlay" href="./subject.php?id=<?=$id?>"></a>
            <div class="row">
              <div class="title"><?=$row['subject']?></div>
              <div class="progressSection">
                <?php
                  $total = count(explode(',' , $row['sections']));
                  $res1 = mysqli_query($con, "SELECT count(*) as count from completed where subj_id=$id;");
                  $completed = mysqli_fetch_array($res1)['count'];
                  $pct = 0;
                  if ($total) {
                    $pct = floor(100*($completed / $total));
                  }
                  $res1 = mysqli_query($con, "SELECT AVG(score) as score from completed where subj_id=$id;");
                  $score = mysqli_fetch_array($res1)['score'];
                  $score = floor($score);
                  if($pct > 0) { 
                    if ($row['enter_answer']) { ?>
                      <div class="score">
                        <?=$score?>%
                      </div>
                    <?php } ?>
                  <div class="pct">
                    <div class="pctbar" style="width: <?=$pct?>%;"></div>
                  </div>
                <?php } ?>
              </div>
            </div>
            <div class="row sectionInfo">
              <div class="section">
                <?=$sNum?>) <?=trim(explode(',' , $row['sections'])[$sNum - 1]);?>
              </div>
              <div class="status <?=$row['prelim_completed'] ? "inprogress" : "prelim" ?>">
                <?=$row['prelim_completed'] ? "Tasks available" : "Prelim quiz available" ?>
              </div>
              <?php
                $res2 = mysqli_query($con, "SELECT count(*) as count from tasks where subj_id=$id;");
                $total = mysqli_fetch_array($res2)['count'];
                $res2 = mysqli_query($con, "SELECT count(*) as count from tasks where subj_id=$id AND completed=1;");
                $completed = mysqli_fetch_array($res2)['count'];
                $pct = 0;
                if ($total) {
                  $pct = floor(100*($completed / $total));
                }
                $res2 = mysqli_query($con, "SELECT count(*) as count from tasks where subj_id=$id AND correct=1;");
                $correct = mysqli_fetch_array($res2)['count'];
                $correctPct = 0;
                if ($completed) {
                  $correctPct = floor(100*($correct / $completed));
                }
                $barclass = $pct > 0 ? '' : 'invisible';
              ?>
              <div class="progressSection">
                <div class="score">
                  <?php if ($row['enter_answer'] && $pct > 0) { ?>
                    <?=$correctPct?>%
                  <?php } ?>
                </div>
                <div class="pct <?=$barclass?>">
                  <div class="pctbar" style="width: <?=$pct?>%;"></div>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </body>
</html>
