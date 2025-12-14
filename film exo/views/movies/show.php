<?php
$title = "Détails du film";
ob_start();
?>

<h1>Détails du film</h1>

<p><strong>Titre :</strong> <?= htmlspecialchars($movie['titre']) ?></p>
<p><strong>Réalisateur :</strong> <?= htmlspecialchars($movie['realisateur']) ?></p>
<p><strong>Année :</strong> <?= $movie['annee'] ?></p>
<p><strong>Genre :</strong> <span class="badge badge-genre-<?= strtolower(str_replace([' ','-'],'',$movie['genre'])) ?>"><?= htmlspecialchars($movie['genre']) ?></span></p>
<p><strong>Note :</strong> <?= $movie['note'] !== null ? $movie['note'] : '-' ?>/10</p>
<p><strong>Durée :</strong> <?= $movie['duree'] !== null ? $movie['duree'].' min' : '-' ?></p>
<p><strong>Ajouté le :</strong> <?= date('d/m/Y à H:i', strtotime($movie['created_at'])) ?></p>

<div class="detail-actions">
    <a href="index.php?action=edit&id=<?= $movie['id'] ?>" class="btn btn-warning"><i class="fas fa-edit"></i> Modifier</a>
    <a href="index.php?action=delete&id=<?= $movie['id'] ?>" class="btn btn-danger" onclick="return confirm('Voulez-vous vraiment supprimer ce film ?')"><i class="fas fa-trash"></i> Supprimer</a>
    <a href="index.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Retour à la liste</a>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
