
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
    function sendMail() {
        sujet = document.getElementById("contact_form_sujet");
        contenu = document.getElementById("contact_form_message");
        if (sujet.value == "") {
            message(false, false, "le champs sujet est requis !");
        } else {
            if (contenu.value == "") {
                message(false, false, "le champs message est requis !");
            } else {
                window.open('mailto:dumas.sandy2002@gmail.com?subject=' + sujet.value + '&body=' + contenu.value);
            }
        }
    }