<?php
// Afficher toutes les erreurs
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<h2>Test de connexion MySQL</h2>";

// Tentative avec localhost
echo "<h3>Test avec 'localhost'</h3>";
try {
    $conn1 = new mysqli('localhost', 'csa', '', 'ombriere');
    if ($conn1->connect_error) {
        echo "Erreur avec localhost: " . $conn1->connect_error;
    } else {
        echo "Connexion réussie avec localhost!";
        $conn1->close();
    }
} catch (Exception $e) {
    echo "Exception avec localhost: " . $e->getMessage();
}

echo "<hr>";

// Tentative avec 127.0.0.1
echo "<h3>Test avec '127.0.0.1'</h3>";
try {
    $conn2 = new mysqli('127.0.0.1', 'csa', '', 'ombriere');
    if ($conn2->connect_error) {
        echo "Erreur avec 127.0.0.1: " . $conn2->connect_error;
    } else {
        echo "Connexion réussie avec 127.0.0.1!";
        $conn2->close();
    }
} catch (Exception $e) {
    echo "Exception avec 127.0.0.1: " . $e->getMessage();
}

echo "<hr>";

// Tentative avec l'utilisateur root
echo "<h3>Test avec utilisateur 'root'</h3>";
try {
    $conn3 = new mysqli('localhost', 'root', '', 'ombriere');
    if ($conn3->connect_error) {
        echo "Erreur avec root: " . $conn3->connect_error;
    } else {
        echo "Connexion réussie avec root!";
        $conn3->close();
    }
} catch (Exception $e) {
    echo "Exception avec root: " . $e->getMessage();
}

// Informations sur la configuration PHP
echo "<hr><h3>Informations PHP</h3>";
echo "Version PHP: " . phpversion() . "<br>";
echo "Extensions chargées: <br>";
$extensions = get_loaded_extensions();
foreach ($extensions as $extension) {
    if ($extension == 'mysqli' || $extension == 'mysql' || $extension == 'pdo_mysql') {
        echo "- $extension <b>(MySQL)</b><br>";
    }
}
