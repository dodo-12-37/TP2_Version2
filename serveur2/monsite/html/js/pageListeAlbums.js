'use strict'

$(document).ready(function () {
    let listeAlbums = document.getElementById("listeAlbums");

    for (let index = 0; index < 13; index++) {
        ajouterAlbums(index);
    }




    function ajouterAlbums(){
        listeAlbums.append(creerNewAlbum());
    }

    function creerNewAlbum(){
        let nbAlbums = listeAlbums.childElementCount + 1;

        let newAlbum = document.createElement("div");
        newAlbum.classList.add("col-12", "col-sm-6", "col-md-4", "col-lg-3", "container", "pt-4", "pb-4");
        newAlbum.id = "album" + nbAlbums;

        let titre = document.createElement("h4");
        titre.textContent = "Album " + nbAlbums;
        newAlbum.append(titre);

        let lien = document.createElement("a");
        lien.dataset.toggle = "collapse";
        lien.href = "#image" + nbAlbums;
        lien.role = "button";
        lien.dataset.ariaexpanded = "false";
        lien.dataset.ariacontrols = "image" + nbAlbums;
        newAlbum.append(lien);

        let img = document.createElement("img");
        img.classList.add("img-thumbnail");
        img.src = "img/album" + nbAlbums + ".jpeg";
        img.alt = "Album " + nbAlbums;
        img.dataset.toggle = "tooltip";
        img.dataset.placement = "top";
        img.title = "Cliquer pour voir les oeuvres associées";
        lien.append(img);

        let divCollapse = document.createElement("div");
        divCollapse.classList.add("collapse", "multi-collapse"); //, "show"
        divCollapse.id = "image" + nbAlbums;
        newAlbum.append(divCollapse);

        let listeOeuvres = document.createElement("ul");
        listeOeuvres.classList.add("list-group");
        let randomNbOeuvre = Math.ceil(Math.random() * 15);
        for (let index = 0; index < randomNbOeuvre; index++) {
            let oeuvre = document.createElement("li");
            oeuvre.textContent = "Oeuvre " + (index + 1);
            oeuvre.classList.add("list-group-item");
            listeOeuvres.append(oeuvre);
        }
        divCollapse.append(listeOeuvres);

        return newAlbum;
    }
})