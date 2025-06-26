<?php function your_theme_enqueue_scripts() {
    // Load jQuery (WordPress built-in)
    wp_enqueue_script('jquery');


    // Bootstrap CSS from CDN
    wp_enqueue_style( 'bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css', array(), '4.6.0' );


    // Your theme's main stylesheet
    wp_enqueue_style( 'theme-style', get_stylesheet_uri(), array('bootstrap'), '1.0' );


    // Bootstrap JS bundle (with Popper) from CDN
    wp_enqueue_script( 'bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js', array('jquery'), '4.6.0', true );


    // Your theme's custom JS (optional)
    // wp_enqueue_script( 'theme-script', get_template_directory_uri() . '/js/scripts.js', array('jquery', 'bootstrap'), '1.0', true );
}
add_action( 'wp_enqueue_scripts', 'your_theme_enqueue_scripts' );


?>
