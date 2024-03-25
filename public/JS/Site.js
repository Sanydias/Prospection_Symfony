const listeSite = [];

function displayRecherche(elementClicke, elementAAfficher) {
    if (elementAAfficher == 'RechercheFiltre') {
        ChildList(elementClicke.children, "Filtre", true);
    } else if (elementAAfficher == 'RechercheCarte'){
        ChildList(elementClicke.children, "Map", false);
    }

    document.getElementById(elementAAfficher).classList.toggle("Hide");
    
}

function ChildList(ChildList, NomImg, Filtre) {
    console.log(ChildList.length);

    for (let i = 0; i < ChildList.length; i++) {
        console.log(i);
        var getSrc = ChildList[i].getAttribute('src');
        if (ChildList[i] == ChildList[0]){
            console.log(getSrc);
            var NomImgComplet = '/IMG/ICONES/' + NomImg + '.png';
            if (getSrc == '/IMG/ICONES/Croix.png') {
                ChildList[i].setAttribute('src', NomImgComplet);
            } else if (getSrc == NomImgComplet){
                ChildList[i].setAttribute('src', '/IMG/ICONES/Croix.png');
            }
            if (Filtre) {
                ChildList[i].classList.toggle('Filtre');
            }
        } else if (ChildList[i] == ChildList[1]){
            console.log('test 1');
            var NomImgComplet = '/IMG/ICONES/' + NomImg + 'Hover.png';
            if (getSrc == '/IMG/ICONES/CroixHover.png') {
                ChildList[i].setAttribute('src', NomImgComplet);
            } else if (getSrc == NomImgComplet){
                ChildList[i].setAttribute('src', '/IMG/ICONES/CroixHover.png');
            }
            if (Filtre) {
                ChildList[i].classList.toggle('Filtre');
            }
        }
    }
}

function rechercherCard() {

    recuperationDonnee();

    card = document.getElementsByClassName('CardSite');
    var inputRecherche = document.getElementById('rechercher').value;
    var motsRecherche = inputRecherche.split(' ');
    for (let i = 0; i < motsRecherche.length; i++) {

        var motRecherche = motsRecherche[i];
        for (let j = 0; j < listeSite.length; j++) {

            var site = listeSite[j];
            for (const key in site) {

                if (key == "interetHistorique" || key =="departement" || key == "commune" || key == "lieudit") {
                    siteValeur = site[key];
                    splitValeur = siteValeur.split(' ');
                    for (let k = 0; k < splitValeur.length; k++) {

                        var motValeur = splitValeur[k];
                        if (motRecherche == motValeur) {
                            for (let l = 0; l < card.length; l++) {
                                cardRecomposeeId = "SiteID-" + site['id'];
                                console.log(card[l].getAttribute('id'));
                                if (card[l].getAttribute('id') == cardRecomposeeId) {
                                    if (card[l].classList.contains('Hide')) {
                                        card[l].classList.remove('Hide');
                                        card[l].setAttribute('class', 'CardSite');
                                        console.log(card[l].classList);
                                    }
                                }

                            }
                        } else {
                            for (let l = 0; l < card.length; l++) {

                                if (card[l].classList.contains('Hide')) {
                                } else {
                                    card[l].classList.add('Hide');
                                }

                            }
                        }
                    }
                }

            }

        }

    }

}

function recuperationDonnee() {
    card = document.getElementsByClassName('CardSite');
    for (let i = 0; i < card.length; i++) {
        element = card[i];
        exploded = element.getAttribute('id').split('-');
        id = exploded[1];
        searchtimer = element.children[0].children[0];
        if (searchtimer.getAttribute('class') == 'Limited') {
            timer = true;
        } else {
            timer = false;
        }
        interetHistorique = element.children[1].innerHTML;

        oldDepartement = element.children[3].children[0].innerHTML;
        splitCardElement(oldDepartement);
        departement = splited;

        oldCommune = element.children[3].children[1].innerHTML;
        splitCardElement(oldCommune);
        commune = splited;

        oldLieudit = element.children[3].children[2].innerHTML;
        splitCardElement(oldLieudit);
        lieudit = splited;

        site = {
            "id" : id,
            "timer" : timer,
            "interetHistorique" : interetHistorique,
            "departement" : departement,
            "commune" : commune,
            "lieudit" : lieudit
        }
        listeSite[i] = site;
    }
}

function splitCardElement(element) {
    splitElement = element.split(' : ');
    splited = splitElement[1];
    return splited;
}