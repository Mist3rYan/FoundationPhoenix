<?php
define("DBHOST","localhost");
define("DBUSER","root");
define("DBPASSWORD","");
define("DBNAME","phoenix_foundation");

// ON DEFINIT LE DSN
$dsn = "mysql:host=".DBHOST.";dbname=".DBNAME;
try {
    // ON SE CONNECTE A LA BDD
    $con = new PDO($dsn, DBUSER, DBPASSWORD);
    // ON DEFINIT LE CHARSET EN UTF8
    $con->exec("SET NAMES utf8");
    // ON DEFINIT LA METHODE DE RECUPERATION DES DONNEES
    $con->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
    echo "<br>";
    die();
}

if($con){
    echo "Connexion à la base de données réussie";
    echo "<br>";
}

?>
