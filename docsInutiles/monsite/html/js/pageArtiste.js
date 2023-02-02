'use strict'
let artiste_photo = document.getElementById("artiste_photo");
let filePhoto = document.getElementById("filePhoto");
let nomVille = document.querySelector("select#villeGroupSelect");
let nom = document.getElementById("nom");

document.getElementById("btn_submit").addEventListener("click", validate);
nom.addEventListener("keyup", afficherNom);
filePhoto.addEventListener("change", afficherPhoto);
document.getElementById("btn_reset").addEventListener("click", reinitialiser);


function validate(e) {

    reinitialiser;

    let estValide = true;
    let masqueNom = /^[\wéÉèÈÇçêÊôÔöÖïÏ',._ -]*$/;
    if (!masqueNom.test(nom.value) || nom.value == '')
    // if (nom.value == '') 
    {
        estValide = false;
        document.getElementById("err_nom").textContent = "(*) nom invalide"
    }
    // let check = filePhoto.files[0];
    if (artiste_photo.src == "" || filePhoto.files[0] == null) {
        estValide = false;
        document.getElementById("err_artiste_photo").textContent = '(*) photo invalide'
    }


    if (!estValide) {
        e.preventDefault();
    }
    else {
        let msg_txt = msg();
        if (!confirm(msg_txt)) {
            e.preventDefault();
        }
    }

}
function afficherNom(e) {
    document.getElementById("artiste_figcap").textContent = e.target.value;
}
function afficherPhoto() {
    artiste_photo.src = window.URL.createObjectURL(this.files[0]);
    document.getElementById("custom-file-label").textContent = filePhoto.files[0].name;

}
function reinitialiser() {
    document.getElementById("err_nom").textContent = "";
    document.getElementById("err_artiste_photo").textContent = "";
    document.getElementById("artiste_photo").src = "img/artiste_photo.png";
    document.getElementById("custom-file-label").textContent = "Télécharger Votre photo";
}
function msg() {
    let indexSelected = nomVille.selectedIndex;
    let nomVille_txt = nomVille.options[indexSelected].textContent;
    let photo_txt = document.getElementById("filePhoto").files[0].name;

    let ligne1 = "SVP vérifier les information suivant:\n";
    let ligne2 = "Votre nom: " + nom.value + "\n";
    let ligne3 = "Votre Ville: " + nomVille_txt + "\n";
    let ligne4 = "Votre photo: " + photo_txt + "\n";
    let ligne5 = "Est-ce que vous voulez l'envoyer ?"

    let msg_txt = ligne1 + ligne2 + ligne3 + ligne4 + ligne5;
    return msg_txt;
}