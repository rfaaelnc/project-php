<?php

if(session_status() === PHP_SESSION_NONE) {
  session_start();
}

$userSession = (isset($_SESSION['user_login'])) ? unserialize($_SESSION['user_login']) : '';

if(!$userSession) {
  header("location:?s=login&p=login");
}

if($userSession != null && $userSession['user_id']) {
  
  $pollQuestion = new PollQuestion();
  
  $pollQuestion->loadById($_GET['id']);

  $pollAnswer = new PollAnswer();

  $answersArr = $pollAnswer->loadAll($_GET['id']);
  
  $totalVotes = 0;
  foreach($answersArr as $answer) {
    $totalVotes += $answer['votes'];
  }
  
}

?>


<div class="poll">

  <div class="poll__details">

  <div class="poll__item">
    <h3 class="poll__title"><?php echo $pollQuestion->getQuestion(); ?></h3>
  </div>

  <div class="poll__container poll__container--collapse">

      <strong class="share-link">Link para compartilhar : <a href="https://rafael.javiu.com.br/poll/poll.php?id=<?php echo $pollQuestion->getLink(); ?>"><?php echo $pollQuestion->getLink(); ?></a></strong>
    

      <ul class="poll-list">
        <?php foreach($answersArr as $answer): ?>

          <?php $percentageVotes = ($totalVotes > 0) ? round(($answer['votes'] / $totalVotes) * 100) : 0 ?>

          <li class="poll-list__item">
            <div class="progressbar">
              <div class="progressbar__bg" style="width:<?php echo $percentageVotes ?>%;"></div>
              <div class="progressbar__content">

              <h5 class="progressbar__text">
                <?php echo $answer['answer']; ?>
               </h5>

              <strong class="progressbar__amount">

                <?php echo $percentageVotes ?>%
                
              </strong>

              </div>
          </li>

        <?php endforeach; ?>
      </ul>
      

      <div class="poll__actions poll__actions--btns">
        <a class="button__primary button__primary--small" href="?s=polls&p=poll&id=<?php echo $pollQuestion->getQuestionID(); ?>">Editar</a>
        <a class="button__primary button__primary--small js-delete" data-toggle="modal" data-target="#modalConfirm" data-id="3" data-text="Deseja deletar a enquete ?" href="#" style="cursor:pointer">Excluir</a>
      </div>

       <div class="poll__actions poll__actions--btns">
        <a class="button__primary button__primary--small" onclick="history.back();" style="cursor:pointer">Voltar</a>
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