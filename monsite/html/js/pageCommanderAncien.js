'use strict';

$(document).ready(function () {

    // let listCommande = document.getElementById("listCommande");
    let input_sltOeuvres = document.getElementById("sltOeuvres");
    // let input_sltAlbums = document.getElementById("sltAlbums");
    let input_nbOeuvres = document.getElementById("nbOeuvre");

    let prixTotalCommande = document.getElementById("prixTotalCommande");
    let prixRabaisCommande = document.getElementById("prixRabaisCommande");
    let taxesCommande = document.getElementById("taxesCommande");
    let prixTotalAvantTaxesCommande = document.getElementById("prixTotalAvantTaxesCommande");
    let prixTotalTaxesCommande = document.getElementById("prixTotalTaxesCommande");

    // document.getElementById("btn_addCommande").addEventListener("click", validerInputNombreOeuvres);
    document.getElementById("btn_resetCommande").addEventListener("click", resetCommande);
    document.getElementById("btn_submitCommande").addEventListener("click", submitCommande);

    // listCommande.forEach(produit => {
    //     produit.addEventListener("change", validerInputNombreOeuvresItems);

    // });

    for (let index = 0; index < listCommande.length; index++) {
        const produit = listCommande[index];
        produit.addEventListener("change", validerInputNombreOeuvresItems);
    }

    // input_sltAlbums.addEventListener("change", reloadOeuvre);


    // function reloadOeuvre() {
    //     //input_sltOeuvres
    //     let albumID = $('#sltAlbums').val().split(":")[0];

    //     $.ajax({
    //         url: 'loadTracklist.php',
    //         dataType: "html",
    //         method: 'post',
    //         data: {
    //             album: albumID
    //         },
    //         success: function (data) {
    //             $('#sltOeuvres').html(data)
    //         },
    //         error: function (data) {
    //             $('#sltOeuvres').html("Album Failed to load");
    //         }
    //     });
    // }


    function validerInputNombreOeuvres(e) {
        //e.preventDefault();

        for (let index = 0; index < listCommande.length; index++) {
            const produit = listCommande[index];
            console.log(produit);
            produit.addEventListener("change", validerInputNombreOeuvresItems);
        }

        if (validerValeurEntreMinMax(input_nbOeuvres.value, 1, 10)) {
            ajouterCommande();
        }
        else {
            alert("Le nombre d'oeuvres n'est pas entre 1 et 10 inclus. Recommencer.")
            input_nbOeuvres.value = 1;
        }
    }

    function validerInputNombreOeuvresItems(e) {
        let numId = parseInt(e.target.id.substring(8));

        if (validerValeurEntreMinMax(e.target.value, 0, 10)) {
            changerPrixItem(e, numId);
        }
        else {
            alert("Le nombre d'oeuvres de l'item de commande #" + numId + " n'est pas entre 0 et 10 inclus. Recommencer!")
            e.target.value = 1;
        }
    }

    function validerValeurEntreMinMax(valeur, min, max) {
        return valeur >= min && valeur <= max;
    }

    function ajouterCommande() {
        //listCommande.append(creerItemCommande());
        updateTotaux();
    }

    function changerPrixItem(e, numId) {
        numId = supprimerItem(e, numId);

        if (listCommande.childElementCount != 0) {
            let spanPrixUnitaireItem = document.getElementById("prixUnitaire" + numId);
            let spanPrixItem = document.getElementById("prix" + numId);
            let nbOeuvresItem = document.getElementById("nbOeuvre" + numId);

            spanPrixItem.textContent = calculerPrixItem(spanPrixUnitaireItem.textContent, nbOeuvresItem.value).toFixed(2);
        }

        updateTotaux();
    }

    function creerItemCommande() {
        let nbItemCommandes = listCommande.childElementCount + 1;

        let newItemCommande = document.createElement("div");
        newItemCommande.classList.add("col-12", "col-lg-6", "mb-2", "p-2", "border");
        newItemCommande.id = "commande" + nbItemCommandes;

        let imageItem = document.createElement("img");
        imageItem.src = "img/" + input_sltAlbums.value + ".jpeg";
        imageItem.alt = "Image de l'album";
        imageItem.classList.add("float-right", "img-thumbnail", "mb-2")
        imageItem.width = 75;
        imageItem.height = 75;
        newItemCommande.append(imageItem);

        let titreItem = document.createElement("h4");
        titreItem.textContent = input_sltOeuvres.value;
        newItemCommande.append(titreItem);

        let nomAlbumItem = document.createElement("p");
        nomAlbumItem.textContent = input_sltAlbums.value;
        newItemCommande.append(nomAlbumItem);

        let inputNombreAlbumItem = document.createElement("input");
        inputNombreAlbumItem.type = "number";
        inputNombreAlbumItem.classList.add("form-control", "mb-3");
        inputNombreAlbumItem.name = "nbOeuvre" + nbItemCommandes;
        inputNombreAlbumItem.id = "nbOeuvre" + nbItemCommandes;
        inputNombreAlbumItem.value = input_nbOeuvres.value;
        inputNombreAlbumItem.min = 0;
        inputNombreAlbumItem.max = 10;
        inputNombreAlbumItem.addEventListener("change", validerInputNombreOeuvresItems);
        newItemCommande.append(inputNombreAlbumItem);

        let spanPrixUnitaireItem = document.createElement("span");
        spanPrixUnitaireItem.id = "prixUnitaire" + nbItemCommandes;
        spanPrixUnitaireItem.textContent = (Math.round((Math.random() + 0.01) * 10 * 100) / 100).toFixed(2);
        let divPrixUnitaireItem = document.createElement("div");
        divPrixUnitaireItem.append("Prix unitaire: ", spanPrixUnitaireItem, " $");
        newItemCommande.append(divPrixUnitaireItem);

        let spanPrixItem = document.createElement("span");
        spanPrixItem.id = "prix" + nbItemCommandes;
        spanPrixItem.textContent = calculerPrixItem(spanPrixUnitaireItem.textContent, input_nbOeuvres.value).toFixed(2);
        let divPrixItem = document.createElement("div");
        divPrixItem.classList.add("font-weight-bold", "font-italic");
        divPrixItem.append("Prix: ", spanPrixItem, " $");
        newItemCommande.append(divPrixItem);

        return newItemCommande;
    }

    function calculerPrixItem(prixUnitaireItem, nbOeuvresItem) {
        return (Math.round(parseFloat(nbOeuvresItem) * parseFloat(prixUnitaireItem) * 100) / 100);
    }

    function supprimerItem(e, numId) {

        if (e.target.value == 0) {
            let estSupprimer = confirm("Voulez-vous vraiment supprimer l'item ?");

            if (estSupprimer) {
                listCommande.removeChild(document.getElementById("commande" + numId));
                reajusterIdItem();
                if (numId != 1) {
                    numId -= 1;
                }
            }
            else {
                e.target.value = 1;
            }
        }

        return numId;
    }

    function reajusterIdItem() {
        for (let indice = 0; indice < listCommande.childElementCount; indice++) {
            const LIGNE_COMMANDE = listCommande.children[indice];

            LIGNE_COMMANDE.id = "commande" + Number(indice + 1);
            LIGNE_COMMANDE.children[3].id = "nbOeuvre" + Number(indice + 1);
            LIGNE_COMMANDE.children[4].children[0].id = "prixUnitaire" + Number(indice + 1);
            LIGNE_COMMANDE.children[5].children[0].id = "prix" + Number(indice + 1);
        }
    }

    function updateTotaux() {
        let rabaisTitre = document.getElementById("rabaisTitre");
        let sommePrixTotal = 0;
        let rabais = 0;

        for (let indice = 0; indice < listCommande.childElementCount; indice++) {
            sommePrixTotal += parseFloat(document.getElementById("prix" + Number(indice + 1)).textContent);
        }

        switch (true) {
            case sommePrixTotal >= 100:
                rabais = 0.2 * sommePrixTotal;
                rabaisTitre.textContent = "Rabais 20%: ";
                prixRabaisCommande.parentElement.parentElement.classList.add("text-success");
                break;
            case sommePrixTotal >= 50:
                rabais = 0.1 * sommePrixTotal;
                rabaisTitre.textContent = "Rabais 10%: ";
                prixRabaisCommande.parentElement.parentElement.classList.add("text-success");
                break;
            default:
                rabais = 0;
                rabaisTitre.textContent = "Rabais: ";
                prixRabaisCommande.parentElement.parentElement.classList.remove("text-success");
                break;
        }

        prixTotalCommande.textContent = (Math.round(sommePrixTotal * 100) / 100).toFixed(2);
        prixRabaisCommande.textContent = (Math.round(rabais * 100) / 100).toFixed(2);
        prixTotalAvantTaxesCommande.textContent = (Math.round((sommePrixTotal - rabais) * 100) / 100).toFixed(2);

        let sommeTaxesCommande = ((sommePrixTotal - rabais) * 0.15);
        taxesCommande.textContent = (Math.round(sommeTaxesCommande * 100) / 100).toFixed(2);

        prixTotalTaxesCommande.textContent = (Math.round((sommePrixTotal - rabais + sommeTaxesCommande) * 100) / 100).toFixed(2);
    }

    function resetCommande(e) {
        //e.preventDefault();
        input_sltAlbums.selectedIndex = 0;
        input_sltOeuvres.selectedIndex = 0;
        input_nbOeuvres.value = 1;

        while (listCommande.firstChild) {
            listCommande.removeChild(listCommande.lastChild);
        }

        updateTotaux();
    }

    function submitCommande(e) {
        let estValide = true;
        let listeStringItems = "";

        for (let indice = 0; indice < listCommande.childElementCount; indice++) {
            const LIGNE_COMMANDE = listCommande.children[indice];
            let nombreOeuvre = document.getElementById("nbOeuvre" + Number(indice + 1)).value;

            if (!validerValeurEntreMinMax(nombreOeuvre, 1, 10)) {
                estValide = false;
            }

            listeStringItems += "Item " + Number(indice + 1) + " (Oeuvre: " + LIGNE_COMMANDE.children[1].textContent + ", Album: " + LIGNE_COMMANDE.children[2].textContent +
                ", Nombre: " + LIGNE_COMMANDE.children[3].value + ", Prix unitaire: " + LIGNE_COMMANDE.children[4].children[0].textContent +
                "$, Prix: " + LIGNE_COMMANDE.children[5].children[0].textContent + "$)\n";
        }

        if (estValide) {
            let decision = confirm(afficherMsg(listeStringItems))

            if (!decision) {
                e.preventDefault();
            }
        }
        else {
            e.preventDefault();
        }
    }

    function afficherMsg(listeStringItems) {
        let msg_txt = "Voici votre commande :\n" + listeStringItems + "----------------------------\nPrix total : " + prixTotalCommande.textContent + "$, Rabais: " +
            prixRabaisCommande.textContent + "$, Prix avant taxes: " + prixTotalAvantTaxesCommande.textContent + "$, Taxes: " + taxesCommande.textContent + "$.\nPrix final: " +
            prixTotalTaxesCommande.textContent + "$.";

        return msg_txt;
    }
});