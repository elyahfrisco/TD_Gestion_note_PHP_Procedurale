<?php
require_once __DIR__ . '/../config/database.php';
$pdo = db_connect();
$id = (int)($_GET['id'] ?? 0);
$pdo->prepare("DELETE FROM classes WHERE id_classe = ?")->execute([$id]);
header('Location: classe_list.php');