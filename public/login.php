<?php
session_start();
require_once('fonctions/connect.php');
// Validation du formulaire
if (isset($_POST['email']) &&  isset($_POST['password'])) {

    $query = "SELECT * FROM Users WHERE email = :email AND password = :password";  
    $statement = $con->prepare($query);
    $statement->execute(
        array(
            'email' => $_POST['email'],
            'password' => $_POST['password']
        )
    );
    $user = $statement->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        $_SESSION['user'] = $user['firstname'];
        $_SESSION['message'] = "Bienvenue ".$user['firstname']; //stocke le message dans une variable de session
        $_SESSION['message_type'] = "success"; //définit le type de message (success, info, warning, danger)
        header('Location: index.php');
        exit(); 
    } else {
        $_SESSION['message'] = "Les informations sont incorrectes ! Avez vous ajouté les fixtures ?"; //stocke le message dans une variable de session
        $_SESSION['message_type'] = "error"; //définit le type de message (success, info, warning, danger)
        header('Location: index.php');
        exit(); 
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
    <title>Foundation Phoenix</title>
    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/reset.css" />
    <link rel="stylesheet" href="assets/css/main.css" />
</head>

<body>
    <?php include '_partials/_header.php'; ?>
    <?php include '_partials/_messages.php'; ?>
    <div class="container d-flex flex-column justify-content-center">
        <!--
   Si utilisateur/trice est non identifié(e), on affiche le formulaire
-->
        <?php if (!isset($loggedUser)) : ?>
            <form action="" method="post">
                <!-- si message d'erreur on l'affiche -->
                <?php if (isset($errorMessage)) :
                    $_SESSION['message'] = $errorMessage; //stocke le message dans une variable de session
                    $_SESSION['message_type'] = "error"; //définit le type de message (success, info, warning, danger)
                ?>
                <?php endif; ?>
                <div class="mb-3 mt-4">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" aria-describedby="email-help" placeholder="you@exemple.com">
                    <div id="email-help" class="form-text">L'email utilisé lors de la création de compte.</div>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <button type="submit" class="btn btn-primary">Envoyer</button>
            </form>
            <!-- 
    Si utilisateur/trice bien connectée on affiche un message de succès
-->
        <?php else : ?>
            <div class="alert alert-success" role="alert">
                Bonjour <?php echo $loggedUser['email']; ?> et bienvenue sur le site !
            </div>
        <?php endif; ?>
    </div>

    <!-- bootstrap js-->
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <!-- js -->
    <script src="assets/js/main.js"></script>
</body>

</html>