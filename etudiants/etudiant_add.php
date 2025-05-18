<?php
require_once __DIR__ . '/../config/database.php';
$pdo = db_connect();
$classes = $pdo->query("SELECT * FROM classes ORDER BY nom_classe")->fetchAll();
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom     = trim($_POST['nom'] ?? '');
    $prenom  = trim($_POST['prenom'] ?? '');
    $classe  = ($_POST['classe'] !== '') ? (int)$_POST['classe'] : null;

    if ($nom === '' || $prenom === '') $errors[] = "Nom et prénom requis.";
    if (!$errors) {
        $stmt = $pdo->prepare("INSERT INTO etudiants (nom_etudiant, prenom_etudiant, id_classe_etudiant)
                               VALUES (:n, :p, :c)");
        $stmt->execute(['n'=>$nom,'p'=>$prenom,'c'=>$classe]);
        header('Location: etudiant_list.php');
        exit;
    }
}
?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Ajout étudiant</title>
</head>

<body>
    <h2>Ajouter un étudiant</h2>
    <?php foreach ($errors as $err) echo "<p style='color:red'>$err</p>";?>
    <form method="post">
        <label>Nom :<input name="nom" required></label><br>
        <label>Prénom :<input name="prenom" required></label><br>
        <label>Classe :
            <select name="classe">
                <option value="">-- aucune --</option>
                <?php foreach ($classes as $c): ?>
                <option value="<?= $c['id_classe'] ?>"><?= htmlspecialchars($c['nom_classe']) ?></option>
                <?php endforeach; ?>
            </select>
        </label><br>
        <button>Enregistrer</button>
    </form>
    <a href="etudiant_list.php">⬅️ Retour</a>
</body>

</html>