var input = [false, false, false, false];
var count = 0;

/* FONCTION DE VÉRIFICATION DE LA VALIDITÉ DES CHAMPS DÉPARTEMENT, COMMUNE, LIEUX-DIT ET INTÉRÊT HISTORIQUE */

    function validationdElement(element, number) {
        if (element.value.length == 0){
            message(false, false, "Un ou plusieurs champs requis n'a pas été remplis !")
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
        displayElement(labeltypetimer, inputtypetimer, element);
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
            message(false, false, "Vous n'avez pas remplit tout les champs requis !");
        }
        validationFormulaire();
    }

    function nombreLigne(action){
        var table_body = document.getElementsByTagName('tbody')[0];
        var button_suppr = document.getElementById('ButtonRemoveSite');
        var button_add = document.getElementById('ButtonAddSite');
        var input_count = document.getElementById('ajout_site_form_count');
        switch (action) {
            case 'add':
                count++;
                var tr = document.createElement('tr');
                tr.classList.add("ajout");
                tr.innerHTML = '<td><input type="text" name="departement_'+ count +'" class="StyleInput" id="departement_' + count + '"></td><td><input type="text" name="commune_' + count + '" class="StyleInput" id="commune_' + count + '"></td><td><input type="text" name="lieuxdit_' + count + '" class="StyleInput" id="lieuxdit_' + count + '"></td><td><input type="text" name="interethistorique_' + count + '" class="StyleInput" id="interethistorique_' + count + '"></td><td><input type="text" name="lien_' + count + '" class="StyleInput" id="lien_' + count + '"></td><td><select name="timer_' + count + '" class="StyleInput" id="timer_' + count + '"><option value="0" selected="selected">Non</option><option value="1">Oui</option></select></td><td class="Hide"><input type="text" name="typetimer_' + count + '" class="StyleInput" id="typetimer_' + count + '"></td>'
                table_body.lastChild.after(tr);
                button_suppr.classList.remove('Hide');
                if (count == 9) {
                    button_add.classList.add('Hide');
                }
                break;
                
            case 'remove':
                count--;
                table_body.lastChild.remove();
                if (table_body.children.length == 1) {
                    button_suppr.classList.add('Hide');
                }
                if (count == 8) {
                    button_add.classList.remove('Hide');
                }
                break;
        
            default:
                break;
        }
        input_count.value = count;
    }
    
/* FONCTION D'AFFICHAGE DU TYPE DE TIMER SI LE CHAMP TIMER EST A TRUE */

    function displayPriorite(element) {
        var labelPriorite = document.getElementById('priorite').parentNode;
        var inputPriorite = document.getElementById('actualite_form_priorite').parentNode;
        displayElement(labelPriorite, inputPriorite, element);
    }

    function displayElement(label, input, element) {
        if (element.value == 1){
            label.classList.remove('Hide');
            input.classList.remove('Hide');
        }else if(element.value == 0){
            label.classList.add('Hide');
            input.classList.add('Hide');
        }else{
            message(false, false, "PROBLEME !")
        }
    }

    window.onload = (event) => {
        element = document.getElementById("actualite_form_afficher");
        if (element) {
            displayPriorite(element);
        }
    };