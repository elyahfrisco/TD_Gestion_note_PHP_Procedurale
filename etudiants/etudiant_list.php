<?php
require_once __DIR__ . '/../config/database.php';
$pdo = db_connect();
$sql = "SELECT e.*, c.nom_classe
        FROM etudiants e
        LEFT JOIN classes c ON c.id_classe = e.id_classe_etudiant
        ORDER BY e.nom_etudiant, e.prenom_etudiant";
$etudiants = $pdo->query($sql)->fetchAll();
?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Liste des étudiants</title>
</head>

<body>
    <h2>Étudiants</h2>
    <a href="etudiant_add.php">➕ Ajouter un étudiant</a> |
    <a href="../index.php">🏠 Menu</a>
    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Classe</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($etudiants as $e): ?>
        <tr>
            <td><?= $e['id_etudiant'] ?></td>
            <td><?= htmlspecialchars($e['nom_etudiant']) ?></td>
            <td><?= htmlspecialchars($e['prenom_etudiant']) ?></td>
            <td><?= htmlspecialchars($e['nom_classe']) ?></td>
            <td>
                <a href="etudiant_edit.php?id=<?= $e['id_etudiant'] ?>">✏️</a>
                <a href="etudiant_delete.php?id=<?= $e['id_etudiant'] ?>"
                    onclick="return confirm('Supprimer ?');">🗑️</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>