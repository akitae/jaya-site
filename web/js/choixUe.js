$(function() {

    // On active le drag and drop pour tous les tableaux des pôles.
    let listSort = document.getElementsByClassName("sort");

    [].forEach.call(listSort, function (list) {
        Sortable.create(list, {
            ghostClass: 'matiere-ghost',
            animation: 150,
            onEnd: function (evt) {
                let matieres = evt.to.querySelectorAll(".matiere");

                [].forEach.call(matieres, function (matiere) {
                    let index = Array.prototype.indexOf.call(matieres, matiere);
                    $(matiere).find(".ordre > .badge").text((index+1));
                });
            }
        });
    });

    /**
     * On enregistre les choix de l'étudiant.
     */
    $('#submit').on('click', function (e) {
        let arrayMatiere = [];

        /**
         * On récupère toutes les matières des pôles.
         */
        $('.sort').find('.matiere').each(function (index) {
            let matiere = {
                id: $(this).attr("rel"),
                ordre: $(this).find(".ordre > .badge").text()
            };
            arrayMatiere.push(matiere);
        });

        /**
         * On enregistre les choix.
         */
        $.ajax({
            url: "/choixUe/enregistrer/",
            data: {array_Matiere:arrayMatiere},
            method: "POST",
        }).done(function (res) {
            $('#response').removeClass("hidden");
            $('#response').append("<div class='alert alert-success alert-dismissable'><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>"+res+"</div>");
        }).fail(function (res) {
            console.log(res.responseText);
        });
    });

});
