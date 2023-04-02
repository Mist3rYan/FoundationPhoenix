<?php

if (isset($_SESSION['message']) && isset($_SESSION['message_type'])) { //vérifie si le message existe dans la session
    $message = $_SESSION['message']; //stocke le message dans une variable
    $message_type = $_SESSION['message_type']; //stocke le type de message dans une variable
    unset($_SESSION['message']); //supprime la variable de session pour éviter l'affichage du message lors d'un rechargement de page
    unset($_SESSION['message_type']); //supprime la variable de session pour éviter l'affichage du message lors d'un rechargement de page
}
if (isset($message_type)) {//vérifie si le type de message existe
    switch ($message_type) {
        case 'success':
            $alert = 'alert-success';
            break;
        case 'error':
            $alert = 'alert-danger';
            break;
        case 'warning':
            $alert = 'alert-warning';
            break;
        case 'info':
            $alert = 'alert-info';
            break;
        default:
            $alert = 'alert-primary';
            break;
    }
    echo '<div class="alert ' . $alert . '" role="alert">' . $message . '</div>';
}

/* $_SESSION['message'] = "Erreur : " . $e->getMessage(); //stocke le message dans une variable de session
$_SESSION['message_type'] = "danger"; //définit le type de message (success, info, warning, danger) */