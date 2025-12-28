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