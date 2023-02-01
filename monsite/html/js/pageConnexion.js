// Auteur : Binh
'use strict'

$(document).ready(function () {

    let estValide = true;

    // Supprimer toutes les erreurs et Réintilialiser le formulaire
    $('#conn_reset').click(function () {
        $(".err_texts").text("");
    });

    // Vérifier le fomulaire onclick submit
    $('#conn_submit').click(function (e) {
        estValide = true;

        // Supprimer toutes les erreurs et Réintilialiser le formulaire
        $(".err_texts").text("");

        // vérifier courriel
        verifierCourriel();

        // Vérifier mot de passe
        verifierMDP();

        if (!estValide) {
            e.preventDefault();
        }

    });

    // Vérifier courriel sans clicker submit
    $('#courriel').keyup(function () {
        verifierCourriel();
    });

    // Vérifier mot de passe sans clicker submit
    $('#mot_de_passe').keyup(function () {
        verifierMDP();
    });

    // Liste des fonctions
    function motDPasseDAccordRegex() {
        let motDPass = $('#mot_de_passe').val();
        let masqueMotDPass1 = /^.*\d+.*$/; // check contenir chiffre
        let masqueMotDPass2 = /^.*[a-z]+.*$/; // check contenir caratère 
        let masqueMotDPass3 = /^.*[A-Z]+.*$/; // check contenir CARACTÉRE
        let masqueMotDPass4 = /^.*[\@\?\$\#\&\^\*\+\±\=\_\\\£\%\|\!]+.*$/; //check contenir spécial caractére
        let estDAccrod = motDPass.length >= 8 && masqueMotDPass1.test(motDPass) && masqueMotDPass2.test(motDPass) && masqueMotDPass3.test(motDPass) && masqueMotDPass4.test(motDPass);
        return estDAccrod;
    }

    function verifierMDP() {
        // Supprimer les erreurs
        $("#err_MDP").text("");

        if (!motDPasseDAccordRegex()) {
            estValide = false;
            $('#err_MDP').text('(*) Refusé.');
            $("#mdp_explique").text("Mot de passe doit contenir au minimum 8 caractères: au moins une lettre minuscule et une lettre majuscule, un caractère spécial et un chiffre.");
        } else {
            $('#err_MDP').text('');
            $("#mdp_explique").text('');
        }
    }

    function verifierCourriel() {
        let masqueCourriel = /^\w+@\w+\.\w+$/;
        let adresseCourriel = $('#courriel').val();

        $("#errCourriel").text("");

        if (adresseCourriel == '') {
            estValide = false;
            $('#errCourriel').text('(*) Champ obligatoire.');
        }
        else if (!masqueCourriel.test(adresseCourriel)) {
            estValide = false;
            $('#errCourriel').text('(*) Adresse courriel invalide.');
        }
    }

    function afficherMsg() {
        let courriel_txt = $('#courriel').val();

        let ligne1 = "SVP vérifier les information suivant:\n";
        let ligne2 = "Votre courriel: " + courriel_txt + "\n";

        let msg_txt = ligne1 + ligne2;

        return msg_txt;
    }
})