<?php
declare(strict_types=1);

class Category
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function findAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM categories ORDER BY nom ASC");
        return $stmt->fetchAll();
    }

    public function findOneById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE id=:id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch() ?: null;
    }

    public function addCategory(array $data): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO categories (nom, description, couleur)
            VALUES (:nom, :description, :couleur)
        ");
        $stmt->bindValue(':nom', $data['nom'], PDO::PARAM_STR);
        $stmt->bindValue(':description', $data['description'] ?? null, PDO::PARAM_STR);
        $stmt->bindValue(':couleur', $data['couleur'], PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function updateCategory(int $id, array $data): bool
    {
        $stmt = $this->db->prepare("
            UPDATE categories
            SET nom=:nom, description=:description, couleur=:couleur
            WHERE id=:id
        ");
        $stmt->bindValue(':nom', $data['nom'], PDO::PARAM_STR);
        $stmt->bindValue(':description', $data['description'] ?? null, PDO::PARAM_STR);
        $stmt->bindValue(':couleur', $data['couleur'], PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function deleteCategory(int $id): bool
    {
        // Vérifie qu'il n'y a pas d'articles liés
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM articles WHERE category_id=:id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        if ((int)$stmt->fetchColumn() > 0) {
            return false;
        }
        $stmt = $this->db->prepare("DELETE FROM categories WHERE id=:id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function isNameUnique(string $name, ?int $excludeId = null): bool
    {
        $query = "SELECT COUNT(*) FROM categories WHERE nom=:nom";
        if ($excludeId) $query .= " AND id != :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nom', $name, PDO::PARAM_STR);
        if ($excludeId) $stmt->bindValue(':id', $excludeId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() == 0;
    }

    public function countArticles(int $categoryId): int
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM articles WHERE category_id=:id");
        $stmt->bindValue(':id', $categoryId, PDO::PARAM_INT);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }
}
