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

    public function updateProduit($id_produit, $nom, $description, $prix)
    {
        $db = $this->db_connect();
        $req = $db->prepare('UPDATE tbl_produit SET nom = :nom, description = :description, prix = :prix WHERE id_produit = :id_produit');
        $req->execute(array(
            ':id_produit' => $id_produit,
            ':nom' => $nom,
            ':description' => $description,
            ':prix' => $prix
        ));

        return ($req->rowCount() > 0);
    }

    public function deleteProduit($id_produit)
    {
        $db = $this->db_connect();
        $req = $db->prepare('DELETE FROM tbl_produit WHERE id_produit = :id_produit');
        $req->execute(array(':id_produit' => $id_produit));

        return ($req->rowCount() > 0);
    }


}