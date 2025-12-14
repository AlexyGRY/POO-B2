<?php
$title = "Liste des étudiants";
ob_start();
?>

<h1>Liste des étudiants</h1>
<p><a href="index.php?action=create" class="btn btn-primary"><i class="fas fa-plus"></i> Ajouter un étudiant</a></p>

<?php if (empty($students)): ?>
    <p>Aucun étudiant trouvé</p>
<?php else: ?>
<table class="student-table">
    <thead>
        <tr>
            <th>Nom complet</th>
            <th>Email</th>
            <th>Matière</th>
            <th>Note</th>
            <th>Appréciation</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($students as $student): ?>
        <tr>
            <td><?= htmlspecialchars($student['nom'] . ' ' . $student['prenom']) ?></td>
            <td><?= htmlspecialchars($student['email']) ?></td>
            <td><?= htmlspecialchars($student['matiere']) ?></td>
            <td><?= $student['note'] !== null ? htmlspecialchars($student['note']) : '-' ?></td>
            <td>
                <span class="badge badge-appreciation-<?= strtolower(str_replace(' ', '', $student['appreciation'])) ?>">
                    <?= htmlspecialchars($student['appreciation']) ?>
                </span>
            </td>
            <td class="actions">
                <a href="index.php?action=show&id=<?= $student['id'] ?>" class="btn btn-small btn-info"><i class="fas fa-eye"></i></a>
                <a href="index.php?action=edit&id=<?= $student['id'] ?>" class="btn btn-small btn-warning"><i class="fas fa-edit"></i></a>
                <a href="index.php?action=delete&id=<?= $student['id'] ?>" class="btn btn-small btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet étudiant ?')"><i class="fas fa-trash"></i></a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<p><strong>Moyenne générale :</strong> <?= $average ?> / 20</p>
<?php endif; ?>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
