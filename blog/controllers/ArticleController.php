<?php
declare(strict_types=1);

require_once __DIR__ . '/../models/Article.php';
require_once __DIR__ . '/../models/Category.php';

class ArticleController
{
    private Article $articleModel;
    private Category $categoryModel;

    public function __construct()
    {
        $this->articleModel = new Article();
        $this->categoryModel = new Category();
    }

    public function index(): void
    {
        $articles = $this->articleModel->findAll();
        require __DIR__ . '/../views/articles/list.php';
    }

    public function show(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $article = $this->articleModel->findOneById($id);
        if (!$article) header("Location: index.php?action=articles");
        require __DIR__ . '/../views/articles/show.php';
    }

    public function create(): void
    {
        $errors = [];
        $categories = $this->categoryModel->findAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titre = trim($_POST['titre']);
            $contenu = trim($_POST['contenu']);
            $auteur = trim($_POST['auteur']);
            $category_id = (int)$_POST['category_id'];
            $statut = $_POST['statut'];
            $date_publication = $_POST['date_publication'] ?: null;

            if (strlen($titre) < 3 || strlen($titre) > 200) $errors[] = "Titre invalide.";
            if (strlen($contenu) < 10) $errors[] = "Contenu invalide.";
            if (strlen($auteur) < 2 || strlen($auteur) > 100) $errors[] = "Auteur invalide.";
            if (!$this->categoryModel->findOneById($category_id)) $errors[] = "Catégorie invalide.";
            if (!in_array($statut, ['Brouillon','Publié','Archivé'])) $errors[] = "Statut invalide.";

            if (empty($errors)) {
                $this->articleModel->addArticle([
                    'titre' => $titre,
                    'contenu' => $contenu,
                    'auteur' => $auteur,
                    'category_id' => $category_id,
                    'statut' => $statut,
                    'date_publication' => $date_publication
                ]);
                header("Location: index.php?action=articles");
                exit;
            }
        }

        require __DIR__ . '/../views/articles/form.php';
    }

    public function edit(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $article = $this->articleModel->findOneById($id);
        if (!$article) header("Location: index.php?action=articles");

        $errors = [];
        $categories = $this->categoryModel->findAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titre = trim($_POST['titre']);
            $contenu = trim($_POST['contenu']);
            $auteur = trim($_POST['auteur']);
            $category_id = (int)$_POST['category_id'];
            $statut = $_POST['statut'];
            $date_publication = $_POST['date_publication'] ?: null;

            if (strlen($titre) < 3 || strlen($titre) > 200) $errors[] = "Titre invalide.";
            if (strlen($contenu) < 10) $errors[] = "Contenu invalide.";
            if (strlen($auteur) < 2 || strlen($auteur) > 100) $errors[] = "Auteur invalide.";
            if (!$this->categoryModel->findOneById($category_id)) $errors[] = "Catégorie invalide.";
            if (!in_array($statut, ['Brouillon','Publié','Archivé'])) $errors[] = "Statut invalide.";

            if (empty($errors)) {
                $this->articleModel->updateArticle($id, [
                    'titre' => $titre,
                    'contenu' => $contenu,
                    'auteur' => $auteur,
                    'category_id' => $category_id,
                    'statut' => $statut,
                    'date_publication' => $date_publication
                ]);
                header("Location: index.php?action=articles");
                exit;
            }
        }

        require __DIR__ . '/../views/articles/form.php';
    }

    public function delete(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $this->articleModel->deleteArticle($id);
        header("Location: index.php?action=articles");
        exit;
    }
}
