<?php

require_once("globals.php");
require_once("db.php");
require_once("models/Message.php");
require_once("dao/UserDAO.php");

$message = new Message($BASE_URL);

$flassMessage = $message->getMessage();

if(!empty($flassMessage["msg"])) {
  // Limpar a mensagem
  $message->clearMessage();
}

$userDao = new UserDAO($conn, $BASE_URL);

$userData = $userDao->verifyToken(false);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PARA-PET - Fornecedores</title>
    <link rel="short icon" href="<?= $BASE_URL ?>img/favicon.ico" />
    <!-- CSS bootstrap-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.css"integrity="sha512-h1rwF0uB6r2IuEZcyjPrR53bBKN9Wb4yL+w3Rdlzmc3CkBF1gMSFvQIIstnu4bEtYDaKca5ke5S8UBAACRImyg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- font awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- CSS projeto -->
    <link rel="stylesheet" href="<?= $BASE_URL ?>css/styles.css">
</head>
<body>
    <header>
        <nav id="main-navbar" class="navbar navbar-expand-lg">
            <a href="<?= $BASE_URL ?>" class="nav-bar-brand">
        <img src="<?= $BASE_URL ?>img/logo.png" alt="logo fornecedores" id="logo">
        <span id="parapet-title">PARA-PETS Fornecedores</span></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation"><i class="fas fa-bars"></i></button>
        <div class="collapse navbar-collapse" id="navbar">
            <ul class="navbar-nav">
                <?php if($userData): ?>
                    <li class="nav-item">
                        <a href="<?= $BASE_URL ?>newproduct.php" class="nav-link">
                            <i class="far fa-plus-square"></i> Cadastrar produto
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= $BASE_URL ?>dashboard.php" class="nav-link">Meus produtos</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= $BASE_URL ?>editprofile.php" class="nav-link bold">
                            <?= $userData->name ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= $BASE_URL ?>logout.php" class="nav-link">Sair</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a href="<?= $BASE_URL ?>auth.php" class="nav-link">Entrar / Cadastrar</a>
                    </li>
                <?php endif; ?>
        </ul>
      </div>
    </nav>
  </header>
  <?php if(!empty($flassMessage["msg"])): ?>
    <div class="msg-container">
      <p class="msg <?= $flassMessage["type"] ?>"><?= $flassMessage["msg"] ?></p>
    </div>
  <?php endif; ?>