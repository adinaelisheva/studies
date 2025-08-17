<div class="topbar">
  <div class="topbarSection left">
    <div class="sitename">StudyHelper</div>
    <a href=".">All Subjects</a>
    <a href="./history.php">Completed studies</a>
    <?php if ($g_currentSubjId) { ?>
      <div class="divider"></div>
      <a href="./subject.php?id=<?=$g_currentSubjId?>"><?=$g_currentSubjTitle?></a>
    <?php } ?>
  </div>
  <div class="topbarSection right">
    <a href="./create.php">Create new</a>
  </div>
</div>