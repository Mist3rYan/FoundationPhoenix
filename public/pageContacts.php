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
  <title>Foundation Phoenix -Contacts</title>
  <!-- CSS -->
  <link rel="stylesheet" href="assets/css/reset.css" />
  <link rel="stylesheet" href="assets/css/main.css" />
</head>

<body>
  <?php include '_partials/_header.php'; ?>
  <?php include '_partials/_messages.php'; ?>
  <div class="container">
  <div class="h2 text-center alert alert-dismissible alert-primary mt-4">
      <strong>CONTACTS</strong>
    </div>
    <div class="card-deck">
      <?php
      // On récupère les agents
      $contacts = $con->query('SELECT * FROM contacts');
      // On affiche chaque entrée une à une
      while ($contact = $contacts->fetch()) {
        $date = new DateTime($contact['birthdate']);
      ?>
        <div class="card mt-4">
          <div class="card-header bg-dark">
            <h5 class="card-title"><span class="h4 text-warning"><?php echo $contact['name']; ?></span></h5>
            <h6 class="card-subtitle mb-2 text-muted"><span class="h5 text-white"><?php echo $contact['firstname']; ?></span></h6>
          </div>
          <div class="card-body">
            <p class="card-text"><span class=" text-decoration-underline">Code agent :</span><span> <?php echo $contact['code']; ?></span></p>
            <p class="card-text"><span class="text-decoration-underline">Pays de naissance :</span><span> <?php echo $contact['nationality']; ?></span></p>
            <p class="card-text"><span class="text-decoration-underline">Date de naissanse :</span><span> <?php echo $date->format('d-m-Y'); ?></span></p>
          </div>
        </div>
      <?php
      }
      $contacts->closeCursor(); // Termine le traitement de la requête
      ?>
    </div>
  </div>

  <!-- bootstrap js-->
  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <!-- js -->
  <script src="assets/js/main.js"></script>
</body>

</html>