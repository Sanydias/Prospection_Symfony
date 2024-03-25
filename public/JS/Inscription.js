
window.addEventListener("load", (event) => {
    input = document.getElementsByTagName("input");
    for (let i = 0; i < input.length; i++) {
        const element = input[i];
        deplaceLabel(element);
    }
});

/* DÉFINITION VARIABLE GLOBALE */

    var count = 1;
    var emailValide = "non";
    var motDePasseOk = "non";

/* FONCTION QUI PERMET D'AFFICHER UNE PRÉVISUALISATION DE L'IMAGE INSÉRÉE PAR L'UTILISATEUR */

    function apercu(image) {

        /* SI UN FICHIER EST DÉFINIT ET N'EST PAS VIDE */

            if (image.files && image.files[0]) {

                /* VARIABLE PERMETTANT DE LIRE LE CONTENU D'UN FICHIER STOCKÉE SUR L'ORDINATEUR DE L'UTILISATEUR */

                    var reader = new FileReader();
                
                /* PENDANT LE CHARGEMENT DE READER ON RÉCUPÈRE LA BALISE QUI VA SERVIR DE PRÉVISUALISATION */

                    reader.onload = function (element) {

                        /* DÉFINIT L'ATTRIBUT SOURCE DE LA BALISE PREVISUALISATION */

                            $('#Previsualisation').attr('src', element.target.result);

                        /* CHANGEMENT DE LA LARGEUR DE LA BALISE PREVISUALISATION */

                            $('#Previsualisation').width(320);

                        /* CHANGEMENT DE LA HAUTEUR DE LA BALISE PREVISUALISATION */

                            $('#Previsualisation').height(320);
                            
                            resizeIconeHeader(document.getElementById("Previsualisation"));
                    }

                /* LIRE LE FICHIER COMME UNE URL */

                    reader.readAsDataURL(image.files[0]);
                
            }

    }

/* FONCTION QUI PERMET DE CHANGER LE TYPE D'INPUT */

    function toggleType(id) {

        /* VÉRIFICATION SI L'INPUT EST UN MOT DE PASSE OU UNE CONFIRMATION */

            switch (id) {
                case 'MotDePasse':
                    
                    /* VÉRIFICATION DU TYPE DE L'INPUT */

                        input = document.getElementById('utilisateur_form_password');
                        if (input.getAttribute('type') == 'text') {
                    
                            /* DÉFINITION DU TYPE DE L'INPUT */

                                input.setAttribute('type', 'password');
                                document.getElementById('AfficherMotDePasse').style.display = 'flex';
                                document.getElementById('CacherMotDePasse').style.display = 'none';
                                
                        }else{
                    
                            /* DÉFINITION DU TYPE DE L'INPUT */

                                input.setAttribute('type', 'text');
                                document.getElementById('AfficherMotDePasse').style.display = 'none';
                                document.getElementById('CacherMotDePasse').style.display = 'flex';
                        }
                        break;
            
                case 'ConfirmationMotDePasse':
                    
                    /* VÉRIFICATION DU TYPE DE L'INPUT */

                        input = document.getElementById('IdConfirmationMotDePasse');
                        if (input.getAttribute('type') == 'text') {
                    
                            /* DÉFINITION DU TYPE DE L'INPUT */

                                input.setAttribute('type', 'password');
                                document.getElementById('AfficherConfirmationMotDePasse').style.display = 'flex';
                                document.getElementById('CacherConfirmationMotDePasse').style.display = 'none';

                        }else{
                    
                            /* DÉFINITION DU TYPE DE L'INPUT */

                                input.setAttribute('type', 'text');
                                document.getElementById('AfficherConfirmationMotDePasse').style.display = 'none';
                                document.getElementById('CacherConfirmationMotDePasse').style.display = 'flex';

                        }
                        break;
                    case 'ConnexionMotDePasse':
                        
                        /* VÉRIFICATION DU TYPE DE L'INPUT */
    
                            input = document.getElementById('inputPassword');
                            if (input.getAttribute('type') == 'text') {
                        
                                /* DÉFINITION DU TYPE DE L'INPUT */
    
                                    input.setAttribute('type', 'password');
                                    document.getElementById('AfficherMotDePasse').style.display = 'flex';
                                    document.getElementById('CacherMotDePasse').style.display = 'none';
                                    
                            }else{
                        
                                /* DÉFINITION DU TYPE DE L'INPUT */
    
                                    input.setAttribute('type', 'text');
                                    document.getElementById('AfficherMotDePasse').style.display = 'none';
                                    document.getElementById('CacherMotDePasse').style.display = 'flex';
                            }
            
                default:
                    break;
            }

    }

