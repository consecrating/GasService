<?php
function yobazar_child_enqueue_styles() {
    // Load parent style (this already loads most required assets via dependencies)
    wp_enqueue_style( 'yobazar-style', get_template_directory_uri() . '/style.css' );

    // Load child theme style
    wp_enqueue_style( 'yobazar-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( 'yobazar-style' )
    );
}
add_action( 'wp_enqueue_scripts', 'yobazar_child_enqueue_styles' );
