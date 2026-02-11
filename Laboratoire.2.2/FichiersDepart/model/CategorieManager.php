<?php
require_once("model/Manager.php");
require_once("model/Categorie.php");

class CategorieManager extends Manager{

    public function getCategories(){
        $db = $this->db_connect();
        $req = $db->query('SELECT * FROM tbl_categorie ORDER BY id_categorie');

        $categories = array();

        while($data = $req->fetch()){
            array_push($categories, new Categorie($data));
        }

        $req->closeCursor();
        return $categories;

    }
}

?>