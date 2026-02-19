<?php
// Démarrage de la session au début du routeur
session_start();

// Vérifier et restaurer la session avec le cookie autologin
require_once('controller/controllerUtilisateur.php');
autoLogin();



//Débogage afficher ce qui est reçu en paramètres
echo "----------------------------<br/>";
echo "Paramètres reçus:<br/><pre>";
print_r($_REQUEST);
echo "</pre>----------------------------<br/>";

//Est-ce qu'un paramètre action est présent
if (isset($_REQUEST['action'])) {

    //Est-ce que l'action demandée est la liste des produits
    if ($_REQUEST['action'] == 'produits') {
        //Ajoute le controleur de Produit
        require('controller/controllerProduit.php');
        //Appel la fonction listProduits contenu dans le controleur de Produit
        listProduits();
    }
    // Sinon est-ce que l'action demandée est la description d'un produit
    elseif ($_REQUEST['action'] == 'produit') {

        // Est-ce qu'il y a un id en paramètre
        if (isset($_REQUEST['id']) && $_REQUEST['id'] > 0) {
            //Ajoute le controleur de Produit
            require('controller/controllerProduit.php');
            //Appel la fonction produit contenu dans le controleur de Produit
            produit($_REQUEST['id']);
        } else {
            //Si on n'a pas reçu de paramètre id, mais que la page produit a été appelé
            echo 'Erreur : aucun identifiant de produit envoyé';
        }
    } elseif ($_REQUEST['action'] == 'categories') {
        require('controller/controllerCategorie.php');
        listCategories();

    } elseif ($_REQUEST['action'] == 'produitCategorie') {
        // Est-ce qu'il y a un id en paramètre
        if (isset($_REQUEST['id']) && $_REQUEST['id'] > 0) {
            //Ajoute le controleur de Produit
            require('controller/controllerProduit.php');
            //Appel la fonction produit contenu dans le controleur de Produit
            listProduitsCategorie($_REQUEST['id']);
        }
    }
    // Si l'action demandé est le clic sur le bouton Connexion
    elseif ($_REQUEST['action'] == 'connexion') {
        require_once('controller/controllerUtilisateur.php');
        getFormConnexion();
    }
    // Si l'action demandé est le clic sur le bouton Inscription
    elseif ($_REQUEST['action'] == 'inscription') {
        require_once('controller/controllerUtilisateur.php');
        if (

        //On valide les paramètres reçus pour l'inscription dans index.php
            $_SERVER['REQUEST_METHOD'] === 'POST' &&
            isset($_REQUEST['prenom']) &&
            isset($_REQUEST['nom']) &&
            isset($_REQUEST['courriel']) &&
            isset($_REQUEST['mot_de_passe'])
        ) {
            inscrireUtilisateur(
                $_REQUEST['prenom'],
                $_REQUEST['nom'],
                $_REQUEST['courriel'],
                $_REQUEST['mot_de_passe']
            );
        } else {
            getFormInscription();
        }
    }
    // Si l'action demandé est le clic sur le bouton Authentifier du formulaire de connexion
    elseif ($_REQUEST['action'] == 'authentifier') {
        if (isset($_REQUEST['courriel']) && isset($_REQUEST['motPasse'])) {
            require_once('controller/controllerUtilisateur.php');
            $souvenirMoi = isset($_REQUEST['souvenirMoi']);
            authentifier($_REQUEST['courriel'], $_REQUEST['motPasse'], $souvenirMoi);
        } else {
            echo "Erreur, mot de passe ou courriel pas bon";
            echo '<a href="?action=connexion"> Retour à la page de connexion</a>';
        }
    }
    // Si l'action demandé est le clic sur le bouton deconnexion
    elseif ($_REQUEST['action'] == 'deconnexion') {
        require_once('controller/controllerUtilisateur.php');
        deconnexion();
    }
    // Si l'action demandé est la connexion Google
    elseif ($_REQUEST['action'] == 'authGoogle' && isset($_REQUEST['credential'])) {
        require_once('controller/controllerUtilisateur.php');
        authentificationGoogle($_REQUEST['credential']);
    }
    elseif ($_REQUEST['action'] == 'sessionFermer'){
        require_once('controller/controllerUtilisateur.php');
        fermer_session();
    }
    elseif ($_REQUEST['action'] == 'validation'){
        if (isset($_REQUEST['courriel']) && isset($_REQUEST['token'])) {
            require_once('controller/controllerUtilisateur.php');
            checkTokenInscription($_REQUEST['courriel'], $_REQUEST['token']);
        } else {
            echo "Lien de validation invalide.";
        }
    }
}
// Si pas de paramètre charge l'accueil
else {
    //Ajoute le controleur de Produit
    require('controller/controllerAccueil.php');
    //Appel la fonction listProduits contenu dans le controleur de Produit
    listProduits();
}