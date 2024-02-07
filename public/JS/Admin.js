function suppressionCompte(id) {
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