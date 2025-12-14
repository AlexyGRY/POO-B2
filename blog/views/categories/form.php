<?php
$title = isset($category) ? "Modifier la catégorie" : "Ajouter une catégorie";
ob_start();
?>

<h1><?= $title ?></h1>

<?php if(!empty($errors)): ?>
<div>
    <?php foreach($errors as $err): ?>
        <p style="color:red"><?= htmlspecialchars($err) ?></p>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<form method="POST">
    <label>Nom</label>
    <input type="text" name="nom" value="<?= htmlspecialchars($category['nom'] ?? '') ?>" required>
    <label>Description</label>
    <textarea name="description"><?= htmlspecialchars($category['description'] ?? '') ?></textarea>
    <label>Couleur</label>
    <input type="color" name="couleur" value="<?= htmlspecialchars($category['couleur'] ?? '#007bff') ?>">
    <button type="submit"><?= isset($category) ? "Modifier" : "Ajouter" ?></button>
</form>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
