var number = 2;
var interval;
    
    function carroussel(count){
        cible = document.getElementById("Silder" + count);
        enfants = document.getElementById("Carroussel").children;
        for (let i = 0; i < enfants.length; i++) {
            enfant = enfants[i];

            if (enfant.classList.contains("Hide")) {
            } else {
                enfant.classList.add("Hide");
            }
        }
        cible.classList.remove("Hide");

        bouton = document.getElementById("BoutonActualite" + count);
        parentboutons = document.getElementsByClassName("BoutonActualite");
        for (let i = 0; i < parentboutons.length; i++) {
            enfantbouton = parentboutons[i].children[0];
            if (parentboutons[i] == bouton) {
                if (enfantbouton.classList.contains("PasSelectionne")) {
                    enfantbouton.classList.remove("PasSelectionne");
                    enfantbouton.classList.add("Selectionne");
                } else if (enfantbouton.classList.contains("Selectionne")) {
                }
            } else {
                if (enfantbouton.classList.contains("PasSelectionne")) {
                    
                } else {
                    enfantbouton.classList.add("PasSelectionne");
                }
                if (enfantbouton.classList.contains("Selectionne")) {
                    enfantbouton.classList.remove("Selectionne");
                }
            }
        }

        flecheGauche = document.getElementById("FlecheGauche");
        flecheDroite = document.getElementById("FlecheDroite");
        if ((count - 1) == 0) {
            flecheGauche.setAttribute("onclick", "carroussel(" + (enfants.length) + ")");
        } else {
            flecheGauche.setAttribute("onclick", "carroussel(" + (count - 1) + ")");
        }
        if ((count + 1) > (enfants.length)) {
            flecheDroite.setAttribute("onclick", "carroussel(1)");
            number = 1;
        } else {
            flecheDroite.setAttribute("onclick", "carroussel(" + (count + 1) + ")");
            number = count + 1;
        }

        changeInterval();
    }

    function changeInterval() {
        clearInterval(interval);
        interval = setInterval(carroussel, 5000, number);
    }

    window.addEventListener("load", (event) => {
        changeInterval();
    });