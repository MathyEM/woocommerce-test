<?php
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
function my_theme_enqueue_styles() {
    $parenthandle = 'twentywenty-style';
    $theme = wp_get_theme();
    wp_enqueue_style( $parenthandle, get_template_directory_uri() . '/style.css', 
        array(), 
        $theme->parent()->get('Version')
    );
}

// Custom Post Type - Medarbejdere 
//-- https://www.wpbeginner.com/wp-tutorials/how-to-create-custom-post-types-in-wordpress/
//-- https://developer.wordpress.org/reference/functions/register_post_type/
// Hooking up our function to theme setup
add_action( 'init', 'create_posttype' );
function create_posttype() {
 
    register_post_type( 'employees',
        array(
            'labels' => array(
                'name' => __( 'Medarbejdere' ),
                'singular_name' => __( 'Medarbejder' )
            ),
            'has_archive' => true,
            'public' => true,
            'show_ui' => true,
            'show_in_nav_menus' => true,
            'rewrite' => array('slug' => 'employees'),
            'supports' => array('title', 'thumbnail', 'custom-fields'),
            'texonomies' => array('departments'),
 
        )
    );
}

//Custom Taxonomy - Afdelinger
//-- https://www.wpbeginner.com/wp-tutorials/create-custom-taxonomies-wordpress/
//-- https://developer.wordpress.org/reference/functions/register_taxonomy/
//Hook into the init action and call create_departments_taxonomy when it fires
add_action( 'init', 'create_departments_taxonomy', 0 );
function create_departments_taxonomy() {
   $labels = array(
    'name' => _x( 'Afdelinger', 'taxonomy general name' ),
    'singular_name' => _x( 'Afdeling', 'taxonomy singular name' ),
    'parent_item' => null,
    'parent_item_colon' => null,
    'menu_name' => __( 'Afdelinger' ),
  ); 
 
  register_taxonomy('departments','employees',array(
    'hierarchical' => false,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'update_count_callback' => '_update_post_term_count',
    'query_var' => true,
    'rewrite' => array( 'slug' => 'department' ),
  ));
}