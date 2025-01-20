<?php
// Configuration pour se connecter à la base de données
$host = '127.0.0.1';  // L'hôte de la base de données
$dbname = 'cloud_printing';  // Nom de la base de données
$user = 'root';  // Nom d'utilisateur
$password = '';  // Mot de passe

try {
    // Création de la connexion PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>
