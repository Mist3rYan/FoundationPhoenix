<?php
session_start(); //démarre la session
require_once('fonctions/connect.php'); //charge la connexion à la base de données
// Spécialités
$stack = [];

if (isset($_POST['create'])) {
  $type = $_POST['type'];
  $code = $_POST['code'];
  $address = $_POST['address'];

  if (($_POST['pays']) != 'Pays...') {
    $pays = $_POST['pays'];
  } else {
    $pays = '';
    $_SESSION['message'] = " Merci de sélectionner un pays ! "; //stocke le message dans une variable de session
    $_SESSION['message_type'] = "warning"; //définit le type de message (success, info, warning, danger)
    header('Location: pageHideoutCreate.php');
    exit();
  }

  // Vérifie si le nom d'utilisateur existe déjà
  $stmt = $con->prepare("SELECT * FROM hideouts WHERE code=?");
  $stmt->execute([$code]);
  $codeSearch = $stmt->fetch();
  if ($codeSearch) {
    $_SESSION['message'] = " Le code hideout existe déjà !"; //stocke le message dans une variable de session
    $_SESSION['message_type'] = "warning"; //définit le type de message (success, info, warning, danger)
  } else {
    // le nom d'utilisateur n'existe pas
    $stmt = $con->prepare("INSERT INTO hideouts (code, type, address, country) VALUES (?, ?, ?, ?)");
    $stmt->execute([$code, $type, $address, $pays]);
    if ($stmt) {
      $_SESSION['message'] = " Hideout créé avec succès !"; //stocke le message dans une variable de session
      $_SESSION['message_type'] = "success"; //définit le type de message (success, info, warning, danger)
      header('Location: pageHideouts.php');
      exit();
    } else {
      $_SESSION['message'] = " Erreur lors de la création de Hideout!"; //stocke le message dans une variable de session
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
  <title>Foundation Phoenix - Hideouts</title>
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
      <strong>CREATION HIDEOUT</strong>
    </div>
    <form action="pageHideoutCreate.php" method="post">
      <div class="row mt-4">
        <div class="col">
          <input type="text" class="form-control" name="type" placeholder="Type" required>
        </div>
        <div class="col">
          <input type="text" class="form-control" name="code" placeholder="Code" required>
        </div>
      </div>
      <div class="row mt-4">
        <div class="col">
          <input type="text" class="form-control" name="address" placeholder="Adresse" required>
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