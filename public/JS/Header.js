
/* FONCTION D'AFFICHAGE DU MESSAGE */

    function message(boutonsOuiNon, lienOui, contenu) {
        divBouton = document.getElementById('DivBoutonsMessage');
        croix = document.getElementById('IdMessageCroix');
        blocMessage = document.getElementById('Message');
        blocMessage.setAttribute('style', 'display: flex');
        if (boutonsOuiNon) {
            divBouton.setAttribute('style', 'display: flex');
            croix.setAttribute('style', 'display: none');
            document.getElementById('BoutonOui').setAttribute('href', lienOui);
        } else {
            divBouton.setAttribute('style', 'display: none');
            croix.setAttribute('style', 'display: flex');
        }
        document.getElementById('ContenuMessage').innerHTML = contenu;
    }
    
/* FONCTION PERMETTANT DE RÉCUPÉRER QUEL BOUTON A ÉTÉ CLIQUÉ */

    function decalerMenu(boutonClique) {

        /* RÉCUPÉRATION DES BOUTONS ET DE LEURS LIENS */

            boutonCompte = document.getElementById('IdDivBoutonCompte');
            liensCompte = document.getElementById('IdCompte');
            boutonMenu = document.getElementById('IdBoutonMenu');
            liensMenu = document.getElementById('IdMenu');

        /* SI LE BOUTON CLIQUÉ EST CELUI POUR LE COMPTE */

            if (boutonClique == boutonCompte) {
                toggle(liensCompte, liensMenu, "non");
            }

        /* SI LE BOUTON CLIQUÉ EST CELUI POUR LE MENU */

            if (boutonClique == boutonMenu) {
                toggle(liensMenu, liensCompte, "oui");
            }
        
    }

/* FONCTION PERMETTANT D'AFFICHER OU CACHER UN GROUPE DE LIENS */

    function toggle(elementAAfficher, elementACacher, Menu) {

        /* RÉCUPÉRATION DES BOUTONS ET DE LEURS LIENS */

            boutonBurger = document.getElementById('IdMenuBurger');
            boutonCroix = document.getElementById('IdMenuCroix');

        /* SI LE BOUTON EST LE MENU ALORS... */

            if (Menu == "oui") {

                    display = boutonCroix.getAttribute("style");

                    /* CACHER LA BORDURE BASSE DU COMPTE */

                        boutonCompte.removeAttribute("style");
                        
                    /* SI LE MENU EST AFFICHÉ... */

                        if (display == "display: flex") {

                            /* ...ALORS... */

                                /* CACHER LA BORDURE BASSE DU MENU */

                                    boutonMenu.removeAttribute("style");

                                /* AFFICHER L'ICONE DU BURGER ET CACHER L'ICONE DE LA CROIX */

                                    boutonBurger.setAttribute("style", "display: flex");
                                    boutonCroix.setAttribute("style", "display: none");
                                    
                        } else {

                            /* ...SINON... */

                                /* AFFICHER LA BORDURE BASSE DU MENU */

                                    boutonMenu.setAttribute("style", "border-bottom: 1px solid #735645");

                                /* CACHER L'ICONE DU BURGER ET AFFICHER L'ICONE DE LA CROIX */

                                    boutonBurger.setAttribute("style", "display: none");
                                    boutonCroix.setAttribute("style", "display: flex");

                        }

            }

        /* SI LE BOUTON N'EST PAS LE MENU ALORS... */

            if (Menu == "non") {
                    display = boutonCompte.getAttribute("style");

                    /* CACHER LA BORDURE BASSE DU MENU */

                        boutonMenu.removeAttribute("style");

                    /* AFFICHER L'ICONE DU MENU BURGER CACHER L'ICONE DE LA CROIX */

                        boutonBurger.setAttribute("style", "display: flex");
                        boutonCroix.setAttribute("style", "display: none");
                        
                    /* SI LA BORDURE BASSE DU COMPTE EST AFFICHÉ ALORS LA CACHER SINON L'AFFICHER */

                        if (display == "border-bottom: 1px solid #735645") {
                            boutonCompte.removeAttribute("style");
                        } else {
                            boutonCompte.setAttribute("style", "border-bottom: 1px solid #735645");
                        }
                    
            }
            
        /* SI LE GROUPE DE LIENS EST DÉJÀ AFFICHÉ ALORS LE CACHER SINON L'AFFICHER */

            if (elementAAfficher.classList.contains("Afficher")) {
                elementAAfficher.classList.remove("Afficher");
            } else {
                elementAAfficher.classList.add("Afficher");
                elementACacher.classList.remove("Afficher");
            }

    }

/* FONCTION PERMETTANT DE CACHER UN MESSAGE AFFICHÉ */

    function cacherMessage() {
        document.getElementById('Message').setAttribute('style', 'display: none;');
    }


/* FONCTION DE RESIZING D'IMAGES PAR RAPPORT À LEURS DIMENSIONS */

    function resizeIconeHeader(element) {
        hauteur = element.height;
        largeur = element.width;
        if (hauteur < largeur) {
            element.style.height = "100%";
            element.style.width = "auto";
        } else {
            element.style.height = "auto";
            element.style.width = "100%";
        }
    }

    function getStorage(){
        var loi = localStorage.getItem("loi");
        if (!loi) {
            window.location.href = "/";
        }
    }

    window.onload = getStorage();