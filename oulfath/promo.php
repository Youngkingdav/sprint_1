<?php
// db.php
// Configuration de la connexion PostgreSQL

$host = 'localhost';           // Adresse du serveur PostgreSQL
$port = 5432;                  // Port par défaut PostgreSQL
$dbname = 'system_evaluation_suivi'; // Nom de ta base de données
$user = 'postgres';            // Ton utilisateur PostgreSQL
$password = '6666'; // Remplace par le mot de passe correct

try {
    // DSN (Data Source Name)
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";

    // Création de la connexion PDO
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    // Arrêt du script si la connexion échoue
    die('Erreur de connexion à la base de données : ' . $e->getMessage());
}
