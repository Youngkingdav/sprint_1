<?php
declare(strict_types=1);

ini_set('display_errors', '1');
error_reporting(E_ALL);

session_start();

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

/**
 * Si ton projet est dans :
 * http://localhost/gestion-espace-pedagogique/public/
 */
$uri = str_replace('/gestion-espace-pedagogique/public', '', $uri);

/**
 * Route US 2.1
 */
if ($uri === '/formateurs/create') {
    require_once __DIR__ . '/../src/controllers/US21_CreateFormateurController.php';
    (new US21_CreateFormateurController())->create();
    exit;
}

/**
 * 404
 */
http_response_code(404);
echo "<h1>404 - Page non trouvée</h1>";
