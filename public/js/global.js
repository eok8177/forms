jQuery(document).ready(function($) {

 
    $(".info-panel .close").click(function() {
      $(this).parents(".info-panel").hide();
     });
    


  $('.news.slick-slider').slick({
         nextArrow: ('.slider-holder .next'),
      prevArrow: ('.slider-holder .prev'),
      infinite: true,
      dots: false,
      arrows: true,
      autoplaySpeed: 2000,
     
     
    });


});



