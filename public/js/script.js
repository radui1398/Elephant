/*
Theme Name: New Theme
Theme URI: -
Author: -
Version: 1.0
*/
$ = jQuery;

var mouseOnHeader = false;

jQuery(document).ready(function ($) {
    // Homepage Iframe
    const googleMap = $('#lazyIframeMap');
    googleMap.on('click', function (e) {
        const googleMapUrl = googleMap.data('src');
        const googleMapOverlay = $('.map-overlay', googleMap);
        googleMap.append('<iframe src="' + googleMapUrl + '" frameborder="0" style="border:0;" allowfullscreen=""></iframe>')
    });

    //Menu
    const header = $('header');
    const dropdownOverlay = $('.dropdown-open', header);
    const nav = $('ul', header);
    const li = $('header .menu > li.menu-item-has-children');

    $(dropdownOverlay).mouseleave(function () {
        const currentLI = $('li.hovered');
        currentLI.removeClass('hovered');
        dropdownOverlay.height('100%');
        header.removeClass('dropdown-is-open');
    });

    li.hover(function () {
        const existentLI = $('li.hovered');
        if (existentLI.length) {
            existentLI.removeClass('hovered');
        }
        const thisLI = $(this);
        dropdownOverlay.height(headerOverlayHeight + 'px');
        header.addClass('dropdown-is-open');
        thisLI.focus();
        thisLI.addClass('hovered');
    });

    // MEGA Menu Fix
    $('ul.sub-menu ul.sub-menu').parent().addClass('mega-menu-item');
    $('ul li.menu-heading > a').on('click', function (e) {
        e.preventDefault(); //disable click for Menu Heading
    });

    // Wordpress Editor Fix
    const imageWithZoom = $('.zoom-for-full');
    imageWithZoom.each(function () {
        const thisImage = $(this);
        const thisAnchor = thisImage.parent();
        thisAnchor.addClass('image-with-zoom');
        thisAnchor.attr('data-fancybox', '');
        thisAnchor.append(
            '<span class="gallery-image-overlay">\n' +
            '<i class="fas fa-search"></i>\n' +
            '</span>'
        );
    })

    // Share Button - Post Page
    const shareButton = $('#share-button');
    const shareButtonWidget = $('.share-article-button.widget');
    const shareButtonContainer = shareButton.parent();
    const sharePlatforms = $('a.brand', shareButtonContainer);

    shareButton.on('click', function (e) {
        e.preventDefault();

        sharePlatforms.toggleClass('show')
    });

    shareButtonWidget.on('click', function (e) {
        e.preventDefault();

        setTimeout(function(){
            shareButton.trigger('click');
        },1300);

        $('html, body').animate({
            scrollTop: $("#share-button").offset().top - 300
        }, 1000);
    });


});

$(window).on('wpcf7:invalid', function () {
    // Contact Form Validation
    const invalid = $('.wpcf7-not-valid');
    invalid.each(function () {
        let thisInput = $(this);
        thisInput.focus(function () {
            $(this).removeClass('wpcf7-not-valid');
            checkForValidationErrors('.wpcf7-not-valid');
        })
    })
});

$(window).on('wpcf7:mailsent', function () {
    // Contact Form Validation
    setTimeout(function () {
        $('.wpcf7-response-output').fadeOut();
    }, 3000);
});

function checkForValidationErrors(validateClass) {
    if ($(validateClass).length === 0) {
        $('.wpcf7-response-output').fadeOut();
    }
}

