<?php
require_once __DIR__.'/../config/database.php';
session_start();
if (isset($_SESSION['user_id'])) header('Location: ../index.php');

$pdo = db_connect();
$errors = [];
if ($_SERVER['REQUEST_METHOD']==='POST'){
    $user = trim($_POST['username'] ?? '');
    $pass  = $_POST['password'] ?? '';
    $stmt  = $pdo->prepare("SELECT id_user, password_hash FROM users WHERE username=?");
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

<body
    style="margin:0;font-family:'Segoe UI',Tahoma,Arial,sans-serif;display:flex;justify-content:center;align-items:center;min-height:100vh;background:#f2f4f7;">

    <div
        style="width:360px;background:#fff;padding:2rem 2.5rem;border-radius:10px;box-shadow:0 4px 20px rgba(0,0,0,.08);">
        <h2 style="text-align:center;margin-top:0;margin-bottom:1.5rem;color:#333;">Se connecter</h2>

        <?php if($justReg) echo "<p style='color:#28a745;text-align:center;margin:0 0 1rem'>Inscription réussie&nbsp;! Connectez-vous.</p>"; ?>
        <?php foreach($errors as $err) echo "<p style='color:#dc3545;text-align:center;margin:0 0 1rem'>$err</p>"; ?>

        <form method="post">
            <label style="display:block;margin-bottom:1rem;">
                <span style="display:block;font-weight:600;margin-bottom:.25rem;">Nom d’utilisateur</span>
                <input name="username" required
                    style="width:100%;padding:.6rem .75rem;border:1px solid #ced4da;border-radius:6px;font-size:1rem;outline:none;">
            </label>

            <label style="display:block;margin-bottom:1.5rem;">
                <span style="display:block;font-weight:600;margin-bottom:.25rem;">Mot de passe</span>
                <input type="password" name="password" required
                    style="width:100%;padding:.6rem .75rem;border:1px solid #ced4da;border-radius:6px;font-size:1rem;outline:none;">
            </label>

            <button
                style="width:100%;padding:.65rem 1rem;font-size:1rem;font-weight:600;background:#007bff;color:#fff;border:none;border-radius:6px;cursor:pointer;">
                Connexion
            </button>
        </form>

        <p style="text-align:center;margin-top:1.25rem;font-size:.9rem;">
            <a href="register.php" style="color:#007bff;text-decoration:none;">Créer un compte</a>
        </p>
    </div>

</body>

</html>