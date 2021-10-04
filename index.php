<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="assets/css/style.css" rel="stylesheet" type="text/css" />
</head>
<?php

session_start();

require_once('config.php');

// $sql = new Sql();

// $usuarios = $sql->select("SELECT * FROM users");
echo '<pre>';

// $poll_question = new Poll();
// $poll_question->loadById(1);


// $poll_answers = new PollAnswer();

// $poll_answers->loadById(1);

// print_r($poll_answers);



// $result = PollAnswer::loadAll($poll_question->getQuestionID());


// print_r($poll_question->getQuestion());
// echo '<br>';
// print_r($result);

// $poll_answers = new PollAnswer();

// $poll_answers->loadById(1);


// if($_SERVER['REQUEST_METHOD'] == "POST") {

//   $login = $_POST['login'];
//   $password = $_POST['password'];

//   $sql = new Sql();
//   $user = new User();

//   $result = $user->login($login,$password);

//   if($result === TRUE) {

    
//   } else {

//     echo "Login ou senha inválidos";

//   }


// };



// print_r($_SESSION);

// $userSession = (isset($_SESSION['user_login'])) ? unserialize($_SESSION['user_login']) : '';

// if($userSession != null && $userSession['user_id']) {
  
//   print_r($userSession['user_id']);
  
//   $pollQuestion = new PollQuestion();
  
//   $polls = $pollQuestion->getList($userSession['user_id']);
  
//   print_r($polls);
  
// }

// echo '</pre>';

// session_destroy();

echo '</pre>';

// session_destroy();

$page = (isset($_GET['p'])) ? $_GET['p'] : 'login';


?>

<body class="page__home page__<?php echo $page ?>">

<?php if($page !== 'login'): ?>
  <header class="l-header">

    <div class="l-header__container">

      <div class="l-header__box l-header__logo">
        <h1 class="l-header__title">ENQUETES V0.5</h1>
      </div>
      
      <div class="l-header__box">
        <h3 class="l-header__title--secondary"><a href="?s=polls&p=polls">PAINEL</a></h3>
      </div>
      <div class="l-header__box l-header__actions">
        <span>
          <a class="l-header__link" href="?s=login&p=logout">SAIR</a>
        </span>
      </div>

    </div>

  </header>
<?php endif; ?>

  <main class="l-main">

    <?php

      $pageDefault = "login";
      $subPageDefault = "login";

      $page = (isset($_GET['p'])) ? $_GET['p'] : 'login';
      $subPage = (isset($_GET['s'])) ? $_GET['s'] : 'login';

      $pageDir = 'pages';
      $extension = '.php';
      
      
      $page404 = $pageDir . DIRECTORY_SEPARATOR . '404' . $extension;

      $file = $pageDir . DIRECTORY_SEPARATOR . $page . $extension;
      
      if(isset($page) && isset($subPage)) {

        $file = $pageDir . DIRECTORY_SEPARATOR . $subPage . DIRECTORY_SEPARATOR . $page . $extension;

      } 

      // var_dump($file);

      if(file_exists($file)) {

        include_once($file);

      } else {

        include_once($page404);
        
      }

      // print_r($page);
    ?>
<!--
      <section class="login">

        <form class="login__form" method="POST">

          <div class="login__group">
            <labeL for="login">User</labeL>
            <input type="text" name="login" required>
          </div>

          <div class="login__group">
            <labeL for="password">password</labeL>
            <input type="password" name="password" required>
          </div>

          <button class="login__button" type="submit">Logar</button>


        </form>


      </section>
    -->
  </main>

  <footer class="l-footer">

    <p class="l-footer__copy">Todos os direitos reservados</p>

  </footer>
  
</body>
</html>