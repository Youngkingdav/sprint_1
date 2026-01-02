<<<<<<< HEAD
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('ADMIN', 'FORMATEUR', 'ETUDIANT') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE formateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    specialite VARCHAR(150),
    telephone VARCHAR(20),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
=======
-- ============================================
-- TABLES POUR US33 - Ajouter étudiant à espace
-- ============================================

-- Table espace_etudiants (si elle n'existe pas déjà)
CREATE TABLE IF NOT EXISTS espace_etudiants (
    id INT PRIMARY KEY AUTO_INCREMENT,
    etudiant_id INT NOT NULL,
    espace_id INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (etudiant_id) REFERENCES etudiants(id) ON DELETE CASCADE,
    FOREIGN KEY (espace_id) REFERENCES espaces_pedagogiques(id) ON DELETE CASCADE,
    UNIQUE KEY unique_etudiant_espace (etudiant_id, espace_id)
);

-- Données de test pour US33 (optionnel)
INSERT IGNORE INTO promotions (nom) VALUES 
('Promotion 2024 - Informatique'),
('Promotion 2025 - Marketing'),
('Promotion 2024 - Gestion');

INSERT IGNORE INTO etudiants (nom, prenom, promotion_id) VALUES 
('DUPONT', 'Jean', 1),
('MARTIN', 'Marie', 1),
('BERNARD', 'Pierre', 1),
('THOMAS', 'Sophie', 2),
('PETIT', 'Luc', 2),
('ROBERT', 'Julie', 3),
('RICHARD', 'Thomas', 3),
('DURAND', 'Laura', 3);

INSERT IGNORE INTO espaces_pedagogiques (nom, matiere) VALUES 
('Espace Algorithmique', 'Algo'),
('Espace Base de données', 'BDD'),
('Espace Développement Web', 'Web');
>>>>>>> 7172c3dfd5c16980dd5946d9229f52f9b72184a4
