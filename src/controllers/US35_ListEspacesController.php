<?php
class US35_ListEspacesController {

    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function index() {
        $query = "
            SELECT 
                e.id,
                m.nom AS matiere,
                p.libelle AS promotion,
                p.annee_academique
            FROM espaces_pedagogiques e
            JOIN matieres m ON e.matiere_id = m.id
            JOIN promotions p ON e.promotion_id = p.id
            ORDER BY e.id
        ";

        try {
            $stmt = $this->pdo->query($query);
            $espaces = $stmt->fetchAll(PDO::FETCH_ASSOC);

            require __DIR__ . '/../views/us35.php'; // affiche ta vue
        } catch (PDOException $e) {
            die("Erreur SQL : " . $e->getMessage());
        }
    }
}
