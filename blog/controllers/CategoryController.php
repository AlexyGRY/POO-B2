<?php
declare(strict_types=1);

require_once __DIR__ . '/../models/Category.php';

class CategoryController
{
    private Category $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new Category();
    }

    public function index(): void
    {
        $categories = $this->categoryModel->findAll();
        require __DIR__ . '/../views/categories/list.php';
    }

    public function create(): void
    {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['nom']);
            $description = trim($_POST['description'] ?? '');
            $color = $_POST['couleur'];

            if (strlen($name) < 2 || strlen($name) > 100) $errors[] = "Le nom doit contenir entre 2 et 100 caractères.";
            if (!$this->categoryModel->isNameUnique($name)) $errors[] = "Ce nom de catégorie existe déjà.";
            if (!preg_match('/^#[0-9A-Fa-f]{6}$/', $color)) $errors[] = "Couleur invalide.";

            if (empty($errors)) {
                $this->categoryModel->addCategory([
                    'nom' => $name,
                    'description' => $description,
                    'couleur' => $color
                ]);
                header("Location: index.php?action=categories");
                exit;
            }
        }
        require __DIR__ . '/../views/categories/form.php';
    }

    public function edit(): void
    {
        $errors = [];
        $id = (int)($_GET['id'] ?? 0);
        $category = $this->categoryModel->findOneById($id);
        if (!$category) {
            header("Location: index.php?action=categories");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['nom']);
            $description = trim($_POST['description'] ?? '');
            $color = $_POST['couleur'];

            if (strlen($name) < 2 || strlen($name) > 100) $errors[] = "Le nom doit contenir entre 2 et 100 caractères.";
            if (!$this->categoryModel->isNameUnique($name, $id)) $errors[] = "Ce nom de catégorie existe déjà.";
            if (!preg_match('/^#[0-9A-Fa-f]{6}$/', $color)) $errors[] = "Couleur invalide.";

            if (empty($errors)) {
                $this->categoryModel->updateCategory($id, [
                    'nom' => $name,
                    'description' => $description,
                    'couleur' => $color
                ]);
                header("Location: index.php?action=categories");
                exit;
            }
        }
        require __DIR__ . '/../views/categories/form.php';
    }

    public function delete(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        if (!$this->categoryModel->deleteCategory($id)) {
            $errorMessage = "Impossible de supprimer cette catégorie car des articles y sont associés.";
        }
        header("Location: index.php?action=categories");
        exit;
    }
}
