jQuery(document).ready(function ($) {
    $(window).scroll(function () {
        var info_id = ($('#info').offset().top - $(window).scrollTop());
        var games_id = ($('#games').offset().top - $(window).scrollTop());
        var resume_id = ($('#resume').offset().top - $(window).scrollTop());
        var contact_id = ($('#contact').offset().top - $(window).scrollTop());

        if (contact_id < 150) {
            $('.icon-menu-color i').removeClass('current-section');
            $('#icon_menu_contact i').addClass('current-section');
        }
        else if (resume_id < 150) {
            $('.icon-menu-color i').removeClass('current-section');
            $('#icon_menu_resume i').addClass('current-section');
        }
        else if (games_id < 150) {
            $('.icon-menu-color i').removeClass('current-section');
            $('#icon_menu_games i').addClass('current-section');
        }
        else if (info_id < 150) {
            $('.icon-menu-color i').removeClass('current-section');
            $('#icon_menu_info i').addClass('current-section');
        }
        else {
            $('.icon-menu-color i').removeClass('current-section');
        }
    });

    $('#icon_menu_language i').on('click', function () {
        if ($('#lang_modal').length == 0) {
            var datas = {
                'action': 'open_language_modal',
            };
            jQuery.ajax({
                url: frontendajax.ajaxurl,
                type: 'POST',
                data: datas,
                dataType: "text",
                success: function (result) {
                    var resultat = JSON.parse(result);
                    if (resultat['html'] != '') {
                        $('#lang_modal').remove();
                        $('body').append(resultat['html']);
                        $('#lang_modal').modal('show');
                    }
                },
            });
        }
        else {
            $('#lang_modal').modal('show');
        }
    });
    $('.download-btn').on('click', function () {
        var parent_div =  $(this).parent().parent();
        var datas = {
            'action': 'increment_dl_count_post',
            'post_id': parent_div.data('post-id'),
            'href': $(this).attr('href'),
        };
        jQuery.ajax({
            url: frontendajax.ajaxurl,
            type: 'POST',
            data: datas,
            dataType: "text",
            success: function (result) {
                var resultat = JSON.parse(result);
                if(resultat['success'] && resultat['nb_dl']) {
                    //parent_div.find('.nb-dl-nb').html(resultat['nb_dl']);
                }
                else {
                    console.log('Erreur : ' + resultat['error']);
                }
            }
        });
    });
});