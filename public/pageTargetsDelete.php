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
    <title>Foundation Phoenix - Targets</title>
    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/reset.css" />
    <link rel="stylesheet" href="assets/css/main.css" />
</head>

<body>
    <?php include '_partials/_header.php'; ?>
    <?php include '_partials/_messages.php'; ?>
    <?php
    // On récupère le nombre d'agents par page
    $entityByPage = 3;
    // On récupère le nombre total d'agents
    $entityTotalReq = $con->query('SELECT id FROM Targets');
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
            <strong>SUPPRESSION TARGETS</strong>
        </div>
        <?php
    if ($entityTotal == 0) { ?>
      <div class="alert alert-dismissible alert-danger">
        <strong>Il n'y a aucune cible enregistrée.</strong>
      </div>
    <?php
    } else { ?>
        <div class="card-deck">
            <?php
            // On récupère les agents
            $targets = $con->query('SELECT * FROM Targets ORDER BY id DESC LIMIT ' . $start . ',' . $entityByPage);
            // On affiche chaque entrée une à une
            while ($target = $targets->fetch()) {
                $date = new DateTime($target['birthdate']);
            ?>
                <div class="card mt-4">
                    <div class="card-header bg-dark">
                        <h5 class="card-title"><span class="h4 text-warning"><?php echo $target['name']; ?></span></h5>
                        <h6 class="card-subtitle mb-2 text-muted"><span class="h5 text-white"><?php echo $target['firstname']; ?></span></h6>
                    </div>
                    <div class="card-body">
                        <p class="card-text"><span class=" text-decoration-underline">Code target :</span><span> <?php echo $target['code']; ?></span></p>
                        <p class="card-text"><span class="text-decoration-underline">Pays de naissance :</span><span> <?php echo $target['nationality']; ?></span></p>
                        <p class="card-text"><span class="text-decoration-underline">Date de naissanse :</span><span> <?php echo $date->format('d-m-Y'); ?></span></p>
                    </div>
                    <div class="card-footer mt-4">
                        <a class="btn btn-danger " data-bs-toggle="modal" data-bs-target="#modal<?= $target['id'] ?>">Supprimer</a>
                    </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="modal<?= $target['id'] ?>" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title">Supprimer</h3>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Confirmez vous la suppression ?</p>
                            </div>
                            <div class='modal-footer'>
                                <a type="button" class='btn btn-danger' href="fonctions/delete.php?id=<?= $target['id'] ?>&table=targets"> Oui </a>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>

                        </div>
                    </div>
                </div>
            <?php
            }
            $targets->closeCursor(); // Termine le traitement de la requête
            ?>
        </div>
    </div>
    <!-- Pagination -->
    <nav class="m-4">
        <ul class="pagination pagination-lg justify-content-center">
            <li class="page-item">
                <?php
                if ($currentPage == 1) { ?>
                    <a class="page-link disabled" href="pageTargetsDelete.php?page=<?=$currentPage?>">Précédent</a>
                <?php
                } else { ?>
                    <a class="page-link" href="pageTargetsDelete.php?page=<?=$currentPage- 1 ?>">Précédent</a>
                <?php
                } ?>
            </li>
            <?php
            for ($i = 1; $i <= $pageTotal; $i++) {
                if ($i != $currentPage) { ?>
                    <li class="page-item"><a class="page-link" href="pageTargetsDelete.php?page=<?=$i ?>"><?php echo $i ?></a> </li>
                <?php
                } else { ?>
                    <li class="page-item active">
                        <a class="page-link" href="pageTargetsDelete.php?page=<?=$i ?>"><?php echo $i ?></a>
                    </li>
            <?php
                }
            }
            ?>
            <li class="page-item">
                <?php
                if ($currentPage == $pageTotal) { ?>
                    <a class="page-link disabled" href="pageTargetsDelete.php?page=<?=$currentPage?>">Suivant</a>
                <?php
                } else { ?>
                    <a class="page-link" href="pageTargetsDelete.php?page=<?=$currentPage+ 1 ?>">Suivant</a>
                <?php
                } ?>
            </li>
        </ul>
    </nav>
    <?php
    }
?>
    <!-- bootstrap js-->
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <!-- js -->
    <script src="assets/js/main.js"></script>
</body>

</html>