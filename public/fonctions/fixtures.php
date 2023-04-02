<?php
session_start(); //démarre la session
require_once('../fonctions/installDatabase.php'); //charge la connexion à la base de données
require_once('../../vendor/autoload.php'); //charge les dépendances
require_once('../Models/agent.php'); //charge les fonctions liées aux agents

// On crée une instance de Faker en FR
$faker = Faker\Factory::create('fr_FR');

// Spécialités
$specialities = array(
    'Cryptologie',
    'Infiltration',
    'Renseignement',
    'Securite',
    'Diplomatie',
    'Finance',
    'Droit',
    'Sport de combat',
    'Concentration',
    'Medecine'
);

// Spécialités
$country = array(
    'France',
    'Russie',
    'Angleterre',
    'Chine',
    'Etats-Unis',
    'Japon',
    'Allemagne',
    'Italie',
    'Espagne',
    'Portugal',
    'Pologne',
    'Belgique',
    'Suisse',
    'Canada',
    'Mexique',
    'Brésil',
    'Argentine',
    'Australie',
    'Nouvelle-Zélande',
    'Afrique du Sud',
    'Inde',
    'Indonésie',
    'Chili',
    'Colombie',
    'Perou',
    'Equateur'
);

//Agents
$agent = new Agent();
$nbAgents = 20;
for ($i = 0; $i < $nbAgents; $i++) {
    $agent->setCode($faker->numberBetween(0, 10000));
    $agent->setName($faker->name());
    $agent->setFirstname($faker->firstname());

    // On choisit un pays aléatoire
    $nbr = rand(1, count($country) - 1);
    $agent->setNationality($country[$nbr]);

    // On choisit une date aléatoire entre 18 et 60 ans
    $date = $faker->dateTimeBetween('-60 years', '-18 years');
    $agent->setBirthdate($date->format('Y-m-d'));

    // On choisit un nombre aléatoire de spécialités
    $nombre = $faker->numberBetween(1, 5);
    shuffle($specialities);
    $listeSpecialities = [];
    for ($j = 0; $j < $nombre; $j++) {
        array_push($listeSpecialities, $specialities[$j]);
    }
    $agent->setSpeciality($listeSpecialities);

    // On insère les données dans la base de données
    $req = $dbco->prepare("INSERT INTO Agents (code, name, firstname, nationality, birthdate, speciality) VALUES (?,?,?,?,?,?)");
    $req->execute(array(
        $agent->getCode(),
        $agent->getName(),
        $agent->getFirstname(),
        $agent->getNationality(),
        date($agent->getBirthdate()),
        json_encode($agent->getSpeciality())
    ));
}

//Contacts
$contact = new User();
$nbContact = 20;
for ($i = 0; $i < $nbContact; $i++) {
    $contact->setCode($faker->numberBetween(0, 10000));
    $contact->setName($faker->name());
    $contact->setFirstname($faker->firstname());

    // On choisit un pays aléatoire
    $nbr = rand(1, count($country) - 1);
    $contact->setNationality($country[$nbr]);

    // On choisit une date aléatoire entre 18 et 60 ans
    $date = $faker->dateTimeBetween('-60 years', '-18 years');
    $contact->setBirthdate($date->format('Y-m-d'));

    // On insère les données dans la base de données
    $req = $dbco->prepare("INSERT INTO contacts (code, name, firstname, nationality, birthdate) VALUES (?,?,?,?,?)");
    $req->execute(array(
        $contact->getCode(),
        $contact->getName(),
        $contact->getFirstname(),
        $contact->getNationality(),
        date($contact->getBirthdate())
    ));
}

//Targets
$target = new User();
$nbTarget = 20;
for ($i = 0; $i < $nbTarget; $i++) {
    $target->setCode($faker->numberBetween(0, 10000));
    $target->setName($faker->name());
    $target->setFirstname($faker->firstname());
    // On choisit un pays aléatoire
    $nbr = rand(1, count($country) - 1);
    $target->setNationality($country[$nbr]);

    // On choisit une date aléatoire entre 18 et 60 ans
    $date = $faker->dateTimeBetween('-60 years', '-18 years');
    $target->setBirthdate($date->format('Y-m-d'));

    // On insère les données dans la base de données
    $req = $dbco->prepare("INSERT INTO targets (code, name, firstname, nationality, birthdate) VALUES (?,?,?,?,?)");
    $req->execute(array(
        $target->getCode(),
        $target->getName(),
        $target->getFirstname(),
        $target->getNationality(),
        date($target->getBirthdate())
    ));
}

$_SESSION['message'] = "Les données ont bien été ajoutées !"; //stocke le message dans une variable de session
$_SESSION['message_type'] = "success"; //définit le type de message (success, info, warning, danger)

header('Location: ../index.php');
exit();
