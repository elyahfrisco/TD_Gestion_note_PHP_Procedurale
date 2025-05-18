<?php
require_once __DIR__ . '/../config/database.php';
$pdo = db_connect();
$id = (int)($_GET['id'] ?? 0);
$etudiant = $pdo->prepare("SELECT * FROM etudiants WHERE id_etudiant=?");
$etudiant->execute([$id]);
$e = $etudiant->fetch();
if (!$e) die("Étudiant introuvable");

$classes = $pdo->query("SELECT * FROM classes ORDER BY nom_classe")->fetchAll();
$errors = [];
if ($_SERVER['REQUEST_METHOD']==='POST'){
    $nom = trim($_POST['nom']); $prenom = trim($_POST['prenom']);
    $classe = ($_POST['classe']!=='') ? (int)$_POST['classe'] : null;
    if($nom==''||$prenom=='') $errors[]="Nom et prénom requis";
    if(!$errors){
        $pdo->prepare("UPDATE etudiants SET nom_etudiant=?, prenom_etudiant=?, id_classe_etudiant=? WHERE id_etudiant=?")
            ->execute([$nom,$prenom,$classe,$id]);
        header('Location: etudiant_list.php');exit;
    }
}
?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Modifier étudiant</title>
</head>

<body>
    <h2>Modifier étudiant</h2>
    <?php foreach($errors as $er) echo "<p style='color:red'>$er</p>";?>
    <form method="post">
        <label>Nom:<input name="nom" value="<?=htmlspecialchars($e['nom_etudiant'])?>" required></label><br>
        <label>Prénom:<input name="prenom" value="<?=htmlspecialchars($e['prenom_etudiant'])?>" required></label><br>
        <label>Classe:
            <select name="classe">
                <option value="">-- aucune --</option>
                <?php foreach($classes as $c):?>
                <option value="<?=$c['id_classe']?>" <?= $c['id_classe']==$e['id_classe_etudiant']?'selected':''?>>
                    <?=htmlspecialchars($c['nom_classe'])?></option>
                <?php endforeach;?>
            </select>
        </label><br>
        <button>Mettre à jour</button>
    </form>
    <a href="etudiant_list.php">⬅️ Retour</a>
</body>

</html>