<?php
$title = isset($movie) ? "Modifier un film" : "Ajouter un film";
ob_start();
?>

<h1><?= $title ?></h1>

<?php if(!empty($errors)): ?>
    <div class="error-message">
        <?php foreach($errors as $error): ?>
            <p><?= htmlspecialchars($error) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form method="POST">
    <div class="form-group">
        <label>Titre</label>
        <input type="text" name="titre" value="<?= htmlspecialchars($movie['titre'] ?? '') ?>" required maxlength="200">
    </div>
    <div class="form-group">
        <label>Réalisateur</label>
        <input type="text" name="realisateur" value="<?= htmlspecialchars($movie['realisateur'] ?? '') ?>" required maxlength="150">
    </div>
    <div class="form-group">
        <label>Année</label>
        <input type="number" name="annee" value="<?= $movie['annee'] ?? '' ?>" required min="1888" max="<?= date('Y')+2 ?>">
    </div>
    <div class="form-group">
        <label>Genre</label>
        <select name="genre" required>
            <option value="">-- Sélectionner un genre --</option>
            <?php
            $genres = ['Action','Comédie','Drame','Science-Fiction','Horreur','Thriller','Romance','Documentaire'];
            foreach($genres as $g):
                $selected = ($movie['genre'] ?? '') === $g ? 'selected' : '';
            ?>
            <option value="<?= $g ?>" <?= $selected ?>><?= $g ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label>Note (0-10)</label>
        <input type="number" step="0.1" min="0" max="10" name="note" value="<?= $movie['note'] ?? '' ?>">
    </div>
    <div class="form-group">
        <label>Durée (minutes)</label>
        <input type="number" min="1" name="duree" value="<?= $movie['duree'] ?? '' ?>">
    </div>
    <button type="submit" class="btn btn-primary"><?= isset($movie) ? "Modifier" : "Ajouter" ?></button>
    <a href="index.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Annuler</a>
</form>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
