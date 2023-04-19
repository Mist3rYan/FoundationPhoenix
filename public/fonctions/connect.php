<?php
define('DBHOST', 'sql202.epizy.com');
define('DBUSER', 'epiz_34039178');
define('DBNAME', 'epiz_34039178_foundation_phoenix');
define('PORT', '3306');
define('PASSWORD', 'jA2qLkGuWhEFx');

$servername = DBHOST;
$username = DBUSER;
$password = PASSWORD;
$dbname = DBNAME;
$port = PORT;;

// ON DEFINIT LE DSN
$dsn = new PDO("mysql:host=$servername;port=$port", $username, $password);
// $dsn = "mysql:host=" . DBHOST .':'.DBPORT. ";dbname=" . DBNAME;
try {
    // ON SE CONNECTE A LA BDD
    $con = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // ON DEFINIT LE CHARSET EN UTF8
    $con->exec("SET NAMES utf8");
    // ON DEFINIT LA METHODE DE RECUPERATION DES DONNEES
    $con->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $_SESSION['message'] = "Erreur : Merci d'ajouter les fixtures à partir de la page d'accueil"; //stocke le message dans une variable de session
    $_SESSION['message_type'] = "error"; //définit le type de message (success, info, warning, danger)
    header('Location: ../index.php');
    exit();
}
