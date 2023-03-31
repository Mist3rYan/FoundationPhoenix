<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "phoenix_foundation";

// Create connection
try {
    $pdo = new PDO('mysql:host='.$host.';dbname='.$database.'', 'root', '');
} catch (PDOException $e) {
    file_put_contents('dblogs.log', $e->getMessage() . PHP_EOL, FILE_APPEND);
    echo 'Une erreur est survenue';
}
