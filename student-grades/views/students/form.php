<?php
$title = isset($student) ? "Modifier un étudiant" : "Ajouter un étudiant";
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
        <label>Nom</label>
        <input type="text" name="nom" value="<?= htmlspecialchars($student['nom'] ?? '') ?>" required>
    </div>
    <div class="form-group">
        <label>Prénom</label>
        <input type="text" name="prenom" value="<?= htmlspecialchars($student['prenom'] ?? '') ?>" required>
    </div>
    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($student['email'] ?? '') ?>" required>
    </div>
    <div class="form-group">
        <label>Matière</label>
        <input type="text" name="matiere" value="<?= htmlspecialchars($student['matiere'] ?? '') ?>" required>
    </div>
    <div class="form-group">
        <label>Note (0-20)</label>
        <input type="number" name="note" step="0.01" min="0" max="20" value="<?= htmlspecialchars($student['note'] ?? '') ?>">
    </div>
    <div class="form-group">
        <label>Appréciation</label>
        <select name="appreciation">
            <?php 
            $options = ['Très bien', 'Bien', 'Assez bien', 'Insuffisant'];
            foreach($options as $opt): 
                $selected = ($student['appreciation'] ?? 'Assez bien') === $opt ? 'selected' : '';
            ?>
                <option value="<?= $opt ?>" <?= $selected ?>><?= $opt ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary"><?= isset($student) ? "Modifier" : "Ajouter" ?></button>
</form>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