/* FONCTION DE DÉPLACEMENT DE LABEL */

    function deplaceLabel(element){
        var id = element.getAttribute("id");
        var label = document.getElementsByTagName("label");
        for (let i = 0; i < label.length; i++) {
            var recuperation = label[i].getAttribute("for");
            if (recuperation == id) {
                if (element.value.length == 0 || element.value == "ND") {
                    label[i].setAttribute("style", "transform: translate(0, 0) scale(1); color: #735645;");
                } else {
                    label[i].setAttribute("style", "transform: translate(-25px, -25px) scale(0.9); color: #F2E3B3;");
                }
            }
        }
    }


/* FONCTION D'AFFICHAGE SI UN TYPE DE PRÉFÉRENCES EST SELECTIONNÉ */

    function blocPreference(option) {
        region = document.getElementById('BlocRegion');
        departement = document.getElementById('BlocDepartement');
        ville = document.getElementById('BlocVille');
        switch (option.value) {
            case "region":
                region.setAttribute("style", "display:flex");
                departement.setAttribute("style", "display:none");
                ville.setAttribute("style", "display:none");
            break;
        
            case "departement":
                region.setAttribute("style", "display:none");
                departement.setAttribute("style", "display:flex");
                ville.setAttribute("style", "display:none");
            break;
    
            case "ville":
                region.setAttribute("style", "display:none");
                departement.setAttribute("style", "display:none");
                ville.setAttribute("style", "display:flex");
            break;
    
            default:
                region.setAttribute("style", "display:none");
                departement.setAttribute("style", "display:none");
                ville.setAttribute("style", "display:none");
            break;
        }
    }

/* FONCTION DE SWITCH ENTRE LES ÉTAPES */

    function etape(recuperation) {
                    
        /* RÉCUPÉRATION DES ÉLÉMENTS CHANGEANT SELON L'ÉTAPE */

            var boutonEtape1 = document.getElementById("Etape1");
            var boutonEtape2 = document.getElementById("Etape2");
            var boutonEtape3 = document.getElementById("Etape3");
            var etape1 = document.getElementById("Groupe1");
            var etape2 = document.getElementById("Groupe2");
            var etape3 = document.getElementById("Groupe3");
            var button_previous = document.getElementById("utilisateur_form_precedent");
            var button_next = document.getElementById("utilisateur_form_suivant");
            var button_submit = document.getElementById("utilisateur_form_valider");
            var name = recuperation.getAttribute('id');
                    
        /* DÉCRÉMENTATION SI LE BOUTON CLIQUÉ EST PRÉCÉDENT ET INCRÉMENTATION SI NON */

            if (name == "utilisateur_form_precedent") {
                count--;
            }else{
                count++;
            }

        /* VÉRIFICATION DE L'ÉTAPE */

            switch (count) {
                case 1:
            
                    /* ON PASSE À L'ÉTAPE 1 */

                        boutonEtape1.setAttribute("style", "background-color: #F2E3B3; color: #735645");
                        boutonEtape2.setAttribute("style", "background-color: #735645; color: #F2E3B3");
                        boutonEtape3.setAttribute("style", "background-color: #735645; color: #F2E3B3");
                        etape1.setAttribute("style", "display:flex");
                        etape2.setAttribute("style", "display:none");
                        etape3.setAttribute("style", "display:none");
                        button_previous.setAttribute("style", "display:none");
                        button_next.setAttribute("style", "display:flex");
                        button_submit.setAttribute("style", "display:none");
                    
                break;

                case 2:

                    var email = document.getElementById("utilisateur_form_email");

                    /* VÉRIFICATION QUE LA LONGUEUR DE LA VALEUR DE L'EMAIL EST DIFFÉRENTE DE 0 */
                    
                        if (email.value.length == 0) {
                            message(false, false, "Vous n'avez pas remplit le champs 'Email' !");
                            count--;
                        } else {
        
                            /* VÉRIFICATION QUE LE MOT DE PASSE ENTRÉ EST VALIDE */

                                if (motDePasseOk == "non") {
                                    message(false, false, "Le champs 'Mot de Passe' n'est pas valide!");
                                    count--;
                                } else {
        
                                    /* ON PASSE À L'ÉTAPE 2 */

                                        boutonEtape1.setAttribute("style", "background-color: #735645; color: #F2E3B3");
                                        boutonEtape2.setAttribute("style", "background-color: #F2E3B3; color: #735645");
                                        boutonEtape3.setAttribute("style", "background-color: #735645; color: #F2E3B3");
                                        etape1.setAttribute("style", "display:none");
                                        etape2.setAttribute("style", "display:flex");
                                        etape3.setAttribute("style", "display:none");
                                        button_previous.setAttribute("style", "display:flex");
                                        button_next.setAttribute("style", "display:flex");
                                        button_submit.setAttribute("style", "display:none");

                                }

                        }
                        
                break;

                case 3:

                    var pseudo = document.getElementById("utilisateur_form_pseudo");

                    /* VÉRIFICATION QUE LA LONGUEUR DE LA VALEUR DE L'EMAIL EST DIFFÉRENTE DE 0 */
                    
                        if (pseudo.value.length == 0) {
                            message(false, false, "Vous n'avez pas remplit le champs 'Pseudo' !");
                            count--;
                        } else {
        
                            /* ON PASSE À L'ÉTAPE 3 */

                                boutonEtape1.setAttribute("style", "background-color: #735645; color: #F2E3B3");
                                boutonEtape2.setAttribute("style", "background-color: #735645; color: #F2E3B3");
                                boutonEtape3.setAttribute("style", "background-color: #F2E3B3; color: #735645");
                                etape1.setAttribute("style", "display:none");
                                etape2.setAttribute("style", "display:none");
                                etape3.setAttribute("style", "display:flex");
                                button_previous.setAttribute("style", "display:flex");
                                button_next.setAttribute("style", "display:none");
                                button_submit.setAttribute("style", "display:flex");

                        }
                        
                break;

            }

    }

