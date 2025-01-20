<?php
// db.php
$host = 'localhost'; // Adresse du serveur MySQL
$dbname = 'cloud_printing'; // Nom de la base de données
$username = 'root'; // Ton nom d'utilisateur MySQL
$password = ''; // Ton mot de passe MySQL

try {
    // Création de la connexion PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Configuration du mode d'erreur PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Gestion de l'erreur de connexion
    die("Erreur de connexion : " . $e->getMessage());
}
?>
