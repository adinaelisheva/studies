<html>
  <?php
    include("setup.php");
  ?>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
    <link href="https://fonts.googleapis.com/css2?family=Lora&family=Raleway&family=Balsamiq+Sans:wght@700&display=swap" rel="stylesheet">
    <link href="global.css" type="text/css" rel="stylesheet" />
    <link href="subject.css" type="text/css" rel="stylesheet" />
    <script src="subject.js" type="text/javascript"></script>
    <title>Studies | <?=$g_currentSubjTitle?></title>

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
    <div class="subjid hidden"><?=$g_currentSubjId?></div>
    <div class="content">
      <h1><?=$g_currentSubjTitle?> - <?=$g_currentSubjSection?></h1>
      <?php if (!$g_prelimCompleted) { ?>
        <a href="prelimQuiz.php?id=<?=$g_currentSubjId?>">Complete preliminary quiz</a>
      <?php } else { ?>
        <div class="complete">Preliminary quiz complete! ✓</div>
      <?php
        $res0 = mysqli_query($con, "SELECT * from prelim_questions WHERE subj_id='$g_currentSubjId';");
        if(!$res0) {
          exit();
        } ?>
        <div class="divider"></div>
        <?php while($row = mysqli_fetch_array($res0)){?>
          <div class="prelimAnswerRow">
            <div class="prelimQ"><?=$row['question']?></div>
            <?php if(str_starts_with($row['answer'], "http")) { ?>
              <a class="prelimA" href="<?=$row['answer']?>"><?=$row['answer']?></a>
            <?php } else { ?>
              <div class="prelimA"><?=$row['answer']?></div>
            <?php } ?>
          </div>
      <?php } ?>
        <div class="divider"></div>
      <?php
        $res = mysqli_query($con, "SELECT * from tasks WHERE subj_id='$g_currentSubjId';");
        if(!$res) { 
          exit();
        } 
        $sectionCompleted = true;
        $foundAnyQuestions = false; ?>
        <h2>Next tasks:</h2>
        <div>
          <div class="error">Couldn't find any tasks for this subject!</div>
          <?php while($row = mysqli_fetch_array($res)){ 
            $completed = $row['completed'];
            $correct = $row['correct'];
            $foundAnyQuestions = true;
            if (!$completed) {
              $sectionCompleted = false;
            }
            $completeClass = $completed ? '' : 'hidden';
            $correctClass = $correct ? '' : 'hidden';
            $wrongClass = $correct ? 'hidden' : '';
            $buttonClass = $completed ? 'hidden' : '';?>
            <div class="task">
              <div class="taskname"><?=$row['name']?></div>
              <?php if($g_currentSubjAnswers) { ?>
                <div class="buttonGroup">
                  <button class="completeButton correct <?=$buttonClass?>" taskid="<?=$row['id']?>">Correct</button>
                  <button class="completeButton wrong <?=$buttonClass?>" taskid="<?=$row['id']?>">Wrong</button>
                  <div class="complete correct <?=$completeClass?> <?=$correctClass?>">✓</div>
                  <div class="complete wrong <?=$completeClass?> <?=$wrongClass?>">𝙭</div>
              </div>
              <?php } else { ?>
                <button class="completeButton <?=$buttonClass?>" taskid="<?=$row['id']?>">Complete</button>
                <div class="complete <?=$completeClass?>">✓</div>
              <?php } ?>
            </div>
          <?php } ?>
        </div>
        <?php
        $sectionCompleted = $sectionCompleted && $foundAnyQuestions;
        $secCompletedClass = $sectionCompleted ? '' : 'hidden';
        $secUncompletedClass = $sectionCompleted ? 'hidden' : ''; ?>
        <div class="sectionComplete <?=$secCompletedClass?>">
          <div>Finished <?=$g_currentSubjSection?>! 🎉</div>
          <div class="buttons">
            <button class="startNewSection">Start new section</button>
            <button class="completeSubject">Finish <?=$g_currentSubjTitle?></button>
          </div>
        </div>
        <div class="subjectComplete hidden">Finished <?=$g_currentSubjTitle?>! 🎉</div>
        <div class="cancelSection <?=$secUncompletedClass?>">
          <button class="cancelAndRestart">Cancel and start new section</button>
        </div>        
      <?php } ?>
    </div>
  </body>
</html>
