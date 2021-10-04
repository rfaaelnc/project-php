<?php

if(session_status() === PHP_SESSION_NONE) {
  session_start();
  // print_r($_SESSION);
}

$userSession = (isset($_SESSION['user_login'])) ? unserialize($_SESSION['user_login']) : '';

if(!$userSession) {
  header("location:?s=login&p=login");
}

if($userSession != null && $userSession['user_id']) {
  
  // print_r($userSession['user_id']);
  
  $pollQuestion = new PollQuestion();
  
  $polls = $pollQuestion->getList($userSession['user_id']);
  
  // print_r($polls);
  
}

?>



<div class="poll">.

  <?php if(count($polls) > 0): ?>

  <?php foreach($polls as $poll): ?>
  <div class="poll__item">
    <h3 class="poll__title"><?php echo $poll['question'] ?></h3>

    <div class="poll__actions">
      <a class="button__secondary button__secondary--small" href="?s=polls&p=poll&id=<?php echo $poll['question_id'] ?>">Visualizar</a>
      <a class="button__secondary button__secondary--small" href="?s=polls&p=edit&id=<?php echo $poll['question_id'] ?>">Editar</a>
      <!-- <a class="button__secondary button__secondary--small" href="#">Collapse</a> -->
    </div>
  </div>
  <?php endforeach; ?>

<?php else: ?>
  <p class="text__center">Nenhuma enquete cadastrada</p>
<?php endif; ?>



  <div class="poll__actions poll__actions--bottom">
    <a class="button__primary button__primary--large" href="?s=polls&p=add">Adicionar Enquetes</a>
  </div>

</div>