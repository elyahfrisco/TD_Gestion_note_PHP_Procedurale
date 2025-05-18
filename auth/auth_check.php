<?php
// À inclure en tout début de chaque page protégée
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: auth/login.php');
    exit;
}