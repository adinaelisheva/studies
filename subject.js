let numTasks;
let numComplete = 0;

function setup() {
  const tasks = document.querySelectorAll('.task');
  numTasks = tasks.length;
  for (let t = 0; t < tasks.length; t++) {
    // Just check the first one bc all the buttons will be hidden if it's complete
    if(tasks[t].querySelector('.completeButton').classList.contains('hidden')) {
      numComplete++;
    }
    const buttons = tasks[t].querySelectorAll('.completeButton');
    for (const button of buttons) {
      const isCorrect = button.classList.contains('correct');
      const isWrong = button.classList.contains('wrong');
      button.addEventListener('click', () => {
        completeTask(t, isCorrect, isWrong);
      });
    }
  }
  const newSectionButton = document.querySelector('.startNewSection');
  const cancelAndRestartButton = document.querySelector('.cancelAndRestart');
  const completeSubjectButton = document.querySelector('.completeSubject');
 
  // These should all exist
  if (!newSectionButton || !cancelAndRestartButton || !completeSubjectButton) {
    return;
  }

  newSectionButton.addEventListener('click', () => {
    startNewSection(true);
  });
  cancelAndRestartButton.addEventListener('click', () => {
    startNewSection(false);
  });
  completeSubjectButton.addEventListener('click', () => {
    completeSubject();
  })
}

function startNewSection(completed) {
  const id = location.search.match(/id=(\d+)/)[1];
  if (completed) {
    let fetchStr = `./completeSection.php?id=${id}`;
    if (document.querySelector('.complete.correct')) {
      const correct = document.querySelectorAll('.task .complete.correct:not(.hidden)').length;
      const total = document.querySelectorAll('.task .complete:not(.hidden)').length;
      const score = Math.floor((correct/total) * 100);
      fetchStr = fetchStr + `&score=${score}`;
    }
    fetch(fetchStr);
  }
  window.location = './createSection.php?id=' + id;
}

function completeTask(index, isCorrect, isWrong) {
  const task = document.querySelectorAll('.task')[index];
  const button = task.querySelector('.completeButton');
  const id = button.getAttribute('taskid');
  let fetchStr = `./markTaskComplete.php?id=${id}`;
  if (isCorrect) {
    fetchStr = fetchStr + '&correct=1';
  }
  fetch(fetchStr);
  // Hide every button associated with this task
  const buttons = task.querySelectorAll('.completeButton');
  for (let i = 0; i < buttons.length; i++) {
    buttons[i].classList.add('hidden');
  }
  let completeIcon = task.querySelector('.complete');
  if (isCorrect) {
    completeIcon = task.querySelector('.complete.correct');
  }
  if (isWrong) {
    completeIcon = task.querySelector('.complete.wrong')
  }
  completeIcon.classList.remove('hidden');
  numComplete++;
  if (numComplete === numTasks && numTasks > 0) {
    document.querySelector('.cancelAndRestart').classList.add('hidden');
    document.querySelector('.sectionComplete').classList.remove('hidden');
  }
}

async function completeSubject() {
  const id = location.search.match(/id=(\d+)/)[1];
  await fetch(`./completeSubject.php?id=${id}`);
  document.querySelector('.sectionComplete .buttons').classList.add('hidden');
  document.querySelector('.subjectComplete').classList.remove('hidden');
  window.setTimeout(() => {
    window.location = '.';
  }, 1000);
}

window.onload = setup;