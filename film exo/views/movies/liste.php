<?php
$title = "Liste des films";
ob_start();
?>

<h1>Ma Collection de Films</h1>
<p><a href="index.php?action=create" class="btn btn-primary"><i class="fas fa-plus"></i> Ajouter un film</a></p>

<?php if(empty($movies)): ?>
    <p>Aucun film trouvé</p>
<?php else: ?>
<table class="movie-table">
    <thead>
        <tr>
            <th>Titre</th>
            <th>Réalisateur</th>
            <th>Année</th>
            <th>Genre</th>
            <th>Note</th>
            <th>Durée</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($movies as $movie): ?>
        <tr>
            <td><?= htmlspecialchars($movie['titre']) ?></td>
            <td><?= htmlspecialchars($movie['realisateur']) ?></td>
            <td><?= $movie['annee'] ?></td>
            <td><span class="badge badge-genre-<?= strtolower(str_replace([' ','-'],'',$movie['genre'])) ?>"><?= htmlspecialchars($movie['genre']) ?></span></td>
            <td><?= $movie['note'] !== null ? $movie['note'] : '-' ?>/10</td>
            <td><?= $movie['duree'] !== null ? $movie['duree'].' min' : '-' ?></td>
            <td class="actions">
                <a href="index.php?action=show&id=<?= $movie['id'] ?>" class="btn btn-small btn-info"><i class="fas fa-eye"></i></a>
                <a href="index.php?action=edit&id=<?= $movie['id'] ?>" class="btn btn-small btn-warning"><i class="fas fa-edit"></i></a>
                <a href="index.php?action=delete&id=<?= $movie['id'] ?>" class="btn btn-small btn-danger" onclick="return confirm('Voulez-vous vraiment supprimer ce film ?')"><i class="fas fa-trash"></i></a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<p><strong>Nombre total de films :</strong> <?= count($movies) ?> |
<strong>Note moyenne :</strong> <?= $average ?>/10</p>
<?php endif; ?>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
