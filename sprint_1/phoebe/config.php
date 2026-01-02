<?php
$host = 'localhost'; $port = '5432'; $dbname = 'system_evaluation_suivi';
$user = 'postgres'; $password = 'test123'; // Change ton mot de passe PostgreSQL

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) { die("Erreur DB: " . $e->getMessage()); }
?>
