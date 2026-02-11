<?php
require('model/UtilisateurManager.php');



function getFormConnexion(){
    require_once('view/loginView.php');
}


function authentifier($courriel, $motPasse){
    $utilisateurManager = new UtilisateurManager();
    $utilisateur = $utilisateurManager->verifAuthentification($courriel, $motPasse);
    
    if ($utilisateur !== null) {
        // Authentification réussie
        // Ajouter les informations dans $_SESSION
        $_SESSION['courriel'] = $utilisateur->getCourriel();
        $_SESSION['motPasse'] = $utilisateur->getMdp();
        $_SESSION['role'] = $utilisateur->getRoleUtilisateur();
        
        // Redirection vers la page d'accueil
        header('Location: ./');
    } else {
        // Authentification échouée
        // Afficher le formulaire de connexion
        getFormConnexion();
    }
}

function deconnexion(){
    session_destroy();
    // Charger l'accueil et afficher la liste des produits
    require('controller/controllerAccueil.php');
    listProduits();
}

<?php
function authentificationGoogle($credential) {
    // Inclut la bibliothèque Google Client
    require_once 'vendor/autoload.php';

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

    // Appelle la méthode pour vérifier si l'utilisateur existe déjà
    $utilisateur = getUtilisateurParCourriel($courriel);

    if ($utilisateur) {
        // L'utilisateur existe déjà, la session commence
        $_SESSION['user'] = $utilisateur;
        echo "Utilisateur existant connecté : " . $courriel;
    } else {
        // Si nouvel utilisateur, on les met dans la bd
        $infosUtilisateur = [
            'prenom' => $payload['given_name'],  // prénom
            'nom' => $payload['family_name'],    // nom
            'courriel' => $courriel,             // email
            'actif' => 1,                         // actif
            'role' => 0,                           // rôle normal
            'type' => 1                            // type Google
        ];

        // Ajoute l'utilisateur à la BD
        $nouvelUtilisateur = addUtilisateur($infosUtilisateur);

        // Démarre la session pour le nouvel utilisateur
        $_SESSION['user'] = $nouvelUtilisateur;
        echo "Nouvel utilisateur créé : " . $courriel;
    }
}

function addUtilisateur($infosUtilisateur) {
    $pdo = new PDO('mysql:host=localhost;dbname=dwalabo;charset=utf8', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("
        INSERT INTO tbl_utilisateur
        (nom, prenom, courriel, mdp, est_actif, role_utilisateur, type_utilisateur, token)
        VALUES
        (:nom, :prenom, :courriel, :mdp, :est_actif, :role_utilisateur, :type_utilisateur, :token)
    ");

    // Pour Google, mdp = vide ou un hash aléatoire
    $mdp = password_hash(bin2hex(random_bytes(8)), PASSWORD_DEFAULT);

    $stmt->execute([
        'nom' => $infosUtilisateur['nom'],
        'prenom' => $infosUtilisateur['prenom'],
        'courriel' => $infosUtilisateur['courriel'],
        'mdp' => $mdp,
        'est_actif' => $infosUtilisateur['est_actif'],
        'role_utilisateur' => $infosUtilisateur['role'],
        'type_utilisateur' => $infosUtilisateur['type'],
        'token' => ''
    ]);

    // Retourne l'utilisateur créé
    return getUtilisateurParCourriel($infosUtilisateur['courriel']);
}




?>