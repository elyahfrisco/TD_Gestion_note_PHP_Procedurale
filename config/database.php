<?php
// Fichier: config/database.php

define('DB_HOST', 'localhost');
define('DB_PORT', '3306'); // Port spécifié
define('DB_NAME', 'etudiant'); // Nom de la base de données spécifié
define('DB_USER', 'root');    // Utilisateur par défaut sans mot de passe (ou votre utilisateur)
define('DB_PASS', '');        // Pas de mot de passe

/**
 * Établit une connexion à la base de données en utilisant PDO.
 * @return PDO|null L'objet de connexion PDO en cas de succès, null sinon.
 */
function db_connect() {
    $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Lève des exceptions en cas d'erreur SQL
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Récupère les résultats en tableau associatif par défaut
        PDO::ATTR_EMULATE_PREPARES   => false,                  // Désactive l'émulation des requêtes préparées pour plus de sécurité/performance
    ];

    try {
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        return $pdo;
    } catch (PDOException $e) {
        // En production, loguer l'erreur plutôt que de l'afficher directement
        // Pour le développement, on peut l'afficher :
        error_log("Erreur de connexion PDO : " . $e->getMessage());
        // Afficher un message plus générique à l'utilisateur
        // die("Impossible de se connecter à la base de données. Veuillez réessayer plus tard.");
        return null; // Retourner null pour indiquer l'échec
    }
}

// Constantes pour les matières
define('MATIERES', ['MATHS', 'SVT', 'ANGLAIS']);
?>