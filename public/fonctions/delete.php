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


if ($table == 'Missions') {
    if ($res) {
        $query = "DELETE FROM Cibles_has_Missions WHERE mission_id = :id";
        $statement = $con->prepare($query);
        $statement->execute(array('id' => $id));
        $query = "DELETE FROM Hideouts_has_Missions WHERE mission_id = :id";
        $statement = $con->prepare($query);
        $statement->execute(array('id' => $id));
        $query = "DELETE FROM Agents_has_Missions WHERE mission_id = :id";
        $statement = $con->prepare($query);
        $statement->execute(array('id' => $id));
        $query = "DELETE FROM Contacts_has_Missions WHERE mission_id = :id";
        $statement = $con->prepare($query);
        $statement->execute(array('id' => $id));

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

if ($table == 'Agents') {
    $query = "SELECT * FROM Agents_has_Missions WHERE agent_id = :id";
    $statement = $con->prepare($query);
    $statement->execute(array('id' => $id));
    $query = "DELETE FROM Agents_has_Missions WHERE agent_id = :id";
    $stmt = $con->prepare($query);
    $stmt->execute(array('id' => $id));
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
        $query = "DELETE FROM Agents_has_Missions WHERE mission_id = :id";
        $stmt = $con->prepare($query);
        $stmt->execute(array('id' => $id));
        $query = "DELETE FROM Cibles_has_Missions WHERE mission_id = :id";
        $stmt = $con->prepare($query);
        $stmt->execute(array('id' => $id));
        $query = "DELETE FROM Hideouts_has_Missions WHERE mission_id = :id";
        $stmt = $con->prepare($query);
        $stmt->execute(array('id' => $id));
        $query = "DELETE FROM Contacts_has_Missions WHERE mission_id = :id";
        $stmt = $con->prepare($query);
        $stmt->execute(array('id' => $id));
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
if ($table == 'Specialities') {
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
if ($table == 'Hideouts') {
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
if ($table == 'Targets') {
    $query = "SELECT * FROM Cibles_has_Missions WHERE cible_id = :id";
    $statement = $con->prepare($query);
    $statement->execute(array('id' => $id));
    $query = "DELETE FROM Cibles_has_Missions WHERE cible_id = :id";
    $stmt = $con->prepare($query);
    $stmt->execute(array('id' => $id));
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
        $query = "DELETE FROM Cibles_has_Missions WHERE mission_id = :id";
        $stmt = $con->prepare($query);
        $stmt->execute(array('id' => $id));
        $query = "DELETE FROM Hideouts_has_Missions WHERE mission_id = :id";
        $stmt = $con->prepare($query);
        $stmt->execute(array('id' => $id));
        $query = "DELETE FROM Agents_has_Missions WHERE mission_id = :id";
        $stmt = $con->prepare($query);
        $stmt->execute(array('id' => $id));
        $query = "DELETE FROM Contacts_has_Missions WHERE mission_id = :id";
        $stmt = $con->prepare($query);
        $stmt->execute(array('id' => $id));
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
if ($table == 'Contacts') {
    $query = "SELECT * FROM Contacts_has_Missions WHERE contact_id = :id";
    $statement = $con->prepare($query);
    $statement->execute(array('id' => $id));
    $query = "DELETE FROM Contacts_has_Missions WHERE contact_id = :id";
    $stmt = $con->prepare($query);
    $stmt->execute(array('id' => $id));
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
        $query = "DELETE FROM Contacts_has_Missions WHERE mission_id = :id";
        $stmt = $con->prepare($query);
        $stmt->execute(array('id' => $id));
        $query = "DELETE FROM Cibles_has_Missions WHERE mission_id = :id";
        $stmt = $con->prepare($query);
        $stmt->execute(array('id' => $id));
        $query = "DELETE FROM Hideouts_has_Missions WHERE mission_id = :id";
        $stmt = $con->prepare($query);
        $stmt->execute(array('id' => $id));
        $query = "DELETE FROM Agents_has_Missions WHERE mission_id = :id";
        $stmt = $con->prepare($query);
        $stmt->execute(array('id' => $id));
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
