$(document).ready(function(){
    //Cache HTML page
    var entireDoc = $('html, body');
    
    $('#hero, body > main').click(function() {
        $('#page-header').find('.navbar-collapse').removeClass('in');
    });
    
    //Enable smooth navigation
    $('.landing-nav').on('click', 'a', function(e) {
        e.preventDefault();
        smoothScroll(entireDoc, $(this).attr('href'));   
    });

    $('#go-to-the-top, #cta-hire-link, #navbar-brand-link').click(function(e) {
        e.preventDefault();
        smoothScroll(entireDoc, $(this).attr('href'));
    });

    //Enable tab navigation
    $('#portfolio-item-navigation').on('click', 'a', function(e) {
        e.preventDefault();
        $(this).tab('show');
    });
    
    //Manage modal data
    $('.portfolio-product-item').click(function() {
        var img_src = $(this).attr('data-src');
        var img_alt = $(this).children('strong').text();

        $('#modal-img').attr('src', img_src);
        $('#modal-img').attr('alt', img_alt);

        $('.modal-title').html(img_alt);

        $('#portfolio-modal').on('hide.bs.modal', function() {
            $('#modal-img').attr('src', '');
            $('#modal-img').attr('alt', '');
            $('modal-title').html('');
        });
    });
    
    $('.user-journey-link').click(function() {
        $(this).toggleClass('user-journey-link-active');
        $(this).find('span').toggleClass('glyphicon-menu-up glyphicon-menu-down');
    });
    
    $('.user-journey').on('hide.bs.collapse', function() {
        $(this).find('.user-journey-link').not(':focus').removeClass('user-journey-link-active');
        $(this).find('.user-journey-link').not(':focus').find('span').removeClass('glyphicon-menu-up').addClass('glyphicon-menu-down');
    });
});

function smoothScroll(elem, pos) {
    $(elem).animate({
        scrollTop: $(pos).offset().top
    }, 'slow');
}