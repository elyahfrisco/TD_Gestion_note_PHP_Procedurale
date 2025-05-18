<?php
require_once __DIR__ . '/../config/database.php';
$pdo = db_connect();

$classes = $pdo->query("SELECT * FROM classes ORDER BY nom_classe")->fetchAll();

if (!isset($_GET['classe'])) {
    echo "<h2>Choisir une classe</h2><ul>";
    foreach ($classes as $c) {
        echo '<li><a href="?classe='.$c['id_classe'].'">'.htmlspecialchars($c['nom_classe']).'</a></li>';
    }
    echo '</ul><a href="../index.php">Menu</a>';
    exit;
}

$idC = (int)$_GET['classe'];
$sql = "SELECT e.nom_etudiant, e.prenom_etudiant, n.matiere, n.valeur_note
        FROM etudiants e
        JOIN notes n ON n.id_etudiant_note = e.id_etudiant
        WHERE e.id_classe_etudiant = :c
        ORDER BY e.nom_etudiant, n.matiere";
$stmt = $pdo->prepare($sql);
$stmt->execute(['c'=>$idC]);
$rows = $stmt->fetchAll();
?>
<h2>Notes – classe
    <?= htmlspecialchars($classes[array_search($idC, array_column($classes,'id_classe'))]['nom_classe']) ?></h2>
<table border="1">
    <tr>
        <th>Étudiant</th>
        <th>Matière</th>
        <th>Note</th>
    </tr>
    <?php foreach($rows as $r): ?>
    <tr>
        <td><?= htmlspecialchars($r['nom_etudiant'].' '.$r['prenom_etudiant']) ?></td>
        <td><?= $r['matiere'] ?></td>
        <td><?= $r['valeur_note'] ?></td>
    </tr>
    <?php endforeach;?>
</table>
<a href="?">⬅️ Choisir une autre classe</a> |
<a href="../index.php">🏠 Menu</a>