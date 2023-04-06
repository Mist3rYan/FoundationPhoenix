<?php
session_start(); //démarre la session
require_once('connect.php');

$table = $_GET['table'];

//Suppression d'une ligne à l'aide d'une instruction préparée
$sql = "DELETE FROM $table WHERE `id` = :id";
//Préparez notre déclaration DELETE
$stmt = $con->prepare($sql);
// id de la ligne à supprimer
$id = $_GET['id'];
//id de la ligne à supprimer
$stmt->bindValue(':id', $id);
//Exécuter notre instruction DELETE
$res = $stmt->execute();

if ($res) {
    $_SESSION['message'] = "Suppression effectuée avec succès !";
    $_SESSION['message_type'] = "error";//définit le type de message (success, info, warning, error)
    header('Location: ../index.php');
    exit();
} else {
    $_SESSION['message'] = "Erreur lors de la suppression !";
    $_SESSION['message_type'] = "error";
    header('Location: ../index.php');//définit le type de message (success, info, warning, error)
    exit();
}

?>