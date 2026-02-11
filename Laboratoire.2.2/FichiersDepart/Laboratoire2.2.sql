SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT=0;
START TRANSACTION;

DROP DATABASE IF EXISTS dwalabo;

CREATE DATABASE dwalabo
	DEFAULT CHARACTER SET utf8
	DEFAULT COLLATE utf8_general_ci;

USE dwalabo;

CREATE TABLE tbl_categorie (
  id_categorie int(11) NOT NULL AUTO_INCREMENT,
  categorie varchar(255) NOT NULL,
  description varchar(255) NOT NULL,
  PRIMARY KEY (id_categorie)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE tbl_produit (
  id_produit int(11) NOT NULL AUTO_INCREMENT,
  id_categorie int(11) NOT NULL,
  produit varchar(255) NOT NULL,
  description varchar(255) NOT NULL,
  PRIMARY KEY (id_produit),
  FOREIGN KEY (id_categorie) REFERENCES tbl_categorie(id_categorie)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE tbl_utilisateur (
  id_utilisateur int(11) NOT NULL AUTO_INCREMENT,
  nom varchar(255) NOT NULL,
  prenom varchar(255) NOT NULL,
  courriel varchar(255) NOT NULL UNIQUE,
  mdp varchar(255) NOT NULL,
  est_actif tinyint(4) NOT NULL,
  role_utilisateur tinyint(4) NOT NULL,
  type_utilisateur tinyint(4) NOT NULL,
  token varchar(255) NOT NULL,
  PRIMARY KEY (id_utilisateur)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE tbl_autologin (
  id_autologin int(11) NOT NULL AUTO_INCREMENT,
  id_utilisateur int(11) NOT NULL,
  token_hash varchar(255) NOT NULL,
  est_valide tinyint(4) NOT NULL,
  date_expiration date NOT NULL,
  PRIMARY KEY (id_autologin),
  FOREIGN KEY (id_utilisateur) REFERENCES tbl_utilisateur(id_utilisateur)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO tbl_categorie (categorie, description) VALUES
('Papeterie', 'Article de bureau en lien avec la papetrie'),
('Électronique', 'Article de bureau électronique');

INSERT INTO tbl_produit (id_categorie, produit, description) VALUES
(1, 'Crayon de mine', 'Paquet de 10 crayons de marque HB'),
(1, 'Stylo bleu', 'Paquet de 10 stylos de marque BIC'),
(2, 'Calculatrice', 'Calculatrice de comptabilité'),
(2, 'Aiguisoir électrique', 'Aiguisoir électrique de marque GE');

INSERT INTO tbl_utilisateur (nom, prenom, courriel, mdp, est_actif, role_utilisateur, type_utilisateur, token) VALUES
('admin', 'admin', 'admin@gmail.com', '$2y$10$wrHuXB.wR0EScOHyqNhJnOzW/6HcE.C0c0eaUF4XjhJGSwYfDQMrS', 1, 1, 0, ''),
('Deschamps', 'Jacob', 'jacob@bidon.ca', '$2y$10$8X7hTD.nrXey4Fu.Qga9RORxSj1eS5IofHVfMMydUxxQVZfEzYeOK', 1, 0, 0, '');

COMMIT;