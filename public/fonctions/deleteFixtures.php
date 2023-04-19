<?php
session_start(); //démarre la session
define('DBHOST', 'sql202.epizy.com');
define('DBUSER', 'epiz_34039178');
define('DBNAME', 'epiz_34039178_foundation_phoenix');
define('PORT', '3306');
define('PASSWORD', 'jA2qLkGuWhEFx');

$servername = DBHOST;
$username = DBUSER;
$password = PASSWORD;
$dbname = DBNAME;
$port = PORT;

$dsn = new PDO("mysql:host=$servername;port=$port", $username, $password);
try {
    // $dsn = "mysql:host=" . DBHOST .':'.DBPORT. ";dbname=" . DBNAME;
    // ON SE CONNECTE A LA BDD
    $con = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // ON DEFINIT LE CHARSET EN UTF8
    $con->exec("SET NAMES utf8");
    // ON DEFINIT LA METHODE DE RECUPERATION DES DONNEES
    $con->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $sql = "TRUNCATE TABLE `Agents`";
    $con->exec($sql);
    $sql = "TRUNCATE TABLE `Contacts`";
    $con->exec($sql);
    $sql = "TRUNCATE TABLE `Hideouts`";
    $con->exec($sql);
    $sql = "TRUNCATE TABLE `Missions`";
    $con->exec($sql);
    $sql = "TRUNCATE TABLE `Specialties`";
    $con->exec($sql);
    $sql = "TRUNCATE TABLE `Targets`";
    $con->exec($sql);
    $sql = "TRUNCATE TABLE `Users`";
    $con->exec($sql);
    $sql = "TRUNCATE TABLE `Targets_has_Missions`";
    $con->exec($sql);
    $sql = "TRUNCATE TABLE `Hideouts_has_Missions`";
    $con->exec($sql);
    $sql = "TRUNCATE TABLE `Agents_has_Missions`";
    $con->exec($sql);
    $sql = "TRUNCATE TABLE `Contacts_has_Missions`";
    $con->exec($sql);
    session_destroy(); //détruit la session
    session_start(); //démarre la session
    $_SESSION['message'] = "Base de données bien supprimée"; //stocke le message dans une variable de session
    $_SESSION['message_type'] = "success"; //définit le type de message (success, info, warning, danger)
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
    $_SESSION['message'] = "Erreur : " . $e->getMessage(); //stocke le message dans une variable de session
    $_SESSION['message_type'] = "error"; //définit le type de message (success, info, warning, danger)
    header('Location: ../index.php');
    exit();
}
header('Location: ../index.php');
exit();
