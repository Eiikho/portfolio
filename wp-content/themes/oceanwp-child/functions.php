<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if (!function_exists('chld_thm_cfg_locale_css')) :
    function chld_thm_cfg_locale_css($uri)
    {
        if (empty($uri) && is_rtl() && file_exists(get_template_directory() . '/rtl.css'))
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter('locale_stylesheet_uri', 'chld_thm_cfg_locale_css');

if (!function_exists('child_theme_configurator_css')) :
    function child_theme_configurator_css()
    {
        wp_enqueue_style('chld_thm_cfg_child', trailingslashit(get_stylesheet_directory_uri()) . 'style.css', array('font-awesome', 'simple-line-icons', 'magnific-popup', 'slick', 'oceanwp-style', 'oceanwp-hamburgers', 'oceanwp-spin'));
    }
endif;
add_action('wp_enqueue_scripts', 'child_theme_configurator_css', 10);


// END ENQUEUE PARENT ACTION

/**
 * Register Bootstrap CSS
 */
if (!function_exists('bootstrap_style')) {
    function bootstrap_style()
    {
        wp_enqueue_style('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css', array(), '4.4.1');
    }
    add_action('wp_enqueue_scripts', 'bootstrap_style');
}

/**
 * Register Bootstrap JS with jquery
 */
if (!function_exists('bootstrap_js')) {
    function bootstrap_js()
    {
        wp_enqueue_script('bootstrap-popper', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/esm/popper.js', array('jquery'), '1.16.0', true);
        wp_enqueue_script('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js', array('jquery'), '4.4.1', true);
    }

    add_action('wp_enqueue_scripts', 'bootstrap_js');
}

//add personal JS files
add_action('wp_enqueue_scripts', 'my_script_function');
function my_script_function()
{
    wp_enqueue_script('mon-script', get_stylesheet_directory_uri() . '/js/mon-script.js', array('jquery'), '1.0', true);
    wp_localize_script('mon-script', 'frontendajax', array('ajaxurl' => admin_url('admin-ajax.php')));
}

// Function to increment dl count !
function increment_dl_count($post_id)
{
    $meta_key = "dl_count";
    $dl_count = get_post_meta($post_id, $meta_key);

    return update_post_meta($post_id, $meta_key, (string) ((int) $dl_count[0] + 1));
}


// get infos for a single game inside DB
function get_single_game_data($post_id)
{
    $p = get_post($post_id);

    // Get all image related to current post
    $args = array('post_type' => 'attachment', 'post_mime_type' => 'image', 'post_parent' => $p->ID);
    $attached_images = get_posts($args);

    // building data array with selected results
    $info = array('name' => $p->post_title, 'desc' => $p->post_content);
    $meta = get_post_meta($p->ID);

    if (array_key_exists("game_playable", $meta))
        $info["game_playable"] = $meta["game_playable"][0];

    if (array_key_exists("release_date", $meta))
        $info["release_date"] = $meta["release_date"][0];

    if (array_key_exists("dev_time", $meta))
        $info["dev_time"] = $meta["dev_time"][0];

    if (array_key_exists("lifetime", $meta))
        $info["lifetime"] = $meta["lifetime"][0];

    if (array_key_exists("style", $meta))
        $info["style"] = $meta["style"][0];

    if (array_key_exists("dl_count", $meta))
        $info["dl_count"] = $meta["dl_count"][0];

    if (array_key_exists("techno", $meta))
        $info["techno"] = $meta["techno"][0];

    if (array_key_exists("movie_path", $meta))
        $info["movie_path"] = $meta["movie_path"][0];

    if (array_key_exists("ocean_link_format", $meta)) {
        $info["download_url"] = $meta["ocean_link_format"][0];
    } else {
        $info["download_url"] = "#";
    }

    if (count($attached_images) > 0) {
            $info['image'] = $attached_images;
    }
    return $info;
}

// Shortcode to get all games data
add_shortcode('get_all_games_data', 'get_all_games_data_function');
function get_all_games_data_function()
{
    $selected_category = 4; // Desired category initialisation ; 4 = Games
    $posts = get_posts(array('orderby' => 'date', 'order' => "ASC")); // get all posts from DB
    $html = "";

    $cpt = 0;
    foreach ($posts as $p) {
        $current_cat = wp_get_post_categories($p->ID);
        if (in_array($selected_category, $current_cat)) {
            $game = get_single_game_data($p->ID);

            $attached_img_src = wp_get_attachment_image_src(get_post_thumbnail_id($p->ID), 'medium')[0];
            $desc = (strlen($game['desc']) > 350 ? (substr($game['desc'], 0, 350) . '...') : $game['desc']);
            $dl_count_txt = "";
            if ($game['dl_count'] > 0) {
                $dl_count_txt .= '<span class="nb-dl">Téléchargé <span class="nb-dl-nb">' . $game['dl_count'] . '</span> fois</span>';
            }

            $html .= '<div class="row mx-2 my-4 jeu-details" data-post-id="' . $p->ID . '">';
            $html .= '    <div class="col-md-4 p-0 text-center jeu-img">';
            //slider
            $html .= '<div id="slider_img_game_' . $cpt . '" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">';
            if (array_key_exists('image', $game)) {
                $html .= '<li data-target="#slider_img_game_' . $cpt . '" data-slide-to="0" class="active"></li>';
                $cpt_slides = 1;
                foreach ($game['image'] as $img) {
                    $html .= '<li data-target="#slider_img_game_' . $cpt . '" data-slide-to="' . $cpt_slides . '"></li>';
                    $cpt_slides++;
                }
            }
            $html .= '</ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="' . $attached_img_src . '">
                    </div>';
            if (array_key_exists('image', $game)) {
                foreach ($game['image'] as $img) {
                    $html .= '<div class="carousel-item">';
                    $html .= '<img src="' . $img->guid . '">';
                    $html .= '</div>';
                }
            }
            $html .= '    </div>
                <a class="carousel-control-prev" href="#slider_img_game_' . $cpt . '" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#slider_img_game_' . $cpt . '" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>';
            //- end slider
            $html .= '      <a href="' . $game['download_url'] . '" class="btn btn-primary my-3 mx-2 download-btn" download>
                                <i class="fas fa-download"></i> Télécharger
                                ' . $dl_count_txt . '
                            </a>';
            $html .= '    </div>';
            $html .= '    <div class="col-md-8 py-3 jeu-content">';
            $html .= '          <a href="' . get_permalink($p->ID) . '" class="btn btn-secondary my-3 mx-2 voir-jeu"><i class="fas fa-eye"></i> Voir le jeu</a>';
            $html .= '        <h2 class="pb-3">' . $game["name"] . '</h2>';
            $html .= '        <h3 class="pb-2">Description</h3>';
            $html .= '        <div class="description-jeu pl-3">' . $desc . '</div>';
            $html .= '    </div>';
            $html .= '</div>';

            $cpt++;
        }
    }

    return $html;
}

//ajax function 
add_action("wp_ajax_open_language_modal", "open_language_modal");
add_action("wp_ajax_nopriv_open_language_modal", "open_language_modal");
function open_language_modal()
{
    $resultat = array();

    $html = '<div class="modal fade" id="lang_modal" tabindex="-1" role="dialog" aria-labelledby="lang_modal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="lang_modalLabel">' . __('Changer de langue') . '</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col text-center">
                            <a href="' . get_home_url() . '/en">
                                <img src="' . get_home_url() . '/wp-content/uploads/2020/01/flag_en.png' . '"><br>' . __('Anglais') . '
                            </a>
                        </div>
                        <div class="col text-center">
                            <a href="' . get_home_url() . '">
                                <img src="' . get_home_url() . '/wp-content/uploads/2020/01/flag_fr.png' . '"><br>' . __('Français') . '
                            </a>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">' . __('Fermer') . '</button>
                </div>
            </div>
            </div>
        </div>';

    $resultat['html'] = $html;

    echo json_encode($resultat);
    die;
}
// # GAME DL ++
add_action("wp_ajax_increment_dl_count_post", "increment_dl_count_post");
add_action("wp_ajax_nopriv_increment_dl_count_post", "increment_dl_count_post");
function increment_dl_count_post()
{
    $res = array();
    $post_id = isset($_POST['post_id']) ? $_POST['post_id'] : null;
    $href = isset($_POST['href']) ? $_POST['href'] : null;

    if (!$post_id) {
        $res['error'] = "Pas d'id du jeu";
    } else {
        if ($href && $href != '' && $href != '#') {
            if (!increment_dl_count($post_id)) {
                $res['error'] = "Erreur lors de l'incrémentation du nombre de DL du jeu";
            } else {
                $res['success'] = "Incrémentation réussie";
                $res['nb_dl'] = get_post_meta($post_id, 'dl_count');
            }
        } else {
            $res['error'] = "Aucun fichier à télécharger";
        }
    }

    echo json_encode($res);
    die;
}
