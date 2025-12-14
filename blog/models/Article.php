<?php
declare(strict_types=1);

class Article
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function findAll(): array
    {
        $stmt = $this->db->query("
            SELECT a.*, c.nom AS category_name, c.couleur AS category_color
            FROM articles a
            JOIN categories c ON a.category_id = c.id
            ORDER BY a.created_at DESC
        ");
        return $stmt->fetchAll();
    }

    public function findOneById(int $id): ?array
    {
        $stmt = $this->db->prepare("
            SELECT a.*, c.nom AS category_name, c.couleur AS category_color
            FROM articles a
            JOIN categories c ON a.category_id = c.id
            WHERE a.id = :id
        ");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch() ?: null;
    }

    public function addArticle(array $data): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO articles (titre, contenu, auteur, category_id, statut, date_publication)
            VALUES (:titre, :contenu, :auteur, :category_id, :statut, :date_publication)
        ");
        $stmt->bindValue(':titre', $data['titre'], PDO::PARAM_STR);
        $stmt->bindValue(':contenu', $data['contenu'], PDO::PARAM_STR);
        $stmt->bindValue(':auteur', $data['auteur'], PDO::PARAM_STR);
        $stmt->bindValue(':category_id', $data['category_id'], PDO::PARAM_INT);
        $stmt->bindValue(':statut', $data['statut'], PDO::PARAM_STR);
        $stmt->bindValue(':date_publication', $data['date_publication'] ?: null, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function updateArticle(int $id, array $data): bool
    {
        $stmt = $this->db->prepare("
            UPDATE articles
            SET titre=:titre, contenu=:contenu, auteur=:auteur, category_id=:category_id, statut=:statut, date_publication=:date_publication
            WHERE id=:id
        ");
        $stmt->bindValue(':titre', $data['titre'], PDO::PARAM_STR);
        $stmt->bindValue(':contenu', $data['contenu'], PDO::PARAM_STR);
        $stmt->bindValue(':auteur', $data['auteur'], PDO::PARAM_STR);
        $stmt->bindValue(':category_id', $data['category_id'], PDO::PARAM_INT);
        $stmt->bindValue(':statut', $data['statut'], PDO::PARAM_STR);
        $stmt->bindValue(':date_publication', $data['date_publication'] ?: null, PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function deleteArticle(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM articles WHERE id=:id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function countByStatus(string $status): int
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM articles WHERE statut=:statut");
        $stmt->bindValue(':statut', $status, PDO::PARAM_STR);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    public function countAll(): int
    {
        $stmt = $this->db->query("SELECT COUNT(*) FROM articles");
        return (int)$stmt->fetchColumn();
    }
}
