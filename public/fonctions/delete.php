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


if ($table == 'missions') {

    if ($res) {
        $_SESSION['message'] = "Suppression effectuée avec succès !";
        $_SESSION['message_type'] = "error"; //définit le type de message (success, info, warning, error)
        header('Location: ../pageMissionsDelete.php');
        exit();
    } else {
        $_SESSION['message'] = "Erreur lors de la suppression !";
        $_SESSION['message_type'] = "error";
        header('Location: ../pageMissionsDelete.php'); //définit le type de message (success, info, warning, error)
        exit();
    }
}

if ($table == 'agents') {
    $query = "SELECT * FROM Agents_has_Missions WHERE mission_id = :id";
    $statement = $con->prepare($query);
    $statement->execute(array('id' => $id));
    while ($suppressionMission = $statement->fetch(PDO::FETCH_ASSOC)) {
        $sql = "DELETE FROM Missions WHERE `id` = :id";
        //Préparez notre déclaration DELETE
        $stmt = $con->prepare($sql);
        // id de la ligne à supprimer
        $id = $suppressionMission['mission_id'];
        //id de la ligne à supprimer
        $stmt->bindValue(':id', $id);
        //Exécuter notre instruction DELETE
        $res = $stmt->execute();
    }
    if ($res) {
        $_SESSION['message'] = "Suppression effectuée avec succès !";
        $_SESSION['message_type'] = "error"; //définit le type de message (success, info, warning, error)
        header('Location: ../pageAgentsDelete.php');
        exit();
    } else {
        $_SESSION['message'] = "Erreur lors de la suppression !";
        $_SESSION['message_type'] = "error";
        header('Location: ../pageAgentsDelete.php'); //définit le type de message (success, info, warning, error)
        exit();
    }
}
if ($table == 'specialities') {
    if ($res) {
        $_SESSION['message'] = "Suppression effectuée avec succès !";
        $_SESSION['message_type'] = "error"; //définit le type de message (success, info, warning, error)
        header('Location: ../pageSpecialitiesDelete.php');
        exit();
    } else {
        $_SESSION['message'] = "Erreur lors de la suppression !";
        $_SESSION['message_type'] = "error";
        header('Location: ../pageSpecialitiesDelete.php'); //définit le type de message (success, info, warning, error)
        exit();
    }
}
if ($table == 'hideouts') {
    if ($res) {
        $_SESSION['message'] = "Suppression effectuée avec succès !";
        $_SESSION['message_type'] = "error"; //définit le type de message (success, info, warning, error)
        header('Location: ../pageHideoutsDelete.php');
        exit();
    } else {
        $_SESSION['message'] = "Erreur lors de la suppression !";
        $_SESSION['message_type'] = "error";
        header('Location: ../pageHideoutsDelete.php'); //définit le type de message (success, info, warning, error)
        exit();
    }
}
if ($table == 'targets') {
    $query = "SELECT * FROM Targets_has_Missions WHERE mission_id = :id";
    $statement = $con->prepare($query);
    $statement->execute(array('id' => $id));
    while ($suppressionMission = $statement->fetch(PDO::FETCH_ASSOC)) {
        $sql = "DELETE FROM Missions WHERE `id` = :id";
        //Préparez notre déclaration DELETE
        $stmt = $con->prepare($sql);
        // id de la ligne à supprimer
        $id = $suppressionMission['mission_id'];
        //id de la ligne à supprimer
        $stmt->bindValue(':id', $id);
        //Exécuter notre instruction DELETE
        $res = $stmt->execute();
    }
    if ($res) {
        $_SESSION['message'] = "Suppression effectuée avec succès !";
        $_SESSION['message_type'] = "error"; //définit le type de message (success, info, warning, error)
        header('Location: ../pageTargetsDelete.php');
        exit();
    } else {
        $_SESSION['message'] = "Erreur lors de la suppression !";
        $_SESSION['message_type'] = "error";
        header('Location: ../pageTargetsDelete.php'); //définit le type de message (success, info, warning, error)
        exit();
    }
}
if ($table == 'contacts') {
    $query = "SELECT * FROM Contacts_has_Missions WHERE mission_id = :id";
    $statement = $con->prepare($query);
    $statement->execute(array('id' => $id));
    while ($suppressionMission = $statement->fetch(PDO::FETCH_ASSOC)) {
        $sql = "DELETE FROM Missions WHERE `id` = :id";
        //Préparez notre déclaration DELETE
        $stmt = $con->prepare($sql);
        // id de la ligne à supprimer
        $id = $suppressionMission['mission_id'];
        //id de la ligne à supprimer
        $stmt->bindValue(':id', $id);
        //Exécuter notre instruction DELETE
        $res = $stmt->execute();
    }
    if ($res) {
        $_SESSION['message'] = "Suppression effectuée avec succès !";
        $_SESSION['message_type'] = "error"; //définit le type de message (success, info, warning, error)
        header('Location: ../pageContactsDelete.php');
        exit();
    } else {
        $_SESSION['message'] = "Erreur lors de la suppression !";
        $_SESSION['message_type'] = "error";
        header('Location: ../pageContactsDelete.php'); //définit le type de message (success, info, warning, error)
        exit();
    }
}
