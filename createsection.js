const TEXT = '0';
const BOOL = '1';
const NUM = '2';

function setup() {
  const removeQButton = document.querySelector('.removeQuestion');
  removeQButton.addEventListener('click', (e) => {
    removeQuestion(removeQButton);
    e.preventDefault();
  });
  const addQButton = document.querySelector('.addQuestion');
  addQButton.addEventListener('click', (e) => {
    addQuestion(removeQButton);
    e.preventDefault();
  });
  const removeTaskButton = document.querySelector('.removeTask');
  removeTaskButton.addEventListener('click', (e) => {
    removeTask(removeTaskButton);
    e.preventDefault();
  });
  const addTaskButton = document.querySelector('.addTask');
  addTaskButton.addEventListener('click', (e) => {
    addTask(removeTaskButton);
    e.preventDefault();
  });

  document.querySelectorAll('select.type').forEach((s) => {
    s.addEventListener('change', () => {
      updateSiblingForType(s);
    });
  });

  document.querySelector('button.create').addEventListener('click', () => {
    createNewSection();
  });
}

function removeLastItemFromContainer(container, selector, button) {
  const items = container.querySelectorAll(selector);
  if (items.length < 1) {
    return;
  } else if (items.length === 1) {
    button.setAttribute('disabled','');
  }
  const item = items[items.length - 1];
  container.removeChild(item);
  if (container.children.length > 0) {
    // Chop off the '.' to get the actual classname
    const classname = selector.substring(1, selector.length);
    const lastChild = container.children[container.children.length - 1];
    if (!lastChild.classList.contains(classname)) {
      // it's a divider or something, remove it
      container.removeChild(lastChild);
    }
  }
  
}

function addQuestion(removeButton) {
  if (removeButton) {
    removeButton.removeAttribute('disabled');
  }
  const container = document.querySelector('.questionContainer');
  const newQ = document.createElement('div');
  newQ.classList.add('question');

  if (container.children.length > 0) {
    const divider = document.createElement('div');
    divider.classList.add('divider');
    divider.classList.add('small');
    newQ.appendChild(divider);
  }

  const qItem = document.createElement('div');
  qItem.classList.add('item');
  const questionLabel = document.createElement('div');
  questionLabel.innerText = 'Question:'
  qItem.appendChild(questionLabel);
  const qInput = document.createElement('input');
  qInput.setAttribute('type', 'text');
  qInput.classList.add('prelimQuestion');
  qItem.appendChild(qInput);
  newQ.appendChild(qItem);

  const aItem = document.createElement('div');
  aItem.classList.add('item');
  const answersLabel = document.createElement('div');
  answersLabel.innerText = 'Valid answers:'
  aItem.appendChild(answersLabel);
  const area = document.createElement('textarea');
  area.classList.add('answers');
  aItem.appendChild(area);
  newQ.appendChild(aItem);

  const tItem = document.createElement('div');
  tItem.classList.add('item');
  const typeLabel = document.createElement('div');
  typeLabel.innerText = 'Type:'
  tItem.appendChild(typeLabel);
  const select = document.createElement('select');
  select.classList.add('type');
  const option1 = document.createElement('option');
  option1.innerText = 'text';
  option1.value = '0';
  select.appendChild(option1);
  const option3 = document.createElement('option');
  option3.innerText = 'true/false';
  option3.value = '1';
  select.appendChild(option3);
  const option2 = document.createElement('option');
  option2.innerText = 'number';
  option2.value = '2';
  select.appendChild(option2);
  tItem.appendChild(select);
  select.addEventListener('change', () => {
    updateSiblingForType(select);
  });
  newQ.appendChild(tItem);

  container.appendChild(newQ);
}

function removeQuestion(button) {
  const container = document.querySelector('.questionContainer');
  removeLastItemFromContainer(container, '.question', button);
  if (container.children.length === 0) {
    addQuestion();
  }
}

function addTask(removeButton) {
  if (removeButton) {
    removeButton.removeAttribute('disabled');
  }
  const container = document.querySelector('.tasks');
  const newT = document.createElement('div');
  newT.classList.add('item');
  const name = document.createElement('div');
  name.innerText = 'Task name:';
  newT.appendChild(name);
  const input = document.createElement('input');
  input.setAttribute('type', 'text');
  input.classList.add('additionalTaskName');
  newT.appendChild(input);
  container.appendChild(newT);  
}

