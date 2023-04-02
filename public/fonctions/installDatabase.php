<?php


$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'phoenix_foundation';
try {
    $dbco = new PDO("mysql:host=$servername", $username, $password);
    $dbco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "CREATE DATABASE IF NOT EXISTS phoenix_foundation CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci";
    if ($dbco->exec($sql)) {
        $dbco = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $dbco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "CREATE TABLE IF NOT EXISTS `Agents` (
                    `id` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
                    `code` VARCHAR (50) NOT NULL,
                    `name` VARCHAR (50) NOT NULL,
                    `firstname` VARCHAR (50) NOT NULL,
                    `nationality` VARCHAR (50) NOT NULL,
                    `speciality` VARCHAR (500) NOT NULL,
                    `birthdate` DATE NOT NULL
                ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci";
        $dbco->exec($sql);

        $sql = "CREATE TABLE IF NOT EXISTS `Contacts` (
                    `id` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
                    `code` VARCHAR (50) NOT NULL,
                    `name` VARCHAR (50) NOT NULL,
                    `firstname` VARCHAR (50) NOT NULL,
                    `nationality` VARCHAR (50) NOT NULL,
                    `birthdate` DATE NOT NULL
                ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci";
        $dbco->exec($sql);

        $sql = "CREATE TABLE IF NOT EXISTS `Targets` (
                    `id` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
                    `code` VARCHAR (50) NOT NULL,
                    `name` VARCHAR (50) NOT NULL,
                    `firstname` VARCHAR (50) NOT NULL,
                    `nationality` VARCHAR (50) NOT NULL,
                    `birthdate` DATE NOT NULL
                ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci";
        $dbco->exec($sql);

        $sql = "CREATE TABLE IF NOT EXISTS `Hideouts` (
                    `id` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
                    `code` VARCHAR (50) NOT NULL,
                    `address` TEXT NOT NULL,
                    `country` VARCHAR (50) NOT NULL,
                    `type` VARCHAR (50) NOT NULL
                ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci";
        $dbco->exec($sql);


        $sql = "CREATE TABLE IF NOT EXISTS `Specialities` (
                    `id` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
                    `name` VARCHAR (50) NOT NULL
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
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
