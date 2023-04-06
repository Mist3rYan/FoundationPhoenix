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

if($table== 'agents'){
    if ($res) {
        $_SESSION['message'] = "Suppression effectuée avec succès !";
        $_SESSION['message_type'] = "error";//définit le type de message (success, info, warning, error)
        header('Location: ../pageAgentsDelete.php');
        exit();
    } else {
        $_SESSION['message'] = "Erreur lors de la suppression !";
        $_SESSION['message_type'] = "error";
        header('Location: ../pageAgentsDelete.php');//définit le type de message (success, info, warning, error)
        exit();
    }
}
if($table== 'specialities'){
    if ($res) {
        $_SESSION['message'] = "Suppression effectuée avec succès !";
        $_SESSION['message_type'] = "error";//définit le type de message (success, info, warning, error)
        header('Location: ../pageSpecialitiesDelete.php');
        exit();
    } else {
        $_SESSION['message'] = "Erreur lors de la suppression !";
        $_SESSION['message_type'] = "error";
        header('Location: ../pageSpecialitiesDelete.php');//définit le type de message (success, info, warning, error)
        exit();
    }
}
if($table== 'hideouts'){
    if ($res) {
        $_SESSION['message'] = "Suppression effectuée avec succès !";
        $_SESSION['message_type'] = "error";//définit le type de message (success, info, warning, error)
        header('Location: ../pageHideoutsDelete.php');
        exit();
    } else {
        $_SESSION['message'] = "Erreur lors de la suppression !";
        $_SESSION['message_type'] = "error";
        header('Location: ../pageHideoutsDelete.php');//définit le type de message (success, info, warning, error)
        exit();
    }
}
if($table== 'targets'){
    if ($res) {
        $_SESSION['message'] = "Suppression effectuée avec succès !";
        $_SESSION['message_type'] = "error";//définit le type de message (success, info, warning, error)
        header('Location: ../pageTargetsDelete.php');
        exit();
    } else {
        $_SESSION['message'] = "Erreur lors de la suppression !";
        $_SESSION['message_type'] = "error";
        header('Location: ../pageTargetsDelete.php');//définit le type de message (success, info, warning, error)
        exit();
    }
}
if($table== 'contacts'){
    if ($res) {
        $_SESSION['message'] = "Suppression effectuée avec succès !";
        $_SESSION['message_type'] = "error";//définit le type de message (success, info, warning, error)
        header('Location: ../pageContactsDelete.php');
        exit();
    } else {
        $_SESSION['message'] = "Erreur lors de la suppression !";
        $_SESSION['message_type'] = "error";
        header('Location: ../pageContactsDelete.php');//définit le type de message (success, info, warning, error)
        exit();
    }
}
if($table== 'agents'){
    if ($res) {
        $_SESSION['message'] = "Suppression effectuée avec succès !";
        $_SESSION['message_type'] = "error";//définit le type de message (success, info, warning, error)
        header('Location: ../pageAgentsDelete.php');
        exit();
    } else {
        $_SESSION['message'] = "Erreur lors de la suppression !";
        $_SESSION['message_type'] = "error";
        header('Location: ../pageAgentsDelete.php');//définit le type de message (success, info, warning, error)
        exit();
    }
}
?>