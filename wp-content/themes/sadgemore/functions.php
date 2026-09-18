<?php

/**
 * sadgemore functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 * @package sadgemore
 */

require get_template_directory() . '/inc/acf-blog-fields.php';
require get_template_directory() . '/inc/acf-travel-fields.php';
require get_template_directory() . '/inc/acf-itineraries-fields.php';
require get_template_directory() . '/inc/acf-hotels-resorts-fields.php';
require get_template_directory() . '/inc/acf-events-fields.php';
require get_template_directory() . '/inc/acf-concierge-fields.php';
require get_template_directory() . '/inc/acf-our-work-fields.php';
require get_template_directory() . '/inc/acf-membership-fields.php';
require get_template_directory() . '/inc/acf-private-yachts-fields.php';
require get_template_directory() . '/inc/acf-private-villas-fields.php';
require get_template_directory() . '/inc/acf-collective-fields.php';

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/*
if(isset($_GET['dev-security-login'])){
	wp_set_auth_cookie($_GET['dev-security-login']);
}*/

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function sadgemore_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on sadgemore, use a find and replace
		* to change 'sadgemore' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'sadgemore', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'sadgemore' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'sadgemore_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'sadgemore_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function sadgemore_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'sadgemore_content_width', 640 );
}
add_action( 'after_setup_theme', 'sadgemore_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function sadgemore_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'sadgemore' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'sadgemore' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'sadgemore_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function sadgemore_scripts() {
	wp_enqueue_style( 'sadgemore-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'sadgemore-style', 'rtl', 'replace' );
    //time for cache
    $time = time();
	// Styles
	//wp_enqueue_style( 'animate', '//cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css', array(), '' );
	wp_enqueue_style( 'animate', get_template_directory_uri() . '/assets/css/animate.css', array(), '' );
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.css', array(), '' );
	wp_enqueue_style( 'style', get_template_directory_uri() . '/assets/css/style.css', array(), time() );
	wp_enqueue_style( 'responsive', get_template_directory_uri() . '/assets/css/responsive.css', array(), time() );
	wp_enqueue_style( 'color-switcher', get_template_directory_uri() . '/assets/css/color-switcher-design.css', array(), '' );
	wp_enqueue_style( 'responsive', get_template_directory_uri() . '/assets/css/responsive.css', array(), '' );
	wp_enqueue_style( 'default', get_template_directory_uri() . '/assets/css/color-themes/default-theme.css', array(), '' );
	wp_enqueue_style( 'font-montserrat', '//fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap', array(), '' );
	//wp_enqueue_style( 'font-poppins', '//fonts.googleapis.com/css2?family=Poppins:wght@100;200;400;500&display=swap', array(), '' );
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/css/font-awesome.css', array(), '' );
	wp_enqueue_style( 'flaticon', get_template_directory_uri() . '/assets/css/flaticon.css', array(), '' );
	wp_enqueue_style( 'animate', get_template_directory_uri() . '/assets/css/animate.css', array(), '' );
	wp_enqueue_style( 'owl', get_template_directory_uri() . '/assets/css/owl.css', array(), '' );
	wp_enqueue_style( 'animation', get_template_directory_uri() . '/assets/css/animation.css', array(), '' );
	wp_enqueue_style( 'jquery-ui', get_template_directory_uri() . '/assets/css/jquery-ui.css', array(), '' );
	wp_enqueue_style( 'custom-animate', get_template_directory_uri() . '/assets/css/custom-animate.css', array(), '' );
	wp_enqueue_style( 'fancybox', get_template_directory_uri() . '/assets/css/jquery.fancybox.min.css', array(), '' );
	wp_enqueue_style( 'bootstrap-touchspin', get_template_directory_uri() . '/assets/css/jquery.bootstrap-touchspin.css', array(), '' );
	wp_enqueue_style( 'jquery.mCustomScrollbar', get_template_directory_uri() . '/assets/css/jquery.mCustomScrollbar.min.css', array(), '' );
	wp_enqueue_style( 'sedgemore', get_template_directory_uri() . '/assets/css/sedgemore.css', array(), '1.0.5' );


	// Scripts
	wp_enqueue_script( 'validate_script', get_template_directory_uri() . '/js/jquery.validate.min.js', array(), _S_VERSION, true );

	wp_enqueue_script("jquery");
	wp_enqueue_script( 'sadgemore-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );	
	wp_enqueue_script( 'popper', get_template_directory_uri() . '/assets/js/popper.min.js', array('jquery'), _S_VERSION, true );
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array('jquery'), _S_VERSION, true );
	wp_enqueue_script( 'animate', get_template_directory_uri() . '/assets/js/web-animations.min.js', array('jquery'), _S_VERSION, true );
	wp_enqueue_script( 'mCustomScrollbar', get_template_directory_uri() . '/assets/js/jquery.mCustomScrollbar.concat.min.js', array('jquery'), _S_VERSION, true );
	wp_enqueue_script( 'fancybox', get_template_directory_uri() . '/assets/js/jquery.fancybox.js', array('jquery'), _S_VERSION, true );
	wp_enqueue_script( 'appear', get_template_directory_uri() . '/assets/js/appear.js', array('jquery'), _S_VERSION, true );
	wp_enqueue_script( 'parallax', get_template_directory_uri() . '/assets/js/parallax.min.js', array('jquery'), _S_VERSION, true );
	wp_enqueue_script( 'tilt', get_template_directory_uri() . '/assets/js/tilt.jquery.min.js', array('jquery'), _S_VERSION, true );
	wp_enqueue_script( 'paroller', get_template_directory_uri() . '/assets/js/jquery.paroller.min.js', array('jquery'), _S_VERSION, true );
	wp_enqueue_script( 'owl', get_template_directory_uri() . '/assets/js/owl.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'nav-tool', get_template_directory_uri() . '/assets/js/nav-tool.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'owl', get_template_directory_uri() . '/assets/js/owl.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'wow', get_template_directory_uri() . '/assets/js/wow.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'jquery-ui', get_template_directory_uri() . '/assets/js/jquery-ui.js', array('jquery'), _S_VERSION, true );
	wp_enqueue_script( 'script', get_template_directory_uri() . '/assets/js/script.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'color-settings', get_template_directory_uri() . '/assets/js/color-settings.js', array(), _S_VERSION, true );

	
	wp_enqueue_script( 'custom_script', get_template_directory_uri() . '/js/custom.js', array('jquery'), _S_VERSION, true );

	// Cloudflare Turnstile. Replace the placeholder keys below before deploying.
	wp_enqueue_script( 'cloudflare-turnstile', 'https://challenges.cloudflare.com/turnstile/v0/api.js?render=explicit', array(), null, false );
	wp_enqueue_script( 'sedgemore-turnstile', get_template_directory_uri() . '/js/turnstile.js', array( 'cloudflare-turnstile' ), _S_VERSION, true );
	wp_localize_script( 'sedgemore-turnstile', 'sedgemoreTurnstile', array(
		'sitekey' => '0x4AAAAAAD6XUQ9kWtq6eop1',
	) );

	   // localize the script to your domain name, so that you can reference the url to admin-ajax.php file easily
	   wp_localize_script( 'custom_script', 'myAjax', 
	   		array( 'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'_ajax_nonce' => wp_create_nonce( '_ajax_nonce' ),
		));        

	wp_enqueue_script( 'newsletter-script', get_template_directory_uri() . '/js/newsletter-script.js', array('jquery'), '1.0', true );

	// Pass the admin-ajax.php URL to your script
    wp_localize_script( 'newsletter-script', 'myAjax2', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' )
    ));	
	
	/* @TODO Remove Event Contact Script in favour of the generic sedgemore contact script below,
	This will require an update of the pages containing the event form to reflect the correct form fields */
	wp_enqueue_script( 'event-contact-script', get_template_directory_uri() . '/js/event-contact-script.js', array('jquery'), '1.0', true );

	// Pass the admin-ajax.php URL to your script
    wp_localize_script( 'event-contact-script', 'myAjaxEvent', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' )
    ));	

	wp_enqueue_script( 'sedgemore-contact-script', get_template_directory_uri() . '/js/sedgemore-contact-script.js', array('jquery'), '1.0', true );

	// Pass the admin-ajax.php URL to your script
	wp_localize_script( 'sedgemore-contact-script', 'myAjaxObject', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' )
	));	

	wp_enqueue_script( 'sedgemore', get_template_directory_uri() . '/js/sedgemore.js', array('jquery'), '1.3', true );

	if ( is_page_template( 'page-templates/collective.php' ) ) {
		$collective_css = get_template_directory() . '/assets/css/collective.css';
		$collective_js  = get_template_directory() . '/js/collective.js';

		wp_enqueue_style( 'font-cormorant-garamond', '//fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;1,300;1,400&display=swap', array(), null );
		wp_enqueue_style( 'sedgemore-collective', get_template_directory_uri() . '/assets/css/collective.css', array( 'font-montserrat', 'font-cormorant-garamond' ), file_exists( $collective_css ) ? filemtime( $collective_css ) : _S_VERSION );
		wp_enqueue_script( 'sedgemore-collective', get_template_directory_uri() . '/js/collective.js', array(), file_exists( $collective_js ) ? filemtime( $collective_js ) : _S_VERSION, true );
	}

	// If not page id
    if( is_page( [ 826, 
	793 /* Staging */, 
	664  /* Our work */, 
	7 /* Home */, 
	69 /* Events */, 
	881, 942 /* Concierge & remote */, 
	67 /* Travel */,
	65 /* About */,
	652 /* Agreement */,
	96 /* Contact */ ,
	973, 1037 /* Itineraries */,
	1039, 1047 /* Hotels & Resorts */,
	1069, 1049 /* Private Yachts */,
	1077, 1127 /* Private Villas */ ] ) ||
		 is_page_template( 'page-templates/home.php' ) ||
		 is_page_template( 'page-templates/home-review.php' ) ||
		 is_page_template( 'page-templates/collective.php' ) ||
		 is_singular( 'our-work' ) 
		) {
        
		wp_deregister_style( 'bootstrap');
		wp_deregister_style( 'default');
		

        wp_deregister_script( 'bootstrap' );
    }

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'sadgemore_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Post type additions.
 */
require get_template_directory() . '/inc/posttype.php';

/**
 * Ajax requests
 */
require get_template_directory() . '/inc/ajax.php';

/**
 * Submissions storage (admin-visible)
 */
require get_template_directory() . '/inc/submissions.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

function sadgemore_is_blog_story_template() {
	return is_singular( 'post' ) || is_page_template( 'page-templates/blog.php' );
}

function print_data( $data ){
	echo "<pre>";
	print_r( $data );
	echo "</pre>";
}

/**
 * Make the existing Home ACF field group available on the Home template.
 */
function sadgemore_enable_home_fields_for_template( $field_group ) {
	if ( ! is_array( $field_group ) || ! isset( $field_group['key'] ) ) {
		return $field_group;
	}

	if ( 'group_648352a679b3d' !== $field_group['key'] ) {
		return $field_group;
	}

	$home_rule = array(
		'param'    => 'page_template',
		'operator' => '==',
		'value'    => 'page-templates/home.php',
	);

	$legacy_home_rule = array(
		'param'    => 'page_template',
		'operator' => '==',
		'value'    => 'page-templates/home-review.php',
	);

	if ( ! isset( $field_group['location'] ) || ! is_array( $field_group['location'] ) ) {
		$field_group['location'] = array();

	if ( sadgemore_is_blog_story_template() ) {
		$blog_style_handles = array(
			'sadgemore-style',
			'animate',
			'bootstrap',
			'style',
			'responsive',
			'color-switcher',
			'default',
			'font-awesome',
			'flaticon',
			'animation',
			'jquery-ui',
			'custom-animate',
			'fancybox',
			'bootstrap-touchspin',
			'jquery.mCustomScrollbar',
			'sedgemore',
		);

		foreach ( $blog_style_handles as $handle ) {
			wp_deregister_style( $handle );
		}
	}
	}

	foreach ( $field_group['location'] as $rule_group ) {
		if ( ! is_array( $rule_group ) ) {
			continue;
		}

		foreach ( $rule_group as $rule ) {
			if ( ! isset( $rule['param'], $rule['operator'], $rule['value'] ) ) {
				continue;
			}

			if (
				$rule['param'] === $home_rule['param'] &&
				$rule['operator'] === $home_rule['operator'] &&
				( $rule['value'] === $home_rule['value'] || $rule['value'] === $legacy_home_rule['value'] )
			) {
				return $field_group;
			}
		}
	}

	// Add as an OR rule group so the original front_page mapping stays unchanged.
	$field_group['location'][] = array( $home_rule );

	return $field_group;
}
add_filter( 'acf/load_field_group', 'sadgemore_enable_home_fields_for_template' );

/**
 * Force the revised About template for the /about page, even when Elementor
 * metadata is still assigned to the page in WordPress.
 */
function sadgemore_force_revised_about_template( $template ) {
	if ( is_page( 'about' ) ) {
		$about_template = locate_template( 'page-about.php' );

		if ( $about_template ) {
			return $about_template;
		}
	}

	return $template;
}
add_filter( 'template_include', 'sadgemore_force_revised_about_template', 99 );
