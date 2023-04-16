<?php
session_start(); //démarre la session
require_once('fonctions/connect.php');

// Spécialités
$stacks = [];
$stackIds = [];
$specialities = $con->query('SELECT * FROM specialities ORDER BY id');
while ($specialitie = $specialities->fetch()) {
    array_push($stacks, $specialitie['name']);
    array_push($stackIds, $specialitie['id']);
}
$specialities->closeCursor(); // Termine le traitement de la requête

// Agents
$stackAgents = [];
$stackAgentCountrys = [];
$stackAgentIds = [];
$stackAgentSpecs = [];
$agents = $con->query('SELECT * FROM agents ORDER BY id');
while ($agent = $agents->fetch()) {
    array_push($stackAgents, $agent['code']);
    array_push($stackAgentCountrys, $agent['nationality']);
    array_push($stackAgentIds, $agent['id']);
    array_push($stackAgentSpecs, $agent['speciality']);
}
$agents->closeCursor(); // Termine le traitement de la requête

// Cibles
$stackTargets = [];
$stackTargetCountrys = [];
$stackTargetIds = [];
$targets = $con->query('SELECT * FROM targets ORDER BY id');
while ($target = $targets->fetch()) {
    array_push($stackTargets, $target['code']);
    array_push($stackTargetCountrys, $target['nationality']);
    array_push($stackTargetIds, $target['id']);
}
$targets->closeCursor(); // Termine le traitement de la requête

