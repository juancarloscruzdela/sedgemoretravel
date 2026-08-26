<?php

/*Custom Post type start*/
function sadgemore_post_types() {

    $labels = array(
        'name' => _x('Teams', 'plural'),
        'singular_name' => _x('Team', 'singular'),
        'menu_name' => _x('Team', 'admin menu'),
        'name_admin_bar' => _x('Team', 'admin bar'),
        'add_new' => _x('Add New', 'add new'),
        'add_new_item' => __('Add New Team'),
        'new_item' => __('New Team'),
        'edit_item' => __('Edit Team'),
        'view_item' => __('View Team'),
        'all_items' => __('All Team'),
        'search_items' => __('Search Team'),
        'not_found' => __('No Team found.'),
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'query_var' => true,
        'hierarchical' => false,
        'menu_icon'   => 'dashicons-businessperson',
        'supports' => array(
            'title', // post title
            'editor', // post content
            'thumbnail', // featured images
        ),
    );
    register_post_type('team', $args);

    // Travel post type
    $labels = array(
        'name' => _x('Travel', 'plural'),
        'singular_name' => _x('Travel', 'singular'),
        'menu_name' => _x('Travel', 'admin menu'),
        'name_admin_bar' => _x('Travel', 'admin bar'),
        'add_new' => _x('Add New', 'add new'),
        'add_new_item' => __('Add New Travel'),
        'new_item' => __('New Travel'),
        'edit_item' => __('Edit Travel'),
        'view_item' => __('View Travel'),
        'all_items' => __('All Travel'),
        'search_items' => __('Search Travel'),
        'not_found' => __('No Travel found.'),
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'query_var' => true,
        'hierarchical' => false,
        'menu_icon'   => 'dashicons-megaphone',
        'publicly_queryable'  => false,
        'rewrite' => array('slug' => 'travels'),
        'supports' => array(
            'title', // post title
            'editor', // post content
            'thumbnail', // featured images
        ),
    );
    register_post_type('travel', $args);

     // Events post type
     $labels = array(
        'name' => _x('Events', 'plural'),
        'singular_name' => _x('Event', 'singular'),
        'menu_name' => _x('Events', 'admin menu'),
        'name_admin_bar' => _x('Event', 'admin bar'),
        'add_new' => _x('Add New', 'add new'),
        'add_new_item' => __('Add New Event'),
        'new_item' => __('New Event'),
        'edit_item' => __('Edit Event'),
        'view_item' => __('View Event'),
        'all_items' => __('All Event'),
        'search_items' => __('Search Event'),
        'not_found' => __('No Event found.'),
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'query_var' => true,
        'hierarchical' => false,
        'menu_icon'   => 'dashicons-megaphone',        
        'supports' => array(
            'title', // post title
            'editor', // post content
            'thumbnail', // featured images
        ),
    );
    register_post_type('events', $args);


    add_filter( 'template_include', 'include_our_work_template_function', 1 );
    function include_our_work_template_function( $template_path ) {
        if ( get_post_type() == 'our-work' ) {
            if ( is_single() ) {

                 if ( $theme_file = locate_template( array ( 'post-type-templates/single-our-work.php' ) ) ) {
                    $template_path = $theme_file;
                }

            }
        }
        return $template_path;
    }

     // Our Work post type
     $labels = array(
        'name' => _x('Our Work', 'plural'),
        'singular_name' => _x('Our Work', 'singular'),
        'menu_name' => _x('Our Work', 'admin menu'),
        'name_admin_bar' => _x('Our Work', 'admin bar'),
        'add_new' => _x('Add New', 'add new'),
        'add_new_item' => __('Add New Work'),
        'new_item' => __('New Work'),
        'edit_item' => __('Edit Our Work'),
        'view_item' => __('View Our Work'),
        'all_items' => __('All Work'),
        'search_items' => __('Search Work'),
        'not_found' => __('No Work found.'),
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'query_var' => true,
        'hierarchical' => false,
        'menu_icon'   => 'dashicons-megaphone',
        'has_archive' 		=> false,
        'rewrite' => array('slug' => 'our-work', 'with_front' => false ),  
        'supports' => array(
            'title', // post title
            'editor', // post content
            'thumbnail', // featured images
        ),
    );
    register_post_type('our-work', $args);    

    // Partnership post type
    $labels = array(
        'name' => _x('Partnerships', 'plural'),
        'singular_name' => _x('Partnership', 'singular'),
        'menu_name' => _x('Partnerships', 'admin menu'),
        'name_admin_bar' => _x('Partnerships', 'admin bar'),
        'add_new' => _x('Add New', 'add new'),
        'add_new_item' => __('Add New Partnerhip'),
        'new_item' => __('New Partnership'),
        'edit_item' => __('Edit Partnerships'),
        'view_item' => __('View Partnerships'),
        'all_items' => __('All Partnerhips'),
        'search_items' => __('Search Partnerhips'),
        'not_found' => __('No Partnerhips found.'),
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'query_var' => true,
        'hierarchical' => false,
        'menu_icon'   => 'dashicons-megaphone',        
        'supports' => array(
            'title', // post title
            'editor', // post content
            'thumbnail', // featured images
        ),
    );
    register_post_type('partnership', $args);  

    $labels = array(
        'name' => _x( 'Travel type', 'sadgemore' ),
        'singular_name' => _x( 'Travel type', 'sadgemore' ),
        'search_items' =>  __( 'Search Travel type' ),
        'all_items' => __( 'All Travel type' ),
        'parent_item' => __( 'Parent Travel type' ),
        'parent_item_colon' => __( 'Parent Travel type:' ),
        'edit_item' => __( 'Edit Travel type' ), 
        'update_item' => __( 'Update Travel type' ),
        'add_new_item' => __( 'Add New Travel type' ),
        'new_item_name' => __( 'New Travel type Name' ),
        'menu_name' => __( 'Travel type' ),
      );    
      
    // Now register the taxonomy
      register_taxonomy('travel-type',array('travel'), array(
		'public' => false,
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_in_rest' => true,
        'show_admin_column' => true,
        'query_var' => true,
      ));
}
add_action('init', 'sadgemore_post_types');
/*Custom Post type end*/