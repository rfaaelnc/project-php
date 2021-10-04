<?php
  if(session_status() === PHP_SESSION_NONE) {
    session_start();
  }

  $userSession = (isset($_SESSION['user_login'])) ? unserialize($_SESSION['user_login']) : '';

  if($userSession) {
    header("location:?s=polls&p=polls");
  }

  if($_SERVER['REQUEST_METHOD'] == "POST") {

    $login = $_POST['login'];
    $password = $_POST['password'];

    $sql = new Sql();
    $user = new User();

    $result = $user->login($login,$password);

    if($result === TRUE) {

        header("location:?s=polls&p=polls");
      
    } else {

      echo "Login ou senha inválidos";

    }

  };

?>
<section class="login">

  <form class="login__form" method="POST">

    <div class="login__group">
      <labeL for="login">Usuário</labeL>
      <input type="text" name="login" required>
    </div>

    <div class="login__group">
      <labeL for="password">Senha</labeL>
      <input type="password" name="password" required>
    </div>

    <button class="login__button button__primary button__primary--small" type="submit">Logar</button>


  </form>

</section>