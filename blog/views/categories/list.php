<?php
$title = "Liste des catégories";
ob_start();
?>

<h1>Liste des catégories</h1>
<p><a href="index.php?action=category_create" class="btn btn-primary"><i class="fas fa-plus"></i> Ajouter une catégorie</a></p>

<table>
    <thead>
        <tr>
            <th>Nom</th>
            <th>Description</th>
            <th>Articles</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($categories as $cat): ?>
        <tr>
            <td><span style="background-color: <?= $cat['couleur'] ?>; color:white; padding:2px 5px;"><?= htmlspecialchars($cat['nom']) ?></span></td>
            <td><?= htmlspecialchars($cat['description']) ?></td>
            <td><?= $this->categoryModel->countArticles($cat['id']) ?></td>
            <td>
                <a href="index.php?action=category_edit&id=<?= $cat['id'] ?>">Modifier</a>
                <a href="index.php?action=category_delete&id=<?= $cat['id'] ?>" onclick="return confirm('Supprimer ?')">Supprimer</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
