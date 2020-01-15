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
if ( !function_exists( 'bootstrap_style' ) ) {
	function bootstrap_style() {
		wp_enqueue_style( 'bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css', array(), '4.4.1' );
	}
	add_action( 'wp_enqueue_scripts', 'bootstrap_style' );
}

/**
 * Register Bootstrap JS with jquery
 */
if ( !function_exists( 'bootstrap_js' ) ) {
	function bootstrap_js() {
		wp_enqueue_script( 'bootstrap-popper', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/esm/popper.js', array( 'jquery' ), '1.16.0', true );
		wp_enqueue_script( 'bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js', array( 'jquery' ), '4.4.1', true );
	}

	add_action( 'wp_enqueue_scripts', 'bootstrap_js' );
}

//add personal JS files
add_action('wp_enqueue_scripts', 'my_script_function');
function my_script_function()
{
    wp_enqueue_script('mon-script', get_stylesheet_directory_uri() . '/js/mon-script.js', array('jquery'), '1.0', true);
    wp_localize_script( 'mon-script', 'frontendajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
}

//shortcode perso

//add_shortcode('increment_dl_count', 'custom_increment_dl_count');
// Function to increment dl count
function custom_increment_dl_count($post_id)
{
    $meta_key = "dl_count";
    $post_id = 667; // Comment on passe ce param comme arg de la fonction, du lien ou whatever ??????????????
    $dl_count = get_post_meta($post_id, $meta_key);

    update_post_meta($post_id, $meta_key, (String)((int)$dl_count[0] + 1));
}

// Shortcode to get all games data
add_shortcode('get_games_data', 'custom_get_games_data');
function custom_get_games_data()
{    
    $selected_category = 4; // Desired category initialisation
    $categories = get_categories(); // Getting all categories from DB
    $posts = get_posts(); // get all posts from DB
    $displayble_posts = array(); // returned array populated with selected posts    
    
    foreach($posts as $p){
        $current_cat = wp_get_post_categories($p->ID);
        if($current_cat[0] == $selected_category){ // Add the selected post the posts list if matching the desired category
            
            // Get all image related to current post
            $args = array('post_type' => 'attachment', 'post_mime_type' => 'image', 'post_parent' => $p->ID); 
            $attached_images = get_posts( $args );

            // building data array with selected results
            $info = array( 'name' => $p->post_title, 'desc' => $p->post_content );
            $meta = get_post_meta($p->ID);

            if(array_key_exists("game_playable", $meta))
                $info["game_playable"] = $meta["game_playable"][0];

            if(array_key_exists("release_date", $meta))
                $info["release_date"] = $meta["release_date"][0];

            if(array_key_exists("dev_time", $meta))
                $info["dev_time"] = $meta["dev_time"][0];

            if(array_key_exists("lifetime", $meta))
                $info["lifetime"] = $meta["lifetime"][0];

            if(array_key_exists("style", $meta))
                $info["style"] = $meta["style"][0];

            if(array_key_exists("dl_count", $meta))
                $info["dl_count"] = $meta["dl_count"][0];

            if(array_key_exists("techno", $meta))
                $info["techno"] = $meta["techno"][0];
            
            if(array_key_exists("movie_path", $meta))
                $info["movie_path"] = $meta["movie_path"][0];

            if(count($attached_images) > 0)
                $info['image'] = $attached_images;                
         
            $displayble_posts[] = $info;
            
            }   
    }

    // Building HTML
    foreach($displayble_posts as $d){
        $html .= '<div class="row" style="color:white">';
        $html .= '<div class="col">';
        $html .= 'Titre : '. $d["name"];
        $html .= '</br> Description : '. $d['desc'];
        $html .= '</br> Devices : '. $d['game_playable'];
        $html .= '</br>Release date : '.$d['release_date'];
        $html .= '</br>Development time : '.$d['dev_time'];
        $html .= '</br>Lifetime : '.$d['lifetime'];
        $html .= '</br>Style : '.$d['style'];
        $html .= '</br>Download count : '.$d['dl_count'];
        $html .= '</br>Technology used : '.$d['techno'];
        $html .= '</br>';
        foreach($d['image'] as $img){
            $html .= '<img src="'. $img->guid .'"  height="150" width="150">';
        }        
        $html .= '</div>';
        $html .= '</div>';
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
