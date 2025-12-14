<?php
declare(strict_types=1);

class MovieController {
    private Movie $movieModel;

    public function __construct()
    {
        $this->movieModel = new Movie();
    }

    public function index()
    {
        $movies = $this->movieModel->findAll();
        $average = $this->movieModel->getAverage();
        require __DIR__ . '/../views/movies/liste.php';
    }

    public function show()
    {
        $id = (int)($_GET['id'] ?? 0);
        if ($id <= 0) header('Location: index.php');

        $movie = $this->movieModel->findOneById($id);
        if (!$movie) header('Location: index.php');

        require __DIR__ . '/../views/movies/show.php';
    }

    public function create()
    {
        $errors = [];
        if ($_POST) {
            $titre = trim($_POST['titre'] ?? '');
            $realisateur = trim($_POST['realisateur'] ?? '');
            $annee = (int)($_POST['annee'] ?? 0);
            $genre = $_POST['genre'] ?? '';
            $note = $_POST['note'] ?? null;
            $duree = $_POST['duree'] ?? null;

            // validations
            if(strlen($titre) < 1 || strlen($titre) > 200) $errors[] = "Titre invalide (1-200 caractères)";
            if(strlen($realisateur) < 2 || strlen($realisateur) > 150) $errors[] = "Réalisateur invalide (2-150 caractères)";
            $yearMax = (int)date('Y') + 2;
            if($annee < 1888 || $annee > $yearMax) $errors[] = "Année invalide";
            if(!$this->movieModel->isGenreValid($genre)) $errors[] = "Genre invalide";
            if($note !== null && ($note < 0 || $note > 10)) $errors[] = "Note doit être entre 0 et 10";
            if($duree !== null && $duree <= 0) $errors[] = "Durée invalide";

            if(empty($errors)) {
                $this->movieModel->addMovie(compact('titre','realisateur','annee','genre','note','duree'));
                header('Location: index.php');
                exit;
            }
        }
        require __DIR__ . '/../views/movies/form.php';
    }

    public function edit()
    {
        $id = (int)($_GET['id'] ?? 0);
        if ($id <= 0) header('Location: index.php');

        $movie = $this->movieModel->findOneById($id);
        if (!$movie) header('Location: index.php');

        $errors = [];
        if ($_POST) {
            $titre = trim($_POST['titre'] ?? '');
            $realisateur = trim($_POST['realisateur'] ?? '');
            $annee = (int)($_POST['annee'] ?? 0);
            $genre = $_POST['genre'] ?? '';
            $note = $_POST['note'] ?? null;
            $duree = $_POST['duree'] ?? null;

            // validations
            if(strlen($titre) < 1 || strlen($titre) > 200) $errors[] = "Titre invalide (1-200 caractères)";
            if(strlen($realisateur) < 2 || strlen($realisateur) > 150) $errors[] = "Réalisateur invalide (2-150 caractères)";
            $yearMax = (int)date('Y') + 2;
            if($annee < 1888 || $annee > $yearMax) $errors[] = "Année invalide";
            if(!$this->movieModel->isGenreValid($genre)) $errors[] = "Genre invalide";
            if($note !== null && ($note < 0 || $note > 10)) $errors[] = "Note doit être entre 0 et 10";
            if($duree !== null && $duree <= 0) $errors[] = "Durée invalide";

            if(empty($errors)) {
                $this->movieModel->updateMovie($id, compact('titre','realisateur','annee','genre','note','duree'));
                header('Location: index.php');
                exit;
            }
        }
        require __DIR__ . '/../views/movies/form.php';
    }

    public function delete()
    {
        $id = (int)($_GET['id'] ?? 0);
        if($id > 0) $this->movieModel->deleteMovie($id);
        header('Location: index.php');
    }
}
