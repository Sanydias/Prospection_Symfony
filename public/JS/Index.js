$(function(){
    $('.liensImagesCarrousel').hide();
    $('.liensImagesCarrousel').first().show();
    function imagePrecedent(){
        if ($("#sliderCarrousel").children(":visible").prev().length != 0) {
            $("#sliderCarrousel").children(":visible").prev().show();
            $("#sliderCarrousel").children(":visible").last().hide();
        }else{
            $("#sliderCarrousel").children().last().show();
            $("#sliderCarrousel").children(":visible").first().hide();
        }
    }
    function imageSuivant(){
        if ($("#sliderCarrousel").children(":visible").next().length != 0) {
            $("#sliderCarrousel").children(":visible").next().show();
            $("#sliderCarrousel").children(":visible").first().hide();
        }else{
            $("#sliderCarrousel").children().first().show();
            $("#sliderCarrousel").children(":visible").last().hide();
        }
    }
    
    setInterval(imageSuivant, 5000);
    $('#carrouselPrevious').click(imagePrecedent);
    $("#carrouselNext").click(imageSuivant);
});