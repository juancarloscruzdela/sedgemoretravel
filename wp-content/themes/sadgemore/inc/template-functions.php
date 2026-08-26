<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package sadgemore
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function sadgemore_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'sadgemore_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function sadgemore_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'sadgemore_pingback_header' );


function hook_css(){

    if ( isset( $_GET['text_style_option']) ){
        ?>
        <style type="text/css">
            @media screen (max-width:728px) {
                body .hedi_slider{
                    line-height: 2rem;
                }
                
            }
        </style>
        <?php
    }
    
    
    if ( isset( $_GET['text_style_option']) && $_GET['text_style_option'] === 'version1') {
	?>
	<style type="text/css">
		body .hedi_slider{
			font-weight:600;  /* Was 400 */
		}
	</style>
	<?php
    }

    if ( isset( $_GET['text_style_option']) && $_GET['text_style_option'] === 'version2') {
        ?>
    <style type="text/css">
        body .hedi_slider{
            font-weight:600;  /* Was 400 */
            font-family: "Montserrat", sans-serif;
        }
    </style>
    <?php
    }

    if ( isset( $_GET['text_style_option']) && $_GET['text_style_option'] === 'version3') {
        ?>
    <style type="text/css">
        body .banr_sec_wrap .owl-item .slide:before{
          background-color:rgba(0,0,0,0.5);
          /*background-color:rgba(255,165,0,0.2);*/
        }
    </style>
    <?php
    }    
}
add_action('wp_head', 'hook_css');

/**
 * Add acf option pages
 */

function sadgemore_acf_options_pages() {
    if( function_exists('acf_add_options_page') ) {
        
        acf_add_options_page(array(
            'page_title'    => 'Theme General Settings',
            'menu_title'    => 'Theme Settings',
            'menu_slug'     => 'theme-general-settings',
            'capability'    => 'edit_posts',
            'redirect'      => false
        ));
        
        acf_add_options_sub_page(array(
            'page_title'    => 'Theme Header Settings',
            'menu_title'    => 'Header',
            'parent_slug'   => 'theme-general-settings',
        ));
        
        acf_add_options_sub_page(array(
            'page_title'    => 'Theme Footer Settings',
            'menu_title'    => 'Footer',
            'parent_slug'   => 'theme-general-settings',
        ));
        
    }
}
add_action('admin_menu', 'sadgemore_acf_options_pages');