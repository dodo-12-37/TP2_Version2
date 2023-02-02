<?php

class Oeuvre
{
    // Attributs
    private $m_id;
    private $m_titre;
    private $m_idArtiste;
    private $m_idRole;
    private $m_dureeSec;
    private $m_tailleMb;
    private $m_dateAjout;
    private $m_idAlbum;
    private $m_prix;
    private $m_lyric;
    //private $m_nbCopie;

    // new Oeuvre($idOeuvre, $titreOeuvre, $nomArtiste, $descriptionRole, $dureesec, $tailleMb, $dateAjout, $titreAlbum, $prix);
    // Constructeur
    public function __construct($p_id, $p_titre, $p_idArtiste, $p_dureeSec, $p_tailleMb, $p_lyric, $p_dateAjout, $p_idAlbum, $p_prix, $p_idRole)
    {
        $this->setID($p_id);
        $this->setTitre($p_titre);
        $this->setIdArtiste($p_idArtiste);
        $this->setIdRole($p_idRole);
        $this->setDureeSec($p_dureeSec);
        $this->setTailleMb($p_tailleMb);
        $this->setDateAjout($p_dateAjout);
        $this->setIdAlbum($p_idAlbum);
        $this->setPrix($p_prix);
        $this ->setLyric($p_lyric);
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

    public function getTitre(): string
    {
        return $this->m_titre;
    }
    public function setTitre($p_titre)
    {
        // +Ajout validation titre
        $this->m_titre = $p_titre;
    }

    public function getIdArtiste(): int
    {
        return $this->m_idArtiste;
    }
    public function setIdArtiste($p_idArtiste)
    {
        // +Ajout validation artiste
        $this->m_idArtiste = $p_idArtiste;
    }

    public function getIdRole(): int
    {
        return $this->m_idRole;
    }
    public function setIdRole($p_idRole)
    {
        // +Ajout validation role
        $this->m_idRole = $p_idRole;
    }

    public function getDureeSec(): int
    {
        return $this->m_dureeSec;
    }
    public function setDureeSec($p_dureeSec)
    {
        // +Ajout validation dureeSec
        $this->m_dureeSec = $p_dureeSec;
    }

    public function getTailleMb(): float
    {
        return $this->m_tailleMb;
    }
    public function setTailleMb($p_tailleMb)
    {
        // +Ajout validation tailleMb
        $this->m_tailleMb = $p_tailleMb;
    }

    public function getDateAjout()
    {
        return $this->m_dateAjout;
    }
    public function setDateAjout($p_dateAjout)
    {
        // +Ajout validation dateAjout
        $this->m_dateAjout = $p_dateAjout;
    }

    public function getIdAlbum(): int
    {
        return $this->m_idAlbum;
    }
    public function setIdAlbum($p_iDAlbum)
    {
        // +Ajout validation album
        $this->m_idAlbum = $p_iDAlbum;
    }

    public function getPrix(): int
    {
        return $this->m_prix;
    }
    public function setPrix($p_prix)
    {
        // +Ajout validation prix
        $this->m_prix = $p_prix;
    }

    public function getLyric(): ?string
    {
        return $this->m_lyric;
    }
    public function setLyric($p_lyric)
    {
        // +Ajout validation prix
        $this->m_lyric = $p_lyric;
    }
    


    // Methodes
    public function verifID()
    {
        return true;
    }

    public function verifTitre()
    {
        return true;
    }

    public function verifArtiste()
    {
        return true;
    }

    public function verifRole()
    {
        return true;
    }

    public function verifDureeSec()
    {
        return true;
    }

    public function verifTailleMb()
    {
        return true;
    }

    public function verifDateAjout()
    {
        return true;
    }

    public function verifAlbum()
    {
        return true;
    }

    public function verifPrix()
    {
        return true;
    }
}
