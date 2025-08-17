function setup() {
  document.querySelector('button.create').addEventListener('click', () => {
    createNewCourse();
  });
}

async function createNewCourse() {
  // First verify that the quiz is valid
  const inputs = document.querySelectorAll('.required');
  for (const i of inputs) {
    if (i.value === '') {
      i.classList.add('withError');
    } else {
      i.classList.remove('withError');
    }
  }
  if (document.querySelector('.withError')) {
    document.querySelector('.invalid').classList.remove('hidden');
    return;
  } else {
    document.querySelector('.invalid').classList.add('hidden');
  }

  // Create the course in the main studies table
  const courseName = encodeURIComponent(document.querySelector('#courseName').value);
  const sections = encodeURIComponent(document.querySelector('#sections').value);
  const response = await fetch(`./addNewCourse.php?name=${courseName}&sections=${sections}`);
  const id = await response.json();

  const form = document.querySelector('.form');
  form.parentElement.removeChild(form);
  document.querySelector('.valid').classList.remove('hidden');
  document.querySelector('button.create').setAttribute('disabled', '');
  window.setTimeout(() => {
    window.location = './createSection.php?id=' + id;
  }, 1000);
}

window.onload = setup;