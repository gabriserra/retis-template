jQuery(document).ready(function($) {

/*------------------------------------------------
            TOP BAR WIDGET
------------------------------------------------*/

$('.topbar-search-toggle').click(function(){
    $('#site-navigation .widget_search').fadeToggle();
});

/*------------------------------------------------
            RETIS SLIDER
------------------------------------------------*/

var $sliderretis = $('#slider').data('effect');

$("#slider").slick({
    cssEase: $sliderretis
});


});