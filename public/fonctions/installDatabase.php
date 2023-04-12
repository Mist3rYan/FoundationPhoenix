<?php
$servername = $_SESSION['DBHOST'];
$username = $_SESSION['DBUSER'];
$password = $_SESSION['PASSWORD'];
$dbname = $_SESSION['DBNAME'];

try {
    $dbco = new PDO("mysql:host=$servername", $username, $password);
    $dbco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "CREATE DATABASE IF NOT EXISTS phoenix_foundation CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci";

    if ($dbco->exec($sql)) {

        $dbco = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $dbco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "CREATE TABLE IF NOT EXISTS `Agents` (
                    `id` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
                    `code` VARCHAR (100) NOT NULL,
                    `name` VARCHAR (100) NOT NULL,
                    `firstname` VARCHAR (100) NOT NULL,
                    `nationality` VARCHAR (100) NOT NULL,
                    `speciality` VARCHAR (500) NOT NULL,
                    `birthdate` DATE NOT NULL
                ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci";
        $dbco->exec($sql);

        $sql = "CREATE TABLE IF NOT EXISTS `Contacts` (
                    `id` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
                    `code` VARCHAR (100) NOT NULL,
                    `name` VARCHAR (100) NOT NULL,
                    `firstname` VARCHAR (100) NOT NULL,
                    `nationality` VARCHAR (100) NOT NULL,
                    `birthdate` DATE NOT NULL
                ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci";
        $dbco->exec($sql);

        $sql = "CREATE TABLE IF NOT EXISTS `Targets` (
                    `id` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
                    `code` VARCHAR (100) NOT NULL,
                    `name` VARCHAR (100) NOT NULL,
                    `firstname` VARCHAR (100) NOT NULL,
                    `nationality` VARCHAR (100) NOT NULL,
                    `birthdate` DATE NOT NULL
                ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci";
        $dbco->exec($sql);

        $sql = "CREATE TABLE IF NOT EXISTS `Hideouts` (
                    `id` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
                    `code` VARCHAR (100) NOT NULL,
                    `address` TEXT NOT NULL,
                    `country` VARCHAR (100) NOT NULL,
                    `type` VARCHAR (100) NOT NULL
                ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci";
        $dbco->exec($sql);


        $sql = "CREATE TABLE IF NOT EXISTS `Specialities` (
                    `id` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
                    `name` VARCHAR (100) NOT NULL
                ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci";
        $dbco->exec($sql);
        
        $sql = "CREATE TABLE IF NOT EXISTS `Missions` (
            `id` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
            `titre` VARCHAR (100) NOT NULL,
            `description` TEXT NOT NULL,
            `nom_de_code` VARCHAR (100) NOT NULL,
            `country` VARCHAR (100) NOT NULL,
            `type_mission` VARCHAR (100) NOT NULL,
            `status` VARCHAR (100) NOT NULL,
            `date_debut` DATE NOT NULL,
            `date_fin` DATE,
            `specialitie_id` INTEGER NOT NULL,
            FOREIGN KEY (`specialitie_id`) REFERENCES `Specialities`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci";
        $dbco->exec($sql);

        $sql = "CREATE TABLE IF NOT EXISTS `Agents_has_Missions` (
            `agent_id` INT NOT NULL,
            `mission_id` INT NOT NULL,
            PRIMARY KEY (`agent_id`, `mission_id`),
            FOREIGN KEY (`agent_id`) REFERENCES `Agents`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
            FOREIGN KEY (`mission_id`) REFERENCES `Missions`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci";
        $dbco->exec($sql);

        $sql = "CREATE TABLE IF NOT EXISTS `Contacts_has_Missions` (
            `contact_id` INT NOT NULL,
            `mission_id` INT NOT NULL,
            PRIMARY KEY (`contact_id`, `mission_id`),
            FOREIGN KEY (`contact_id`) REFERENCES `Contacts`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
            FOREIGN KEY (`mission_id`) REFERENCES `Missions`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci";
        $dbco->exec($sql);

        $sql = "CREATE TABLE IF NOT EXISTS `Cibles_has_Missions` (
            `cible_id` INT NOT NULL,
            `mission_id` INT NOT NULL,
            PRIMARY KEY (`cible_id`, `mission_id`),
            FOREIGN KEY (`cible_id`) REFERENCES `Targets`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
            FOREIGN KEY (`mission_id`) REFERENCES `Missions`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci";
        $dbco->exec($sql);

        $sql = "CREATE TABLE IF NOT EXISTS `Hideouts_has_Missions` (
            `hideouts_id` INT NOT NULL,
            `mission_id` INT NOT NULL,
            PRIMARY KEY (`hideouts_id`, `mission_id`),
            FOREIGN KEY (`hideouts_id`) REFERENCES `Hideouts`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
            FOREIGN KEY (`mission_id`) REFERENCES `Missions`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci";
        $dbco->exec($sql);

        $sql = "CREATE TABLE IF NOT EXISTS `Users` (
                    `id` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
                    `name` VARCHAR (50) NOT NULL,
                    `firstname` VARCHAR (50) NOT NULL,
                    `email` VARCHAR (50) NOT NULL,
                    `password` VARCHAR (50) NOT NULL,
                    `createdAt` DATE NOT NULL
                ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci";
        $dbco->exec($sql);

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
    } else {
        $_SESSION['message'] = "Les fixtures ont déja été ajoutées"; //stocke le message dans une variable de session
        $_SESSION['message_type'] = "error"; //définit le type de message (success, info, warning, danger)
        header('Location: ../index.php');
        exit();
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
