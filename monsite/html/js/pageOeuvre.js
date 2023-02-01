
// Auteur: Binh

$(document).ready(function () {

    //prend la date du jour comme valeur par défaut de la date d’ajout
    afficherDate();

    //Vérifier le formulaire on click button Envoyer
    $("#oeuvre_submit").click(function (e) {

        let titre_txt = $("#nom_oeuvre").val();
        let codeAlbum_txt = $('#art_code').val().split(":")[1]; //.substring(2, 9);
        let prix_txt = $("#art_prix").val();
        let artistNom_txt = $("#nomArtiste").val().split(":")[1];
        let duration_txt = $("#art_duration").val();
        let taille_txt = $("#art_taille").val();

        // Supprimer toutes les erreurs et Réintilialiser le formulaire
        $(".err_texts").text("");

        let estValide = true;

        // vérifier titre
        if (titre_txt == "") {
            estValide = false;
            $("#err_nom_oeuvre").text("(*) Champ obligatoire");
        }

        // vérifier Artiste principal
        if (artistNom_txt == "") {
            estValide = false;
            $("#err_art_principal").text("(*) Champ obligatoire");
        }

        // vérifier code d'album
        let masqueCodeAlbum = /^[A-Z]{3}[0-9]{4}$/;
        if (!masqueCodeAlbum.test(codeAlbum_txt) || codeAlbum_txt == "") {
            estValide = false;
            $("#err_art_code").text("(*) Code invalide");
        }

        // vérifier duration
        if (duration_txt <= 0 || duration_txt == "") {
            estValide = false;
            $("#err_art_duration").text("(*) Durée invalide");
        }

        // vérifier taille d'album
        if (taille_txt <= 0 || taille_txt == "") {
            estValide = false;
            $("#err_art_taille").text("(*) Taille invalide");
        }

        // vérifier prix
        if (prix_txt < 0 || prix_txt == "") {
            estValide = false;
            $("#err_art_prix").text("(*) Prix invalide");
        }

        if (!estValide) {
            e.preventDefault();
        }
        else {
            let decision = confirm(msg());

            if (!decision) {
                e.preventDefault();
            }
        }

        // Afficher message au utilisateur
        function msg() {
            //variables locaux
            let date_txt = $("#art_date_maj").val();
            let role_txt = $('#art_role').find('option:selected').text();
            let ligne0_txt = "SVP vérifier les informations suivantes:\n";
            let ligne1_txt = "Titre: " + titre_txt + "\n" + "Code: " + codeAlbum_txt + "\n" + "Prix: " + prix_txt + "\n";
            let ligne2_txt = "Artiste: " + artistNom_txt + "\n" + "Rôle: " + role_txt + "\n";
            let ligne3_txt = "Date d'ajouter: " + date_txt + "\n" + "Duré: " + duration_txt + "\n" + "Taille: " + taille_txt + "\n";
            let ligne4_txt = "Voulez-vous l'ajouter?"
            let msg_txt = ligne0_txt + ligne1_txt + ligne2_txt + ligne3_txt + ligne4_txt;
            return msg_txt;
        }
    });

    // Réinitialiser le formulaire
    $("#oeuvre_reset").on("click", function (e) {
        e.preventDefault();
        $("#art_form").trigger("reset");
        afficherDate();
        $(".err_texts").text("");
    })

    // Afficher date ajout
    function afficherDate() {
        let aujourdhui = new Date();
        $("#art_date_maj").val(aujourdhui.toLocaleDateString("fr-CA"));
    }
});