function updateSiblingForType(select) {
  let parent = select.parentElement;
  while (!parent.classList.contains('question')) {
    parent = parent.parentElement;
  }
  const siblingArea = parent.querySelector('textarea');
  const toUpdate = siblingArea.parentElement;
  if (select.value === TEXT) {
    toUpdate.classList.remove('hidden');
  } else {
    toUpdate.classList.add('hidden');
  }
}

function removeTask(button) {
  const container = document.querySelector('.tasks');
  removeLastItemFromContainer(container, '.item', button);
  if (container.children.length === 0) {
    addTask();
  }
}

async function createNewSection() {
  const validDiv = document.querySelector('.valid');
  const invalidDiv = document.querySelector('.invalid');
  const loadingDiv = document.querySelector('.loading');
  const id = location.search.match(/id=(\d+)/)[1];
  // If we have > 1 prelim question or the first one is filled out, 
  // we have a preliminary quiz
  const hasPrelim = 
      document.querySelector(".prelimQuestion").value || 
      document.querySelectorAll(".prelimQuestion").length > 1;

  // First verify that the quiz is valid
  const numTasksDiv = document.querySelector("#numTasks");
  const hasBasicTasks = numTasksDiv.value !== '' && numTasksDiv.value > 0;
  const addlTaskDiv = document.querySelector(".additionalTaskName");
  if (!hasBasicTasks && addlTaskDiv.value === '') {
    numTasksDiv.classList.add('withError');
    addlTaskDiv.classList.add('withError');
  } else {
    numTasksDiv.classList.remove('withError');
    addlTaskDiv.classList.remove('withError');
  }
  const select = document.querySelector('.sectionNames');
  if (!select.value) {
    select.classList.add('withError');
  } else {
    select.classList.remove('withError');
  }
  if (document.querySelector('.withError')) {
    invalidDiv.classList.remove('hidden');
    return;
  } else {
    invalidDiv.classList.add('hidden');
  }

  loadingDiv.classList.remove('hidden');
  // First delete any previous tasks and questions
  await fetch(`./clearSubject.php?id=${id}`);

  loadingDiv.innerText = 'Updating main course...';
  // Update the course in the main studies table
  const checkAnswers = document.querySelector('#checkAnswers').checked ? 1 : 0;
  const skipPrelim = hasPrelim ? 0 : 1;
  const secNum = select.value;
  await fetch(`./updateSubject.php?id=${id}&answers=${checkAnswers}&prelim=${skipPrelim}&section=${secNum}`);
  
  // Add the prelim questions to the questions table
  if (hasPrelim) {
    const questions = document.querySelectorAll('.questionContainer > .question');
    loadingDiv.innerText = `Adding ${questions.length} prelim questions...`;
    for (const q of questions) {
      const question = q.querySelector('.prelimQuestion').value;
      const type = q.querySelector('.type').value;
      let answers = q.querySelector('.answers').value;
      if (type === BOOL) {
        answers = 'on,off';
      } else if (type === NUM) {
        answers = 'INT';
      }
      await fetch(`./addNewPrelimQuestion.php?id=${id}&question=${question}&answers=${answers}&type=${type}`);
    }
  }

  // Add the tasks to the task table 
  if (hasBasicTasks) {
    const startTaskNum = document.querySelector('#startTask').value;
    const taskCount = numTasksDiv.value;
    loadingDiv.innerText = `Adding ${taskCount} basic tasks...`;
    await fetch(`./addNewTask.php?id=${id}&taskstart=${startTaskNum}&taskcount=${taskCount}`);
  }
  const tasks = document.querySelectorAll('.additionalTaskName');
  if (tasks.length > 0) {
    loadingDiv.innerText = `Adding ${tasks.length} additional tasks...`;
  }
  for (const t of tasks) {
    if (t.value) {
      await fetch(`./addNewTask.php?id=${id}&task=${t.value}`);
    }
  }

  const form = document.querySelector('.form');
  form.parentElement.removeChild(form);
  loadingDiv.classList.add('hidden');
  validDiv.classList.remove('hidden');
  document.querySelector('button.create').setAttribute('disabled', '');
  window.setTimeout(() => {
    window.location = './subject.php?id=' + id;
  }, 1000);
}

window.onload = setup;