<?php

//Ce fichier est appelé par le routeur (index.php) et gère le comportement de la page d'accueil.

//Sur l'acceuil, nous avons besoin des produits
require('model/ProduitManager.php');

//Fonction qui affichera tous les produits
function listProduits()
{
    //Nouvel objet de type ProduitManager 
    $produitManager = new ProduitManager();
    
    
    //Crée une variable $produits qui sera utilisée dans la vue.
    //Cette variable contiendra un array d'objet de type Produit. 
    $produits = $produitManager->getProduits();

    //Appel la vue d'accueil
    require('view/accueilView.php');
}
