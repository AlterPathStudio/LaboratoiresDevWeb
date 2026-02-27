<?php

require('model/ProduitManager.php');

function listProduits($estAppelApi = false)
{
    $produitManager = new ProduitManager();
    $produits = $produitManager->getProduits();

    if ($estAppelApi) {
        return json_encode($produits, JSON_PRETTY_PRINT);
    }

    require('view/produitsView.php');
}

function produit($idProduit, $estAppelApi = false)
{
    $produitManager = new ProduitManager();
    $produit = $produitManager->getProduit($idProduit);

    if ($estAppelApi) {
        if ($produit === null || $produit->get_id_produit() === null) {
            return null;
        }

        return json_encode($produit, JSON_PRETTY_PRINT);
    }

    if (!$estAppelApi) {
        require('view/produitView.php');
    }
}

function listProduitsCategorie($id_categorie){
    $produitManager = new ProduitManager();
    $produits = $produitManager->getProduitsCategorie($id_categorie);

    $categorie = $produits[0]->get_categorie();


    require('view/produitsView.php');
}