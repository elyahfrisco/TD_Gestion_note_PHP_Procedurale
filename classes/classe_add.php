<?php
require_once __DIR__ . '/../config/database.php';
$pdo = db_connect();

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom_classe'] ?? '');
    if ($nom === '') {
        $errors[] = "Le nom est requis";
    } else {
        $sql = "INSERT INTO classes (nom_classe) VALUES (:nom)";
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute(['nom' => $nom]);
            header('Location: classe_list.php');
            exit;
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) { // duplicata
                $errors[] = "Cette classe existe déjà.";
            } else {
                $errors[] = $e->getMessage();
            }
        }
    }
}
?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Ajouter classe</title>
</head>

<body>
    <h2>Ajouter une classe</h2>
    <?php foreach ($errors as $err) echo "<p style='color:red'>$err</p>"; ?>
    <form method="post">
        <label>Nom de la classe :
            <input type="text" name="nom_classe" required>
        </label>
        <button type="submit">Enregistrer</button>
    </form>
    <a href="classe_list.php">⬅️ Retour</a>
</body>

</html>