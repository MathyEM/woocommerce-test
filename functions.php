<?php
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
function my_theme_enqueue_styles() {
    wp_enqueue_style( 'child-style', get_stylesheet_uri(),
        array( 'twentytweny' ), 
        wp_get_theme()->get('Version')
    );

    wp_enqueue_style( 'my-style', get_template_directory_uri() . '/css/style.css', array());
}