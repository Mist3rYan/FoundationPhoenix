<?php
session_start(); //démarre la session
require_once('fonctions/connect.php');
// Spécialités
$stack = [];
$specialities = $con->query('SELECT * FROM specialities ORDER BY id');
while ($specialitie = $specialities->fetch()) {
  array_push($stack, $specialitie['name']);
}
$specialities->closeCursor(); // Termine le traitement de la requête
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Bootstrap CSS -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
  <title>Foundation Phoenix - Missions</title>
  <!-- CSS -->
  <link rel="stylesheet" href="assets/css/reset.css" />
  <link rel="stylesheet" href="assets/css/main.css" />
</head>

<body>
  <?php include '_partials/_header.php'; ?>
  <?php include '_partials/_messages.php'; ?>
  <?php
  if (isset($_GET['id']) and !empty($_GET['id'])) {
    $query = "SELECT * FROM missions WHERE id = :id";
    $statement = $con->prepare($query);
    $statement->execute(
      array(
        'id' => $_GET['id']
      )
    );
    $mission = $statement->fetch(PDO::FETCH_ASSOC);
  ?>
    <div class="container">
      <div class="h2 text-center alert alert-dismissible alert-primary mt-4">
        <strong>MISSION</strong>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="h3 text-center alert alert-dismissible alert-secondary">
            <strong><?php echo $mission['titre']; ?></strong>
          </div>
        </div>
      </div>
      <div>
        <table class="table table-striped">
          <tbody>
            <tr>
              <th scope="row">Nom de code la mission: </th>
              <td colspan="6"><?php echo $mission['nom_de_code']; ?></td>
            </tr>
            <tr>
              <th scope="row">Type de mission: </th>
              <td colspan="6"><?php echo $mission['type_mission']; ?></td>
            </tr>
            <?php
            $query = "SELECT * FROM cibles_has_missions WHERE mission_id = :id";
            $statement = $con->prepare($query);
            $statement->execute(
              array(
                'id' => $mission['id']
              )
            );
            $i = 1;
            while ($cibleId = $statement->fetch(PDO::FETCH_ASSOC)) {
              $queryCible = "SELECT * FROM targets WHERE id = :id";
              $statementCible = $con->prepare($queryCible);
              $statementCible->execute(
                array(
                  'id' => $cibleId['cible_id']
                )
              );
              $cible = $statementCible->fetch(PDO::FETCH_ASSOC);
            ?>
              <tr>
                <th scope="row">Cible <?php echo $i; ?></th>
                <td>Code cible: <?php echo $cible['code'] ?></td>
                <td>Nom: <?php echo $cible['name'] ?></td>
                <td>Prenom: <?php echo $cible['firstname'] ?></td>
                <td>Pays de naissance: <?php echo $cible['nationality'] ?></td>
                <td colspan="2">Né le: <?php $date = new DateTime($cible['birthdate']);
                                        echo $date->format('d-m-Y'); ?></td>
              </tr>
            <?php
              $i++;
            }
            ?>
            <tr>
              <th scope="row">Status la mission: </th>
              <td colspan="6"><?php echo $mission['status']; ?></td>
            </tr>
            <tr>
              <th scope="row">Date de début de la mission: </th>
              <td colspan="6"><?php $date = new DateTime($mission['date_debut']);
                              echo $date->format('d-m-Y'); ?></td>
            </tr>
            <tr>
              <th scope="row">Date de fin de la mission: </th>
              <td colspan="6"><?php if ($mission['date_fin'] != "0000-00-00") {
                                $date = new DateTime($mission['date_fin']);
                                echo $date->format('d-m-Y');
                              } ?></td>
            </tr>
            <tr>
              <th scope="row">Pays de la mission: </th>
              <td colspan="6"><?php echo $mission['country']; ?></td>
            </tr>
            <tr>
              <th scope="row">Description: </th>
              <td colspan="6"><?php echo $mission['description']; ?></td>
            </tr>
            <tr>
              <th scope="row">Spécialité requise: </th>
              <?php
              $query = "SELECT * FROM specialities WHERE id = :id";
              $statement = $con->prepare($query);
              $statement->execute(
                array(
                  'id' => $mission['specialitie_id']
                )
              );
              $speciality = $statement->fetch(PDO::FETCH_ASSOC);
              ?>
              <td colspan="6"><?php echo $speciality['name'] ?></td>
            </tr>
            <?php
            $query = "SELECT * FROM agents_has_missions WHERE mission_id = :id";
            $statement = $con->prepare($query);
            $statement->execute(
              array(
                'id' => $mission['id']
              )
            );
            $i = 1;
            while ($agentId = $statement->fetch(PDO::FETCH_ASSOC)) {
              $queryAgent = "SELECT * FROM agents WHERE id = :id";
              $statementAgent = $con->prepare($queryAgent);
              $statementAgent->execute(
                array(
                  'id' => $agentId['agent_id']
                )
              );
              $agent = $statementAgent->fetch(PDO::FETCH_ASSOC);
              $array = $agent['speciality'];
              $deleteCharac = array("[", "]", '"');
              $array = str_replace($deleteCharac, "", $array);
            ?>
              <tr>
                <th scope="row">Agent <?php echo $i; ?></th>
                <td>Code agent: <?php echo $agent['code'] ?></td>
                <td>Nom: <?php echo $agent['name'] ?></td>
                <td>Prenom: <?php echo $agent['firstname'] ?></td>
                <td>Pays de naissance: <?php echo $agent['nationality'] ?></td>
                <td><?php echo $array ?></td>
                <td>Né le: <?php $date = new DateTime($agent['birthdate']);
                            echo $date->format('d-m-Y'); ?></td>
              </tr>
            <?php
              $i++;
            }
            $query = "SELECT * FROM contacts_has_missions WHERE mission_id = :id";
            $statement = $con->prepare($query);
            $statement->execute(
              array(
                'id' => $mission['id']
              )
            );
            $i = 1;
            while ($contactId = $statement->fetch(PDO::FETCH_ASSOC)) {
              $queryContact = "SELECT * FROM contacts WHERE id = :id";
              $statementContact = $con->prepare($queryContact);
              $statementContact->execute(
                array(
                  'id' => $contactId['contact_id']
                )
              );
              $contact = $statementContact->fetch(PDO::FETCH_ASSOC);
            ?>
              <tr>
                <th scope="row">Contact <?php echo $i; ?></th>
                <td>Code contact: <?php echo $contact['code'] ?></td>
                <td>Nom: <?php echo $contact['name'] ?></td>
                <td>Prenom: <?php echo $contact['firstname'] ?></td>
                <td>Pays de naissance: <?php echo $contact['nationality'] ?></td>
                <td colspan="2">Né le: <?php $date = new DateTime($contact['birthdate']);
                                        echo $date->format('d-m-Y'); ?></td>
              </tr>
            <?php
              $i++;
            }
            $query = "SELECT * FROM hideouts_has_missions WHERE mission_id = :id";
            $statement = $con->prepare($query);
            $statement->execute(
              array(
                'id' => $mission['id']
              )
            );
            $i = 1;
            while ($hideoutId = $statement->fetch(PDO::FETCH_ASSOC)) {
              $queryHideout = "SELECT * FROM hideouts WHERE id = :id";
              $statementHideout = $con->prepare($queryHideout);
              $statementHideout->execute(
                array(
                  'id' => $hideoutId['hideouts_id']
                )
              );
              $hideout = $statementHideout->fetch(PDO::FETCH_ASSOC);
            ?>
              <tr>
                <th scope="row">Planque <?php echo $i; ?></th>
                <td>Code de la planque: <?php echo $hideout['code'] ?></td>
                <td>Type: <?php echo $hideout['type'] ?></td>
                <td colspan="2">Adresse: <?php echo $hideout['address'] ?></td>
                <td colspan="2">Pays: <?php echo $hideout['country'] ?></td>
              </tr>
            <?php
              $i++;
            }
            ?>
          </tbody>
        </table>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="h3 text-center alert alert-danger alert-secondary">
            <strong>Données strictement confidentielles</strong>
          </div>
        </div>
      </div>
    </div>
  <?php
  } else {
    // On récupère le nombre d'agents par page
    $entityByPage = 3;
    // On récupère le nombre total d'agents
    $entityTotalReq = $con->query('SELECT id FROM missions');
    // On calcule le nombre de pages total
    $entityTotal = $entityTotalReq->rowCount();
    // On arrondit au nombre supérieur le nombre de pages
    $pageTotal = ceil($entityTotal / $entityByPage);

    if (isset($_GET['page']) and !empty($_GET['page']) and $_GET['page'] > 0) {
      $_GET['page'] = intval($_GET['page']);
      $currentPage = $_GET['page'];
    } else {
      $currentPage = 1;
    }
    // On calcule le numéro du premier agent de la page
    $start = ($currentPage - 1) * $entityByPage;
  ?>
    <div class="container">
      <div class="h2 text-center alert alert-dismissible alert-primary mt-4">
        <strong>MISSIONS</strong>
      </div>
      <?php
      if ($entityTotal == 0) { ?>
        <div class="alert alert-dismissible alert-danger">
          <strong>Il n'y a aucune mission enregistrée.</strong>
        </div>
      <?php
      } else { ?>
        <div class="card-deck">
          <?php
          // On récupère les agents
          $missions = $con->query('SELECT * FROM missions ORDER BY id DESC LIMIT ' . $start . ',' . $entityByPage);
          // On affiche chaque entrée une à une
          while ($mission = $missions->fetch()) {
          ?>
            <div class="card mt-4">
              <div class="card-header bg-dark">
                <h5 class="card-title"><span class="h4 text-warning"><?php echo $mission['type_mission']; ?></span></h5>
                <h6 class="card-subtitle mb-2 text-muted"><span class="h5 text-white"><?php echo $mission['nom_de_code']; ?></span></h6>
              </div>
              <div class="card-body">
                <p class="card-text"><span class=" text-decoration-underline">Titre :</span><span> <?php echo $mission['titre']; ?></span></p>
                <p class="card-text"><span class="text-decoration-underline">Description :</span><span> <?php echo $mission['description']; ?></span></p>
                <p class="card-text"><span class="text-decoration-underline">Pays :</span><span> <?php echo $mission['country']; ?></span></p>
              </div>
              <div class="card-footer mt-'">
                <a href="pageMissions.php?id=<?php echo $mission['id']; ?>" class="btn btn-primary">Afficher la mission</a>
              </div>
            </div>
          <?php
          }
          $missions->closeCursor(); // Termine le traitement de la requête
          ?>
        </div>
    </div>
    <!-- Pagination -->
    <nav class="m-4">
      <ul class="pagination pagination-lg justify-content-center">
        <li class="page-item">
          <?php
          if ($currentPage == 1) { ?>
            <a class="page-link disabled" href="<?php echo 'pageMissions.php?page=' . $currentPage ?>">Précédent</a>
          <?php
          } else { ?>
            <a class="page-link" href="<?php echo 'pageMissions.php?page=' . $currentPage - 1 ?>">Précédent</a>
          <?php
          } ?>
        </li>
        <?php
        for ($i = 1; $i <= $pageTotal; $i++) {
          if ($i != $currentPage) { ?>
            <li class="page-item"><a class="page-link" href="<?php echo 'pageMissions.php?page=' . $i ?>"><?php echo $i ?></a> </li>
          <?php
          } else { ?>
            <li class="page-item active">
              <a class="page-link" href="<?php echo 'pageMissions.php?page=' . $i ?>"><?php echo $i ?></a>
            </li>
        <?php
          }
        }
        ?>
        <li class="page-item">
          <?php
          if ($currentPage == $pageTotal) { ?>
            <a class="page-link disabled" href="<?php echo 'pageMissions.php?page=' . $currentPage ?>">Suivant</a>
          <?php
          } else { ?>
            <a class="page-link" href="<?php echo 'pageMissions.php?page=' . $currentPage + 1 ?>">Suivant</a>
          <?php
          } ?>
        </li>
      </ul>
    </nav>
<?php
      }
    }
?>
<!-- bootstrap js-->
<script src="assets/js/bootstrap.bundle.min.js"></script>
<!-- js -->
<script src="assets/js/main.js"></script>
</body>

</html>