<?php
declare(strict_types=1);

// Affichage des erreurs
ini_set('display_errors', '1');
error_reporting(E_ALL);

// Démarrage de la session
session_start();

// Définition du chemin de base
define('BASE_PATH', dirname(__DIR__));

// Autoload des classes
spl_autoload_register(function ($class) {
    $paths = [
        BASE_PATH . '/src/controllers/',
        BASE_PATH . '/src/models/',
        BASE_PATH . '/src/repositories/',
        BASE_PATH . '/src/core/',
        BASE_PATH . '/src/config/',
    ];

    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Initialisation de la base de données
require_once BASE_PATH . '/src/config/Database.php';
$db = Database::getInstance();

// Récupération de l'URI
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Si ton projet est dans : http://localhost/gestion-espace-pedagogique/public/
$uri = str_replace('/gestion-espace-pedagogique/public', '', $uri);

// Routes
if ($uri === '/formateurs/create') {
    require_once BASE_PATH . '/src/controllers/US21_CreateFormateurController.php';
    (new US21_CreateFormateurController())->create();
    exit;
}

// Ici tu peux ajouter d'autres routes, par exemple :
// if ($uri === '/autre/route') { ... }

// Route par défaut (404)
http_response_code(404);
echo "<h1>404 - Page non trouvée</h1>";
