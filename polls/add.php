<?php

if(session_status() === PHP_SESSION_NONE) {
  session_start();
}

$userSession = (isset($_SESSION['user_login'])) ? unserialize($_SESSION['user_login']) : '';

if(!$userSession) {
  header("location:?s=login&p=login");
}

if($userSession != null && $userSession['user_id']) {
  
  $userID = $userSession['user_id'];
  
}

if($_SERVER['REQUEST_METHOD'] === "POST") {

  $question = $_POST['question'];
  $answers = $_POST['answer'];


  if($question && $answers) {

    $sql = new Sql();

    $pollQuestion = new PollQuestion();

    $results = $sql->query("INSERT INTO poll_questions (question,link,user_id) VALUES (:QUESTION,:LINK,:USERID)", 
    array(
      ':QUESTION'=>$question,
      ':LINK'=> $userID. $pollQuestion->generatorLink(),
      ':USERID'=>$userID,
    ));

    $stmt = $sql->query("SELECT LAST_INSERT_ID()");

    $lastID = $stmt->fetchColumn();

    foreach($answers as $answer) {

      $results = $sql->query("INSERT INTO poll_answers (question_id,answer) 
                              VALUES (:QUESTIONID,:ANSWER)", 
      array(
        ':QUESTIONID'=>$lastID,
        ':ANSWER'=> $answer,
      ));

    }

    echo 'Cadastrado com sucesso';

  } else {

    echo 'Preencha todos os campos';

  }

}

?>

<section class="poll poll__add">

   <div class="poll__item">
    <h3 class="poll__title">Adicionar Enquete</h3>
  </div>


  <form class="form-poll" method="POST">

  <div class="input__list">
    <div class="input__group">
        <label>Pergunta</labeL>
        <input type="text" name="question" >
      </div>

      <div class="input__group input__group--answer">
        <label>Resposta 1</labeL>
        <input type="text" name="answer[]" >
      </div>

      <div class="input__group">
        <label>Resposta 2</label>
        <input type="text" name="answer[]" >
      </div>
  </div>

    <div class="poll__actions">
      <button class="button__primary button__primary--auto js-answer" type="button">Adicionar mais respostas</button>
      <button class="button__primary button__primary--auto input__button" type="submit">Cadastrar</button>
    </div>

  </form>

</section>



<script>

  function addAnswer() {
    const btnAnswer = document.querySelector('.js-answer');
    btnAnswer.addEventListener('click', ()=> {

      const $form_add = document.querySelector('.form-poll');
      const $input_list = $form_add.querySelector('.input__list');
      const inputLength = $input_list.querySelectorAll('.input__group').length;
      const $group_form = $form_add.querySelector('.input__group--answer');

      const clone = $group_form.cloneNode(true);

      clone.querySelector('label').textContent = 'Resposta ' + inputLength;
      clone.querySelector('input').value = '';

      if(inputLength <= 10) {
        $input_list.appendChild(clone.cloneNode(true));
      }

      })
  }

  addAnswer();

</script>