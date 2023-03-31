CREATE DATABASE IF NOT EXISTS phoenix_foundation CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

USE phoenix_foundation;

CREATE TABLE IF NOT EXISTS `Agents` (
    `id` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `code` VARCHAR (50) NOT NULL,
    `name` VARCHAR (50) NOT NULL,
    `firstname` VARCHAR (50) NOT NULL,
    `nationality` VARCHAR (50) NOT NULL,
    `speciality` VARCHAR (50) NOT NULL,
    `birthdate` DATE NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `Contacts` (
    `id` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `code` VARCHAR (50) NOT NULL,
    `name` VARCHAR (50) NOT NULL,
    `firstname` VARCHAR (50) NOT NULL,
    `nationality` VARCHAR (50) NOT NULL,
    `speciality` VARCHAR (50) NOT NULL,
    `birthdate` DATE NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `Targets` (
    `id` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `code` VARCHAR (50) NOT NULL,
    `name` VARCHAR (50) NOT NULL,
    `firstname` VARCHAR (50) NOT NULL,
    `nationality` VARCHAR (50) NOT NULL,
    `speciality` VARCHAR (50) NOT NULL,
    `birthdate` DATE NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `Hideouts` (
    `id` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `code` VARCHAR (50) NOT NULL,
    `address` TEXT NOT NULL,
    `country` VARCHAR (50) NOT NULL,
    `type` VARCHAR (50) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `Specialities` (
    `id` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `name` VARCHAR (50) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `Users` (
    `id` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `name` VARCHAR (50) NOT NULL,
    `firstname` VARCHAR (50) NOT NULL,
    `email` VARCHAR (50) NOT NULL,
    `password` VARCHAR (50) NOT NULL,
    `createdAt` DATE NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

insert into
    Users (name, firstname, email, password, createdAt)
values
    (
        "Thornton",
        "Peter",
        "peter.thornton@foundationphoenix.org",
        "$2y$10$RQRSX2cYvxDxCcK.5V0FmeOeT5zT3qG02vA8oNshpiPkEh9IGKt4m",
        Now()
    );

/* CREATE TABLE IF NOT EXISTS `Missions` (
    `id` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `title` VARCHAR (50) NOT NULL,
    `codeName` VARCHAR (50) NOT NULL,
    `description` TEXT NOT NULL,
    `country` VARCHAR (50) NOT NULL,
    `type` VARCHAR (50) NOT NULL,
    `status` VARCHAR (50) NOT NULL,
    `startDate` DATE NOT NULL,
    `endDate` DATE NOT NULL,
    `specialityId` INTEGER NOT NULL,
    `agentId` VARCHAR (200),
    `targetId` VARCHAR (200),
    `hideoutId` VARCHAR (200),
    `contactId` VARCHAR (200),
    CONSTRAINT FOREIGN KEY (specialityId) REFERENCES Specialities(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT FOREIGN KEY (agentId) REFERENCES Agents(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT FOREIGN KEY (targetId) REFERENCES Targets(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT FOREIGN KEY (hideoutId) REFERENCES Hideouts(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT FOREIGN KEY (contactId) REFERENCES Contacts(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci; */