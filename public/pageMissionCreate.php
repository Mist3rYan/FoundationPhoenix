<?php
session_start(); //démarre la session
require_once('fonctions/connect.php'); //charge la connexion à la base de données

// Spécialités
$stacks = [];
$stackIds = [];
$specialities = $con->query('SELECT * FROM Specialities ORDER BY id');
while ($specialitie = $specialities->fetch()) {
  array_push($stacks, $specialitie['name']);
  array_push($stackIds, $specialitie['id']);
}
$specialities->closeCursor(); // Termine le traitement de la requête

$stackAgents = [];
$stackAgentCountrys = [];
$stackAgentIds = [];
$stackAgentSpecs = [];
$agents = $con->query('SELECT * FROM Agents ORDER BY id');
while ($agent = $agents->fetch()) {
  array_push($stackAgents, $agent['code']);
  array_push($stackAgentCountrys, $agent['nationality']);
  array_push($stackAgentIds, $agent['id']);
  array_push($stackAgentSpecs, $agent['speciality']);
}
$agents->closeCursor(); // Termine le traitement de la requête

$stackTargets = [];
$stackTargetCountrys = [];
$stackTargetIds = [];
$targets = $con->query('SELECT * FROM Targets ORDER BY id');
while ($target = $targets->fetch()) {
  array_push($stackTargets, $target['code']);
  array_push($stackTargetCountrys, $target['nationality']);
  array_push($stackTargetIds, $target['id']);
}
$targets->closeCursor(); // Termine le traitement de la requête

$stackContacts = [];
$stackContactCountrys = [];
$stackContactIds = [];
$contacts = $con->query('SELECT * FROM Contacts ORDER BY id');
while ($contact = $contacts->fetch()) {
  array_push($stackContacts, $contact['code']);
  array_push($stackContactCountrys, $contact['nationality']);
  array_push($stackContactIds, $contact['id']);
}
$contacts->closeCursor(); // Termine le traitement de la requête

$stackHideouts = [];
$stackHideoutCountrys = [];
$stackHideoutIds = [];
$hideouts = $con->query('SELECT * FROM Hideouts ORDER BY id');
while ($hideout = $hideouts->fetch()) {
  array_push($stackHideouts, $hideout['type']);
  array_push($stackHideoutCountrys, $hideout['country']);
  array_push($stackHideoutIds, $hideout['id']);
}
$hideouts->closeCursor(); // Termine le traitement de la requête