// Contacts
$stackContacts = [];
$stackContactCountrys = [];
$stackContactIds = [];
$contacts = $con->query('SELECT * FROM contacts ORDER BY id');
while ($contact = $contacts->fetch()) {
    array_push($stackContacts, $contact['code']);
    array_push($stackContactCountrys, $contact['nationality']);
    array_push($stackContactIds, $contact['id']);
}
$contacts->closeCursor(); // Termine le traitement de la requête
// Hideouts
$stackHideouts = [];
$stackHideoutCountrys = [];
$stackHideoutIds = [];
$hideouts = $con->query('SELECT * FROM hideouts ORDER BY id');
while ($hideout = $hideouts->fetch()) {
    array_push($stackHideouts, $hideout['type']);
    array_push($stackHideoutCountrys, $hideout['country']);
    array_push($stackHideoutIds, $hideout['id']);
}
$hideouts->closeCursor(); // Termine le traitement de la requête
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
        $statement->closeCursor();

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
                <strong>MODIFICATION MISSION</strong>
            </div>
            <span class="text-danger">* Champs obligatoires</span>
            <form action="pageMissionCreate.php" method="post">
                <div class="row mt-4">
                    <div class="col">
                        <label for="nom_de_code" class="form-label">Code *</label>
                        <input type="text" class="form-control" name="nom_de_code" placeholder="Nom de Code" value="<?php echo $mission['nom_de_code']; ?>" required>
                    </div>
                    <div class="col">
                        <label for="titre" class="form-label">Titre de la mission *</label>
                        <input type="text" class="form-control" name="titre" placeholder="Titre" value="<?php echo $mission['titre']; ?>" required>
                    </div>
                    <div class="col">
                        <label for="type_mission" class="form-label">Type de mission *</label>
                        <select id="type_mission" name="type_mission" class="form-control" required>
                            <?php foreach ($type_mission as $value) {
                                if ($value == $mission['type_mission']) {
                                    echo '<option value="' . $value . '" selected>' . $value . '</option>';
                                } else {
                                    echo '<option value="' . $value . '">' . $value . '</option>';
                                }
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col">
                        <label for="descr" class="form-label">Description *</label>
                        <input type="text" class="form-control" name="descr" placeholder="Description" value="<?php echo $mission['description'] ?>" required>
                    </div>
                    <div class="col">
                        <label for="pays" class="form-label">Pays de la mission *</label>
                        <select id="pays" name="pays" class="form-control" onChange="filtrePays();" required>
                            <option selected>Pays...</option>
                            <?php foreach ($country as $value) {
                                if ($value == $mission['country']) { ?>
                                    <option value="<?php echo $value ?>" selected><?php echo $value ?></option>
                                <?php  } else { ?>
                                    <option value="<?php echo $value ?>"><?php echo $value ?></option>
                            <?php }
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col">
                        <label for="contact" class="form-label">Contacts *</label>
                        <select multiple id="contact" name="contact[]" class="form-control" required>
                            <?php
                            $query = "SELECT * FROM contacts_has_missions WHERE mission_id = :id";
                            $statement = $con->prepare($query);
                            $statement->execute(
                                array(
                                    'id' => $mission['id']
                                )
                            );
                            while ($contactId = $statement->fetch(PDO::FETCH_ASSOC)) {
                                $queryContact = "SELECT * FROM contacts WHERE id = :id";
                                $statementContact = $con->prepare($queryContact);
                                $statementContact->execute(
                                    array(
                                        'id' => $contactId['contact_id']
                                    )
                                );
                                $contact = $statementContact->fetch(PDO::FETCH_ASSOC);
                                foreach ($stackContacts as $index => $stackContact) {
                                    if ($stackContact == $contact['code']) { ?>
                                        <option value="<?php echo $stackContactIds[$index] ?>" id="<?php echo $stackContactCountrys[$index] ?>" selected><?php echo $stackContact . " - " . $stackContactCountrys[$index] ?></option>
                                    <?php } else { ?>
                                        <option value="<?php echo $stackContactIds[$index] ?>" id="<?php echo $stackContactCountrys[$index] ?>"><?php echo $stackContact . " - " . $stackContactCountrys[$index] ?></option>
                            <?php }
                                }
                                $statementContact->closeCursor();
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col">
                        <label for="hideout" class="form-label">Hideouts</label>
                        <select multiple id="hideout" name="hideout[]" class="form-control" disabled="disabled">
                            <?php                             
                            $query = "SELECT * FROM contacts_has_missions WHERE mission_id = :id";
                            $statement = $con->prepare($query);
                            $statement->execute(
                                array(
                                    'id' => $mission['id']
                                )
                            );
                            
                            foreach ($stackHideouts as $index => $stackHideout) { ?>
                                <option value="<?php echo $stackHideoutIds[$index] ?>" id="<?php echo $stackHideoutCountrys[$index] ?>"><?php echo $stackHideout . " - " . $stackHideoutCountrys[$index] ?></option>
                            <?php } ?>

                        </select>
                    </div>
                </div>
                <div class="row mt-4 align-items-end">
                    <div class="col">
                        <label for="date_debut" class="form-label">Date de début *</label>
                        <input type="date" class="form-control" name="date_debut" value="<?php echo $mission['date_debut'] ?>" required>
                    </div>
                    <div class="col">
                        <label for="date_fin" class="form-label">Date de fin</label>
                        <input type="date" class="form-control" name="date_fin" value="<?php echo $mission['date_fin'] ?>">
                    </div>
                    <div class="col">
                        <label for="status" class="form-label">Statut de la mission *</label>
                        <select id="status" name="status" class="form-control" required>
                            <?php foreach ($status as $value) {
                                if ($value == $mission['status']) { ?>
                                    <option value="<?php echo $value ?>" selected><?php echo $value ?></option>
                                <?php  } else { ?>
                                    <option value="<?php echo $value ?>"><?php echo $value ?></option>
                            <?php }
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="row mt-4 ">
                    <div class="col">
                        <label for="target" class="form-label">Targets *</label>
                        <select multiple id="target" name="target[]" class="form-control" onChange="filtreAgents();" required>
                            <?php
                            $query = "SELECT * FROM cibles_has_missions WHERE mission_id = :id";
                            $statement = $con->prepare($query);
                            $statement->execute(
                                array(
                                    'id' => $mission['id']
                                )
                            );
                            while ($cibleId = $statement->fetch(PDO::FETCH_ASSOC)) {
                                $queryCible = "SELECT * FROM targets WHERE id = :id";
                                $statementCible = $con->prepare($queryCible);
                                $statementCible->execute(
                                    array(
                                        'id' => $cibleId['cible_id']
                                    )
                                );
                                $cible = $statementCible->fetch(PDO::FETCH_ASSOC);
                                foreach ($stackTargets as $index => $stackTarget) {
                                    if ($stackTarget == $cible['code']) { ?>
                                        <option value="<?php echo $stackTargetIds[$index] ?>" id="<?php echo $stackTargetCountrys[$index] ?>" selected><?php echo $stackTarget . " - " . $stackTargetCountrys[$index] ?></option>
                                    <?php } else { ?>
                                        <option value="<?php echo $stackTargetIds[$index] ?>" id="<?php echo $stackTargetCountrys[$index] ?>"><?php echo $stackTarget . " - " . $stackTargetCountrys[$index] ?></option>
                            <?php }
                                    $statementCible->closeCursor();
                                }
                            } ?>

                        </select>
                    </div>
                    <div class="col">
                        <label for="specialitie_requ" class="form-label">Spécialité requise *</label>
                        <select id="specialitie_requ" name="specialitie_requ" class="form-control" required>
                            <option selected>Spécialité requise...</option>
                            <?php
                            $query = "SELECT * FROM specialities WHERE id = :id";
                            $statement = $con->prepare($query);
                            $statement->execute(
                                array(
                                    'id' => $mission['specialitie_id']
                                )
                            );
                            $speciality = $statement->fetch(PDO::FETCH_ASSOC);
                            $statement->closeCursor();
                            foreach ($stacks as $index => $stack) {
                                if ($stack ==  $speciality['name']) {
                            ?>
                                    <option value="<?php echo $stackIds[$index] ?>" selected><?php echo $stack ?></option>
                                <?php
                                } else {
                                ?>
                                    <option value="<?php echo $stackIds[$index] ?>"><?php echo $stack ?></option>
                            <?php
                                }
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col">
                        <label for="agent" class="form-label">Agents *</label>
                        <select multiple id="agent" name="agent[]" class="form-control" required>
                            <?php
                            $query = "SELECT * FROM agents_has_missions WHERE mission_id = :id";
                            $statement = $con->prepare($query);
                            $statement->execute(
                                array(
                                    'id' => $mission['id']
                                )
                            );
                            while ($agentId = $statement->fetch(PDO::FETCH_ASSOC)) {
                                $queryAgent = "SELECT * FROM agents WHERE id = :id";
                                $statementAgent = $con->prepare($queryAgent);
                                $statementAgent->execute(
                                    array(
                                        'id' => $agentId['agent_id']
                                    )
                                );
                                $agent = $statementAgent->fetch(PDO::FETCH_ASSOC);
                                foreach ($stackAgents as $index => $stackAgent) {
                                    if ($stackAgent == $agent['code']) { ?>
                                        <option value="<?php echo $stackAgentIds[$index] ?>" id="<?php echo $stackAgentCountrys[$index] ?>" selected><?php echo $stackAgent . " - " . $stackAgentCountrys[$index] . "-" . $stackAgentSpecs[$index] ?></option>
                                    <?php } else { ?>
                                        <option value="<?php echo $stackAgentIds[$index] ?>" id="<?php echo $stackAgentCountrys[$index] ?>"><?php echo $stackAgent . " - " . $stackAgentCountrys[$index] . "-" . $stackAgentSpecs[$index] ?></option>
                            <?php }
                                }
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="row mt-4">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" name="create">Modifier</button>
                </div>
            </form>
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
                                <a href="pageMissionModify.php?id=<?php echo $mission['id']; ?>" class="btn btn-primary">Modifier la mission</a>
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
                        <a class="page-link disabled" href="<?php echo 'pageMissionModify.php?page=' . $currentPage ?>">Précédent</a>
                    <?php
                    } else { ?>
                        <a class="page-link" href="<?php echo 'pageMissionModify.php?page=' . $currentPage - 1 ?>">Précédent</a>
                    <?php
                    } ?>
                </li>
                <?php
                for ($i = 1; $i <= $pageTotal; $i++) {
                    if ($i != $currentPage) { ?>
                        <li class="page-item"><a class="page-link" href="<?php echo 'pageMissionModify.php?page=' . $i ?>"><?php echo $i ?></a> </li>
                    <?php
                    } else { ?>
                        <li class="page-item active">
                            <a class="page-link" href="<?php echo 'pageMissionModify.php?page=' . $i ?>"><?php echo $i ?></a>
                        </li>
                <?php
                    }
                }
                ?>
                <li class="page-item">
                    <?php
                    if ($currentPage == $pageTotal) { ?>
                        <a class="page-link disabled" href="<?php echo 'pageMissionModify.php?page=' . $currentPage ?>">Suivant</a>
                    <?php
                    } else { ?>
                        <a class="page-link" href="<?php echo 'pageMissionModify.php?page=' . $currentPage + 1 ?>">Suivant</a>
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