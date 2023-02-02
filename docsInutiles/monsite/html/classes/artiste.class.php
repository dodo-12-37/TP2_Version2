<?php

class Artiste
{
    // Attributs
    private $m_id;
    private $m_nom;
    private $m_imageName;
    private $m_ville;


    // Constructeur
    public function __construct($p_id, $p_nom, $p_imageName, $p_ville){
        $this->setID($p_id);
        $this->setNom($p_nom);
        $this->setImageName($p_imageName);
        $this->setVille($p_ville);
    }


    // Getter/Setter
    public function getID()
    {
        return $this->m_id;
    }
    public function setID($p_id)
    {
        // +Ajout validation id

        $this->m_id = $p_id;
    }

    public function getNom()
    {
        return $this->m_nom;
    }
    public function setNom($p_nom)
    {
        // +Ajout validation titre
        $this->m_nom = $p_nom;
    }

    public function getImageName()
    {
        return $this->m_imageName;
    }
    public function setImageName($p_imageName)
    {
        $this->m_imageName = $p_imageName;
    }

    public function getIdVille()
    {
        return $this->m_ville;
    }
    public function setVille($p_ville)
    {
        // +Ajout validation ville
        $this->m_ville = $p_ville;
    }


    // Methodes
    public function verifID()
    {
        return true;
    }

    public function verifNom()
    {
        return true;
    }

    public function verifImageName()
    {
        return true;
    }

    public function verifVille()
    {
        return true;
    }
    
    public function __toString()
    {
        return $this->getID . " " . $this->getNom . " " . $this->getVille;
    }
}

?>