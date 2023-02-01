'use strict';
let imageURL = document.getElementById("nomImage").textContent = "Image de l'album";

document.getElementById("titre_album").value = "";
document.getElementById("code_album").value = "";

$(document).ready(function () {
    let dateAujourdhui = new Date();
    let dateHier = new Date();
    dateHier.setDate(dateAujourdhui.getDate() - 1);

    let dateLimite = dateHier.toLocaleDateString("fr-CA");

    document.getElementById("date_album").max = dateLimite;

    let album_photo = document.getElementById("album_photo");
    $("#nomImage").val("");

    $("#date_album").val(dateLimite);

    $("#envoyer").click(function validate(e) {
        let estValide = true;

        let masqueTitre = /^([A-z]|[0-9]|\s|\.|\-|\_|[éÉùÙçÇèÈêÊîÎàÀïÏâÂ]){2,50}$/;
        let masqueCode = /^([A-Z]{3}[0-9]{4})$/;
        let masqueImageURL = /\.(jpg|jpeg|png|webp|avif|gif|svg)$/;

        $("[id^='err_']").text("");

        if (!masqueTitre.test($("#titre_album").val()) || $("#titre_album").val() == '') {
            estValide = false;
            $("#err_titre").text("(*) Titre invalide");
        }

        if (!masqueCode.test($("#code_album").val()) || $("#code_album").val() == '') {
            estValide = false;
            $("#err_code").text("(*) Code invalide");
        }

        let dateAlbum = $("#date_album").val();
        if (dateAlbum == "aaaa-mm-jj" || dateAlbum == "" || dateAlbum > dateLimite || dateAlbum < "1920-01-01") {
            estValide = false;
            $("#err_date").text("(*) Date invalide");
        }

        imageURL = $("#nomImage").val();  
        $("#imageAlbum").text(imageURL);
        if (!masqueImageURL.test(imageURL) || imageURL == "") {
            estValide = false;
            $("#err_album_photo").text("(*) Photo invalide");
        }

        if (estValide) {
            let textTitre = "Titre: " + $("#titre_album").val() + "\n";
            let textCode = "Code: " + $("#code_album").val() + "\n";
            let textDate = "Date: " + $("#date_album").val() + "\n";
            let textGenre = "Genre: " + $("#GenreGroupSelect").val() + "\n";
            let textQuestion = "\n Ajouter l'album?";
            let textImage = "Lien de l'image: " + $("#nomImage").val() + "\n";
            let text = textTitre + textCode + textDate + textGenre + textImage + "\n" + textQuestion;
            
            if (!confirm(text)) {
                e.preventDefault();
            }
        }
        else {
            e.preventDefault();
        }
    });

    function afficherTitre() {
        document.getElementById("album_figcap").textContent = $("#titre_album").val();
    }

    $("#titre_album").keyup(afficherTitre);

    $("#nomImage").change(function afficherPhoto() {
        imageURL = $("#nomImage").val();
        album_photo.src = window.URL.createObjectURL(this.files[0]);
        $("#imageAlbum").text(imageURL);
        $("#err_album_photo").text("");
        afficherTitre();
    })

    $("#btn_reset").click(function reinitialiser(e) {
        e.preventDefault();
        $("Form").trigger("reset");
        document.getElementById("titre_album").value = "";
        document.getElementById("code_album").value = "";
        $("#date_album").val(dateLimite);
        $("#imageAlbum").text("Image de l'album ");
        $("[id^='err_']").text("");
        $("#album_figcap").text("Exemple de photo.");
        $("#album_photo").attr("src", "img/album_photo.webp");
    });


    //  cette fonction a été remplacé par fontion .toLocalDateString("fr-CA") sur ligne 11
    // function dateVersChaine(dateX) {
    //     let yearX = dateX.getFullYear();
    //     let monthX = (dateX.getMonth() + 1);
    //     let monthY = "";
    //     let dayY = "";
    //     if (monthX < 10)
    //         monthY = "0" + monthX;
    //     else monthY = monthX;
    //     let dayX = dateX.getDate();
    //     if (dayX < 10)
    //         dayY = "0" + dayX;
    //     else dayY = dayX;
    //     let resultX = yearX + "-" + monthY + "-" + dayY + '';
    //     return resultX;
    // }

});  