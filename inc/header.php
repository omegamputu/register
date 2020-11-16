<?php 
if (session_status() == PHP_SESSION_NONE) {
  # code...
  session_start();
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <title>Espace membre</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/design.css" rel="stylesheet">
  </head>

  <body>

    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="#">Tutoriel</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
          <?php if(isset($_SESSION['auth'])): ?>
            <li class="nav-item">
              <a class="nav-link" href="logout.php">Se déconnecter</a>
            </li>
          <?php else: ?>
          <li class="nav-item">
            <a class="nav-link" href="login.php">Se connecter</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="register.php">S'inscrire</a>
          </li>
          <?php endif; ?>
        </ul>
      </div>
      </div>
    </nav>

    <div class="container">
      <?php if (isset($_SESSION['flash'])): ?>
      <?php foreach($_SESSION['flash'] as $type => $message):  ?>
        <div class="alert alert-<?= $type; ?>">
          <?= $message; ?>
        </div>
      <?php endforeach; ?>
      <?php unset($_SESSION['flash']); ?>
      <?php endif;  ?>
    </div>