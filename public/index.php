<?php
session_start(); //démarre la session
$_SESSION['message'] = "Votre message a bien été envoyé."; //stocke le message dans une variable de session
$_SESSION['message_type'] = "info"; //définit le type de message (success, info, warning, danger)
require_once dirname(__DIR__) . '/vendor/autoload.php'; //charge les dépendances
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Bootstrap CSS -->
  <link href="/assets/css/bootstrap.min.css" rel="stylesheet" />
  <title>Foundation Phoenix</title>
  <!-- CSS -->
  <link rel="stylesheet" href="/assets/css/reset.css" />
  <link rel="stylesheet" href="/assets/css/main.css" />
</head>

<body>
  <?php include '_partials/_header.php'; ?>
  <?php include '_partials/_messages.php'; ?>
  <div class="container d-flex flex-column justify-content-center">
    <div class="text-center">
      <img src="/assets/images/logo.svg" alt="logo phoenix foundation" width="20%" height="20%">
    </div>
    <div class="mt-4">
      <p>Située à Los Angeles, la Fondation Phoenix est une organisation secrète
        gouvernementale protégeant les intérêts du pays. La Fondation est la plus
        ancienne agence de renseignement de l'histoire des Etats-Unis. En effet,
        sa création remonte à la Seconde Guerre mondiale, ce qui indique qu'elle
        était déjà en activité durant les années 1940. L'objectif a toujours été le même :
        protéger les intérêts du pays. </p>
    </div>
  </div>
  <!-- bootstrap js-->
  <script src="/assets/js/bootstrap.bundle.min.js"></script>
  <!-- js -->
  <script src="/assets/js/main.js"></script>
</body>

</html>