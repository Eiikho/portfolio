jQuery(document).ready(function ($) {
    $(window).scroll(function () {
        var info_id = ($('#info').offset().top - $(window).scrollTop());
        var games_id = ($('#games').offset().top - $(window).scrollTop());
        var resume_id = ($('#resume').offset().top - $(window).scrollTop());
        var contact_id = ($('#contact').offset().top - $(window).scrollTop());

        if(contact_id < 150) {
            $('.icon-menu-color i').removeClass('current-section');
            $('#icon_menu_contact i').addClass('current-section');
        }
        else if(resume_id < 150) {
            $('.icon-menu-color i').removeClass('current-section');
            $('#icon_menu_resume i').addClass('current-section');
        }
        else if(games_id < 150) {
            $('.icon-menu-color i').removeClass('current-section');
            $('#icon_menu_games i').addClass('current-section');
        }
        else if(info_id < 150) {
            $('.icon-menu-color i').removeClass('current-section');
            $('#icon_menu_info i').addClass('current-section');
        }
        else {
            $('.icon-menu-color i').removeClass('current-section');
        }
    });
});