<?php
session_start(); //démarre la session
require_once('fonctions/connect.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Bootstrap CSS -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
  <title>Foundation Phoenix</title>
  <!-- CSS -->
  <link rel="stylesheet" href="assets/css/reset.css" />
  <link rel="stylesheet" href="assets/css/main.css" />
</head>

<body>
  <?php include '_partials/_header.php'; ?>
  <?php include '_partials/_messages.php'; ?>
  <div class="container">
    <div class="h2 text-center alert alert-dismissible alert-primary mt-4">
      <strong>HIDEOUTS</strong>
    </div>
    <div class="card-deck">
      <?php
      // On récupère les agents
      $hideouts = $con->query('SELECT * FROM hideouts');
      // On affiche chaque entrée une à une
      while ($hideout = $hideouts->fetch()) {
      ?>
        <div class="card mt-4">
          <div class="card-header bg-dark">
            <h5 class="card-title"><span class="h4 text-warning"><?php echo $hideout['type']; ?></span></h5>
            <h6 class="card-subtitle mb-2 text-muted"><span class=" h5 text-white text-decoration-underline">Code :</span><span class="h5 text-white"> <?php echo $hideout['code']; ?></span></h6>
          </div>
          <div class="card-body">
            <p class="card-text"><span class=" text-decoration-underline">Adresse :</span><span> <?php echo $hideout['address']; ?></span></p>
            <p class="card-text"><span class="text-decoration-underline">Pays :</span><span> <?php echo $hideout['country']; ?></span></p>
          </div>
        </div>
      <?php
      }
      $hideouts->closeCursor(); // Termine le traitement de la requête
      ?>
    </div>
  </div>
  <!-- bootstrap js-->
  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <!-- js -->
  <script src="assets/js/main.js"></script>
</body>

</html>