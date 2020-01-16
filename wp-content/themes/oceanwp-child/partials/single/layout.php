<?php

/**
 * Single post layout
 *
 * @package OceanWP WordPress theme
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
} ?>

<article id="post-<?php the_ID(); ?>">
    <?php
    // Get posts format
    $format = get_post_format();

    // Get elements
    $elements = oceanwp_blog_single_elements_positioning();

    $game = get_single_game_data(get_the_ID());
    $attached_img_src = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'large')[0];
    $attached_img_src_med = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'large')[0];
    $desc = (strlen($game['desc']) > 500 ? (substr($game['desc'], 0, 500) . '...') : $game['desc']);
    $selected_category = 4; // Desired category initialisation ; 4 = Games
    $current_cat = wp_get_post_categories(get_the_ID());
    if (in_array($selected_category, $current_cat)) {
        // begin displaying details 
    ?>
        <div class='row' id="game_details">
            <div class="col-md-8 game-images">
                <div id="slider_img_game_single" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <?php
                        $active = false;
                        /*if ($game['movie_path']) {
                            $html .= '<div class="carousel-item active">';
                            $html .= '<iframe src="' . $game['movie_path'] . '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                            $html .= '</div>';
                            $active = true;
                        }*/
                        if (array_key_exists('image', $game)) {
                            foreach ($game['image'] as $img) {
                                if (!$active) {
                                    $html .= '<div class="carousel-item active">';
                                    $active = true;
                                } else {
                                    $html .= '<div class="carousel-item">';
                                }
                                $html .= '<img src="' . $img->guid . '">';
                                $html .= '</div>';
                            }
                            echo $html;
                        }
                        ?>
                        <a class="carousel-control-prev" href="#slider_img_game_single" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only"><?php echo __('Previous'); ?></span>
                        </a>
                        <a class="carousel-control-next" href="#slider_img_game_single" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only"><?php echo __('Next'); ?></span>
                        </a>
                    </div>
                    <ol class="carousel-indicators visible-sm-block hidden-xs-block visible-md-block visible-lg-block">
                        <?php
                        if (array_key_exists('image', $game)) {
                            $active = false;
                            $cpt_slides = 0;
                            /*if ($game['movie_path']) {
                                echo '<li data-target="#slider_img_game_single" data-slide-to="0" class="active">
                                <iframe src="' . $game['movie_path'] . '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                </li>';
                                $active = true;
                                $cpt_slides++;
                            }*/
                            
                            foreach ($game['image'] as $img) {
                                if (!$active) {
                                    $active = true;
                                    echo '<li data-target="#slider_img_game_single" data-slide-to="' . $cpt_slides . '" class="active">';
                                } else {
                                    echo '<li data-target="#slider_img_game_single" data-slide-to="' . $cpt_slides . '">';
                                }
                                echo '    <img class="d-block w-100 img-fluid" src="' . $img->guid . '">
                                </li>';
                                $cpt_slides++;
                            }
                        }
                        ?>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 game-details p-0" data-post-id="<?php echo get_the_ID(); ?>">
                <div class="game-details-head position-relative mb-3">
                    <div class="game-details-head-overlay"></div>
                    <img src="<?php echo $attached_img_src; ?>">
                    <h2 class="pb-3"><?php echo $game["name"] ?></h2>
                </div>
                <div class="game-desc px-4"><?php echo $desc; ?></div>
                <div class="text-center px-4 py-2">
                    <a href="<?php echo $game['download_url']; ?>" class="btn btn-primary my-3 mx-2 download-btn" download>
                        <i class="fas fa-download"></i>
                        <?php
                        $dl_count_txt = "";
                        if ($game['dl_count'] > 0) {
                            $dl_count_txt .= '<span class="nb-dl">Downloaded <span class="nb-dl-nb">' . $game['dl_count'] . '</span> times</span>';
                        }
                        echo __('Download');
                        echo  $dl_count_txt;
                        ?>
                    </a>
                </div>
                <div class="game-other-info px-4 py-2">
                    <div class="row">
                        <div class="col">
                            <?php echo __('Release date: ') ?>
                        </div>
                        <div class="col">
                            <?php echo ($game['release_date'] != "" ? $game['release_date'] : "Unknown"); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <?php echo __('Controllers: ') ?>
                        </div>
                        <div class="col">
                            <?php echo ($game['game_playable'] != "" ? $game['game_playable'] : "Unknown"); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <?php echo __('Estimated game lifetime: ') ?>
                        </div>
                        <div class="col">
                            <?php echo ($game['lifetime'] != "" ? $game['lifetime'] : "Unknown"); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <?php echo __('Style: ') ?>
                        </div>
                        <div class="col">
                            <?php echo ($game['style'] != "" ? $game['style'] : "Unknown"); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <?php echo __('Technologies: ') ?>
                        </div>
                        <div class="col">
                            <?php echo ($game['techno'] != "" ? $game['techno'] : "Unknown"); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <?php echo __('Development time: ') ?>
                        </div>
                        <div class="col">
                            <?php echo ($game['dev_time'] != "" ? $game['dev_time'] : "Unknown"); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="may-like m-4">
            <h3 class="theme-heading related-posts-title">
                <span class="text"><?php echo __('Other games'); ?></span>
            </h3>
            <div class="row m-4">
                <?php
                $selected_category = 4; // Desired category initialisation ; 4 = Games
                $posts = get_posts(array('orderby' => 'date', 'order' => "ASC")); // get all posts from DB

                $cpt = 0;
                foreach ($posts as $p) {
                    if ($cpt == 3) {
                        break;
                    }
                    $current_cat = wp_get_post_categories($p->ID);
                    if (in_array($selected_category, $current_cat) && $p->ID != get_the_ID()) {
                        $other_game = get_single_game_data($p->ID);
                        $attached_img_src = wp_get_attachment_image_src(get_post_thumbnail_id($p->ID), 'medium')[0];
                ?>
                        <div class="other-game">
                            <a href="<?php echo get_permalink($p->ID); ?>" title="<?php echo $other_game['name']; ?>">
                                <div class="overlay-game"></div>
                                <img src="<?php echo $attached_img_src; ?>">
                                <h3><?php echo $other_game['name']; ?></h3>
                            </a>
                        </div>
                <?php
                    }
                }
                ?>
            </div>
        </div>
    <?php
    } else {
        // Loop through elements
        foreach ($elements as $element) {

            // Featured Image
            if (
                'featured_image' == $element
                && !post_password_required()
            ) {

                $format = $format ? $format : 'thumbnail';

                get_template_part('partials/single/media/blog-single', $format);
            }

            // Title
            if ('title' == $element) {

                get_template_part('partials/single/header');
            }

            // Meta
            if ('meta' == $element) {

                get_template_part('partials/single/meta');
            }

            // Content
            if ('content' == $element) {

                get_template_part('partials/single/content');
            }

            // Tags
            if ('tags' == $element) {

                get_template_part('partials/single/tags');
            }

            // Social Share
            if (
                'social_share' == $element
                && OCEAN_EXTRA_ACTIVE
            ) {

                do_action('ocean_social_share');
            }

            // Next/Prev
            if ('next_prev' == $element) {

                get_template_part('partials/single/next-prev');
            }

            // Author Box
            if ('author_box' == $element) {

                get_template_part('partials/single/author-bio');
            }

            // Related Posts
            if ('related_posts' == $element) {

                get_template_part('partials/single/related-posts');
            }

            // Comments
            if ('single_comments' == $element) {

                comments_template();
            }
        }
    } ?>

</article>