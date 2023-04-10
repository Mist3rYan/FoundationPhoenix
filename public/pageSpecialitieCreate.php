<?php
session_start(); //démarre la session
require_once('fonctions/connect.php'); //charge la connexion à la base de données
// Spécialités
$stack = [];

if (isset($_POST['create'])) {
    $name = $_POST['name'];

    // Vérifie si le nom d'utilisateur existe déjà
    $stmt = $con->prepare("SELECT * FROM specialities WHERE name=?");
    $stmt->execute([$name]);
    $codeSearch = $stmt->fetch();
    if ($codeSearch) {
        $_SESSION['message'] = " La spécialité existe déjà !"; //stocke le message dans une variable de session
        $_SESSION['message_type'] = "warning"; //définit le type de message (success, info, warning, danger)
    } else {
        // le nom d'utilisateur n'existe pas
        $stmt = $con->prepare("INSERT INTO specialities (name) VALUES (?)");
        $stmt->execute([$name]);
        if ($stmt) {
            $_SESSION['message'] = " Spécialité créé avec succès !"; //stocke le message dans une variable de session
            $_SESSION['message_type'] = "success"; //définit le type de message (success, info, warning, danger)
            header('Location: pageSpecialities.php');
            exit();
        } else {
            $_SESSION['message'] = " Erreur lors de la création de la spécialité !"; //stocke le message dans une variable de session
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
    <title>Foundation Phoenix - Targets</title>
    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/reset.css" />
    <link rel="stylesheet" href="assets/css/main.css" />
</head>

<body>
    <?php include '_partials/_header.php'; ?>
    <?php include '_partials/_messages.php'; ?>
    <div class="container">
        <div class="h2 text-center alert alert-dismissible alert-primary mt-4">
            <strong>CREATION SPECIALITE</strong>
        </div>
        <form action="pageSpecialitieCreate.php" method="post">
            <div class="row mt-4">
                <div class="col">
                    <input type="text" class="form-control" name="name" placeholder="Nom" required>
                </div>
                <div class="row mt-4">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" name="create">Créer</button>
                </div>
            </div>
        </form>
    </div>
    <!-- bootstrap js-->
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <!-- js -->
    <script src="assets/js/main.js"></script>
</body>

</html>