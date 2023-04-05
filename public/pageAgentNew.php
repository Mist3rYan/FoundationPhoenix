<?php
session_start(); //démarre la session
require_once('fonctions/connect.php'); //charge la connexion à la base de données
// Spécialités
$stack = [];
$specialities = $con->query('SELECT * FROM specialities ORDER BY id');
while ($specialitie = $specialities->fetch()) {
  array_push($stack, $specialitie['name']);
}
$specialities->closeCursor(); // Termine le traitement de la requête
if (isset($_POST['create'])) {
  $domaine = [];
  $specialite = '';
  $name = $_POST['name'];
  $firstname = $_POST['firstname'];
  $code = $_POST['code'];
  $date = $_POST['date'];

  if (($_POST['pays']) !== 'Pays...') {
    $pays = $_POST['pays'];
  } else {
    $pays = '';
    $_SESSION['message'] = " Merci de sélectionner un pays ! "; //stocke le message dans une variable de session
    $_SESSION['message_type'] = "warning"; //définit le type de message (success, info, warning, danger)
  }
  if (isset($_POST['domaine'])) {
    foreach ($_POST['domaine'] as $valeur) {
      array_push($domaine, $valeur);
    }
    $specialite = implode(',', $domaine);
  } else {
    $_SESSION['message'] = $_SESSION['message'] . " Merci de renseigner une spécialité au minimum !"; //stocke le message dans une variable de session
    $_SESSION['message_type'] = "warning"; //définit le type de message (success, info, warning, danger)
  }
  // Vérifie si le nom d'utilisateur existe déjà
  $stmt = $con->prepare("SELECT * FROM agents WHERE code=?");
  $stmt->execute([$code]);
  $codeSearch = $stmt->fetch();
  if ($codeSearch) {
    $_SESSION['message'] = " Le code agent existe déjà !"; //stocke le message dans une variable de session
    $_SESSION['message_type'] = "warning"; //définit le type de message (success, info, warning, danger)
  } else {
    // le nom d'utilisateur n'existe pas
    $stmt = $con->prepare("INSERT INTO agents (code, name, firstname, nationality, speciality, birthdate) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$code, $name, $firstname, $pays, $specialite, $date]);
    if ($stmt) {
      $_SESSION['message'] = " Agent créé avec succès !"; //stocke le message dans une variable de session
      $_SESSION['message_type'] = "success"; //définit le type de message (success, info, warning, danger)
      header('Location: pageAgents.php');
      exit();
    } else {
      $_SESSION['message'] = " Erreur lors de la création de l'agent !"; //stocke le message dans une variable de session
      $_SESSION['message_type'] = "danger"; //définit le type de message (success, info, warning, danger)
    }
  }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Bootstrap CSS -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
  <title>Foundation Phoenix - Agents</title>
  <!-- CSS -->
  <link rel="stylesheet" href="assets/css/reset.css" />
  <link rel="stylesheet" href="assets/css/main.css" />
</head>

<body>
  <?php include '_partials/_header.php'; ?>
  <?php include '_partials/_messages.php'; ?>
  <?php
  $country = array(
    'France',
    'Russie',
    'Angleterre',
    'Chine',
    'Etats-Unis',
    'Japon',
    'Allemagne',
    'Italie',
    'Espagne',
    'Portugal',
    'Pologne',
    'Belgique',
    'Suisse',
    'Canada',
    'Mexique',
    'Brésil',
    'Argentine',
    'Australie',
    'Nouvelle-Zélande',
    'Afrique du Sud',
    'Inde',
    'Indonésie',
    'Chili',
    'Colombie',
    'Perou',
    'Equateur'
  );
  ?>
  <div class="container">
    <div class="h2 text-center alert alert-dismissible alert-primary mt-4">
      <strong>CREATION AGENT</strong>
    </div>
    <form action="pageAgentNew.php" method="post">
      <div class="row mt-4">
        <div class="col">
          <input type="text" class="form-control" name="name" placeholder="Nom" required>
        </div>
        <div class="col">
          <input type="text" class="form-control" name="firstname" placeholder="Prénom" required>
        </div>
      </div>
      <div class="row mt-4">
        <div class="col">
          <input type="text" class="form-control" name="code" placeholder="Code" required>
        </div>
        <div class="col">
          <select id="pays" name="pays" class="form-control">
            <option selected>Pays...</option>
            <?php foreach ($country as $value) { ?>
              <option value="<?php echo $value ?>"><?php echo $value ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="row mt-4">
        <div class="col-md-12">
          <?php
          foreach ($stack as $value) {
          ?>
            <div class="form-check checkbox-lg form-check-inline">
              <input class="form-check-input" type="checkbox" id="specialitie<?php echo $value ?>" name="domaine[]" value="<?php echo $value ?>">
              <label class="form-check-label h5" for="specialitie<?php echo $value ?>"><?php echo $value ?></label>
            </div>
          <?php
          }
          ?>
        </div>
      </div>
      <div class="row mt-4">
        <div class="col">
          <input type="date" class="form-control" name="date" placeholder="Date de naissance" required>
        </div>
      </div>
      <div class="row mt-4">
        <button type="submit" class="btn btn-primary btn-lg btn-block" name="create">Créer</button>
      </div>
    </form>
  </div>
  <!-- bootstrap js-->
  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <!-- js -->
  <script src="assets/js/main.js"></script>
</body>

</html>