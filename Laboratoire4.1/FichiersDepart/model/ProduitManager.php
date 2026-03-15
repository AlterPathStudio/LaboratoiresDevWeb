<?php

// Ce fichier sert à communiquer avec la BD et construire les objets pour les retourner au controleur.
// Ces fonctions sont généralement appelé par le routeur (index.php) ou d'autres contrôleurs.

require_once("model/Manager.php");
require_once("model/Produit.php");

class ProduitManager extends Manager
{
    // Get touts les produits de la BD et les retourner dans un tableau d'objets Produit
    public function getProduits()
    {
        $db = $this->db_connect();
        $req = $db->query('SELECT * FROM tbl_produit ORDER BY id_produit');

        $produits = array();

        while($data = $req->fetch()){
            array_push($produits, new Produit($data));
        }

        return $produits;
    }

    public function getProduit($produitId)
    {
        $db = $this->db_connect();
        $req = $db->prepare('SELECT p.*, categorie FROM tbl_produit AS p INNER JOIN tbl_categorie AS c ON p.id_categorie = c.id_categorie WHERE id_produit = ?');
        $req->execute(array($produitId));
        $produit = new Produit($req->fetch());

        return $produit;
    }

    public function getProduitsCategorie($id_categorie) {
        $db = $this->db_connect();
        $req = $db->prepare('SELECT * FROM tbl_produit p INNER JOIN tbl_categorie c ON p.id_categorie = c.id_categorie WHERE p.id_categorie = :idCat');
        $req->execute(array(':idCat' => $id_categorie));

        $produits = array();

        while($data = $req->fetch()){
            array_push($produits, new Produit($data));
        }

        return $produits;

    }

    public function categorieExiste($id_categorie)
    {
        $db = $this->db_connect();
        $req = $db->prepare('SELECT COUNT(*) AS nb FROM tbl_categorie WHERE id_categorie = :id_categorie');
        $req->execute(array(':id_categorie' => $id_categorie));
        $resultat = $req->fetch();

        return isset($resultat['nb']) && ((int)$resultat['nb'] > 0);
    }

    public function addProduit($produit, $id_categorie, $description)
    {
        $db = $this->db_connect();
        try {
            $req = $db->prepare('INSERT INTO tbl_produit (produit, id_categorie, description) VALUES (:produit, :id_categorie, :description)');
            $req->execute(array(
                ':produit' => $produit,
                ':id_categorie' => $id_categorie,
                ':description' => $description
            ));

            return ($req->rowCount() > 0);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function editProduit($id_produit, $produit, $id_categorie, $description)
    {
        $db = $this->db_connect();
        try {
            $req = $db->prepare('UPDATE tbl_produit SET produit = :produit, id_categorie = :id_categorie, description = :description WHERE id_produit = :id_produit');
            $req->execute(array(
                ':id_produit' => $id_produit,
                ':produit' => $produit,
                ':id_categorie' => $id_categorie,
                ':description' => $description
            ));

            return ($req->rowCount() > 0);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function deleteProduit($id_produit)
    {
        $db = $this->db_connect();
        $req = $db->prepare('DELETE FROM tbl_produit WHERE id_produit = :id_produit');
        $req->execute(array(':id_produit' => $id_produit));

        return ($req->rowCount() > 0);
    }

    public function produitExiste($id_produit)
    {
        $db = $this->db_connect();
        $req = $db->prepare('SELECT COUNT(*) AS nb FROM tbl_produit WHERE id_produit = :id_produit');
        $req->execute(array(':id_produit' => $id_produit));
        $resultat = $req->fetch();

        return isset($resultat['nb']) && ((int)$resultat['nb'] > 0);
    }


}