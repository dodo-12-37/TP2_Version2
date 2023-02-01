// Auteur : Binh
'use strict'

$(document).ready(function () {
    // Vérifier le fomulaire onclick submit
    // $('#deconn_submit').click(function (e) {
    //     estValide = true;

    //     if (confirm("Voulez-vous vraiment vous déconnecter ?")) {
    //         estValide = true;
    //     } else {
    //         estValide = false;
    //     }

    //     if (!estValide) {
    //         e.preventDefault();
    //     }
    // });

    let estValide = true;

    // Supprimer toutes les erreurs et Réintilialiser la formulaire
    $('#ins_reset').click(function () {
        $(".err_texts").text("");
    });

    // Vérifier le fomulaire onclick submit
    $('#ins_submit').click(function (e) {
        estValide = true;

        // Supprimer toutes les erreurs et Réintilialiser la formulaire
        $(".err_texts").text("");

        // vérifier Nom
        if ($('#nom_utilisateur').val() == '') {
            estValide = false;
            $('#errNom').text('(*) Champ obligatoire.');
        }

        // vérifier courriel
        let masqueCourriel = /^\w+@\w+\.\w+$/;
        let adresseCourriel = $('#courriel').val();
        if (adresseCourriel == '') {
            estValide = false;
            $('#errCourriel').text('(*) Champ obligatoire.');
        }
        else if (!masqueCourriel.test(adresseCourriel)) {
            estValide = false;
            $('#errCourriel').text('(*) Adresse courriel invalide.');
        }

        // Vérifier mot de passe
        verifierMDP();
        
        // Confirmer mot de passe
        confirmerMDP();
        console.log(estValide);

        // Vérifier âge
        let ageUtilisateur = $('#age_utilisateur');
        if (ageUtilisateur.val() != '') {
            if (ageUtilisateur.val() > 100 || ageUtilisateur.val() < 18) {
                estValide = false;
                $('#err_age').text('(*) Âge invalide')
            }
        }

        if (!estValide) {
            e.preventDefault();
        }
        else {
            // let decision = ;

            if (!confirm(afficherMsg())) {
                e.preventDefault();
            }
        }
    });

    // Vérifier mot de passe sans clicker submit
    $('#mot_de_passe').keyup(function () {
        verifierMDP();
    });

    //Vérifier mot de passe sans clicker submit
    $('#mot_de_passe').keyup(function () {
        confirmerMDP()
    });

    //Vérifier confirmation de mot de passe sans clicker submit
    $('#confirmer_mdp').keyup(function () {
        confirmerMDP()
    });

    // Liste des fonctions
    function motDPasseDAccordRegex() {
        let motDPass = $('#mot_de_passe').val();
        let masqueMotDPass1 = /^.*\d+.*$/; // check contenir chiffre
        let masqueMotDPass2 = /^.*[a-z]+.*$/; // check contenir caractères 
        let masqueMotDPass3 = /^.*[A-Z]+.*$/; // check contenir CARACTÈRES
        let masqueMotDPass4 = /^.*[\@\?\$\#\&\^\*\+\±\=\_\\\£\%\|\!]+.*$/; //check contenir spécial caractères
        let estDAccord = motDPass.length >= 8 && masqueMotDPass1.test(motDPass) && masqueMotDPass2.test(motDPass) && masqueMotDPass3.test(motDPass) && masqueMotDPass4.test(motDPass);
        return estDAccord;
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

    function confirmerMDP() {
        // Supprimer les erreurs
        $("#err_cf_mdp").text("");

        // check mdp ==confirmer_mdp
        if ($('#confirmer_mdp').val() != $('#mot_de_passe').val()) {
            $('#err_cf_mdp').text("(*) Non identique.")
            estValide = false;
        }
    }

    function afficherMsg() {
        let nom_txt = $('#nom_utilisateur').val();
        let age_txt = $('#age_utilisateur').val();
        let courriel_txt = $('#courriel').val();

        let ligne1 = "SVP vérifier les information suivant: \n";
        let ligne2 = "Votre nom: " + nom_txt + "\n";
        let ligne3 = "Votre âge: " + age_txt + "\n";
        let ligne4 = "Votre courriel: " + courriel_txt + "\n";

        let msg_txt = ligne1 + ligne2 + ligne3 + ligne4;

        return msg_txt;
    }
})