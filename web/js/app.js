jQuery.fn.extend({
    slideRight: function () {
        return this.each(function () {
            jQuery(this).animate({width: 'show'});
        });
    },
    slideLeft: function () {
        return this.each(function () {
            jQuery(this).animate({width: 'hide'});
        });
    },
    slideToggleWidth: function () {
        return this.each(function () {
            var el = jQuery(this);
            if (el.css('display') == 'none') {
                el.slideRight();
            } else {
                el.slideLeft();
            }
        });
    }
});

$(function () {
    var buttonSearch = $('.navbar-button-search');
    var inputSearch = $('.navbar-search');

    buttonSearch.on('click', function (e) {
        e.preventDefault();

        $(this).fadeOut(200, function () {
            inputSearch.animate({width: 'show'}, function () {
                inputSearch.find('input').focus();
            });
        });
    });

    inputSearch.on('focusout', function (e) {
        e.preventDefault();

        $(this).animate({width: 'hide'}, function () {
            buttonSearch.fadeIn(300);
        });
    })
});