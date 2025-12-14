<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../controllers/CategoryController.php';
require_once __DIR__ . '/../controllers/ArticleController.php';

$action = $_GET['action'] ?? 'home';

switch ($action) {
    // Categories
    case 'categories':
        (new CategoryController())->index();
        break;
    case 'category_create':
        (new CategoryController())->create();
        break;
    case 'category_edit':
        (new CategoryController())->edit();
        break;
    case 'category_delete':
        (new CategoryController())->delete();
        break;

    // Articles
    case 'articles':
        (new ArticleController())->index();
        break;
    case 'article_create':
        (new ArticleController())->create();
        break;
    case 'article_edit':
        (new ArticleController())->edit();
        break;
    case 'article_show':
        (new ArticleController())->show();
        break;
    case 'article_delete':
        (new ArticleController())->delete();
        break;

    default:
        header("Location: index.php?action=categories");
        exit;
}
