<?php
session_start(); //démarre la session
require_once('fonctions/connect.php');

if (isset($_POST['create'])) {
    $type = $_POST['type'];
    $address = $_POST['address'];
    $idUpdate = $_POST['id'];

    // Verifie si  un pays a été selectionné
    if (($_POST['pays']) !== 'Pays...') {
        $pays = $_POST['pays'];
    } else {
        $pays = '';
        $_SESSION['message'] = " Merci de sélectionner un pays ! "; //stocke le message dans une variable de session
        $_SESSION['message_type'] = "warning"; //définit le type de message (success, info, warning, danger)
        header('Location: pageHideoutModify.php');
        exit();
    }
    // Update de Hideout
    $stmt = $con->prepare("UPDATE  hideouts SET type=?, address=?, country=? WHERE id = $idUpdate");
    $stmt->execute([$type, $address, $pays]);
    if ($stmt) {
        $_SESSION['message'] = " Hideout modifié avec succès !"; //stocke le message dans une variable de session
        $_SESSION['message_type'] = "success"; //définit le type de message (success, info, warning, danger)
        header('Location: pageHideoutModify.php');
        exit();
    } else {
        $_SESSION['message'] = " Erreur lors de la modification de hideout !"; //stocke le message dans une variable de session
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
    <title>Foundation Phoenix - Hideouts</title>
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
        $query = "SELECT * FROM hideouts WHERE id = :id";
        $statement = $con->prepare($query);
        $statement->execute(
            array(
                'id' => $_GET['id']
            )
        );
        $hideout = $statement->fetch(PDO::FETCH_ASSOC);
    ?>
        <div class="container">
            <div class="h2 text-center alert alert-dismissible alert-primary mt-4">
                <strong>MODIFICATION HIDEOUT</strong>
            </div>
            <form action="pageHideoutModify.php" method="post">
                <div class="row mt-4">
                    <div class="col">
                        <input type="text" class="form-control" name="id" value="<?php echo $hideout['id'] ?>" hidden>
                        <input type="text" class="form-control" name="type" placeholder="Type" value="<?php echo $hideout['type'] ?>" required>
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" name="address" placeholder="Adresse" value="<?php echo $hideout['address'] ?>" required>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col">
                        <select id="pays" name="pays" class="form-control">
                            <?php foreach ($country as $value) {
                                if ($value == $hideout['country']) {
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
                    <button type="submit" class="btn btn-primary btn-lg btn-block" name="create">Modifier</button>
                </div>
            </form>
        </div><?php
            } else {
                // On récupère le nombre hideout par page
                $entityByPage = 3;
                // On récupère le nombre total de hideout
                $entityTotalReq = $con->query('SELECT id FROM hideouts');
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
                // On calcule le numéro du premier hideout de la page
                $start = ($currentPage - 1) * $entityByPage;
                ?>
        <div class="container">
            <div class="h2 text-center alert alert-dismissible alert-primary mt-4">
                <strong>MODIFICATION HIDEOUTS</strong>
            </div>
            <div class="card-deck">
                <?php
                // On récupère les hideouts
                $hideouts = $con->query('SELECT * FROM hideouts ORDER BY id DESC LIMIT ' . $start . ',' . $entityByPage);
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
                        <div class="card-footer mt-'">
                            <a href="pageHideoutModify.php?id=<?php echo $hideout['id']; ?>" class="btn btn-primary">Modifier</a>
                        </div>
                    </div>
                <?php
                }
                $hideouts->closeCursor(); // Termine le traitement de la requête
                ?>
            </div>
        </div>
        <!-- Pagination -->
        <nav class="m-4">
            <ul class="pagination pagination-lg justify-content-center">
                <li class="page-item">
                    <?php
                    if ($currentPage == 1) { ?>
                        <a class="page-link disabled" href="<?php echo 'pageHideoutModify.php?page=' . $currentPage ?>">Précédent</a>
                    <?php
                    } else { ?>
                        <a class="page-link" href="<?php echo 'pageHideoutModify.php?page=' . $currentPage - 1 ?>">Précédent</a>
                    <?php
                    } ?>
                </li>
                <?php
                for ($i = 1; $i <= $pageTotal; $i++) {
                    if ($i != $currentPage) { ?>
                        <li class="page-item"><a class="page-link" href="<?php echo 'pageHideoutModify.php?page=' . $i ?>"><?php echo $i ?></a> </li>
                    <?php
                    } else { ?>
                        <li class="page-item active">
                            <a class="page-link" href="<?php echo 'pageHideoutModify.php?page=' . $i ?>"><?php echo $i ?></a>
                        </li>
                <?php
                    }
                }
                ?>
                <li class="page-item">
                    <?php
                    if ($currentPage == $pageTotal) { ?>
                        <a class="page-link disabled" href="<?php echo 'pageHideoutModify.php?page=' . $currentPage ?>">Suivant</a>
                    <?php
                    } else { ?>
                        <a class="page-link" href="<?php echo 'pageHideoutModify.php?page=' . $currentPage + 1 ?>">Suivant</a>
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