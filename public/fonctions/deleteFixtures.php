<?php
session_start(); //démarre la session
require_once('../fonctions/connect.php'); //charge la connexion à la base de données

try {
    $sql = "DROP DATABASE phoenix_foundation";
    $con->exec($sql);
    $_SESSION['message'] = "Base de données bien supprimée"; //stocke le message dans une variable de session
    $_SESSION['message_type'] = "success"; //définit le type de message (success, info, warning, danger)
} catch (PDOException $e) {
    $_SESSION['message'] = "Erreur : " . $e->getMessage(); //stocke le message dans une variable de session
    $_SESSION['message_type'] = "error"; //définit le type de message (success, info, warning, danger)
}

header('Location: ../index.php');
exit();
