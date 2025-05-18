gestion_notes/
├── auth/
│ ├── login.php
│ ├── register.php
│ ├── logout.php
│ └── auth_check.php (petit helper à inclure partout)
├── index.php
│
├── config/
│ └── database.php
│
├── classes/
│
│ ├── classe_add.php
│ ├── classe_list.php
│ ├── classe_edit.php
│ └── classe_delete.php
│
├── etudiants/
│
│ ├── etudiant_add.php
│ ├── etudiant_list.php
│ ├── etudiant_edit.php
│ └── etudiant_delete.php
│
├── notes/
│
│ ├── note_manage.php
│ └── note_view.php
│
└── assets/
└── css/
└── style.css

//-------------Creation de Table :

-- S'assurer que la base de données 'etudiant' existe et est sélectionnée.
-- CREATE DATABASE IF NOT EXISTS etudiant;
-- USE etudiant;

---

-- Table `classes`

-- Dans la base etudiant
CREATE TABLE IF NOT EXISTS users (
id_user INT AUTO_INCREMENT PRIMARY KEY,
username VARCHAR(100) NOT NULL UNIQUE,
password_hash VARCHAR(255) NOT NULL,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `classes` (
`id_classe` INT NOT NULL AUTO_INCREMENT,
`nom_classe` VARCHAR(100) NOT NULL,
PRIMARY KEY (`id_classe`),
UNIQUE INDEX `nom_classe_UNIQUE` (`nom_classe` ASC)
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;

---

-- Table `etudiants`

---

CREATE TABLE IF NOT EXISTS `etudiants` (
`id_etudiant` INT NOT NULL AUTO_INCREMENT,
`nom_etudiant` VARCHAR(100) NOT NULL,
`prenom_etudiant` VARCHAR(100) NOT NULL,
`id_classe_etudiant` INT NULL,
PRIMARY KEY (`id_etudiant`),
INDEX `fk_etudiants_classes_idx` (`id_classe_etudiant` ASC),
CONSTRAINT `fk_etudiants_classes`
FOREIGN KEY (`id_classe_etudiant`)
REFERENCES `classes` (`id_classe`)
ON DELETE SET NULL
ON UPDATE CASCADE
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;

---

-- Table `notes`

---

CREATE TABLE IF NOT EXISTS `notes` (
`id_note` INT NOT NULL AUTO_INCREMENT,
`id_etudiant_note` INT NOT NULL,
`matiere` ENUM('MATHS', 'SVT', 'ANGLAIS') NOT NULL,
`valeur_note` DECIMAL(4,2) NULL,
PRIMARY KEY (`id_note`),
INDEX `fk_notes_etudiants_idx` (`id_etudiant_note` ASC),
UNIQUE INDEX `uq_etudiant_matiere` (`id_etudiant_note` ASC, `matiere` ASC),
CONSTRAINT `fk_notes_etudiants`
FOREIGN KEY (`id_etudiant_note`)
REFERENCES `etudiants` (`id_etudiant`)
ON DELETE CASCADE
ON UPDATE CASCADE
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;
