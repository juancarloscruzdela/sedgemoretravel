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

/**
 * Return a stable cache version for a local theme asset.
 *
 * @param string $relative_path Path relative to the theme directory.
 * @return int|string
 */
function sadgemore_asset_version( $relative_path ) {
	$asset_path = trailingslashit( get_template_directory() ) . ltrim( $relative_path, '/' );

	return file_exists( $asset_path ) ? filemtime( $asset_path ) : _S_VERSION;
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
	$page_template = is_singular() ? get_page_template_slug( get_queried_object_id() ) : '';
	$is_optimized_home = is_front_page() || in_array( $page_template, array( 'page-templates/home.php', 'page-templates/home-review.php' ), true );
	$event_form_templates = array(
		'page-templates/dev-staging.php',
		'page-templates/membership.php',
	);
	$sedgemore_form_templates = array(
		'page-templates/about.php',
		'page-templates/blog.php',
		'page-templates/concierge.php',
		'page-templates/events.php',
		'page-templates/home.php',
		'page-templates/hotels-resorts.php',
		'page-templates/itineraries.php',
		'page-templates/our-work.php',
		'page-templates/private-villas.php',
		'page-templates/private-yachts.php',
		'page-templates/travel.php',
	);
	$needs_event_form_script = in_array( $page_template, $event_form_templates, true ) || is_singular( 'our-work' );
	$needs_sedgemore_form_script = in_array( $page_template, $sedgemore_form_templates, true );

	wp_enqueue_style( 'sadgemore-style', get_stylesheet_uri(), array(), sadgemore_asset_version( 'style.css' ) );
	wp_style_add_data( 'sadgemore-style', 'rtl', 'replace' );
	// Styles
	//wp_enqueue_style( 'animate', '//cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css', array(), '' );
	wp_enqueue_style( 'animate', get_template_directory_uri() . '/assets/css/animate.css', array(), sadgemore_asset_version( 'assets/css/animate.css' ) );
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.css', array(), sadgemore_asset_version( 'assets/css/bootstrap.css' ) );
	wp_enqueue_style( 'style', get_template_directory_uri() . '/assets/css/style.css', array(), sadgemore_asset_version( 'assets/css/style.css' ) );
	wp_enqueue_style( 'responsive', get_template_directory_uri() . '/assets/css/responsive.css', array(), sadgemore_asset_version( 'assets/css/responsive.css' ) );
	wp_enqueue_style( 'color-switcher', get_template_directory_uri() . '/assets/css/color-switcher-design.css', array(), sadgemore_asset_version( 'assets/css/color-switcher-design.css' ) );
	wp_enqueue_style( 'default', get_template_directory_uri() . '/assets/css/color-themes/default-theme.css', array(), sadgemore_asset_version( 'assets/css/color-themes/default-theme.css' ) );
	if ( ! is_front_page() ) {
		wp_enqueue_style( 'font-montserrat', '//fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap', array(), '' );
	}
	//wp_enqueue_style( 'font-poppins', '//fonts.googleapis.com/css2?family=Poppins:wght@100;200;400;500&display=swap', array(), '' );
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/css/font-awesome.css', array(), sadgemore_asset_version( 'assets/css/font-awesome.css' ) );
	wp_enqueue_style( 'flaticon', get_template_directory_uri() . '/assets/css/flaticon.css', array(), sadgemore_asset_version( 'assets/css/flaticon.css' ) );
	wp_enqueue_style( 'owl', get_template_directory_uri() . '/assets/css/owl.css', array(), sadgemore_asset_version( 'assets/css/owl.css' ) );
	wp_enqueue_style( 'animation', get_template_directory_uri() . '/assets/css/animation.css', array(), sadgemore_asset_version( 'assets/css/animation.css' ) );
	wp_enqueue_style( 'custom-animate', get_template_directory_uri() . '/assets/css/custom-animate.css', array(), sadgemore_asset_version( 'assets/css/custom-animate.css' ) );
	wp_enqueue_style( 'jquery.mCustomScrollbar', get_template_directory_uri() . '/assets/css/jquery.mCustomScrollbar.min.css', array(), sadgemore_asset_version( 'assets/css/jquery.mCustomScrollbar.min.css' ) );
	wp_enqueue_style( 'sedgemore', get_template_directory_uri() . '/assets/css/sedgemore.css', array(), sadgemore_asset_version( 'assets/css/sedgemore.css' ) );
	if ( ! $is_optimized_home ) {
		wp_enqueue_style( 'jquery-ui', get_template_directory_uri() . '/assets/css/jquery-ui.css', array(), sadgemore_asset_version( 'assets/css/jquery-ui.css' ) );
		wp_enqueue_style( 'fancybox', get_template_directory_uri() . '/assets/css/jquery.fancybox.min.css', array(), sadgemore_asset_version( 'assets/css/jquery.fancybox.min.css' ) );
		wp_enqueue_style( 'bootstrap-touchspin', get_template_directory_uri() . '/assets/css/jquery.bootstrap-touchspin.css', array(), sadgemore_asset_version( 'assets/css/jquery.bootstrap-touchspin.css' ) );
	}


	// Scripts
	wp_enqueue_script( 'validate_script', get_template_directory_uri() . '/js/jquery.validate.min.js', array( 'jquery' ), sadgemore_asset_version( 'js/jquery.validate.min.js' ), true );

	wp_enqueue_script("jquery");
	wp_enqueue_script( 'sadgemore-navigation', get_template_directory_uri() . '/js/navigation.js', array(), sadgemore_asset_version( 'js/navigation.js' ), true );	
	if ( ! $is_optimized_home ) {
		wp_enqueue_script( 'popper', get_template_directory_uri() . '/assets/js/popper.min.js', array(), sadgemore_asset_version( 'assets/js/popper.min.js' ), true );
		wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array( 'jquery', 'popper' ), sadgemore_asset_version( 'assets/js/bootstrap.min.js' ), true );
	}
	wp_enqueue_script( 'animate', get_template_directory_uri() . '/assets/js/web-animations.min.js', array(), sadgemore_asset_version( 'assets/js/web-animations.min.js' ), true );
	wp_enqueue_script( 'mCustomScrollbar', get_template_directory_uri() . '/assets/js/jquery.mCustomScrollbar.concat.min.js', array('jquery'), sadgemore_asset_version( 'assets/js/jquery.mCustomScrollbar.concat.min.js' ), true );
	wp_enqueue_script( 'appear', get_template_directory_uri() . '/assets/js/appear.js', array('jquery'), sadgemore_asset_version( 'assets/js/appear.js' ), true );
	wp_enqueue_script( 'owl', get_template_directory_uri() . '/assets/js/owl.js', array( 'jquery' ), sadgemore_asset_version( 'assets/js/owl.js' ), true );
	wp_enqueue_script( 'nav-tool', get_template_directory_uri() . '/assets/js/nav-tool.js', array( 'jquery' ), sadgemore_asset_version( 'assets/js/nav-tool.js' ), true );
	wp_enqueue_script( 'wow', get_template_directory_uri() . '/assets/js/wow.js', array(), sadgemore_asset_version( 'assets/js/wow.js' ), true );
	$legacy_script_dependencies = array( 'jquery', 'mCustomScrollbar', 'appear', 'owl', 'wow', 'validate_script' );
	if ( ! $is_optimized_home ) {
		wp_enqueue_script( 'fancybox', get_template_directory_uri() . '/assets/js/jquery.fancybox.js', array('jquery'), sadgemore_asset_version( 'assets/js/jquery.fancybox.js' ), true );
		wp_enqueue_script( 'parallax', get_template_directory_uri() . '/assets/js/parallax.min.js', array(), sadgemore_asset_version( 'assets/js/parallax.min.js' ), true );
		wp_enqueue_script( 'tilt', get_template_directory_uri() . '/assets/js/tilt.jquery.min.js', array('jquery'), sadgemore_asset_version( 'assets/js/tilt.jquery.min.js' ), true );
		wp_enqueue_script( 'paroller', get_template_directory_uri() . '/assets/js/jquery.paroller.min.js', array('jquery'), sadgemore_asset_version( 'assets/js/jquery.paroller.min.js' ), true );
		wp_enqueue_script( 'jquery-ui', get_template_directory_uri() . '/assets/js/jquery-ui.js', array('jquery'), sadgemore_asset_version( 'assets/js/jquery-ui.js' ), true );
		$legacy_script_dependencies = array_merge( $legacy_script_dependencies, array( 'fancybox', 'parallax', 'paroller' ) );
	}
	wp_enqueue_script( 'script', get_template_directory_uri() . '/assets/js/script.js', $legacy_script_dependencies, sadgemore_asset_version( 'assets/js/script.js' ), true );
	wp_enqueue_script( 'color-settings', get_template_directory_uri() . '/assets/js/color-settings.js', array( 'jquery' ), sadgemore_asset_version( 'assets/js/color-settings.js' ), true );

	
	wp_enqueue_script( 'custom_script', get_template_directory_uri() . '/js/custom.js', array( 'jquery', 'validate_script', 'owl' ), sadgemore_asset_version( 'js/custom.js' ), true );

	// The controller loads the registered API once a protected form approaches the viewport.
	wp_register_script( 'cloudflare-turnstile', 'https://challenges.cloudflare.com/turnstile/v0/api.js?render=explicit', array(), null, false );
	wp_enqueue_script( 'sedgemore-turnstile', get_template_directory_uri() . '/js/turnstile.js', array(), sadgemore_asset_version( 'js/turnstile.js' ), true );
	wp_localize_script( 'sedgemore-turnstile', 'sedgemoreTurnstile', array(
		'sitekey' => '0x4AAAAAAD6XUQ9kWtq6eop1',
		'apiUrl'  => 'https://challenges.cloudflare.com/turnstile/v0/api.js?render=explicit',
	) );

	   // localize the script to your domain name, so that you can reference the url to admin-ajax.php file easily
	   wp_localize_script( 'custom_script', 'myAjax', 
	   		array( 'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'_ajax_nonce' => wp_create_nonce( '_ajax_nonce' ),
		));        

	wp_enqueue_script( 'newsletter-script', get_template_directory_uri() . '/js/newsletter-script.js', array(), sadgemore_asset_version( 'js/newsletter-script.js' ), true );

	// Pass the admin-ajax.php URL to your script
    wp_localize_script( 'newsletter-script', 'myAjax2', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' )
    ));	
	
	if ( $needs_event_form_script ) {
		/* @TODO Remove Event Contact Script in favour of the generic sedgemore contact script below,
		This will require an update of the pages containing the event form to reflect the correct form fields */
		wp_enqueue_script( 'event-contact-script', get_template_directory_uri() . '/js/event-contact-script.js', array(), sadgemore_asset_version( 'js/event-contact-script.js' ), true );

		// Pass the admin-ajax.php URL to your script.
		wp_localize_script( 'event-contact-script', 'myAjaxEvent', array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
		) );
	}

	if ( $needs_sedgemore_form_script ) {
		wp_enqueue_script( 'sedgemore-contact-script', get_template_directory_uri() . '/js/sedgemore-contact-script.js', array(), sadgemore_asset_version( 'js/sedgemore-contact-script.js' ), true );

		// Pass the admin-ajax.php URL to your script.
		wp_localize_script( 'sedgemore-contact-script', 'myAjaxObject', array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
		) );
	}

	wp_enqueue_script( 'sedgemore', get_template_directory_uri() . '/js/sedgemore.js', array(), sadgemore_asset_version( 'js/sedgemore.js' ), true );

	foreach ( array( 'sadgemore-navigation', 'sedgemore-turnstile', 'newsletter-script', 'sedgemore' ) as $deferred_handle ) {
		wp_script_add_data( $deferred_handle, 'strategy', 'defer' );
	}

	if ( is_page_template( 'page-templates/collective.php' ) ) {
		wp_enqueue_style( 'font-cormorant-garamond', '//fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;1,300;1,400&display=swap', array(), null );
		wp_enqueue_style( 'sedgemore-collective', get_template_directory_uri() . '/assets/css/collective.css', array( 'font-montserrat', 'font-cormorant-garamond' ), sadgemore_asset_version( 'assets/css/collective.css' ) );
		wp_enqueue_script( 'sedgemore-collective', get_template_directory_uri() . '/js/collective.js', array(), sadgemore_asset_version( 'js/collective.js' ), true );
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
