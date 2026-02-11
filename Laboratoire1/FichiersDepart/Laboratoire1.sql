SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
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

INSERT INTO tbl_categorie (categorie, description) VALUES
('Papeterie', 'Article de bureau en lien avec la papetrie'),
('Électronique', 'Article de bureau électronique');

INSERT INTO tbl_produit (id_categorie, produit, description) VALUES
(1, 'Crayon de mine', 'Paquet de 10 crayons de marque HB'),
(1, 'Stylo bleu', 'Paquet de 10 stylos de marque BIC'),
(2, 'Calculatrice', 'Calculatrice de comptabilité'),
(2, 'Aiguisoir électrique', 'Aiguisoir électrique de marque GE');

COMMIT;