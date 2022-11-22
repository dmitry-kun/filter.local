$(document).ready(function() {

    /* Поиск */
    $('.search').click(function() {
        $(this).toggleClass('closed');
        $('.search-block').animate({
            width: 'toggle',
        }, {
            duration: 100,
            specialEasing: {
                width: 'linear',
            }
        });
    });

    /* Мобильное меню */
    $('.burger').click(function() {
        $(this).toggleClass('closed');
        $('.header-menu').animate({
            height: 'toggle',
        }, {
            duration: 100,
            specialEasing: {
                height: 'linear',
            }
        });
    });

});