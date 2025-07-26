<?php
$host = '127.0.0.1'; // Essayez avec cette adresse IP au lieu de 'localhost'
$user = 'csa';
$password = '';
$database = 'ombriere';

// Afficher les erreurs PHP
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "Tentative de connexion à MySQL...<br>";

try {
    $conn = new mysqli($host, $user, $password, $database);

    if ($conn->connect_error) {
        die("Échec de la connexion : " . $conn->connect_error);
    }

    echo "Connexion réussie à la base de données !";
    $conn->close();
} catch (Exception $e) {
    echo "Exception : " . $e->getMessage();
}
