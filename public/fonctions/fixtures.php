<?php
session_start(); //démarre la session
require_once('connect.php');
require_once('../../vendor/autoload.php'); //charge les dépendances
require_once('../Models/Agent.php'); //charge les fonctions liées aux agents
require_once('../Models/Speciality.php'); //charge les fonctions liées aux spécialités
require_once('../Models/Hideout.php'); //charge les fonctions liées aux planques

// On crée une instance de Faker en FR
$faker = Faker\Factory::create('fr_FR');

// Spécialités
$specialities = array(
    'Concentration',
    'Cryptologie',
    'Diplomatie',
    'Droit',
    'Finance',
    'Infiltration',
    'Medecine',
    'Renseignement',
    'Securite',
    'Sport de combat'
);

// Pays
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
$sql = "SELECT id FROM Users WHERE id = 1 ";
$sth = $con->prepare($sql);
$sth->execute();
$result = $sth->fetch(PDO::FETCH_ASSOC);
if ($result['id'] != 1) {
    // User
    $sql = " INSERT INTO
Users(name, firstname, email, password, createdAt)
values
(
    'Thornton',
    'Peter',
    'peter.thornton@foundationphoenix.org',
    'admin',
    Now()
)";
    $con->exec($sql);

    //Specialities
    $speciality = new Speciality();
    foreach ($specialities as $specialitie) {
        $speciality->setName($specialitie);
        // On insère les données dans la base de données
        $sql = "INSERT INTO 
    Specialities (name) 
    values ('" . $speciality->getName() . "'
    )";
        $con->exec($sql);;
    }
    //Agents
    $agent = new Agent();
    // On insère un agent manuellement pour faire un exemple mission
    $agent->setCode("DXSID N°XC4479");
    $agent->setName("MacGyver");
    $agent->setFirstname("Angus");
    $agent->setNationality('Etats-Unis');
    $agent->setBirthdate("1951-03-23");
    $agent->setSpeciality(["Renseignement", "Diplomatie", "Concentration", "Securite"]);
    $sql = "INSERT INTO Agents (code, name, firstname, nationality, birthdate, speciality) 
VALUES (
    '" . $agent->getCode() . "',
    '" . $agent->getName() . "',
    '" . $agent->getFirstname() . "',
    '" . $agent->getNationality() . "',
    '" . date($agent->getBirthdate()) . "',
    '" . json_encode($agent->getSpeciality()) . "'
)";
    $con->exec($sql);


    $nbAgents = 20;
    for ($i = 0; $i < $nbAgents; $i++) {
        $agent->setCode($faker->numberBetween(0, 10000));
        $agent->setName($faker->lastName());
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
        $sql = "INSERT INTO Agents (code, name, firstname, nationality, birthdate, speciality) 
    VALUES (
        '" . $agent->getCode() . "',
        '" . $agent->getName() . "',
        '" . $agent->getFirstname() . "',
        '" . $agent->getNationality() . "',
        '" . date($agent->getBirthdate()) . "',
        '" . json_encode($agent->getSpeciality()) . "'
    )";
        $con->exec($sql);
    }

    //Contacts
    $contact = new User();
    // On insère un contact manuellement pour faire un exemple mission
    $contact->setCode("5s9578");
    $contact->setName("Dalton");
    $contact->setFirstname("Jack");
    $contact->setNationality('Etats-Unis');
    $contact->setBirthdate("1951-02-03");
    $sql = "INSERT INTO Contacts (code, name, firstname, nationality, birthdate) 
VALUES (
    '" . $contact->getCode() . "',
    '" . $contact->getName() . "',
    '" . $contact->getFirstname() . "',
    '" . $contact->getNationality() . "',
    '" . $contact->getBirthdate() . "'
    )";
    $con->exec($sql);

    $nbContact = 20;
    for ($i = 0; $i < $nbContact; $i++) {
        $contact->setCode($faker->numberBetween(0, 10000));
        $contact->setName($faker->lastName());
        $contact->setFirstname($faker->firstname());

        // On choisit un pays aléatoire
        $nbr = rand(1, count($country) - 1);
        $contact->setNationality($country[$nbr]);

        // On choisit une date aléatoire entre 18 et 60 ans
        $date = $faker->dateTimeBetween('-60 years', '-18 years');
        $contact->setBirthdate($date->format('Y-m-d'));

        // On insère les données dans la base de données
        $sql = "INSERT INTO Contacts (code, name, firstname, nationality, birthdate) 
    VALUES (
        '" . $contact->getCode() . "',
        '" . $contact->getName() . "',
        '" . $contact->getFirstname() . "',
        '" . $contact->getNationality() . "',
        '" . $contact->getBirthdate() . "'
        )";
        $con->exec($sql);
    }

    //Targets
    $target = new User();
    // On insère une cible manuellement pour faire un exemple mission
    $target->setCode("Mercenaire N°XC4479");
    $target->setName("Murdoc");
    $target->setFirstname("Francis");
    $target->setNationality('France');
    $target->setBirthdate("2002-02-15");

    $sql = "INSERT INTO Targets (code, name, firstname, nationality, birthdate) 
VALUES (
    '" . $target->getCode() . "',
    '" . $target->getName() . "',
    '" . $target->getFirstname() . "',
    '" . $target->getNationality() . "',
    '" . $target->getBirthdate() . "'
    )";
    $con->exec($sql);

    $nbTarget = 20;
    for ($i = 0; $i < $nbTarget; $i++) {
        $target->setCode($faker->numberBetween(0, 10000));
        $target->setName($faker->lastName());
        $target->setFirstname($faker->firstname());
        // On choisit un pays aléatoire
        $nbr = rand(1, count($country) - 1);
        $target->setNationality($country[$nbr]);

        // On choisit une date aléatoire entre 18 et 60 ans
        $date = $faker->dateTimeBetween('-60 years', '-18 years');
        $target->setBirthdate($date->format('Y-m-d'));

        // On insère les données dans la base de données
        $sql = "INSERT INTO Targets (code, name, firstname, nationality, birthdate) 
    VALUES (
        '" . $target->getCode() . "',
        '" . $target->getName() . "',
        '" . $target->getFirstname() . "',
        '" . $target->getNationality() . "',
        '" . $target->getBirthdate() . "'
        )";
        $con->exec($sql);
    }

    //Hideouts
    $hideout = new Hideout();
    $nbHideout = 5;
    for ($i = 0; $i < $nbHideout; $i++) {
        // On choisit un pays aléatoire
        $nbr = rand(1, count($country) - 1);
        $hideout->setCountry($country[$nbr]);

        $hideout->setAddress($faker->address());
        $hideout->setCode($faker->numberBetween(1, 10000));
        $hideout->setType($faker->randomElement($array = array('Villa', 'Maison', 'Appartement', 'Bunker', 'Hangar', 'Cave', 'Bateau')));
        // On insère les données dans la base de données
        $sql = "INSERT INTO Hideouts (code, address, country, type) 
    VALUES (
        '" . $hideout->getCode() . "',
        '" . $hideout->getAddress() . "',
        '" . $hideout->getCountry() . "',
        '" . $hideout->getType() . "'
        )";
        $con->exec($sql);
    }

    $sql = " INSERT INTO
        Missions(titre, description, nom_de_code, country, type_mission, status, date_debut, date_fin, specialitie_id)
        values
        (
            'Exemple de mission',
            'Eliminer Murdoc, mercenaire français',
            'Jupiter',
            'Etats-Unis',
            'Assassinat',
            'En cours',
            Now(),
            Now(),
            1
        )";
    $con->exec($sql);

    $sql = "SET FOREIGN_KEY_CHECKS = 0";
    $con->exec($sql);
    $sql = "INSERT INTO Agents_has_Missions (mission_id, agent_id)
 VALUES ('1', '1')";
    $con->exec($sql);
    $sql = "INSERT INTO Contacts_has_Missions (mission_id, contact_id) 
 VALUES ('1', '1')";
    $con->exec($sql);
    $sql = "INSERT INTO Cibles_has_Missions (mission_id, cible_id) 
 VALUES ('1', '1')";
    $con->exec($sql);
    $sql = "SET FOREIGN_KEY_CHECKS = 1";
    $con->exec($sql);
    $con = null;

    $_SESSION['message'] = "Les données ont bien été ajoutées !"; //stocke le message dans une variable de session
    $_SESSION['message_type'] = "success"; //définit le type de message (success, info, warning, danger)
    header('Location: ../index.php');
    exit();
} else {
    $_SESSION['message'] = "Les données ont déjà été ajoutées !";
    $_SESSION['message_type'] = "danger";
    header('Location: ../index.php');
    exit();
}
