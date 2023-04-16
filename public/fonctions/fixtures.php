<?php
session_start(); //démarre la session
require_once('../fonctions/installDatabase.php'); //charge la connexion à la base de données
require_once('../../vendor/autoload.php'); //charge les dépendances
require_once('../Models/agent.php'); //charge les fonctions liées aux agents
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


//Specialities
$speciality = new Speciality();
foreach ($specialities as $specialitie) {
    $speciality->setName($specialitie);
    // On insère les données dans la base de données
    $req = $dbco->prepare("INSERT INTO specialities (name) VALUES (?)");
    $req->execute(array(
        $speciality->getName()
    ));
}


//Agents
$agent = new Agent();

// On insère un agent manuellement pour faire un exemple mission
$agent->setCode("DXSID N°XC4479");
$agent->setName("MacGyver");
$agent->setFirstname("Angus");
$agent->setNationality('Etats-Unis');
$agent->setBirthdate("1951-03-23");
$agent->setSpeciality(["Renseignement","Diplomatie","Concentration","Securite"]);
$req = $dbco->prepare("INSERT INTO Agents (code, name, firstname, nationality, birthdate, speciality) VALUES (?,?,?,?,?,?)");
$req->execute(array(
    $agent->getCode(),
    $agent->getName(),
    $agent->getFirstname(),
    $agent->getNationality(),
    date($agent->getBirthdate()),
    json_encode($agent->getSpeciality())
));

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
    $req = $dbco->prepare("INSERT INTO Agents (code, name, firstname, nationality, birthdate, speciality) VALUES (?,?,?,?,?,?)");
    $req->execute(array(
        $agent->getCode(),
        $agent->getName(),
        $agent->getFirstname(),
        $agent->getNationality(),
        $agent->getBirthdate(),
        json_encode($agent->getSpeciality())
    ));
}

//Contacts
$contact = new User();
// On insère un contact manuellement pour faire un exemple mission
$contact->setCode("5s9578");
$contact->setName("Dalton");
$contact->setFirstname("Jack");
$contact->setNationality('Etats-Unis');
$contact->setBirthdate("1951-02-03");
$req = $dbco->prepare("INSERT INTO contacts (code, name, firstname, nationality, birthdate) VALUES (?,?,?,?,?)");
$req->execute(array(
    $contact->getCode(),
    $contact->getName(),
    $contact->getFirstname(),
    $contact->getNationality(),
    $contact->getBirthdate()
));

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
// On insère une cible manuellement pour faire un exemple mission
$target->setCode("Mercenaire N°XC4479");
$target->setName("Murdoc");
$target->setFirstname("Francis");
$target->setNationality('France');
$target->setBirthdate("2002-02-15");

$req = $dbco->prepare("INSERT INTO targets (code, name, firstname, nationality, birthdate) VALUES (?,?,?,?,?)");
$req->execute(array(
    $target->getCode(),
    $target->getName(),
    $target->getFirstname(),
    $target->getNationality(),
    $target->getBirthdate()
));

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
    $req = $dbco->prepare("INSERT INTO targets (code, name, firstname, nationality, birthdate) VALUES (?,?,?,?,?)");
    $req->execute(array(
        $target->getCode(),
        $target->getName(),
        $target->getFirstname(),
        $target->getNationality(),
        date($target->getBirthdate())
    ));
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
    $req = $dbco->prepare("INSERT INTO hideouts (code, address, country, type) VALUES (?,?,?,?)");
    $req->execute(array(
        $hideout->getCode(),
        $hideout->getAddress(),
        $hideout->getCountry(),
        $hideout->getType()
    ));
}
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
$dbco->exec($sql);

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
$dbco->exec($sql);

$missionID = 1;

$stmt = $dbco->prepare("INSERT INTO agents_has_missions (mission_id, agent_id) VALUES (?, ?)");
$stmt->execute([$missionID, 1]);
$stmt = $dbco->prepare("INSERT INTO contacts_has_missions (mission_id, contact_id) VALUES (?, ?)");
$stmt->execute([$missionID, 1]);
$stmt = $dbco->prepare("INSERT INTO cibles_has_missions (mission_id, cible_id) VALUES (?, ?)");
$stmt->execute([$missionID, 1]);



$_SESSION['message'] = "Les données ont bien été ajoutées !"; //stocke le message dans une variable de session
$_SESSION['message_type'] = "success"; //définit le type de message (success, info, warning, danger)

header('Location: ../index.php');
exit();
