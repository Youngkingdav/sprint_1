<?php
// ============================================
// FICHIER : us33_test.php
// BUT : Point d'entrée pour tester l'US33 seul
// ============================================

// Démarrer la session pour les messages
session_start();

// Inclure le controller
require_once __DIR__ . '/src/controllers/US33_AddEtudiantEspaceController.php';

// Créer l'instance du controller
$controller = new US33_AddEtudiantEspaceController();

// Déterminer l'action demandée
$action = $_GET['action'] ?? 'home';

// Router simple
switch ($action) {
    case 'showForm':
        $controller->showForm();
        break;
        
    case 'handleSubmit':
        $controller->handleSubmit();
        break;
        
    case 'getEtudiants':
        $controller->getEtudiants();
        break;
        
    case 'home':
    default:
        $controller->showHome();
        break;
}