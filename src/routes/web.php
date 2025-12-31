<?php

require_once __DIR__ . '/../controllers/US21_CreateFormateurController.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($uri === '/formateurs/create') {
    (new US21_CreateFormateurController())->create();
}
