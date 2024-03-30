const listeSite = [];
var intervalTimer = [];

function displayRecherche(elementClicke, elementAAfficher) {
    if (elementAAfficher == 'RechercheFiltre') {
        ChildList(elementClicke.children, "Filtre", true);
    } else if (elementAAfficher == 'RechercheCarte'){
        ChildList(elementClicke.children, "Map", false);
    }

    document.getElementById(elementAAfficher).classList.toggle("Hide");
    
}

function ChildList(ChildList, NomImg, Filtre) {

    for (let i = 0; i < ChildList.length; i++) {
        var getSrc = ChildList[i].getAttribute('src');
        if (ChildList[i] == ChildList[0]){
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

        var inputRecherche = document.getElementById('rechercher').value;
        var filtreRecherche = document.getElementById('RechercheFiltre');

        if (inputRecherche == '' && filtreRecherche.classList.contains('Hide')) {
            for (let i = 0; i < listeSite.length; i++) {
                const siteID = listeSite[i]['id'];
                showCards(siteID);
            }
        } else {
            hideCards();
            recuperationDonnee();
            if (inputRecherche != '') {

                var motsRecherche = inputRecherche.split(' ');
                for (let i = 0; i < motsRecherche.length; i++) {
        
                    var motRecherche = motsRecherche[i];
                    parcourListeSite(listeSite, motRecherche);
        
                }
            }
            if (!filtreRecherche.classList.contains('Hide')) {

                var departement = filtreRecherche.children[0].value;
                var commune = filtreRecherche.children[1].value;
                var lieuxdit = filtreRecherche.children[2].value;
                var interethistorique = filtreRecherche.children[3].value;
                if (filtreRecherche.children[4].checked) {
                    var timer = 1;
                    for (let i = 0; i < listeSite.length; i++) {
                        var site = listeSite[i];
                        if (site['departement'] == departement || site['commune'] == commune || site['lieudit'] == lieuxdit || site['interetHistorique'] == interethistorique || site['timer'] == timer) {
                            showCards(site['id']);
                        }
                    }
                } else {
                    for (let i = 0; i < listeSite.length; i++) {
                        var site = listeSite[i];
                        if (site['departement'] == departement || site['commune'] == commune || site['lieudit'] == lieuxdit || site['interetHistorique'] == interethistorique) {

                            showCards(site['id']);
                        }
                    }
                }
            }
        }

    }

    function hideCards() {
        card = document.getElementsByClassName('CardSite');
        for (let l = 0; l < card.length; l++) {

            if (card[l].classList.contains('Hide')) {
            } else {
                card[l].classList.add('Hide');
            }

        }
    }

// Récupération de données
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
        return listeSite;
    }

    function splitCardElement(element) {
        splitElement = element.split(' : ');
        splited = splitElement[1];
        return splited;
    }

    function parcourListeSite(listeSite, motRecherche) {
        for (let j = 0; j < listeSite.length; j++) {

            var site = listeSite[j];
            for (const key in site) {

                if (key == "interetHistorique" || key =="departement" || key == "commune" || key == "lieudit") {
                    var siteID = site['id'];
                    siteValeur = site[key];
                    splitValeur = siteValeur.split(' ');
                    for (let k = 0; k < splitValeur.length; k++) {

                        var motValeur = splitValeur[k];
                        if (motRecherche == motValeur) {
                            showCards(siteID);
                        }
                    }
                }

            }

        }
    }

    function showCards(siteID) {
        card = document.getElementsByClassName('CardSite');
        for (let l = 0; l < card.length; l++) {
            cardRecomposeeId = "SiteID-" + siteID;
            if (card[l].getAttribute('id') == cardRecomposeeId) {
                if (card[l].classList.contains('Hide')) {
                    card[l].classList.remove('Hide');
                    card[l].setAttribute('class', 'CardSite');
                }
            }
        }
    }

    function savePreferences(button) {
        button.setAttribute('type', 'submit');
        form = document.getElementsByTagName('form')[0];
        form.submit();
    }

    function cardOnload() {
        var url = window.location.href;
        if (url == "https://localhost:8000/site/rechercher"){
            var card = document.getElementsByClassName("CardSite");
            for (let i = 0; i < card.length; i++) {
                if(card[i].children[0].classList.contains('TimerBoutonsFavori')) {
                    var elementRecup = card[i].children[0].children[1];
                    var element = card[i].children[0].children[0];
                    splitTitle = elementRecup.innerHTML.split(", ");
                    id = splitTitle[0];
                    datefinal = splitTitle[1];
                    setTimerInterval(element, id, datefinal);
                }
            }
        } else {
            site = document.getElementsByClassName("GroupeSiteItem")[0].children[1];
            if (site.classList.contains('Hide')) {
                splitTitle = site.innerHTML.split(", ");
                element = document.getElementsByClassName('Timer')[0];
                id = splitTitle[0];
                datefinal = splitTitle[1];
                setTimerInterval(element, id, datefinal);
            }
        }
        
    }

    function setTimerInterval(element, id, datefinal) {
        intervalTimer[id] = setInterval(setTimer, 1000, element, datefinal);
    }

    function setTimer(element, datefinal) {

        var splitDateFinal = datefinal.split(' ');
        var finalYMD = splitDateFinal[0];
        var splitFinalYMD = finalYMD.split('-');
        var finalY = splitFinalYMD[0];
        var finalMonth = splitFinalYMD[1];
        var finalD = splitFinalYMD[2];
        var finalHMS = splitDateFinal[1];
        var splitFinalHMS = finalHMS.split(':');
        var finalH = splitFinalHMS[0];
        var finalMinutes = 0;
        var finalS = splitFinalHMS[2];
        
        var currentdate = new Date();

        var Year = currentdate.getFullYear();
        var Month = currentdate.getMonth() + 1;
        var Day = currentdate.getDate();
        var Hour = currentdate.getHours();
        var Minute = currentdate.getMinutes();
        var Second = currentdate.getSeconds();

        var newTimer = "";
        var newNewYear, newNewMonth, newNewDay, newNewHour, newNewMinute, newNewSecond;

        var newYear = finalY - Year;
        if (newYear > 0) {
            newNewYear = newYear - 1;
            if (newNewYear == 1) {
                newTimer = newTimer + newNewYear + "An ";
            } else if (newNewYear > 1) {
                newTimer = newTimer + newNewYear + "Ans ";
            }
        }

        var newMonth = subtractMonth(finalMonth, Month, newYear);
        if (newMonth > 0 || newYear > 0) {
            newNewMonth = newMonth - 1;
            if (newNewMonth > 0) {
                newTimer = newTimer + newNewMonth + "mois ";
            } else if (newYear > 0) {
                newTimer = newTimer + newNewMonth + "mois ";
            }
        }
            
        var newDay = subtractD(finalD, Day, Month, Year, newMonth);
        if (newDay > 0 || newYear > 0 || newMonth > 0) {
            newNewDay =  newDay - 1;
            if (newNewDay > 0) {
                if (newNewDay == 1) {
                    newTimer = newTimer + newNewDay + "Jour<br>";
                } else {
                    newTimer = newTimer + newNewDay + "Jours<br>";
                }
            } else if (newYear > 0 || newMonth > 0) {
                if (newNewDay == 0) {
                    newTimer = newTimer + newNewDay + "Jour<br>";
                } else {
                    newTimer = newTimer + newNewDay + "Jours<br>";
                }
            }
        }

        var newHour = subtractH(finalH, Hour, newDay);
        if (newHour > 0 || newDay > 0 || newYear > 0 || newMonth > 0) {
            newNewHour = newHour - 1;
        }

        var newMinute = subtractMin(finalMinutes, Minute, newHour);
        if (newMinute > 0 || newHour > 0 || newDay > 0 || newYear > 0 || newMonth > 0) {
            newNewMinute = newMinute - 1;
        }

        var newSecond = subtractS(finalS, Second, newMinute);
        if (newSecond > 0 || newMinute > 0 || newHour > 0 || newDay > 0 || newYear > 0 || newMonth > 0) {
            newNewSecond = newSecond - 1;
        }

        newTimer = newTimer + newNewHour + ":";
        newTimer = newTimer + newNewMinute + ":";
        newTimer = newTimer + newNewSecond;
        
        element.innerHTML = newTimer;
    }

    function subtractMonth(final, current, year) {
        if (final == current) {
            if (year == 0) {
                var newOne = 0;
            } else {
                var newOne = 12;
            }
        } else if (final < current) {
            var newOne = 12 - (current - final);
        } else {
            var newOne = final - current;
        }

        return newOne;
    }

    function subtractD(final, current, currentmonth, currentyear, month) {
        var lastD;
        if (currentmonth == (4 || 6 || 9 || 11 )) {
            lastD = 30;
        } if (current == 2) {
            if (currentyear % 4 == 1) {
                lastD = 28;
            } else {
                lastD = 29;
            }
        } else {
            lastD = 31;
        }

        if (final == current) {
            if (month == 0) {
                var newOne = 0;
            } else {
                var newOne = lastD;
            }
        } else  if (final < current) {
            var newOne = lastD - (current - final);
        } else {
            var newOne = final - current;
        }

        return newOne;
    }

    function subtractH(final, current, day) {
        if (final == current) {
            if (day == 0) {
                var newOne = 0;
            } else {
                var newOne = 24;
            }
        } else  if (final < current) {
            var newOne = 24 - (current - final);
        } else {
            var newOne = final - current;
        }

        return newOne;
    }

    function subtractMin(final, current, hour) {
        if (final == current) {
            if (hour == 0) {
                var newOne = 0;
            } else {
                var newOne = 60;
            }
        } else  if (final < current) {
            var newOne = 60 - (current - final);
        } else {
            var newOne = final - current;
        }

        return newOne;
    }

    function subtractS(final, current, minute) {
        if (final == current) {
            if (minute == 0) {
                var newOne = 0;
            } else {
                var newOne = 60;
            }
        } else  if (final < current) {
            var newOne = 60 - (current - final);
        } else {
            var newOne = final - current;
        }

        return newOne;
    }

    window.addEventListener("load", (event) => {
        cardOnload();
    });