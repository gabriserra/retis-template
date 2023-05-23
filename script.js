jQuery(document).ready(function($) {

/*------------------------------------------------
            SHOW AGAIN MENU IN NAVBAR
------------------------------------------------*/

var nav_menu = $('.main-navigation ul.nav-menu');

$(document).click(function (e) {
	setTimeout(() => nav_menu.show(), 5);
});

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