/* FONCTION DE VALIDATION DU FORMULAIRE */

    function validationFormulaire() {
        
        var datedenaissance = document.getElementById("utilisateur_form_datedenaissance");
        var button_submit = document.getElementById("utilisateur_form_valider");

        /* VÉRIFICATION QUE LA LONGUEUR DE LA VALEUR DE L'EMAIL EST DIFFÉRENTE DE 0 */

            if (datedenaissance.value.length == 0) {
                button_submit.preventDefault();
                button_submit.classList.add('form_non_valide');
                message(false, false, "Vous n'avez pas remplit le champs 'Date de Naissance' !");
            }else{
                button_submit.classList.remove('form_non_valide');
            }
    }
   
/* FONCTION DE VÉRIFICATION QUE L'EMAIL EST BIEN UN EMAIL */

    function mailChange(email) {
        if(email.value && (email.value).match(/^[\S\.]+@([\S-]+\.)+[\S-]{2,4}$/g)){
            emailValide ="oui";
        }else{
            message(false, false, "L'email n'est pas au bon format ! Il doit être de type 'quelque.chose@mail.com");
            emailValide ="non";
        }
    }

/* FONCTION DE VÉRIFICATION DE LA VALIDITÉ DU MOT DE PASSE AINSI QUE SA CORRESPONDANCE AVEC LA CONFIRMATION DU MOT DE PASSE */

    function verificationMotDePasse() {

        /* RÉCUPÉRATION DU MOT DE PASSE ET DE LA CONFIRMATION */

            var motDePasse = document.getElementById("utilisateur_form_password");
            var confirmationMotDePasse = document.getElementById("IdConfirmationMotDePasse");
        
        /* DÉFINITION DE L'EXPRESSION RÉGULIÈRE */

            var regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[()@$!%*?&])[A-Za-z\d()@$!%*?&]{12,}$/gm;


        /* VÉRIFICATION QUE LE MOT DE PASSE ET LA CONFIRMATION N'AIT PAS UNE TAILLE DE 0 CHARACTÈRES */
        
            if (motDePasse.value.length !== 0 && motDePasse.value) {
                                
                /* VÉRIFICATION QUE LE MOT DE PASSE COMPORTE AU MINIMUM 8 CARACTÈRES */

                    if (motDePasse.value.length >= 12) {
                                        
                        /* VÉRIFICATION QUE LE MOT DE PASSE CORRESPOND À L'EXPRESSION RÉGULIÈRE */

                            if (motDePasse.value.match(regex)) {

                                /* VÉRIFICATION QUE LE MOT DE PASSE CORRESPOND À LA CONFIRMATION */

                                    if (motDePasse.value === confirmationMotDePasse.value) {
                                        motDePasseOk = "oui";
                                        return true;
                                    } else {
                                        motDePasseOk = "non";
                                        message(false, false, "Le mot de passe ne correspond pas à sa confirmation !");
                                        return false;
                                    }

                            } else {
                                motDePasseOk = "non";
                                message(false, false, "Le mot de passe doit contenir au minimum un caractères spécial parmi ( ) @ $ ! % * ? &, un caractère en majuscule, un caractère en minuscule ainsi qu'un chiffre !");
                                return false;
                            }
                                        
                    } else {
                        motDePasseOk = "non";
                        message(false, false, "Le mot de passe doit contenir au minimum 12 caractères !");
                        return false;
                    }

            } else {
                motDePasseOk = "non";
                message(false, false, "Un ou des champs obligatoire n'ont pas été remplit !");
                return false;
            }

    }