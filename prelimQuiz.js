function setup() {
  document.querySelector('button.submit').addEventListener('click', () => {
    validateQuiz();
  })
}

// Copied from stack overflow
function rot13(str) {
  var input     = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
  var output    = 'NOPQRSTUVWXYZABCDEFGHIJKLMnopqrstuvwxyzabcdefghijklm';
  var index     = x => input.indexOf(x);
  var translate = x => index(x) > -1 ? output[index(x)] : x;
  return str.split('').map(translate).join('');
}

function validAnswer(answer, validation) {
  if (validation === 'INT') {
    return Number.isInteger(parseFloat(answer));
  } else {
    return validation.indexOf(answer.toLowerCase()) > -1;
  }
}

function validateQuiz() {
  let valid = true;
  const questions = document.querySelectorAll('.questionRow');
  for (const q of questions) {
    // hide the invalid marker to start
    q.querySelector('.invalid').classList.add('hidden');
    const answer = q.querySelector('.answer input').value;
    let validation = q.querySelector('.validation').innerText;
    // Blank string means any answer is fine
    if (validation !== '') {
      validation = rot13(validation);
      if (validation.indexOf(',') > -1) {
        validation = validation.split(',');
      }
      if (!validAnswer(answer, validation)) {
        valid = false;
        q.querySelector('.invalid').classList.remove('hidden');
      }
    }
  }
  if (valid) {
    document.querySelector('.buttonRow .valid').classList.remove('hidden');
    document.querySelector('.buttonRow .invalid').classList.add('hidden');
    document.querySelector('button.submit').classList.add('hidden');
    const curSubjId = document.querySelector('.curSubjId').innerText;
    fetch(`./markQuizComplete.php?id=${curSubjId}`);
    for (const q of questions) {
      const qid = q.getAttribute('qid');
      const answer = q.querySelector('.answer input').value;
      fetch(`./answerPrelimQuestion.php?id=${qid}&answer=${answer}`);
    }
  } else {
    document.querySelector('.buttonRow .invalid').classList.remove('hidden');
    document.querySelector('.buttonRow .valid').classList.add('hidden');
  }
}


window.onload = setup;