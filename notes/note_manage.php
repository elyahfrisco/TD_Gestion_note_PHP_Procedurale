<?php
require_once __DIR__ . '/../config/database.php';
$pdo = db_connect();

/* Étape 1 : choix de l'étudiant */
if (!isset($_GET['etudiant'])) {
    $etudiants = $pdo->query("SELECT id_etudiant, nom_etudiant, prenom_etudiant FROM etudiants ORDER BY nom_etudiant, prenom_etudiant")->fetchAll();
    ?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Choix étudiant</title>
</head>

<body>
    <h2>Choisir un étudiant</h2>
    <ul>
        <?php foreach ($etudiants as $e): ?>
        <li>
            <a href="?etudiant=<?= $e['id_etudiant'] ?>">
                <?= htmlspecialchars($e['nom_etudiant'].' '.$e['prenom_etudiant']) ?>
            </a>
        </li>
        <?php endforeach; ?>
    </ul>
    <a href="../index.php">⬅️ Menu</a>
</body>

</html>
<?php
    exit;
}

/* Étape 2 : affichage/édition des notes */
$idEtu = (int)$_GET['etudiant'];
// récupérer l'étudiant
$etu = $pdo->prepare("SELECT * FROM etudiants WHERE id_etudiant=?");
$etu->execute([$idEtu]);
$etu = $etu->fetch();
if (!$etu) die("Étudiant inconnu");

// enregistrer si POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach (MATIERES as $m) {
        $val = ($_POST[$m] === '') ? null : (float)$_POST[$m];
        // existe déjà ?
        $sel = $pdo->prepare("SELECT id_note FROM notes WHERE id_etudiant_note=? AND matiere=?");
        $sel->execute([$idEtu, $m]);
        $row = $sel->fetchColumn();
        if ($row) {
            $pdo->prepare("UPDATE notes SET valeur_note=? WHERE id_note=?")
                ->execute([$val, $row]);
        } else {
            $pdo->prepare("INSERT INTO notes (id_etudiant_note, matiere, valeur_note)
                           VALUES (?, ?, ?)")
                ->execute([$idEtu, $m, $val]);
        }
    }
    header('Location: note_manage.php?etudiant='.$idEtu);
    exit;
}

// récupérer notes existantes
$notes = $pdo->prepare("SELECT matiere, valeur_note FROM notes WHERE id_etudiant_note=?");
$notes->execute([$idEtu]);
$notes = $notes->fetchAll(PDO::FETCH_KEY_PAIR); // [matiere => valeur]

?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Notes étudiant</title>
</head>

<body>
    <h2>Notes de <?= htmlspecialchars($etu['nom_etudiant'].' '.$etu['prenom_etudiant']); ?></h2>
    <form method="post">
        <table>
            <tr>
                <th>Matière</th>
                <th>Note (/20)</th>
            </tr>
            <?php foreach (MATIERES as $m): ?>
            <tr>
                <td><?= $m ?></td>
                <td>
                    <input type="number" step="0.01" min="0" max="20" name="<?= $m ?>" value="<?= $notes[$m] ?? '' ?>">
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <button>💾 Enregistrer</button>
    </form>
    <a href="?">⬅️ Choisir un autre étudiant</a> |
    <a href="../index.php">🏠 Menu</a>
</body>

</html>