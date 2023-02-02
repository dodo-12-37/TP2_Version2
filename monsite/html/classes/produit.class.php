<?php
class produit
{
    //Atributs
    private $m_Id;
    private $m_Album;
    private $m_Oeuvre;
    private $m_PrixUnitaire;
    private $m_Image;

    //Constructeur
    public function __construct($p_Id, Album $p_Album, Oeuvre $p_Oeuvre, $p_PrixUnitaire, $p_Image)
    {
        $this->setId($p_Id);
        $this->setAlbum($p_Album);
        $this->setOeuvre($p_Oeuvre);
        $this->setPrixUnitaire($p_PrixUnitaire);
        $this->setImage($p_Image);
    }

    // getter/setter
    public function getId()
    {
        return $this->m_Id;
    }
    // il faut ajouter les validations dans les set
    public function setId($p_Id)
    {
        $this->m_Id = $p_Id;
    }

    public function getAlbum()
    {
        return $this->m_Album;
    }
    public function setAlbum($p_Album)
    {
        $this->m_Album = $p_Album;
    }

    public function getOeuvre()
    {
        return $this->m_Oeuvre;
    }
    public function setOeuvre($p_Oeuvre)
    {
        $this->m_Oeuvre = $p_Oeuvre;
    }

    public function getPrixUnitaire()
    {
        return $this->m_PrixUnitaire;
    }
    public function setPrixUnitaire($p_PrixUnitaire)
    {
        $this->m_PrixUnitaire = $p_PrixUnitaire;
    }

    public function getPrixProduitTotal(int $p_quantite)
    {
        return $this->getPrixUnitaire() * $p_quantite;
    }

    public function getImage()
    {
        return $this->m_Image;
    }
    public function setImage($p_Image)
    {
        $this->m_Image = $p_Image;
    }

    public function getAlbumTitre()
    {
        return $this->m_Album->getTitre();
    }

    public function getOeuvreTitre()
    {
        return $this->m_Oeuvre->getTitre();
    }


    //Methodes
    


    public function __toString()
    {
        return $this->m_Id . " " . $this->m_Name . " " . $this->m_Price;
    }
}

