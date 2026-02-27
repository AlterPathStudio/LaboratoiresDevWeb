<?php
    /*
        Cette classe sert de point commun à tous les modèles et offre les fonctions génériques
        communes à tous. Dans notre cas ce sera l'accès à la BD.
    */

    class Manager {
        const HOSTNAME = 'db';
        const DBNAME = 'dwalabo';
        const USERNAME = 'root';
        const PASSWORD = 'f4q2DG2obVd3I';

        protected function db_connect() {
            $db = new PDO(
                            'mysql:host=' . self::HOSTNAME . ';dbname=' . self::DBNAME . ';charset=utf8', 
                            self::USERNAME,
                            self::PASSWORD
                         );
            
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                         
            return $db;
        }
    };
?>