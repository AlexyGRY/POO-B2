<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../controllers/StudentController.php';
require_once __DIR__ . '/../models/Student.php';

$controller = new StudentController();
$action = $_GET['action'] ?? 'index';

match ($action) {
    'index' => $controller->index(),
    'show' => $controller->show(),
    'create' => $controller->create(),
    'edit' => $controller->edit(),
    'delete' => $controller->delete(),
    default => $controller->index()
};
