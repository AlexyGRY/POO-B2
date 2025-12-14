<?php
declare(strict_types=1);

class Movie {
    private PDO $db;
    private array $genres = ['Action','Comédie','Drame','Science-Fiction','Horreur','Thriller','Romance','Documentaire'];

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function findAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM movies ORDER BY titre ASC");
        return $stmt->fetchAll();
    }

    public function findOneById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM movies WHERE id=:id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $movie = $stmt->fetch();
        return $movie ?: null;
    }

    public function addMovie(array $data): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO movies (titre,realisateur,annee,genre,note,duree)
            VALUES (:titre,:realisateur,:annee,:genre,:note,:duree)
        ");
        $stmt->bindValue(':titre', $data['titre'], PDO::PARAM_STR);
        $stmt->bindValue(':realisateur', $data['realisateur'], PDO::PARAM_STR);
        $stmt->bindValue(':annee', $data['annee'], PDO::PARAM_INT);
        $stmt->bindValue(':genre', $data['genre'], PDO::PARAM_STR);
        $stmt->bindValue(':note', $data['note'] ?? null, PDO::PARAM_STR);
        $stmt->bindValue(':duree', $data['duree'] ?? null, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function updateMovie(int $id, array $data): bool
    {
        $stmt = $this->db->prepare("
            UPDATE movies
            SET titre=:titre,realisateur=:realisateur,annee=:annee,genre=:genre,note=:note,duree=:duree
            WHERE id=:id
        ");
        $stmt->bindValue(':titre', $data['titre'], PDO::PARAM_STR);
        $stmt->bindValue(':realisateur', $data['realisateur'], PDO::PARAM_STR);
        $stmt->bindValue(':annee', $data['annee'], PDO::PARAM_INT);
        $stmt->bindValue(':genre', $data['genre'], PDO::PARAM_STR);
        $stmt->bindValue(':note', $data['note'] ?? null, PDO::PARAM_STR);
        $stmt->bindValue(':duree', $data['duree'] ?? null, PDO::PARAM_INT);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function deleteMovie(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM movies WHERE id=:id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getAverage(): float
    {
        $stmt = $this->db->query("SELECT AVG(note) as avg_note FROM movies WHERE note IS NOT NULL");
        $result = $stmt->fetch();
        return round((float)($result['avg_note'] ?? 0),1);
    }

    public function isGenreValid(string $genre): bool
    {
        return in_array($genre, $this->genres);
    }
}
