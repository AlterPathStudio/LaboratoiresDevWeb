<?php

require('model/ProduitManager.php');

function listProduits()
{
    $produitManager = new ProduitManager();
    $produits = $produitManager->getProduits();

    require('view/produitsView.php');
}

function produit($idProduit)
{
    $produitManager = new ProduitManager();
    $produit = $produitManager->getProduit($idProduit);    

    require('view/produitView.php');
}

function listProduitsCategorie($id_categorie){
    $produitManager = new ProduitManager();
    $produits = $produitManager->getProduitsCategorie($id_categorie);

    $categorie = $produits[0]->get_categorie();


    require('view/produitsView.php');
}