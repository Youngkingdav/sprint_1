<<<<<<< Updated upstream
<<<<<<< HEAD
<?php

require_once __DIR__ . '/../controllers/US21_CreateFormateurController.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($uri === '/formateurs/create') {
    (new US21_CreateFormateurController())->create();
}
=======
// routes/web.php - Ajouter ces routes

// US33 - Ajouter un étudiant à un espace pédagogique
$router->add('GET', '/us33/add', function() {
    $controller = new US33_AddEtudiantEspaceController();
    $controller->showAddForm();
});

$router->add('POST', '/us33/handle-add', function() {
    $controller = new US33_AddEtudiantEspaceController();
    $controller->handleAdd();
});

$router->add('GET', '/us33/get-etudiants', function() {
    $controller = new US33_AddEtudiantEspaceController();
    $controller->getEtudiantsByPromotion();
});
>>>>>>> 7172c3dfd5c16980dd5946d9229f52f9b72184a4
=======
<?php
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../controllers/US35_ListEspacesController.php';

$page = $_GET['page'] ?? 'home';

switch ($page) {
    case 'espaces':
        $pdo = Database::getInstance(); // récupère l’objet PDO
        $controller = new US35_ListEspacesController($pdo);
        $controller->index();
        break;

    case 'home':
    default:
        echo "Page d'accueil";
        break;
}
>>>>>>> Stashed changes
