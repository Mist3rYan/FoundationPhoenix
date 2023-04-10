<?php
session_start(); //démarre la session
require_once('fonctions/connect.php');

if (isset($_POST['create'])) {
    $name = $_POST['name'];
    $firstname = $_POST['firstname'];
    $date = $_POST['date'];
    $idUpdate = $_POST['id'];

    // Verifie si  un pays a été selectionné
    if (($_POST['pays']) !== 'Pays...') {
        $pays = $_POST['pays'];
    } else {
        $pays = '';
        $_SESSION['message'] = " Merci de sélectionner un pays ! "; //stocke le message dans une variable de session
        $_SESSION['message_type'] = "warning"; //définit le type de message (success, info, warning, danger)
        header('Location: pageTargetModify.php');
        exit();
    }
    // Update de l'target
    $stmt = $con->prepare("UPDATE  targets SET name=?, firstname=?, nationality=?, birthdate=? WHERE id = $idUpdate");
    $stmt->execute([$name, $firstname, $pays, $date]);
    if ($stmt) {
        $_SESSION['message'] = " Target modifié avec succès !"; //stocke le message dans une variable de session
        $_SESSION['message_type'] = "success"; //définit le type de message (success, info, warning, danger)
        header('Location: pageTargetModify.php');
        exit();
    } else {
        $_SESSION['message'] = " Erreur lors de la modification de target !"; //stocke le message dans une variable de session
        $_SESSION['message_type'] = "danger"; //définit le type de message (success, info, warning, danger)
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
    if (isset($_GET['id']) and !empty($_GET['id'])) {
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
        $query = "SELECT * FROM targets WHERE id = :id";
        $statement = $con->prepare($query);
        $statement->execute(
            array(
                'id' => $_GET['id']
            )
        );
        $user = $statement->fetch(PDO::FETCH_ASSOC);
    ?>
        <div class="container">
            <div class="h2 text-center alert alert-dismissible alert-primary mt-4">
                <strong>MODIFICATION TARGET</strong>
            </div>
            <form action="pageTargetModify.php" method="post">
                <div class="row mt-4">
                    <div class="col">
                        <input type="text" class="form-control" name="id" value="<?php echo $user['id'] ?>" hidden>
                        <input type="text" class="form-control" name="name" placeholder="Nom" value="<?php echo $user['name'] ?>" required>
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" name="firstname" placeholder="Prénom" value="<?php echo $user['firstname'] ?>" required>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col">
                        <select id="pays" name="pays" class="form-control">
                            <?php foreach ($country as $value) {
                                if ($value == $user['nationality']) {
                            ?>
                                    <option selected value="<?php echo $value ?>"><?php echo $value ?></option>
                                <?php
                                } else {
                                ?>
                                    <option value="<?php echo $value ?>"><?php echo $value ?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col">
                        <input type="date" class="form-control" name="date" placeholder="Date de naissance" value="<?php echo $user['birthdate'] ?>" required>
                    </div>
                </div>
                <div class="row mt-4">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" name="create">Modifier</button>
                </div>
            </form>
        </div><?php
            } else {
                // On récupère le nombre d'targets par page
                $entityByPage = 3;
                // On récupère le nombre total d'targets
                $entityTotalReq = $con->query('SELECT id FROM targets');
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
                // On calcule le numéro du premier target de la page
                $start = ($currentPage - 1) * $entityByPage;
                ?>
        <div class="container">
            <div class="h2 text-center alert alert-dismissible alert-primary mt-4">
                <strong>MODIFICATION TARGETS</strong>
            </div>
            <div class="card-deck">
                <?php
                // On récupère les targets
                $targets = $con->query('SELECT * FROM targets ORDER BY id DESC LIMIT ' . $start . ',' . $entityByPage);
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
                            <p class="card-text"><span class=" text-decoration-underline">Code Target :</span><span> <?php echo $target['code']; ?></span></p>
                            <p class="card-text"><span class="text-decoration-underline">Pays de naissance :</span><span> <?php echo $target['nationality']; ?></span></p>
                            <p class="card-text"><span class="text-decoration-underline">Date de naissanse :</span><span> <?php echo $date->format('d-m-Y'); ?></span></p>
                        </div>
                        <div class="card-footer mt-'">
                            <a href="pageTargetModify.php?id=<?php echo $target['id']; ?>" class="btn btn-primary">Modifier</a>
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
                        <a class="page-link disabled" href="<?php echo 'pageTargetModify.php?page=' . $currentPage ?>">Précédent</a>
                    <?php
                    } else { ?>
                        <a class="page-link" href="<?php echo 'pageTargetModify.php?page=' . $currentPage - 1 ?>">Précédent</a>
                    <?php
                    } ?>
                </li>
                <?php
                for ($i = 1; $i <= $pageTotal; $i++) {
                    if ($i != $currentPage) { ?>
                        <li class="page-item"><a class="page-link" href="<?php echo 'pageTargetModify.php?page=' . $i ?>"><?php echo $i ?></a> </li>
                    <?php
                    } else { ?>
                        <li class="page-item active">
                            <a class="page-link" href="<?php echo 'pageTargetModify.php?page=' . $i ?>"><?php echo $i ?></a>
                        </li>
                <?php
                    }
                }
                ?>
                <li class="page-item">
                    <?php
                    if ($currentPage == $pageTotal) { ?>
                        <a class="page-link disabled" href="<?php echo 'pageTargetModify.php?page=' . $currentPage ?>">Suivant</a>
                    <?php
                    } else { ?>
                        <a class="page-link" href="<?php echo 'pageTargetModify.php?page=' . $currentPage + 1 ?>">Suivant</a>
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