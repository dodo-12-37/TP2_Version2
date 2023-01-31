<?php
    
class Ville
{
    // Attributs
    private $m_id;
    private $m_nom;
    private $m_pays;
    

    // Constructeur
    public function __construct($p_id, $p_nom, $p_pays){
        $this->setNom($p_nom);
        $this->setID($p_id);
        $this->setPays($p_pays);
    }


    // Getter/Setter
    public function getID(){
        return $this->m_id;
    }
    public function setID($p_id){
        // +Ajout validation id
        $this->m_id = $p_id;
    }

    public function getNom(){
        return $this->m_nom;
    }
    public function setNom($p_nom){
        // +Ajout validation nom
        $this->m_nom = $p_nom;
    }
    
    public function getPays(){
        return $this->m_pays;
    }
    public function setPays($p_pays){
        // +Ajout validation pays
        $this->m_pays = $p_pays;
    }



    // Methodes
    public function verifID(){
        return true;
    }

    public function verifNom(){
        return true;
    }

    public function verifPays(){
        return true;
    }

}

?>