<?php

require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../models/Formateur.php';

class FormateurRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function createUser(string $email, string $password): int
    {
        $stmt = $this->db->prepare("
            INSERT INTO users (email, password, role)
            VALUES (:email, :password, 'FORMATEUR')
        ");

        $stmt->execute([
            'email' => $email,
            'password' => password_hash($password, PASSWORD_BCRYPT)
        ]);

        return (int)$this->db->lastInsertId();
    }

    public function create(Formateur $formateur): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO formateurs (user_id, nom, prenom, specialite, telephone)
            VALUES (:user_id, :nom, :prenom, :specialite, :telephone)
        ");

        return $stmt->execute([
            'user_id' => $formateur->user_id,
            'nom' => $formateur->nom,
            'prenom' => $formateur->prenom,
            'specialite' => $formateur->specialite,
            'telephone' => $formateur->telephone
        ]);
    }
}
