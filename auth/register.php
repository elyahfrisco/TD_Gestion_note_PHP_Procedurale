<?php
require_once __DIR__.'/../config/database.php';
session_start();
if (isset($_SESSION['user_id'])) header('Location: ../index.php');

$pdo = db_connect();
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = trim($_POST['username'] ?? '');
    $pass = $_POST['password'] ?? '';
    $conf = $_POST['confirm']  ?? '';

    if ($user === '' || $pass === '')         $errors[] = "Tous les champs sont requis";
    if ($pass !== $conf)                      $errors[] = "Les mots de passe ne correspondent pas";
    if (strlen($pass) < 6)                    $errors[] = "Mot de passe trop court (≥ 6 caractères)";

    if (!$errors) {
        $sql = "INSERT INTO users (username, password_hash) VALUES (:u, :h)";
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute([
                'u' => $user,
                'h' => password_hash($pass, PASSWORD_DEFAULT)
            ]);
            header('Location: login.php?reg=1');
            exit;
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) $errors[] = "Nom d’utilisateur déjà pris";
            else $errors[] = $e->getMessage();
        }
    }
}
?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Inscription</title>
</head>

<body>
    <h2>Créer un compte</h2>
    <?php foreach ($errors as $err) echo "<p style='color:red'>$err</p>"; ?>
    <form method="post">
        <label>Nom d’utilisateur :
            <input name="username" required>
        </label><br>
        <label>Mot de passe :
            <input type="password" name="password" required>
        </label><br>
        <label>Confirmer :
            <input type="password" name="confirm" required>
        </label><br>
        <button>S’inscrire</button>
    </form>
    <p><a href="login.php">Déjà inscrit ? Se connecter</a></p>
</body>

</html>