CREATE DATABASE IF NOT EXISTS student_grades;
USE student_grades;

CREATE TABLE students (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    note DECIMAL(4,2) NULL,
    matiere VARCHAR(100) NOT NULL,
    appreciation ENUM('Très bien','Bien','Assez bien','Insuffisant') DEFAULT 'Assez bien',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO students (nom, prenom, email, matiere, note, appreciation) VALUES
('Dupont', 'Jean', 'jean.dupont@test.com', 'Maths', 14.5, 'Bien'),
('Martin', 'Sophie', 'sophie.martin@test.com', 'Histoire', 18.0, 'Très bien'),
('Bernard', 'Luc', 'luc.bernard@test.com', 'Sciences', 12.0, 'Assez bien'),
('Leroy', 'Emma', 'emma.leroy@test.com', 'Anglais', 8.5, 'Insuffisant'),
('Petit', 'Noah', 'noah.petit@test.com', 'Français', NULL, 'Assez bien');
