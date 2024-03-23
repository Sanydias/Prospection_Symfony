
/* DÉFINITION VARIABLE GLOBALE */

    var count = 1;
    var emailValide = "non";
    var codeValide = "non";
    var motDePasseOk = "non";
    var codeDefinit = Math.floor(Math.random() * 99999);

/* FONCTION QUI PERMET DE CHANGER LE TYPE D'INPUT */

    function toggleType(id) {

        /* VÉRIFICATION SI L'INPUT EST UN MOT DE PASSE OU UNE CONFIRMATION */

            switch (id) {
                case 'MotDePasse':
                    
                    /* VÉRIFICATION DU TYPE DE L'INPUT */

                        input = document.getElementById('oubli_form_password');
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

/* FONCTION DE SWITCH ENTRE LES ÉTAPES */

    function etape(recuperation) {
                    
        /* RÉCUPÉRATION DES ÉLÉMENTS CHANGEANT SELON L'ÉTAPE */

            var boutonEtape1 = document.getElementById("Etape1");
            var boutonEtape2 = document.getElementById("Etape2");
            var etape1 = document.getElementById("Groupe1");
            var etape2 = document.getElementById("Groupe2");
            var button_previous = document.getElementById("oubli_form_precedent");
            var button_next = document.getElementById("oubli_form_suivant");
            var button_submit = document.getElementById("oubli_form_valider");
            var name = recuperation.getAttribute('id');
                    
        /* DÉCRÉMENTATION SI LE BOUTON CLIQUÉ EST PRÉCÉDENT ET INCRÉMENTATION SI NON */

            if (name == "oubli_form_precedent") {
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
                        etape1.setAttribute("style", "display:flex");
                        etape2.setAttribute("style", "display:none");
                        button_previous.setAttribute("style", "display:none");
                        button_next.setAttribute("style", "display:flex");
                        button_submit.setAttribute("style", "display:none");
                    
                break;

                case 2:

                    var email = document.getElementById("oubli_form_email");

                    /* VÉRIFICATION QUE LA LONGUEUR DE LA VALEUR DE L'EMAIL EST DIFFÉRENTE DE 0 */
                    
                        if (email.value.length == 0) {
                            message("Vous n'avez pas remplit le champs 'Email' !");
                            count--;
                        } else {

                            /* VÉRIFICATION DE LA VALIDITÉ DU CODE */

                                if (codeValide == "non") {
                                    message("Le code entré n'est pas valide !");
                                    count--;
                                } else {
        
                                    /* ON PASSE À L'ÉTAPE 2 */

                                        boutonEtape1.setAttribute("style", "background-color: #735645; color: #F2E3B3");
                                        boutonEtape2.setAttribute("style", "background-color: #F2E3B3; color: #735645");
                                        etape1.setAttribute("style", "display:none");
                                        etape2.setAttribute("style", "display:flex");
                                        button_previous.setAttribute("style", "display:flex");
                                        button_next.setAttribute("style", "display:none");
                                        button_submit.setAttribute("style", "display:flex");

                                }

                        }
                        
                break;

            }

    }

/* FONCTION DE VALIDATION DU FORMULAIRE */

    function validationFormulaire() {
        
        var button_submit = document.getElementById("oubli_form_valider");
        
        /* VÉRIFICATION QUE LE MOT DE PASSE ENTRÉ EST VALIDE */

            if (motDePasseOk == "non") {
                button_submit.preventDefault();
                button_submit.classList.add('form_non_valide');
                message("Le champs 'Mot de Passe' n'est pas valide!");
            } else {
                button_submit.classList.remove('form_non_valide');
            }
    }
/* FONCTION DE VÉRIFICATION QUE L'EMAIL EST BIEN UN EMAIL */

    function mailChange(email) {
        if(email.value && (email.value).match(/^[\S\.]+@([\S-]+\.)+[\S-]{2,4}$/g)){
            emailValide ="oui";
        }else{
            message("L'email n'est pas au bon format ! Il doit être de type 'quelque.chose@mail.com");
            emailValide ="non";
        }
    }

    // import { MailSlurp } from 'mailslurp-client';
    // const mailslurp = new MailSlurp({ apiKey: "9715a65d767e5ed8fc67a358ded65cc187b715467b41547dc77f99d4bc928ff6" });
    // const inbox = await mailslurp.inboxController.createInboxWithDefaults();
/* FONCTION DE VÉRIFICATION D'EMAIL' */

    function envoiCode() {
        codeDefinit = Math.floor(Math.random() * 99999);
        Email.send({
            Host : "smtp.yourisp.com",
            Username : "username",
            Password : "password",
            To : 'marie.dumas2002@gmail.com',
            From : "noreply@test.com",
            Subject : "Code de Vérificaltion",
            Body : "Code vérification : " + codeDefinit
        }).then(
        );
    }

/* FONCTION DE VÉRIFICATION DU CODE */

    function verificationCode(codeUtilisateur) {
        if(codeUtilisateur.value == codeDefinit){
            codeValide = "oui";
        }else{
            message("Vous l'email n'est pas au bon format ! Il doit être de type 'quelque.chose@mail.com");
            codeValide = "non";
        }
    }

/* FONCTION DE VÉRIFICATION DE LA VALIDITÉ DU MOT DE PASSE AINSI QUE SA CORRESPONDANCE AVEC LA CONFIRMATION DU MOT DE PASSE */

    function verificationMotDePasse() {

        /* RÉCUPÉRATION DU MOT DE PASSE ET DE LA CONFIRMATION */

            var motDePasse = document.getElementById("oubli_form_password");
            var confirmationMotDePasse = document.getElementById("IdConfirmationMotDePasse");
        
        /* DÉFINITION DE L'EXPRESSION RÉGULIÈRE */

            var regex = /[^\w\d\s]+/gm;

        /* VÉRIFICATION QUE LE MOT DE PASSE ET LA CONFIRMATION ONT UNE VALEUR */

            if(motDePasse.value && confirmationMotDePasse.value){

                /* VÉRIFICATION QUE LE MOT DE PASSE ET LA CONFIRMATION N'AIT PAS UNE TAILLE DE 0 CHARACTÈRES */
                
                    if (motDePasse.value.length !== 0 || confirmationMotDePasse.value.length !== 0) {

                        /* VÉRIFICATION QUE LE MOT DE PASSE CORRESPOND À LA CONFIRMATION */

                            if (motDePasse.value === confirmationMotDePasse.value) {
                                
                                /* VÉRIFICATION QUE LE MOT DE PASSE COMPORTE AU MINIMUM 8 CARACTÈRES */

                                    if (motDePasse.value.length >= 8) {
                                        
                                        /* VÉRIFICATION QUE LE MOT DE PASSE CORRESPOND À L'EXPRESSION RÉGULIÈRE */

                                            if (motDePasse.value.match(regex)) {
                                                motDePasseOk = "oui";
                                                return true;
                                            } else {
                                                motDePasseOk = "non";
                                                message("Le mot de passe doit contenir au minimum 1 caractères spécial !");
                                                return false;
                                            }
                                        
                                    } else {
                                        motDePasseOk = "non";
                                        message("Le mot de passe doit contenir au minimum 8 caractères !");
                                        return false;
                                    }

                            } else {
                                motDePasseOk = "non";
                                message("Le mot de passe ne correspond pas à sa confirmation !");
                                return false;
                            }

                    } else {
                        motDePasseOk = "non";
                        message("Un ou des champs obligatoire n'ont pas été remplit !");
                        return false;
                    }

            } else {
                return false;
            }

    }