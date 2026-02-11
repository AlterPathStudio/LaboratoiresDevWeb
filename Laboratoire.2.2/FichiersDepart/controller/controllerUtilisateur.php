<?php
require('model/UtilisateurManager.php');
require('Util.php');




function getFormConnexion()
{
    require_once('view/loginView.php');
}

function autoLogin(){
    // Vérifier si le cookie autologin existe
    if (isset($_COOKIE['autologin'])) {
        // Décoder le JSON du cookie
        $cookieValues = json_decode($_COOKIE['autologin'], true);
        
        if ($cookieValues && isset($cookieValues['courriel']) && isset($cookieValues['token'])) {
            $courriel = $cookieValues['courriel'];
            $tokenClair = $cookieValues['token'];
            
            // Vérifier les informations du cookie avec la BD
            $utilisateurManager = new UtilisateurManager();
            $utilisateur = $utilisateurManager->verifyAutologin($courriel, $tokenClair);
            
            if ($utilisateur !== null) {
                // Autologin valide - réactiver la session
                $_SESSION['courriel'] = $utilisateur->getCourriel();
                $_SESSION['role'] = $utilisateur->getRoleUtilisateur();
            }
        }
    }
}


function authentifier($courriel, $mdp)
{
    $utilisateurManager = new UtilisateurManager();
    $utilisateur = $utilisateurManager->verifAuthentification($courriel, $mdp);

    if ($utilisateur !== null) {
        // Authentification réussie
        // Ajouter les informations dans $_SESSION
        $_SESSION['courriel'] = $utilisateur->getCourriel();
        $_SESSION['role'] = $utilisateur->getRoleUtilisateur();

        // Vérifier si l'utilisateur a coché "Se souvenir de moi"
        if (isset($_POST['souvenirMoi'])) {
            // Générer un token aléatoire entre 16 et 32 caractères
            $util = new Util();
            $tokenClair = $util->getToken(32); // Token de 32 caractères en texte clair
            
            // Hacher le token pour l'enregistrer en BD
            $tokenHash = password_hash($tokenClair, PASSWORD_DEFAULT);
            
            // Créer le cookie avec le token en clair et le courriel
            $expirationCookie = time() + (30 * 24 * 60 * 60); // 30 jours en secondes
            $cookieValues = array(
                'courriel' => $utilisateur->getCourriel(),
                'token' => $tokenClair
            );
            // Enregistrer le cookie en
            setcookie('autologin', json_encode($cookieValues), $expirationCookie);
            
            // Ajouter l'enregistrement autologin avec le token hachée
            $utilisateurManager->addAutologin($utilisateur->getId(), $tokenHash);
        }

        // Charger l'accueil et afficher la liste des produits
        require('controller/controllerAccueil.php');
        listProduits();
    } else {
        // Authentification échouée
        // Afficher le formulaire de connexion
        getFormConnexion();
    }
}

function deconnexion()
{
    session_destroy();
    // Charger l'accueil et afficher la liste des produits
    require('controller/controllerAccueil.php');
    listProduits();
}


function authentificationGoogle($credential)
{
    // Inclut la bibliothèque Google Client
    require_once 'inc/vendor/autoload.php';

    // ID Google
    $CLIENT_ID = "968412325146-5ipedunslal15l7q1tfl4itr21mohi3h.apps.googleusercontent.com";

    // client Google
    $client = new Google_Client(['client_id' => $CLIENT_ID]);

    // Vérifie le token reçu
    $payload = $client->verifyIdToken($credential);

    if ($payload) {
        // Récupère l'identifiant unique Google
        $userid = $payload['sub'];

        // Affiche le contenu de $payload pour vérifier les informations
        echo "<pre>";
        print_r($payload);
        echo "</pre>";
    } else {
        echo "Token invalide !";
    }

    $courriel = $payload['email'];

    // Utiliser le manager pour vérifier si l'utilisateur existe déjà
    $um = new UtilisateurManager();
    $utilisateur = $um->getUtilisateurParCourriel($courriel);

    if ($utilisateur) {
        $_SESSION['courriel'] = $utilisateur->getCourriel();
        $_SESSION['mdp'] = $utilisateur->getMdp();
        $_SESSION['role'] = $utilisateur->getRoleUtilisateur();
        echo "Utilisateur existant connecté : " . $courriel;
    } else {
        // Si nouvel utilisateur, on les met dans la bd
        $infosUtilisateur = [
            'prenom' => $payload['given_name'],  // prénom
            'nom' => $payload['family_name'],    // nom
            'courriel' => $courriel,             // email
            'est_actif' => 1,                    // actif
            'role' => 0,                         // rôle normal
            'type' => 1                          // type Google
        ];

        // Ajoute l'utilisateur à la BD
        $nouvelUtilisateur = addUtilisateur($infosUtilisateur);

        // Démarre la session pour le nouvel utilisateur
        if ($nouvelUtilisateur) {
            $_SESSION['courriel'] = $nouvelUtilisateur->getCourriel();
            $_SESSION['role'] = $nouvelUtilisateur->getRoleUtilisateur();
        }
        echo "Nouvel utilisateur créé : " . $courriel;
    }
}

function addUtilisateur($infosUtilisateur)
{
   $utilisateurManager = new UtilisateurManager();
    $utilisateur = $utilisateurManager->addUtilisateur($infosUtilisateur);
}




?>