<?php
require_once __DIR__ . '/../config/database.php';
$pdo = db_connect();
$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM classes WHERE id_classe = ?");
$stmt->execute([$id]);
$classe = $stmt->fetch();
if (!$classe) { die("Classe introuvable"); }

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom_classe'] ?? '');
    if ($nom === '') $errors[] = "Le nom est requis";
    if (!$errors) {
        $upd = $pdo->prepare("UPDATE classes SET nom_classe=? WHERE id_classe=?");
        try {
            $upd->execute([$nom, $id]);
            header('Location: classe_list.php');
            exit;
        } catch (PDOException $e) {
            $errors[] = $e->getMessage();
        }
    }
}
?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Modifier classe</title>
</head>

<body>
    <h2>Modifier la classe</h2>
    <?php foreach ($errors as $err) echo "<p style='color:red'>$err</p>"; ?>
    <form method="post">
        <input type="text" name="nom_classe" value="<?= htmlspecialchars($classe['nom_classe']) ?>" required>
        <button>Mettre à jour</button>
    </form>
    <a href="classe_list.php">⬅️ Retour</a>
</body>

</html>