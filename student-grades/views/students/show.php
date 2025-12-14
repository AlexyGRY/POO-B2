<?php
$title = "Détails de l'étudiant";
ob_start();
?>

<h1>Détails de l'étudiant</h1>

<p>Nom: <?= htmlspecialchars($student['nom']) ?></p>
<p>Prénom: <?= htmlspecialchars($student['prenom']) ?></p>
<p>Email: <?= htmlspecialchars($student['email']) ?></p>
<p>Matière: <?= htmlspecialchars($student['matiere']) ?></p>
<p>Note: <?= $student['note'] !== null ? htmlspecialchars($student['note']) : '-' ?>/20</p>
<p>Appréciation: <span class="badge badge-appreciation-<?= strtolower(str_replace(' ', '', $student['appreciation'])) ?>"><?= htmlspecialchars($student['appreciation']) ?></span></p>
<p>Ajouté le: <?= date('d/m/Y à H:i', strtotime($student['created_at'])) ?></p>

<a href="index.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Retour à la liste</a>
<a href="index.php?action=edit&id=<?= $student['id'] ?>" class="btn btn-warning"><i class="fas fa-edit"></i> Modifier</a>
<a href="index.php?action=delete&id=<?= $student['id'] ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet étudiant ?')"><i class="fas fa-trash"></i> Supprimer</a>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
