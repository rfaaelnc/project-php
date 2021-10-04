<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="assets/css/style.css" rel="stylesheet" type="text/css" />
</head>
<body class="page__view--poll">

<?php

session_start();

require_once('config.php');

if(session_status() === PHP_SESSION_NONE) {
  session_start();
}

$getResult = (isset($_GET['result'])) ? TRUE : FALSE;

$getID = (isset($_GET['id'])) ? $_GET['id'] : '';

// if($userSession != null && $userSession['user_id']) {

if($getID) {
  
  $pollQuestion = new PollQuestion();
  
  $pollQuestion->loadByLink($_GET['id']);

  $pollAnswer = new PollAnswer();

  $answersArr = $pollAnswer->loadAll($pollQuestion->getQuestionID());
  
  $totalVotes = 0;
  foreach($answersArr as $answer) {
    $totalVotes += $answer['votes'];
  }
  
  if($_SERVER['REQUEST_METHOD'] === 'POST') {

    $vote = $_POST['vote'];

    $poll = $pollAnswer->loadById($vote);

    $votes = $pollAnswer->getVotes();

    $pollAnswer->updateVotes($pollAnswer->getAnswerID(),++$votes);

    header("location:{$_SERVER['REQUEST_URI']}&result=ok");

  }
} else {
  echo '<h1>Enquete não encontrada<h1>';
  return;
}


?>


<main class="l-main">

  <div class="poll">

    <div class="poll__details">

    <div class="poll__item">
      <h3 class="poll__title"><?php echo $pollQuestion->getQuestion(); ?></h3>
    </div>

    <div class="poll__container poll__container--collapse">

      <div style="display:none">
            Identificador : <?php echo $pollQuestion->getQuestionID(); ?>
            <br>
            Url : <?php echo $pollQuestion->getLink(); ?>
      </div>
        
       <form method="POST">
        <ul class="poll-list">
          <?php foreach($answersArr as $answer): ?>

            <?php $percentageVotes = ($totalVotes > 0) ? round(($answer['votes'] / $totalVotes) * 100) : 0 ?>

            <li class="poll-list__item">
              <div class="progressbar">

               <?php if($getResult !== FALSE): ?>  

                <div class="progressbar__bg" style="width:<?php echo $percentageVotes ?>%;"></div>

               <?php endif; ?>

                <div class="progressbar__content">

                <div class="form-poll__group">

                  <?php if($getResult === FALSE): ?>
                  <input type="radio" name="vote" id="<?php echo $answer['answer_id'] ?>" value="<?php echo $answer['answer_id'] ?>">
                  <?php endif; ?>
                  
                  <label class="progressbar__text" for="<?php echo $answer['answer_id'] ?>">
                    <?php echo $answer['answer']; ?>
                   </label>
                </div>
                <?php if($getResult !== FALSE): ?> 
                <strong class="progressbar__amount">

                  <?php echo $percentageVotes ?>%
                  
                </strong>
                <?php endif; ?>

                </div>
            </li>

          <?php endforeach; ?>
        </ul>
      
      
        <div class="poll__actions poll__actions--btns">
          <?php if($getResult === FALSE): ?>
          <button class="button__primary button__primary--small">Votar</button>
          <?php else: ?>
          <button type="button" class="button__primary button__primary--small" onclick="history.back();">Votar novamente</button>
          <?php endif; ?>
        </div>

      </form>
        </div>

  </div>
</div>

  <div class="modal" id="modalConfirm">

    <div class="modal__container">
      <p class="modal__mesagge">
        Deseja deletar a enquete ?
      </p>

      <div class="modal__footer">
          <a class="button__primary button__primary--small" href="#">Excluir</a>
          <a class="button__primary button__primary--small js-close" onclick="" style="cursor:pointer">Cancelar</a>
      </div>
    </div>
  </div>
</main>

<footer class="l-footer">

  <p class="l-footer__copy">Todos os direitos reservados</p>

</footer>
  


<script>

function modalDelete() {
  const btnModal = document.querySelector('.js-delete');

  const divModal = document.querySelector('#modalConfirm');

  const btnClose = divModal.querySelector('.js-close');

  btnModal.addEventListener('click',function(e) {

    divModal.classList.add('has-active');

  });


  divModal.addEventListener('click', (e)=> {
      // console.log(e.target);

      if(e.target === divModal) {
        divModal.classList.remove('has-active');
      }

      if(e.target === btnClose) {
        divModal.classList.remove('has-active');
      }
  })
}

modalDelete();

</script>

</body>
</html>