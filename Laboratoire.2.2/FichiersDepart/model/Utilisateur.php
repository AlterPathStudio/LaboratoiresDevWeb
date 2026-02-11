<?php


class Utilisateur{
    private $id;
    private $nom;
    private $prenom;
    private $courriel;
    private $mdp;
    private $role_utilisateur;

    public function __construct($params = array()){
  
        foreach($params as $k => $v){

            $methodName = "set_" . $k;
            if(method_exists($this, $methodName)) {
                $this->$methodName($v);
            }   
        }
    }

    



    /**
     * Get the value of mdp
     */ 
    public function getMdp()
    {
        return $this->mdp;
    }

    /**
     * Alias pour getMdp() - utilisé par UtilisateurManager
     */ 
    public function get_mot_passe()
    {
        return $this->getMdp();
    }

    /**
     * Set the value of mdp
     *
     * @return  self
     */ 
    public function setMdp($mdp)
    {
        $this->mdp = $mdp;

        return $this;
    }

    /**
     * Get the value of courriel
     */ 
    public function getCourriel()
    {
        return $this->courriel;
    }

    /**
     * Set the value of courriel
     *
     * @return  self
     */ 
    public function setCourriel($courriel)
    {
        $this->courriel = $courriel;

        return $this;
    }

    /**
     * Get the value of prenom
     */ 
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set the value of prenom
     *
     * @return  self
     */ 
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get the value of nom
     */ 
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set the value of nom
     *
     * @return  self
     */ 
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of role_utilisateur
     */ 
    public function getRoleUtilisateur()
    {
        return $this->role_utilisateur;
    }

    /**
     * Set the value of role_utilisateur
     *
     * @return  self
     */ 
    public function setRole_utilisateur($role_utilisateur)
    {
        $this->role_utilisateur = $role_utilisateur;

        return $this;
    }
}













?>