if (isset($_POST['create'])) {
  $nomDeCode = $_POST['nom_de_code'];
  $titre = $_POST['titre'];
  $description = $_POST['descr'];
  $dateDebut = $_POST['date_debut'];
  $dateFin = $_POST['date_fin'];
  $specialitieRequise = [];

  if (!empty($_POST['target'])) {
    $targetListeIds = $_POST['target'];
  } else {
    $targetListeIds = '';
    $_SESSION['message'] = " Merci de sélectionner une cible ! "; //stocke le message dans une variable de session
    $_SESSION['message_type'] = "warning"; //définit le type de message (success, info, warning, danger)
    header('Location: pageMissionCreate.php');
    exit();
  }

  if (!empty($_POST['contact'])) {
    $contactListeIds = $_POST['contact'];
  } else {
    $contactListeIds = '';
    $_SESSION['message'] = " Merci de sélectionner un contact ! "; //stocke le message dans une variable de session
    $_SESSION['message_type'] = "warning"; //définit le type de message (success, info, warning, danger)
    header('Location: pageMissionCreate.php');
    exit();
  }

  if (!empty($_POST['hideout'])) {
    $hideoutListeIds = $_POST['hideout'];
  } else {
    $hideoutListeIds = '';
  }

  if (!empty($_POST['agent'])) {
    $agentListeIds = $_POST['agent'];
    for ($i = 0; $i < count($agentListeIds); $i++) {
      $stmt = $con->prepare("SELECT * FROM Agents WHERE id=?");
      $stmt->execute([$agentListeIds[$i]]);
      $agent = $stmt->fetch();
      $transforme = explode(',', $agent['speciality']);
      $retire = array('[', ']', '"');
      $transforme = str_replace($retire, '', $transforme);
      array_push($specialitieRequise, $transforme);
    }
  } else {
    $agentListeIds = '';
    $_SESSION['message'] = " Merci de sélectionner un agent ! "; //stocke le message dans une variable de session
    $_SESSION['message_type'] = "warning"; //définit le type de message (success, info, warning, danger)
    header('Location: pageMissionCreate.php');
    exit();
  }

  if (($_POST['type_mission']) !== 'Type de mission...') {
    $typeDeMission = $_POST['type_mission'];
  } else {
    $typeDeMission = '';
    $_SESSION['message'] = " Merci de sélectionner un type de misssion! "; //stocke le message dans une variable de session
    $_SESSION['message_type'] = "warning"; //définit le type de message (success, info, warning, danger)
    header('Location: pageMissionCreate.php');
    exit();
  }

  if (($_POST['pays']) !== 'Pays...') {
    $pays = $_POST['pays'];
  } else {
    $pays = '';
    $_SESSION['message'] = " Merci de sélectionner un pays ! "; //stocke le message dans une variable de session
    $_SESSION['message_type'] = "warning"; //définit le type de message (success, info, warning, danger)
    header('Location: pageMissionCreate.php');
    exit();
  }

  if (($_POST['status']) !== 'Statut de la mission...') {
    $status = $_POST['status'];
  } else {
    $status = '';
    $_SESSION['message'] = " Merci de sélectionner un status ! "; //stocke le message dans une variable de session
    $_SESSION['message_type'] = "warning"; //définit le type de message (success, info, warning, danger)
    header('Location: pageMissionCreate.php');
    exit();
  }

  if (($_POST['specialitie_requ']) !== 'Spécialité requise...') {
    $specialitieRequ = $_POST['specialitie_requ'];
    $stmt = $con->prepare("SELECT * FROM Specialities WHERE id=?");
    $stmt->execute([$specialitieRequ]);
    $specialitieRequ = $stmt->fetch();
    $item = $specialitieRequ['name'];
    $found  = false;
    foreach ($specialitieRequise as $subarray) {
      if (in_array($item, $subarray)) {
        $found = true;
        break;
      }
    }
    if ($found == false) {
      $_SESSION['message'] = " Merci de sélectionner un agent avec la spécialité requise !"; //stocke le message dans une variable de session
      $_SESSION['message_type'] = "warning"; //définit le type de message (success, info, warning, danger)
      header('Location: pageMissionCreate.php');
      exit();
    }
  } else {
    $specialitieRequ = '';
    $_SESSION['message'] = " Merci de sélectionner une spécialité ! "; //stocke le message dans une variable de session
    $_SESSION['message_type'] = "warning"; //définit le type de message (success, info, warning, danger)
    header('Location: pageMissionCreate.php');
    exit();
  }

  // Vérifie si le nom d'utilisateur existe déjà
  $stmt = $con->prepare("SELECT * FROM Missions WHERE nom_de_code=?");
  $stmt->execute([$nomDeCode]);
  $codeSearch = $stmt->fetch();
  if ($codeSearch) {
    $_SESSION['message'] = " La mission existe déjà !"; //stocke le message dans une variable de session
    $_SESSION['message_type'] = "warning"; //définit le type de message (success, info, warning, danger)
  } else {
    // le nom d'utilisateur n'existe pas
    $stmt = $con->prepare("INSERT INTO Missions (titre, description, nom_de_code, country, type_mission, status, date_debut, date_fin,specialitie_id) VALUES (?, ?, ?, ?, ?, ?,?,?,?)");
    $stmt->execute([$titre, $description, $nomDeCode, $pays, $typeDeMission, $status, $dateDebut, $dateFin, $specialitieRequ['id']]);
    $missionID = $con->lastInsertId();
    if ($stmt) {
      $_SESSION['message'] = " Mission créée avec succès !"; //stocke le message dans une variable de session
      $_SESSION['message_type'] = "success"; //définit le type de message (success, info, warning, danger)

      $stmt ="SET FOREIGN_KEY_CHECKS = 0";
      $con->exec($stmt);

      for ($i = 0; $i < count($agentListeIds); $i++) {
        $stmt = $con->prepare("INSERT INTO Agents_has_Missions (mission_id, agent_id) VALUES (?, ?)");
        $stmt->execute([$missionID, $agentListeIds[$i]]);
      }
      if($hideoutListeIds != '') {
        for ($i = 0; $i < count($hideoutListeIds); $i++) {
          $stmt = $con->prepare("INSERT INTO Hideouts_has_Missions (mission_id, hideouts_id) VALUES (?, ?)");
          $stmt->execute([$missionID, $hideoutListeIds[$i]]);
        }
      }
      for ($i = 0; $i < count($contactListeIds); $i++) {
        $stmt = $con->prepare("INSERT INTO Contacts_has_Missions (mission_id, contact_id) VALUES (?, ?)");
        $stmt->execute([$missionID, $contactListeIds[$i]]);
      }
      for ($i = 0; $i < count($targetListeIds); $i++) {
        $stmt = $con->prepare("INSERT INTO Cibles_has_Missions (mission_id, cible_id) VALUES (?, ?)");
        $stmt->execute([$missionID, $targetListeIds[$i]]);
      }

      $stmt ="SET FOREIGN_KEY_CHECKS = 1";
      $con->exec($stmt);
      
      header('Location: pageMissions.php');
      exit();
    } else {
      $_SESSION['message'] = " Erreur lors de la création de la mission !"; //stocke le message dans une variable de session
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
    'Afrique du Sud',
    'Allemagne',
    'Angleterre',
    'Argentine',
    'Australie',
    'Belgique',
    'Brésil',
    'Canada',
    'Chili',
    'Chine',
    'Colombie',
    'Equateur',
    'Espagne',
    'Etats-Unis',
    'France',
    'Inde',
    'Indonésie',
    'Italie',
    'Japon',
    'Mexique',
    'Nouvelle-Zélande',
    'Perou',
    'Pologne',
    'Portugal',
    'Russie',
    'Suisse'
  );

  $status = array(
    'En préparation',
    'En cours',
    'Annulé',
    'Terminé',
    'Echec'
  );
  $type_mission = array(
    'Assassinat',
    'Attentat',
    'Espionnage',
    'Infiltration',
    'Récupération',
    'Sauvetage',
    'Sabotage',
    'Surveillance'
  );
  ?>
  <div class="container">
    <div class="h2 text-center alert alert-dismissible alert-primary mt-4">
      <strong>CREATION MISSION</strong>
    </div>
    <span class="text-danger">* Champs obligatoires</span>
    <form action="pageMissionCreate.php" method="post">
      <div class="row mt-4">
        <div class="col">
        <label for="nom_de_code" class="form-label">Code *</label>
          <input type="text" class="form-control" name="nom_de_code" placeholder="Nom de Code" required>
        </div>
        <div class="col">
        <label for="titre" class="form-label">Titre de la mission *</label>
          <input type="text" class="form-control" name="titre" placeholder="Titre" required>
        </div>
        <div class="col">
        <label for="type_mission" class="form-label">Type de mission *</label>
          <select id="type_mission" name="type_mission" class="form-control" required>
            <option selected>Type de mission...</option>
            <?php foreach ($type_mission as $value) { ?>
              <option value="<?php echo $value ?>"><?php echo $value ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="row mt-4">
        <div class="col">
        <label for="descr" class="form-label">Description *</label>
          <input type="text" class="form-control" name="descr" placeholder="Description" required>
        </div>
        <div class="col">
        <label for="pays" class="form-label">Pays de la mission *</label>
          <select id="pays" name="pays" class="form-control" onChange="filtrePays();" required>
            <option selected>Pays...</option>
            <?php foreach ($country as $value) { ?>
              <option value="<?php echo $value ?>"><?php echo $value ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="row mt-4">
        <div class="col">
          <label for="contact" class="form-label">Contacts *</label>
          <select multiple id="contact" name="contact[]" class="form-control" disabled="disabled" required>
            <?php foreach ($stackContacts as $index => $stackContact) { ?>
              <option value="<?php echo $stackContactIds[$index] ?>" id="<?php echo $stackContactCountrys[$index] ?>"><?php echo $stackContact . " - " . $stackContactCountrys[$index] ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="col">
          <label for="hideout" class="form-label">Hideouts</label>
          <select multiple id="hideout" name="hideout[]" class="form-control" disabled="disabled">
            <?php foreach ($stackHideouts as $index => $stackHideout) { ?>
              <option value="<?php echo $stackHideoutIds[$index] ?>" id="<?php echo $stackHideoutCountrys[$index] ?>"><?php echo $stackHideout . " - " . $stackHideoutCountrys[$index] ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="row mt-4 align-items-end">
        <div class="col">
          <label for="date_debut" class="form-label">Date de début *</label>
          <input type="date" class="form-control" name="date_debut" required>
        </div>
        <div class="col">
          <label for="date_fin" class="form-label">Date de fin</label>
          <input type="date" class="form-control" name="date_fin">
        </div>
        <div class="col">
          <label for="status" class="form-label">Statut de la mission *</label>
          <select id="status" name="status" class="form-control" required>
            <option selected>Statut de la mission...</option>
            <?php foreach ($status as $value) { ?>
              <option value="<?php echo $value ?>"><?php echo $value ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="row mt-4 ">
        <div class="col">
          <label for="target" class="form-label">Targets *</label>
          <select multiple id="target" name="target[]" class="form-control" onChange="filtreAgents();" required>
            <?php foreach ($stackTargets as $index => $stackTarget) { ?>
              <option value="<?php echo $stackTargetIds[$index] ?>" id="<?php echo $stackTargetCountrys[$index] ?>"><?php echo $stackTarget . " - " . $stackTargetCountrys[$index] ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="col">
          <label for="specialitie_requ" class="form-label">Spécialité requise *</label>
          <select id="specialitie_requ" name="specialitie_requ" class="form-control" required>
            <option selected>Spécialité requise...</option>
            <?php foreach ($stacks as $index => $stack) { ?>
              <option value="<?php echo $stackIds[$index] ?>"><?php echo $stack ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="row mt-4">
        <div class="col">
          <label for="agent" class="form-label">Agents *</label>
          <select multiple id="agent" name="agent[]" class="form-control" disabled="disabled" required>
            <?php foreach ($stackAgents as $index => $stackAgent) {
              $array = $stackAgentSpecs[$index];
              $deleteCharac = array("[", "]", '"');
              $array = str_replace($deleteCharac, "", $array); ?>
              <option value="<?php echo $stackAgentIds[$index] ?>" id="<?php echo $stackAgentCountrys[$index] ?>"><?php echo $stackAgent . " - " . $stackAgentCountrys[$index] . "- [" . $array ."]"?></option>
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