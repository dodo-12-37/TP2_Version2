<?php
    
class Pays
{
    // Attributs
    private $m_id;
    private $m_nom;
    private $m_codeMonnaie;
    private $m_taux;
    private $m_continent;
    

    // Constructeur
    public function __construct($p_id, $p_nom, $p_codeMonnaie, $p_taux, $p_continent){
        $this->setID($p_id);
        $this->setNom($p_nom);
        $this->setCodeMonnaie($p_codeMonnaie);
        $this->setTaux($p_taux);
        $this->setContinent($p_continent);
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

    public function getCodeMonnaie(){
        return $this->m_codeMonnaie;
    }
    public function setCodeMonnaie($p_codeMonnaie){
        // +Ajout validation codeMonnaie
        $this->m_codeMonnaie = $p_codeMonnaie;
    }

    public function getTaux(){
        return $this->m_taux;
    }
    public function setTaux($p_taux){
        // +Ajout validation taux
        $this->m_taux = $p_taux;
    }

    public function getContinent(){
        return $this->m_continent;
    }
    public function setContinent($p_continent){
        // +Ajout validation ville
        $this->m_continent = $p_continent;
    }



    // Methodes
    public function verifID(){
        return true;
    }

    public function verifNom(){
        return true;
    }

    public function verifCodeMonnaie(){
        return true;
    }

    public function verifTaux(){
        return true;
    }

    public function verifContinent(){
        return true;
    }

}

?>