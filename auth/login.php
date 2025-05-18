<?php
require_once __DIR__.'/../config/database.php';
session_start();
if (isset($_SESSION['user_id'])) header('Location: ../index.php');

$pdo = db_connect();
$errors = [];
if ($_SERVER['REQUEST_METHOD']==='POST'){
    $user = trim($_POST['username'] ?? '');
    $pass = $_POST['password'] ?? '';
    $stmt = $pdo->prepare("SELECT id_user, password_hash FROM users WHERE username=?");
    $stmt->execute([$user]);
    $row = $stmt->fetch();
    if ($row && password_verify($pass, $row['password_hash'])) {
        $_SESSION['user_id'] = $row['id_user'];
        $_SESSION['username'] = $user;
        header('Location: ../index.php');
        exit;
    } else {
        $errors[] = "Identifiants invalides";
    }
}
$justReg = isset($_GET['reg']);
?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Connexion</title>
</head>

<body>
    <h2>Se connecter</h2>
    <?php if($justReg) echo "<p style='color:green'>Inscription réussie ! Connectez-vous.</p>"; ?>
    <?php foreach($errors as $err) echo "<p style='color:red'>$err</p>"; ?>
    <form method="post">
        <label>Nom d’utilisateur :
            <input name="username" required>
        </label><br>
        <label>Mot de passe :
            <input type="password" name="password" required>
        </label><br>
        <button>Connexion</button>
    </form>
    <p><a href="register.php">Créer un compte</a></p>
</body>

</html>