<?php
require_once __DIR__ . '/../config/database.php';
$pdo = db_connect();
$stmt = $pdo->query("SELECT * FROM classes ORDER BY nom_classe");
$classes = $stmt->fetchAll();
?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Liste des classes</title>
</head>

<body>
    <h2>Liste des classes</h2>
    <a href="classe_add.php">➕ Ajouter une classe</a> |
    <a href="../index.php">🏠 Retour menu</a>
    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($classes as $c): ?>
        <tr>
            <td><?= $c['id_classe'] ?></td>
            <td><?= htmlspecialchars($c['nom_classe']) ?></td>
            <td>
                <a href="classe_edit.php?id=<?= $c['id_classe'] ?>">✏️</a>
                <a href="classe_delete.php?id=<?= $c['id_classe'] ?>" onclick="return confirm('Supprimer ?');">🗑️</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>