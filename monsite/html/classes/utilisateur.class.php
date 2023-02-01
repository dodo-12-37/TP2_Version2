<?php

class Utilisateur
{
    // Attributs
    private $m_id;
    private $m_nom;
    private $m_courriel;
    private $m_password;
    private $m_ville;
    private $m_age;
    private $m_type;


    // Constructeur
    public function __construct($p_id, $p_nom, $p_courriel, $p_password, $p_ville, $p_age)
    {
        $this->setID($p_id);
        $this->setNom($p_nom);
        $this->setCourriel($p_courriel);
        $this->setPassword($p_password);
        $this->setVille($p_ville);
        $this->setAge($p_age);
        $this->setType($p_id);
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
        // +Ajout validation nom
        $this->m_nom = $p_nom;
    }

    public function getCourriel()
    {
        return $this->m_courriel;
    }
    public function setCourriel($p_courriel)
    {
        // +Ajout validation Courriel
        // if ($this->verifCourriel($p_courriel)) {
        //     $this->m_courriel = $p_courriel;
        // }
        // else {
        //     $erreurCourriel = "Erreur du courriel...";
        //     return $erreurCourriel;
        // }

        //if ($this->verifCourriel($p_courriel)) {
            //throw new InvalidArgumentException("Adresse courriel invalide.");
            $this->m_courriel = $p_courriel;
        //}
    }

    public function getPassword()
    {
        return $this->m_password;
    }
    public function setPassword($p_password)
    {
        // +Ajout validation password
        //if ($this->verifPassword($p_password)) {
            //throw new InvalidArgumentException("Mot de passe doit contenir au minimum 8 caractères: au moins une lettre minuscule et une lettre majuscule, un caractère spécial et un chiffre.");
            $this->m_password = $p_password;
        //}
    }

    public function getVille()
    {
        return $this->m_ville;
    }
    public function setVille($p_ville)
    {
        // +Ajout validation ville
        $this->m_ville = $p_ville;
    }

    public function getAge()
    {
        return $this->m_age;
    }
    public function setAge($p_age)
    {
        // +Ajout validation age
        $this->m_age = $p_age;
    }

    public function getType()
    {
        return $this->m_type;
    }
    public function setType($p_id)
    {
        // +Ajout validation type
        if ($p_id <= 5) {
            $this->m_type = 'gerant';
        } else {
            $this->m_type = 'client';
        }
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

    public function verifCourriel($p_courriel)
    {
        // function verifierCourriel() {
        //     let masqueCourriel = /^\w+@\w+\.\w+$/;
        //     let adresseCourriel = $('#courriel').val();

        // $exp = "/^\w+@\w+\.\w+$/";

        // if (preg_match($exp, $p_courriel)) {
        //     return true;
        // }

        // return false;
    }

    public function verifPassword($p_password)
    {
        // let masqueMotDPass1 = /^.*\d+.*$/; // check contenir chiffre
        // let masqueMotDPass2 = /^.*[a-z]+.*$/; // check contenir caratère 
        // let masqueMotDPass3 = /^.*[A-Z]+.*$/; // check contenir CARACTÉRE
        // let masqueMotDPass4 = /^.*[\@\?\$\#\&\^\*\+\±\=\_\\\£\%\|\!]+.*$/; //check contenir spécial caractére
        // let estDAccrod = motDPass.length >= 8 && masqueMotDPass1.test(motDPass) && masqueMotDPass2.test(motDPass) && masqueMotDPass3.test(motDPass) && masqueMotDPass4.test(motDPass);
        // return estDAccrod;

        // $masque1 = "/^.*\d+.*$/";
        // $masque2 = "/^.*[a-z]+.*$/";
        // $masque3 = "/^.*[A-Z]+.*$/";
        // $masque4 = "/^.*[\@\?\$\#\&\^\*\+\±\=\_\\\£\%\|\!]+.*$/";

        // $masque = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$#!%*?&]{8,}$/";

        // return true;
    }

    public function verifVille()
    {
        return true;
    }

    public function verifAge()
    {
        return true;
    }

    public function verifType()
    {
        return true;
    }
}
