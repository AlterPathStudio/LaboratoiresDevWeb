<?php

//La classe Produit représente les champs présents dans la table produit.

class Produit {
    private $_id_produit;
    private $_id_categorie;
    private $_categorie; // N'est pas dans la table produit, mais les requêtes vont aussi chercher le nom de la catégorie en faisant une jointure.
    private $_produit;
    private $_description;

    public function __construct($params = array()){
  
        foreach($params as $k => $v){

            $methodName = "set_" . $k;
            if(method_exists($this, $methodName)) {
                $this->$methodName($v);
            }   
        }
    }

    /**
     * Get the value of _id_produit
     */ 
    public function get_id_produit()
    {
        return $this->_id_produit;
    }

    /**
     * Set the value of _id_produit
     *
     * @return  self
     */ 
    public function set_id_produit($_id_produit)
    {
        $this->_id_produit = $_id_produit;

        return $this;
    }

    /**
     * Get the value of _id_categorie
     */ 
    public function get_id_categorie()
    {
        return $this->_id_categorie;
    }

    /**
     * Set the value of _id_categorie
     *
     * @return  self
     */ 
    public function set_id_categorie($_id_categorie)
    {
        $this->_id_categorie = $_id_categorie;

        return $this;
    }

    /**
     * Get the value of _produit
     */ 
    public function get_produit()
    {
        return $this->_produit;
    }

    /**
     * Set the value of _produit
     *
     * @return  self
     */ 
    public function set_produit($_produit)
    {
        $this->_produit = $_produit;

        return $this;
    }

    /**
     * Get the value of _description
     */ 
    public function get_description()
    {
        return $this->_description;
    }

    /**
     * Set the value of _description
     *
     * @return  self
     */ 
    public function set_description($_description)
    {
        $this->_description = $_description;

        return $this;
    }

    /**
     * Get the value of _categorie
     */ 
    public function get_categorie()
    {
        return $this->_categorie;
    }

    /**
     * Set the value of _categorie
     *
     * @return  self
     */ 
    public function set_categorie($_categorie)
    {
        $this->_categorie = $_categorie;

        return $this;
    }
}