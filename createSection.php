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
    <script src="createsection.js" type="text/javascript"></script>
    <title>Studies | Create new section</title>
  </head>
  
  <body >
    <?php
      include("topbar.php");
      include("setup.php");
      if (!$g_currentSubjId) {
        echo("No subject specified");
        exit();
      }
    ?>
    <div class="content">
      <form class="form">
        <h1>Create new section for <?=$g_currentSubjTitle?></h1>
        <select class="sectionNames">
          <option disabled value <?=$g_currentSubjSNum >= count($g_currentSubjSections) ? 'selected' : '' ?> > 
            -- choose section -- 
          </option>
          <?php for($i = 0; $i < count($g_currentSubjSections); $i++) { 
            $section = $g_currentSubjSections[$i];
            $selectedStr = "";
            if ($i == $g_currentSubjSNum) {
              $selectedStr = "selected";
            }
            ?>
            <option <?=$selectedStr?> value="<?=$i + 1?>"><?=$section?></option>
          <?php } ?>
        </select>
        <div class="divider main"></div>
        <h3>Prelim quiz (optional)</h3>
          <div class="explanation">
            Questions to ensure you're set up and ready to study.
          </div>
          <div class="questionContainer">
          <?php
            $res = mysqli_query($con, "SELECT * from prelim_questions WHERE subj_id='$g_currentSubjId' ORDER BY id ASC;");
            $hasQs = mysqli_num_rows($res) > 0;
            if (!$hasQs) {
              ?>
              <!-- No preset questions, show a blank one -->
              <div class="question">
                <div class="item">
                  <div>Question:</div>
                  <input type="text" class="prelimQuestion">
                </div>
                <div class="item">
                  <div>Valid answers: </div>
                  <textarea class="answers"></textarea>
                </div>
                <div class="item">
                  <div>Type: </div>
                  <select class="type">
                    <option value="0">text</option>
                    <option value="1">true/false</option>
                    <option value="2">number</option>
                  </select>
                </div>
              </div>
            <?php 
            } else {
              $showDivider = false;
              while ($row = mysqli_fetch_array($res)) {
                if ($showDivider) {
                ?>
                  <div class="divider small"></div>
                <?php
                }
                $showDivider = true;
              ?>
              <div class="question">
                <div class="item">
                  <div>Question:</div>
                  <input type="text" class="prelimQuestion" value="<?=$row['question']?>">
                </div>
                <div class="item <?=$row['type']!=0 ? 'hidden' : '' ?>">
                  <div>Valid answers: </div>
                  <textarea class="answers"><?=$row['valid_answers']?></textarea>
                </div>
                <div class="item">
                  <div>Type: </div>
                  <select class="type">
                    <option value="0" <?=$row['type']==0?'selected':''?> >text</option>
                    <option value="1" <?=$row['type']==1?'selected':''?> >true/false</option>
                    <option value="2" <?=$row['type']==2?'selected':''?> >number</option>
                  </select>
                </div>
              </div>
              <?php
              }
            }
          ?>
        </div>

        <div class="buttonrow">
          <button class="addQuestion">Add question</button>
          <button class="removeQuestion" <?=$hasQs ? '' : 'disabled'?> >Remove question</button>
        </div>

        <div class="divider main"></div>

        <h3>Basic Tasks</h3>
        <?php
          $numBTasks = 0;
          $startTNum = 1;
          $checkedStr = $g_currentSubjAnswers ? 'checked' : '';
          $res = mysqli_query($con, "SELECT * from tasks WHERE subj_id='$g_currentSubjId' AND is_basic=1 ORDER BY id ASC;");
          if ($res) {
            $numBTasks = mysqli_num_rows($res);
            $startTNum = explode(' ', mysqli_fetch_array($res)['name'])[1];
          }
          if (!$startTNum) {
            $startTNum = 1;
          }
        ?>
        <div class="item">
          <div>Starting task number: </div><input type="number" id="startTask" value="<?=$startTNum?>" />
        </div>
        <div class="item">
          <div>Number of tasks: </div><input type="number" id="numTasks" value="<?=$numBTasks?>" />
        </div>
        <div class="item">
          <div>Task answers need to be checked: </div>
          <input type="checkbox" id="checkAnswers" <?=$checkedStr?>/>
        </div>

        <div class="divider main"></div>

        <h3>Additional Tasks</h3>
        <div class="explanation">
          What to actually do to study a section (not including any questions numbered above).
        </div>
        <div class="tasks">
          <?php
            $res = mysqli_query($con, "SELECT * from tasks WHERE subj_id='$g_currentSubjId' AND is_basic=0 ORDER BY id ASC;");
            $hasTasks = mysqli_num_rows($res) > 0;
            if (!$hasTasks) {
          ?>
            <!-- No tasks - start with a blank row -->
            <div class="item">
              <div>Task name: </div><input type="text" class="additionalTaskName">
            </div>
          <?php
            } else {
              while ($row = mysqli_fetch_array($res)) {
            ?>
            <div class="item">
              <div>Task name: </div><input type="text" class="additionalTaskName" value="<?=$row['name']?>">
            </div>
            <?php
              }
            }
          ?>
        </div>

        <div class="buttonrow">
          <button class="addTask">Add task</button>
          <button class="removeTask" <?=$hasTasks ? '' : 'disabled'?> >Remove task</button>
        </div>

        <div class="divider main"></div>
      </form>
      <button class="create">Create section</button>
      <div class="hidden invalid">Not all fields filled out!</div>
      <div class="hidden loading">Creating section...</div>
      <div class="hidden valid">New section created!</div>
    </div>
  </body>
</html>
