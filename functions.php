<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

use PublishPress\Addon\Multiple_authors\Classes\Objects\Author;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_parent_css' ) ):
    function chld_thm_cfg_parent_css() {
        wp_enqueue_style( 'chld_thm_cfg_parent', trailingslashit( get_template_directory_uri() ) . 'style.css', array( 'font-awesome-theme','ytv-playlist','bootstrap-theme','magplus-main-style' ) );
    }
endif;
add_action( 'wp_enqueue_scripts', 'chld_thm_cfg_parent_css', 10 );

if ( !function_exists( 'child_theme_configurator_css' ) ):
    function child_theme_configurator_css() {
        wp_enqueue_style( 'chld_thm_cfg_child', trailingslashit( get_stylesheet_directory_uri() ) . 'style.css', array( 'chld_thm_cfg_parent' ) );
    }
endif;
add_action( 'wp_enqueue_scripts', 'child_theme_configurator_css' );

// END ENQUEUE PARENT ACTION



/**
 *
 * Get the Page Title
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( !function_exists('magplus_get_the_title')) {
    function magplus_get_the_title() {

        $title = '';

        //woocoomerce page
        if (function_exists('is_woocoomerce') && is_woocommerce() || function_exists('is_shop') && is_shop()):
            if (apply_filters( 'woocommerce_show_page_title', true )):
                $title = woocommerce_page_title(false);
            endif;
        // Default Latest Posts page
        elseif( is_home() && !is_singular('page') ) :
            $title = esc_html__('Blog','magplus');

        // Singular
        elseif( is_singular() ) :
            $title = get_the_title();

        // Search
        elseif( is_search() ) :
            global $wp_query;
            $total_results = $wp_query->found_posts;
            $prefix = '';

            if( $total_results == 1 ){
                $prefix = '1 '.magplus_get_opt('translation-search-results-for');
            }
            else if( $total_results > 1 ) {
                $prefix = $total_results . ' ' . magplus_get_opt('translation-search-results-for');
            }
            else {
                $prefix = magplus_get_opt('translation-search-results-for');
            }
            $title = $prefix . ': ' . get_search_query();
        //$title = get_search_query();

        // Category and other Taxonomies
        elseif ( is_category() ) :
            $title = sprintf('Category: %s',  single_cat_title('', false));

        elseif ( is_tag() ) :
            $title = sprintf('Tag: %s', single_tag_title('', false));

        elseif ( is_author() ) :
            $author_name = sanitize_title(get_query_var('author_name'));
            $term = get_term_by('slug', $author_name, 'author');

            if ($term) {
                $author = Author::get_by_term_id($term->term_id);
                $author_display_name = $author->display_name;
            } else {
                $author = get_user_by('slug', $author_name);

                $author_display_name = $author->display_name;
            }

            $title = wp_kses_post(sprintf( __( 'Author: %s', 'magplus' ), '<span class="vcard">' . $author_display_name . '</span>' ));


        elseif ( is_day() ) :
            $title = wp_kses_post(sprintf( __( 'Day: %s', 'magplus' ), '<span>' . get_the_date() . '</span>' ));

        elseif ( is_month() ) :
            $title = wp_kses_post(sprintf( __( 'Month: %s', 'magplus' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'magplus' ) ) . '</span>' ));

        elseif ( is_year() ) :
            $title = wp_kses_post(sprintf( __( 'Year: %s', 'magplus' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'magplus' ) ) . '</span>' ));

        elseif( is_tax() ) :
            $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
            $title = $term->name;

        elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
            $title = esc_html__( 'Asides', 'magplus' );

        elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) :
            $title = esc_html__( 'Galleries', 'magplus');

        elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
            $title = esc_html__( 'Images', 'magplus');

        elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
            $title = esc_html__( 'Videos', 'magplus' );

        elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
            $title = esc_html__( 'Quotes', 'magplus' );

        elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
            $title = esc_html__( 'Links', 'magplus' );

        elseif ( is_tax( 'post_format', 'post-format-status' ) ) :
            $title = esc_html__( 'Statuses', 'magplus' );

        elseif ( is_tax( 'post_format', 'post-format-audio' ) ) :
            $title = esc_html__( 'Audios', 'magplus' );

        elseif ( is_tax( 'post_format', 'post-format-chat' ) ) :
            $title = esc_html__( 'Chats', 'magplus' );

        elseif( is_404() ) :
            $title = esc_html__( '404', 'magplus' );

        else :
            $title = esc_html__( 'Archives', 'magplus' );
        endif;

        return $title;
    }
}


/**
 * Blog Author & Date
 * @param type $type
 * @return array
 */
if(!function_exists('magplus_blog_author_date')) {
    function magplus_blog_author_date($show_author = 'yes', $show_date = 'yes') {
        ?>
        <div class="tt-post-label">
            <?php if($show_author == 'yes'):?>
                <span class="tt-post-author-name"><?php do_action('pp_multiple_authors_show_author_box', false, 'inline', false, true); ?></span>
            <?php endif; ?>
            <?php if($show_date == 'yes'): ?>
                <span class="tt-post-date"><?php echo get_the_date(get_option('date_format')); ?></span>
            <?php endif; ?>
        </div>
        <?php
    }
}
