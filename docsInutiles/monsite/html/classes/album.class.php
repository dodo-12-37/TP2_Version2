<?php
    
class Album
{
    // Attributs
    private $m_id;
    private $m_titre;
    private $m_codeAlbum;
    private $m_dateAlbum;
    private $m_genre;
    private $m_imageName;
    private $m_listeOeuvres;
    
    
    // Constructeur
    public function __construct($p_id, $p_titre, $p_codeAlbum, $p_dateAlbum, $p_genre, $p_imageName, $p_listeOeuvres){
        $this->setID($p_id);
        $this->setTitre($p_titre);
        $this->setCodeAlbum($p_codeAlbum);
        $this->setDateAlbum($p_dateAlbum);
        $this->setGenre($p_genre);
        $this->setImageName($p_imageName);
        $this->setListeOeuvres($p_listeOeuvres);
    }


    // Getter/Setter
    public function getID(){
        return $this->m_id;
    }
    public function setID($p_id){
        // +Ajout validation id
        $this->m_id = $p_id;
    }

    public function getTitre(){
        return $this->m_titre;
    }
    public function setTitre($p_titre){
        // +Ajout validation titre
        $this->m_titre = $p_titre;
    }

    public function getCodeAlbum(){
        return $this->m_codeAlbum;
    }
    public function setCodeAlbum($p_codeAlbum){
        // +Ajout validation codeAlbum
        $this->m_codeAlbum = $p_codeAlbum;
    }

    public function getDateAlbum(){
        return $this->m_dateAlbum;
    }
    public function setDateAlbum($p_dateAlbum){
        // +Ajout validation dateAlbum
        $this->m_dateAlbum = $p_dateAlbum;
    }

    public function getGenre(){
        return $this->m_genre;
    }
    public function setGenre($p_genre){
        // +Ajout validation genre
        $this->m_genre = $p_genre;
    }

    public function getImageName(){
        return $this->m_imageName;
    }
    public function setImageName($p_imageName){
        // +Ajout validation imageName
        $this->m_imageName = $p_imageName;
    }

    public function getListeOeuvres(){
        return $this->m_listeOeuvres;
    }
    public function setListeOeuvres($p_listeOeuvres){
        // +Ajout validation type
        $this->m_listeOeuvres = $p_listeOeuvres;
    }


    // Methodes
    public function verifID(){
        return true;
    }

    public function verifTitre(){
        return true;
    }

    public function verifCodeAlbum(){
        return true;
    }

    public function verifDateAlbum(){
        return true;
    }

    public function verifGenre(){
        return true;
    }

    public function verifImageName(){
        return true;
    }

    public function verifType(){
        return true;
    }
}
