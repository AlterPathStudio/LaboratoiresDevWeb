<?php
require_once("model/Manager.php");
require_once("model/Utilisateur.php");


class UtilisateurManager extends Manager
{

    function getUtilisateurParCourriel($courriel)
    {
        $db = $this->db_connect();

        $sql = "SELECT * from tbl_utilisateur WHERE courriel = :courriel";

        $stmt = $db->prepare($sql);

        $stmt->bindValue(':courriel', $courriel);

        $stmt->execute();

        $data = $stmt->fetch();


        if ($data) {
            $user = new Utilisateur($data);
            return $user;
        }

        return null;

    }

    function verifAuthentification($courriel, $motPasse)
    {

        $utilisateur = $this->getUtilisateurParCourriel($courriel);

        if ($utilisateur) {     //Vérifie dans la base de données si l'utilisateur existe
            // Utilisateur trouvé, vérifier le mot de passe
            $hash = $utilisateur->get_mot_passe();
            if ($hash !== null && password_verify($motPasse, $hash)) {
                // Mot de passe correct
                return $utilisateur;
            } else {
                // Mot de passe incorrect
                return null;
            }
        } else {
            // Utilisateur non trouvé
            return null;
        }
    }

    function addUtilisateur($infosUtilisateur)
{
    $pdo = new PDO('mysql:host=db;dbname=dwalabo;charset=utf8', 'root', 'f4q2DG2obVd3I');
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

    // Retourne l'utilisateur créé (via le manager)
    $um = new UtilisateurManager();
    return $um->getUtilisateurParCourriel($infosUtilisateur['courriel']);
}

    function addAutologin($id_utilisateur, $tokenHash)
    {
        $db = $this->db_connect();
        
        // 30 jours à partir d'aujourd'hui
        $date_expiration = date('Y-m-d', strtotime('+30 days'));
        
        $sql = "INSERT INTO tbl_autologin (id_utilisateur, token_hash, est_valide, date_expiration) 
                VALUES (:id_utilisateur, :token_hash, :est_valide, :date_expiration)";
        
        $stmt = $db->prepare($sql);
        
        $stmt->bindValue(':id_utilisateur', $id_utilisateur);
        $stmt->bindValue(':token_hash', $tokenHash);
        $stmt->bindValue(':est_valide', 1);
        $stmt->bindValue(':date_expiration', $date_expiration);
        
        return $stmt->execute();
    }

    function verifyAutologin($courriel, $tokenClair)
    {
        $db = $this->db_connect();
        
        // Récupérer l'utilisateur par courriel
        $utilisateur = $this->getUtilisateurParCourriel($courriel);
        
        if (!$utilisateur) {
            return null;
        }
        
        // Récupérer l'enregistrement autologin de cet utilisateur
        $sql = "SELECT * FROM tbl_autologin 
                WHERE id_utilisateur = :id_utilisateur 
                AND est_valide = 1 
                AND date_expiration >= CURDATE()
                ORDER BY id_autologin DESC
                LIMIT 1";
        
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id_utilisateur', $utilisateur->getId());
        $stmt->execute();
        
        $data = $stmt->fetch();
        
        if (!$data) {
            return null;
        }
        
        // Vérifier que le token fourni correspond au token hachée en BD
        if (password_verify($tokenClair, $data['token_hash'])) {
            return $utilisateur;
        }
        
        return null;
    }

}






?>