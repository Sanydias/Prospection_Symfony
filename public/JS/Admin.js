var input = [false, false, false, false];

function suppressionElement(id) {
    current = "Bloc"+id;
    for (let i = 0; i < $( ".BlocSupprimer" ).length; i++) {
        const element = $( ".BlocSupprimer" )[i];
        if (element.id == current ) {
            $( "#"+current ).toggleClass( "Hide" );
        } else if (element.class != "BlocSupprimer Hide") {
            element.classList.add( "Hide" );
        }
    }
}

/* FONCTION DE VÉRIFICATION DE LA VALIDITÉ DES CHAMPS DÉPARTEMENT, COMMUNE, LIEUX-DIT ET INTÉRÊT HISTORIQUE */

    function validationdElement(element, number) {
        if (element.value.length == 0){
            message("Un ou plusieurs champs requis n'a pas été remplis !")
            input[number] = false;
        }else{
            input[number] = true;
        }
        validationFormulaire();
    }

/* FONCTION D'AFFICHAGE DU TYPE DE TIMER SI LE CHAMP TIMER EST A TRUE */

    function displayTimer(element) {
        var labeltypetimer = document.getElementById('typetimer').parentNode;
        var inputtypetimer = document.getElementById('ajout_site_form_typetimer').parentNode;
        if (element.value == 1){
            labeltypetimer.classList.remove('Hide');
            inputtypetimer.classList.remove('Hide');
        }else if(element.value == 0){
            labeltypetimer.classList.add('Hide');
            inputtypetimer.classList.add('Hide');
        }else{
            message("PROBLEME !")
        }
    }

/* FONCTION DE VALIDATION DU FORMULAIRE */

    function validationFormulaire() {

        var button_submit = document.getElementById("ajout_site_form_valider");

        var checker = arr => arr.every(element => element == true)

        /* VÉRIFICATION QUE LA LONGUEUR DE LA VALEUR DE L'EMAIL EST DIFFÉRENTE DE 0 */

            if (checker(input) == false) {
                button_submit.classList.add('form_non_valide');
                button_submit.setAttribute('type', 'button');
            }else{
                button_submit.classList.remove('form_non_valide');
                button_submit.setAttribute('type', 'submit');
            }
    }

/* FONCTION DE MESSAGE */

function buttonValidation() {
    var checker = arr => arr.every(element => element == true)
    if (checker(input) == false) {
        message("Vous n'avez pas remplit tout les champs requis !");
    }
    validationFormulaire();
}