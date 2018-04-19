$(document).ready(function() {
    $('.tableAdmin').DataTable({
        language: {
            processing:     "Traitement en cours...",
            search:         "Rechercher&nbsp;:",
            lengthMenu:    "Afficher _MENU_ &eacute;l&eacute;ments",
            info:           "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
            infoEmpty:      "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
            infoFiltered:   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
            infoPostFix:    "",
            loadingRecords: "Chargement en cours...",
            zeroRecords:    "Aucun &eacute;l&eacute;ment &agrave; afficher",
            emptyTable:     "Aucune donnée disponible dans le tableau",
            paginate: {
                first:      "Premier",
                previous:   "Pr&eacute;c&eacute;dent",
                next:       "Suivant",
                last:       "Dernier"
            },
            aria: {
                sortAscending:  ": activer pour trier la colonne par ordre croissant",
                sortDescending: ": activer pour trier la colonne par ordre décroissant"
            }
        }
    });

    //mise a jour des groupes pour export (page d'emargement)
    $('#filterGroup').click(function () {
        var donneeToSend = "",
            dernier = null,
            select2Choice = $('#filterMatiere .select2-selection__choice'),
            select2ResulteLi = $('.select2-results__options li');

        for (var i=0; i<select2Choice.length; i++) {
            donneeToSend = donneeToSend + 'matiere'+ i +'='+ select2Choice[i].title + '&';
        }

        for(var j=0;j<select2ResulteLi.length;j++) {
            dernier = '#'+select2ResulteLi[j].id;
        }
        $(dernier).hide();

        if(donneeToSend!==""){
            $.ajax({
                url : '/admin/listUser/filterGroupe', // La ressource ciblée
                type : 'GET',
                data : donneeToSend,
                success : function(response, statut){
                    var
                        liGroupe = $('.select2-results__options li'),
                        isEmpty = true;

                    for(var j=0;j<liGroupe.length;j++){
                        var id = liGroupe[j].id;
                        if(response.indexOf(liGroupe[j].textContent) > -1){
                            $('#'+id).show();
                            isEmpty = false;
                        }else{
                            $('#'+id).hide();
                        }
                        dernier = '#'+id;
                    }
                    $(dernier).hide();
                    if(isEmpty === true){
                        $(dernier).show();
                    }
                }

            });
        }


    });
} );
// For demo to fit into DataTables site builder...
$('.tableAdmin')
    .removeClass( 'display' )
    .addClass('table table-striped table-bordered dataTable');
