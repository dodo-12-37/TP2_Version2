'use strict';

$(document).ready(function () {

    // Supprimer toutes les erreurs et Réintilialiser le formulaire
    $(".err_texts").text("");

    $("#btn_addCommande").click(function validerInput(e) {
        let estValide = true;

        if ($("#sltOeuvres").val() == null) {
            estValide = false;
        }

        if ($("#sltAlbums").val() == null) {
            estValide = false;
        }

        if (!validerValeurEntreMinMax($("#nbOeuvre").val(), 1, 10)) {
            estValide = false;
            alert("Le nombre d'oeuvres n'est pas entre 1 et 10 inclus. Recommencer.")
            $("#nbOeuvre").val() = 1;
        }

        if (estValide) {
            //updateTotaux();
        }
        else {
            e.preventDefault();
        }

    });

    $("#sltAlbums").change(function reloadOeuvre() {
        let albumID = $('#sltAlbums').val().split(":")[0];

        $.ajax({
            url: 'loadTracklist.php',
            dataType: "html",
            method: 'POST',
            data: {
                album: albumID
            },
            success: function (data) {
                $('#sltOeuvres').html(data)
            },
            error: function (data) {
                $('#err_sltOeuvres').html("Album Failed to load");
            }
        });
    });

    $("#listCommande input").change(function updateCart(e) {
        let indexVal = parseInt(e.target.id.split("nbOeuvre")[1] - 1);
        let quantiteVal = parseInt($("#" + e.target.id).val());

        $.ajax({
            method: 'POST',
            url: 'loadUpdateCart.php',
            data: {
                Index: indexVal,
                Quantite: quantiteVal
            },
            dataType: "html",
            success: function (data) {
                // $("#" + e.target.id).val(parseInt(quantite, 10));
                $("#listCommande").html(data);
                location.reload();
            }
        });
    });


    $("#btn_resetCommande").click(function resetCommande(e) {
        let estSupprimer = confirm("Voulez-vous vraiment réinitialiser le panier ?");

        if (!estSupprimer) {
            e.preventDefault();
        }else{
            //$("#formCommander").trigger("reset");
            //location.reload();
        }
    });

    function validerValeurEntreMinMax(valeur, min, max) {
        return valeur >= min && valeur <= max;
    }

    function updateTotaux() {
        // let rabaisTitre = $("#rabaisTitre");
        let sommePrixTotal = 0;
        let rabais = 0;
        // let listCommande = $("#listCommande").length;
        let prixRabaisCommande = $("#prixRabaisCommande");

        for (let indice = 0; indice < $("#listCommande").children().length; indice++) {
            sommePrixTotal += parseFloat(document.getElementById("prix" + Number(indice + 1)).textContent);
        }

        switch (true) {
            case sommePrixTotal >= 100:
                rabais = 0.2 * sommePrixTotal;
                $("#rabaisTitre").val("Rabais 20%: ");
                //prixRabaisCommande.parentElement.parentElement.classList.add("text-success");
                break;
            case sommePrixTotal >= 50:
                rabais = 0.1 * sommePrixTotal;
                $("#rabaisTitre").val("Rabais 10%: ");
                // rabaisTitre.textContent = "Rabais 10%: ";
                //prixRabaisCommande.parentElement.parentElement.classList.add("text-success");
                break;
            default:
                rabais = 0;
                $("#rabaisTitre").val("Rabais: ");
                // rabaisTitre.textContent = "Rabais: ";
                //prixRabaisCommande.parentElement.parentElement.classList.remove("text-success");
                break;
        }

        $("#prixTotalCommande").val((Math.round(sommePrixTotal * 100) / 100).toFixed(2));
        // prixTotalCommande.textContent = (Math.round(sommePrixTotal * 100) / 100).toFixed(2);
        $("#prixRabaisCommande").val((Math.round(rabais * 100) / 100).toFixed(2));
        // prixRabaisCommande.textContent = (Math.round(rabais * 100) / 100).toFixed(2);
        $("#prixTotalAvantTaxesCommande").val((Math.round((sommePrixTotal - rabais) * 100) / 100).toFixed(2));
        // prixTotalAvantTaxesCommande.textContent = (Math.round((sommePrixTotal - rabais) * 100) / 100).toFixed(2);

        let sommeTaxesCommande = ((sommePrixTotal - rabais) * 0.15);
        // taxesCommande.textContent = (Math.round(sommeTaxesCommande * 100) / 100).toFixed(2);
        $("#taxesCommande").val((Math.round(sommeTaxesCommande * 100) / 100).toFixed(2));

        $("#prixTotalTaxesCommande").val((Math.round((sommePrixTotal - rabais + sommeTaxesCommande) * 100) / 100).toFixed(2));
        // prixTotalTaxesCommande.textContent = (Math.round((sommePrixTotal - rabais + sommeTaxesCommande) * 100) / 100).toFixed(2);
    }

});