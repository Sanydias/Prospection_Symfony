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