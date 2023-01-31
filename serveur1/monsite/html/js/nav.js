'use strict'

$(document).ready(function () {
    // Vérifier le fomulaire onclick submit
    $('#deconn_submit').click(function (e) {
        if (!confirm("Voulez-vous vraiment vous déconnecter ?")) {
            e.preventDefault();
        } 
    });
})