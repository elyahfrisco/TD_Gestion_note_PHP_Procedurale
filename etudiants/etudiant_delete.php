<?php
require_once __DIR__ . '/../config/database.php';
$pdo = db_connect();
$pdo->prepare("DELETE FROM etudiants WHERE id_etudiant=?")->execute([(int)$_GET['id']]);
header('Location: etudiant_list.php');