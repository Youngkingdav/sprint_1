<?php
// db.php
$host = 'localhost';
$port = 5432;
$dbname = 'system_evaluation_suivi';
$user = 'prosqres';      // à adapter
$password = '6666';  // à adapter

$dsn = "pgsql:host=$host;port=$port;dbname=$dbname";

try {
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die('Erreur de connexion : ' . $e->getMessage());
}
