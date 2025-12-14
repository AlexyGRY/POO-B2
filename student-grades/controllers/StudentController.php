<?php
declare(strict_types=1);

class StudentController {
    private $studentModel;

    public function __construct()
    {
        $this->studentModel = new Student();
    }

    public function index()
    {
        $students = $this->studentModel->findAll();
        $average = $this->studentModel->getAverage();
        require_once __DIR__ . '/../views/students/liste.php';
    }

    public function show()
    {
        $id = (int)($_GET['id'] ?? 0);
        if ($id <= 0) header('Location: index.php');

        $student = $this->studentModel->findOneById($id);
        if (!$student) header('Location: index.php');

        require_once __DIR__ . '/../views/students/show.php';
    }

    public function create()
    {
        $errors = [];
        if ($_POST) {
            $nom = trim($_POST['nom'] ?? '');
            $prenom = trim($_POST['prenom'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $note = $_POST['note'] ?? null;
            $matiere = trim($_POST['matiere'] ?? '');
            $appreciation = $_POST['appreciation'] ?? 'Assez bien';

            if (strlen($nom) < 2) $errors[] = "Nom invalide (min 2 caractères)";
            if (strlen($prenom) < 2) $errors[] = "Prénom invalide (min 2 caractères)";
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Email invalide";
            if (!$this->studentModel->isEmailUnique($email)) $errors[] = "Email déjà utilisé";
            if ($matiere === '') $errors[] = "Matière obligatoire";
            if ($note !== null && ($note < 0 || $note > 20)) $errors[] = "Note doit être entre 0 et 20";

            if (empty($errors)) {
                $this->studentModel->addStudent([
                    'nom'=>$nom,
                    'prenom'=>$prenom,
                    'email'=>$email,
                    'note'=>$note,
                    'matiere'=>$matiere,
                    'appreciation'=>$appreciation
                ]);
                header('Location: index.php');
                exit;
            }
        }

        require_once __DIR__ . '/../views/students/form.php';
    }

    public function edit()
    {
        $id = (int)($_GET['id'] ?? 0);
        if ($id <= 0) header('Location: index.php');

        $student = $this->studentModel->findOneById($id);
        if (!$student) header('Location: index.php');

        $errors = [];
        if ($_POST) {
            $nom = trim($_POST['nom'] ?? '');
            $prenom = trim($_POST['prenom'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $note = $_POST['note'] ?? null;
            $matiere = trim($_POST['matiere'] ?? '');
            $appreciation = $_POST['appreciation'] ?? 'Assez bien';

            if (strlen($nom) < 2) $errors[] = "Nom invalide (min 2 caractères)";
            if (strlen($prenom) < 2) $errors[] = "Prénom invalide (min 2 caractères)";
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Email invalide";
            if (!$this->studentModel->isEmailUnique($email, $id)) $errors[] = "Email déjà utilisé";
            if ($matiere === '') $errors[] = "Matière obligatoire";
            if ($note !== null && ($note < 0 || $note > 20)) $errors[] = "Note doit être entre 0 et 20";

            if (empty($errors)) {
                $this->studentModel->updateStudent($id, [
                    'nom'=>$nom,
                    'prenom'=>$prenom,
                    'email'=>$email,
                    'note'=>$note,
                    'matiere'=>$matiere,
                    'appreciation'=>$appreciation
                ]);
                header('Location: index.php');
                exit;
            }
        }

        require_once __DIR__ . '/../views/students/form.php';
    }

    public function delete()
    {
        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0) {
            $this->studentModel->deleteStudent($id);
        }
        header('Location: index.php');
    }
}
