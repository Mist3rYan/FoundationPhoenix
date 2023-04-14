<?php
define("DBHOST", $_SESSION['DBHOST']);
define("DBUSER", $_SESSION['DBUSER']);
define("DBPASSWORD", $_SESSION['PASSWORD']);
define("DBNAME", $_SESSION['DBNAME']);

// ON DEFINIT LE DSN
$dsn = "mysql:host=" . DBHOST . ";dbname=" . DBNAME;
try {
    // ON SE CONNECTE A LA BDD
    $con = new PDO($dsn, DBUSER, DBPASSWORD);
    // ON DEFINIT LE CHARSET EN UTF8
    $con->exec("SET NAMES utf8");
    // ON DEFINIT LA METHODE DE RECUPERATION DES DONNEES
    $con->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $_SESSION['message'] = "Erreur : Merci d'ajouter les fixtures à partir de la pager d'accueil"; //stocke le message dans une variable de session
    $_SESSION['message_type'] = "error"; //définit le type de message (success, info, warning, danger)
    header('Location: ./index.php');
    exit();
}
