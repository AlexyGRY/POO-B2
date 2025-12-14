<?php
declare(strict_types=1);

class Student {
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function findAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM students ORDER BY nom ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findOneById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM students WHERE id=:id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $student = $stmt->fetch(PDO::FETCH_ASSOC);
        return $student ?: null;
    }

    public function addStudent(array $data): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO students (nom, prenom, email, note, matiere, appreciation)
            VALUES (:nom, :prenom, :email, :note, :matiere, :appreciation)
        ");
        $stmt->bindValue(':nom', $data['nom'], PDO::PARAM_STR);
        $stmt->bindValue(':prenom', $data['prenom'], PDO::PARAM_STR);
        $stmt->bindValue(':email', $data['email'], PDO::PARAM_STR);
        $stmt->bindValue(':note', $data['note'] ?? null, PDO::PARAM_STR);
        $stmt->bindValue(':matiere', $data['matiere'], PDO::PARAM_STR);
        $stmt->bindValue(':appreciation', $data['appreciation'], PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function updateStudent(int $id, array $data): bool
    {
        $stmt = $this->db->prepare("
            UPDATE students
            SET nom=:nom, prenom=:prenom, email=:email, note=:note, matiere=:matiere, appreciation=:appreciation
            WHERE id=:id
        ");
        $stmt->bindValue(':nom', $data['nom'], PDO::PARAM_STR);
        $stmt->bindValue(':prenom', $data['prenom'], PDO::PARAM_STR);
        $stmt->bindValue(':email', $data['email'], PDO::PARAM_STR);
        $stmt->bindValue(':note', $data['note'] ?? null, PDO::PARAM_STR);
        $stmt->bindValue(':matiere', $data['matiere'], PDO::PARAM_STR);
        $stmt->bindValue(':appreciation', $data['appreciation'], PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function deleteStudent(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM students WHERE id=:id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function isEmailUnique(string $email, ?int $excludeId = null): bool
    {
        $query = "SELECT COUNT(*) FROM students WHERE email=:email";
        if ($excludeId) $query .= " AND id != :id";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        if ($excludeId) $stmt->bindValue(':id', $excludeId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchColumn() == 0;
    }

    public function getAverage(): float
    {
        $stmt = $this->db->query("SELECT AVG(note) as avg_note FROM students WHERE note IS NOT NULL");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return round((float)($result['avg_note'] ?? 0), 2);
    }
}
