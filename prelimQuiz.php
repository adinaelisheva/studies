<html>
  <?php
    include("setup.php");
  ?>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
    <link href="https://fonts.googleapis.com/css2?family=Lora&family=Raleway&family=Balsamiq+Sans:wght@700&display=swap" rel="stylesheet">
    <link href="global.css" type="text/css" rel="stylesheet" />
    <link href="prelimQuiz.css" type="text/css" rel="stylesheet" />
    <script src="prelimQuiz.js" type="text/javascript"></script>
    <title>Studies | Preliminary Quiz for <?=$g_currentSubjTitle?></title>

  </head>
  
  <body >
    <?php
      include("topbar.php");
    ?>
    <div class="content">
      <?php
        $res = mysqli_query($con, "SELECT * from prelim_questions WHERE subj_id='$g_currentSubjId';");
        if(!$res) {
          exit();
        } ?>

      <h1>Preliminary quiz for <?=$g_currentSubjTitle?> - <?=$g_currentSubjSection?></h1>
      <div class="curSubjId hidden"><?=$g_currentSubjId?></div>
      <?php if ($g_prelimCompleted) {?>
        <div class="completed">Quiz already complete!</div>
      <?php } else { 
        $questionsExist = false; ?>
        <div class="quiz">
          <div class="error">Couldn't find any questions for this quiz!</div>
          <?php while($row = mysqli_fetch_array($res)){ 
            $questionsExist = true; ?>
            <div class="questionRow">
              <div class="questionContainer">
                <div class="question"><?=$row['question']?></div>
                <div class="invalid hidden">Invalid</div>
              </div>
              <div class="answer">
                <?php if ($row['type'] == '0') { ?>
                  <input type="text">
                <?php } elseif ($row['type'] == '1') { ?>
                  <input type="checkbox">
                <?php } elseif ($row['type'] == '2') { ?>
                  <input type="number">
                <?php } ?>
              </div>
              <div class="validation"><?=str_rot13($row['valid_answers'])?></div>
            </div>
          <?php } 
        if ($questionsExist) { ?>
          </div>
          <div class="buttonRow">
            <button class="submit">Submit</button>
            <div class="invalid hidden">Not all answers are valid.</div>
            <div class="valid hidden">
              <div class="valid">All answers are valid! Marked complete ✓</div>
              <a class="return" href="./subject.php?id=<?=$g_currentSubjId?>">Return to <?=$g_currentSubjTitle?></a>
            </div>
          </div>
        <?php }
      } ?>
    </div>
  </body>
</html>
