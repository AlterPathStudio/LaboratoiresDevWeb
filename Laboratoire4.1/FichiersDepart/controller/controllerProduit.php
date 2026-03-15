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

function addProduit($nomProduit, $idCategorie, $description)
{
    $produitManager = new ProduitManager();

    if (!$produitManager->categorieExiste($idCategorie)) {
        return array(
            'success' => false,
            'message' => "L'ajout du produit a échoué. L'ID de la catégorie n'existe pas en BD."
        );
    }

    $insertionReussie = $produitManager->addProduit($nomProduit, $idCategorie, $description);

    if ($insertionReussie) {
        return array(
            'success' => true,
            'message' => "L'ajout du produit a fonctionné."
        );
    }

    return array(
        'success' => false,
        'message' => "L'ajout du produit a échoué lors de l'insertion en BD."
    );
}

function deleteProduit($idProduit)
{
    $produitManager = new ProduitManager();

    if (!$produitManager->produitExiste($idProduit)) {
        return array(
            'success' => false,
            'message' => "La suppression du produit a échoué. Le produit n'existe pas."
        );
    }

    $produitSupprime = $produitManager->deleteProduit($idProduit);

    if ($produitSupprime) {
        return array(
            'success' => true,
            'message' => "La suppression du produit a fonctionné."
        );
    }

    return array(
        'success' => false,
        'message' => "La suppression du produit a échoué lors de la suppression en BD."
    );
}

function editProduit($idProduit, $nomProduit, $idCategorie, $description)
{
    $produitManager = new ProduitManager();

    if (!$produitManager->produitExiste($idProduit)) {
        return array(
            'success' => false,
            'message' => "La modification du produit a échoué. L'ID du produit n'existe pas en BD."
        );
    }

    if (!$produitManager->categorieExiste($idCategorie)) {
        return array(
            'success' => false,
            'message' => "La modification du produit a échoué. L'ID de la catégorie n'existe pas en BD."
        );
    }

    $modificationReussie = $produitManager->editProduit($idProduit, $nomProduit, $idCategorie, $description);

    if ($modificationReussie) {
        return array(
            'success' => true,
            'message' => "La modification du produit a fonctionné."
        );
    }

    return array(
        'success' => false,
        'message' => "La modification du produit a échoué lors de la mise à jour en BD."
    );
}