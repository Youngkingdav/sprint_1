<?php
// ============================================
// FICHIER : US33_AddEtudiantEspaceController.php
// BUT : Gère la logique de l'US33
// ============================================

class US33_AddEtudiantEspaceController {
    
    // Données fictives pour la simulation
    private $promotions = [
        ['id' => 1, 'nom' => 'Promotion 2024 - Informatique'],
        ['id' => 2, 'nom' => 'Promotion 2025 - Marketing'],
        ['id' => 3, 'nom' => 'Promotion 2024 - Gestion']
    ];
    
    private $espaces = [
        ['id' => 1, 'nom' => 'Espace Algorithmique', 'matiere' => 'Algo'],
        ['id' => 2, 'nom' => 'Espace Base de données', 'matiere' => 'BDD'],
        ['id' => 3, 'nom' => 'Espace Développement Web', 'matiere' => 'Web']
    ];
    
    private $etudiantsParPromotion = [
        1 => [ // Promotion 1
            ['id' => 101, 'nom' => 'DUPONT', 'prenom' => 'Jean'],
            ['id' => 102, 'nom' => 'MARTIN', 'prenom' => 'Marie'],
            ['id' => 103, 'nom' => 'BERNARD', 'prenom' => 'Pierre']
        ],
        2 => [ // Promotion 2
            ['id' => 201, 'nom' => 'THOMAS', 'prenom' => 'Sophie'],
            ['id' => 202, 'nom' => 'PETIT', 'prenom' => 'Luc']
        ],
        3 => [ // Promotion 3
            ['id' => 301, 'nom' => 'ROBERT', 'prenom' => 'Julie'],
            ['id' => 302, 'nom' => 'RICHARD', 'prenom' => 'Thomas'],
            ['id' => 303, 'nom' => 'DURAND', 'prenom' => 'Laura']
        ]
    ];
    
    // Simulation : étudiants déjà dans des espaces
    private $dejaAjoutes = [
        '101_1' => true, // Jean DUPONT dans Espace Algorithmique
        '102_2' => true  // Marie MARTIN dans Espace Base de données
    ];
    
    /**
     * Affiche le formulaire d'ajout
     */
    public function showForm() {
        // Données à passer à la vue
        $data = [
            'promotions' => $this->promotions,
            'espaces' => $this->espaces
        ];
        
        // Charger la vue
        require_once __DIR__ . '/../../views/us33/form.php';
    }
    
    /**
     * Traite la soumission du formulaire
     */
    public function handleSubmit() {
        // Vérifier que c'est bien une requête POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: us33_test.php?action=showForm');
            exit;
        }
        
        // Récupérer les données du formulaire
        $etudiantId = $_POST['etudiant_id'] ?? '';
        $espaceId = $_POST['espace_id'] ?? '';
        
        // Validation basique
        if (empty($etudiantId) || empty($espaceId)) {
            $_SESSION['us33_message'] = 'Erreur : Tous les champs sont obligatoires';
            $_SESSION['us33_message_type'] = 'error';
            header('Location: us33_test.php?action=showForm');
            exit;
        }
        
        // Vérifier si l'étudiant est déjà dans cet espace (simulation)
        $cle = $etudiantId . '_' . $espaceId;
        
        if (isset($this->dejaAjoutes[$cle])) {
            // CAS DÉFAVORABLE : déjà ajouté
            $_SESSION['us33_message'] = 'ERREUR : Cet étudiant est déjà inscrit dans cet espace pédagogique';
            $_SESSION['us33_message_type'] = 'error';
        } else {
            // CAS FAVORABLE : ajout réussi
            $_SESSION['us33_message'] = 'SUCCÈS : Étudiant ajouté avec succès à l\'espace pédagogique';
            $_SESSION['us33_message_type'] = 'success';
            
            // Simulation : marquer comme ajouté pour les prochaines fois
            // $this->dejaAjoutes[$cle] = true; // À décommenter pour simuler l'ajout réel
        }
        
        // Rediriger vers le formulaire
        header('Location: us33_test.php?action=showForm');
        exit;
    }
    
    /**
     * Retourne les étudiants d'une promotion (pour AJAX)
     */
    public function getEtudiants() {
        $promotionId = $_GET['promotion_id'] ?? 0;
        
        // Vérifier si la promotion existe
        if ($promotionId > 0 && isset($this->etudiantsParPromotion[$promotionId])) {
            $etudiants = $this->etudiantsParPromotion[$promotionId];
        } else {
            $etudiants = [];
        }
        
        // Retourner en JSON
        header('Content-Type: application/json');
        echo json_encode($etudiants);
        exit;
    }
    
    /**
     * Page d'accueil de test
     */
    public function showHome() {
        echo '<!DOCTYPE html>
        <html>
        <head>
            <title>Test US33</title>
            <style>
                body { font-family: Arial; padding: 20px; }
                .card { 
                    background: #f5f5f5; 
                    padding: 20px; 
                    margin: 20px 0;
                    border-radius: 10px;
                }
                .btn {
                    display: inline-block;
                    background: #007bff;
                    color: white;
                    padding: 10px 20px;
                    text-decoration: none;
                    border-radius: 5px;
                }
            </style>
        </head>
        <body>
            <h1>🌐 Test de l\'US33</h1>
            <div class="card">
                <h2>User Story 33</h2>
                <p><strong>En tant que</strong> directeur</p>
                <p><strong>Je souhaite</strong> ajouter un étudiant d\'une promotion donnée dans un espace pédagogique</p>
                <p><strong>Afin de</strong> lui donner des travaux assignés</p>
                <br>
                <a href="us33_test.php?action=showForm" class="btn">🚀 Tester le formulaire</a>
            </div>
        </body>
        </html>';
    }
}
?>