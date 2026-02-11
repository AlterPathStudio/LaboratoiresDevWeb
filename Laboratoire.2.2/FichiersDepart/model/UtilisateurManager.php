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

        // DEBUG: Afficher ce qu'on a trouvé
        echo "<pre>DEBUG SQL: ";
        print_r($data);
        echo "</pre>";

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




}






?>