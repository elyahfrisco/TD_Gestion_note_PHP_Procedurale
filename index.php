<?php
require_once __DIR__.'/auth/auth_check.php';
?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Gestion des notes</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <p>Connecté en tant que <strong><?= htmlspecialchars($_SESSION['username']) ?></strong>
        – <a href="auth/logout.php">Se déconnecter</a></p>
    <h1>🏫 Gestion des notes – menu principal</h1>
    <ul>
        <li><a href="classes/classe_list.php">📁 Classes (CRUD)</a></li>
        <li><a href="etudiants/etudiant_list.php">👨‍🎓 Étudiants (CRUD)</a></li>
        <li><a href="notes/note_manage.php">📝 Notes</a></li>
    </ul>
</body>

</html>