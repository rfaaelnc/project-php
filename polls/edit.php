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
  
  $pollQuestion = new PollQuestion();
  
  $pollQuestion->loadById($_GET['id']);

  $pollAnswer = new PollAnswer();

  $answersArr = $pollAnswer->loadAll($_GET['id']);
  

  if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $question = $_POST['question'];
    $answers  = $_POST['answer'];

    if($question) {

      $sql = new Sql();

      // update question
      $pollQuestion->setQuestion($question);
      $pollQuestion->updateQuestion($_GET['id']);

      // update answers
      foreach($answers as $key => $value) {

        $pollAnswer->loadById($key);
        $pollAnswer->updateAnswer($value);

      }

    }


  }
}

?>

<section class="poll poll__add">

   <div class="poll__item">
    <h3 class="poll__title">Editar ( <?php echo $pollQuestion->getQuestion(); ?> )</h3>
  </div>


  <form class="form-poll" method="POST">

  <div class="input__list">

    <div class="input__group">
      <input type="text" name="question" value="<?php echo $pollQuestion->getQuestion(); ?>">
    </div>

    <?php foreach($answersArr as $answer): ?>
      <div class="input__group">
        <input type="text" name="answer[<?php echo $answer['answer_id'] ?>]"  value="<?php echo $answer['answer']; ?>">
      </div>
    <?php endforeach; ?>  

  </div>
    <div class="poll__actions">
      <button type="submit" class="button__primary button__primary--small">Salvar</button>  
    </div>

  </form>


    <div class="poll__actions">
      <a class="button--back" href="?s=login&p=login" style="cursor:pointer">Voltar</a>
    </div>

</section>