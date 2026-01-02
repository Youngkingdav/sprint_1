<?php

class EspaceRepository
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // Vérifier si un étudiant est déjà dans un espace
    public function isEtudiantInEspace($etudiantId, $espaceId)
    {
        $sql = "SELECT COUNT(*) FROM espace_etudiants 
                WHERE etudiant_id = ? AND espace_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$etudiantId, $espaceId]);
        return $stmt->fetchColumn() > 0;
    }

    // Ajouter un étudiant à un espace
    public function addEtudiantToEspace($etudiantId, $espaceId)
    {
        $sql = "INSERT INTO espace_etudiants (etudiant_id, espace_id, created_at) 
                VALUES (?, ?, NOW())";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$etudiantId, $espaceId]);
    }

    // Récupérer tous les espaces (simple)
    public function findAll()
    {
        $sql = "SELECT * FROM espaces_pedagogiques ORDER BY nom";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer tous les espaces avec matières et promotions (version avancée)
    public function findAllEspaces()
    {
        $sql = "
            SELECT 
                ep.id,
                ep.nom AS espace,
                m.nom AS matiere,
                p.libelle AS promotion,
                p.annee_academique
            FROM espaces_pedagogiques ep
            JOIN matieres m ON ep.matiere_id = m.id
            JOIN promotions p ON ep.promotion_id = p.id
            ORDER BY p.annee_academique DESC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer les étudiants d'une promotion
    public function findEtudiantsByPromotion($promotionId)
    {
        $sql = "SELECT e.* FROM etudiants e 
                WHERE e.promotion_id = ? 
                ORDER BY e.nom, e.prenom";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$promotionId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
