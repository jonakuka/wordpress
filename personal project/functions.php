<?php
// Theme setup
function artgallery_theme_setup() {
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'artgallery_theme_setup');

// Register custom post type for artworks
function artgallery_register_artwork_cpt() {
    $labels = array(
        'name' => 'Artworks',
        'singular_name' => 'Artwork',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Artwork',
        'edit_item' => 'Edit Artwork',
        'new_item' => 'New Artwork',
        'view_item' => 'View Artwork',
        'search_items' => 'Search Artworks',
        'not_found' => 'No artworks found',
        'not_found_in_trash' => 'No artworks found in Trash',
        'menu_name' => 'Artworks',
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'menu_icon' => 'dashicons-art',
    );
    register_post_type('artwork', $args);
}
add_action('init', 'artgallery_register_artwork_cpt');

// Enqueue styles
function artgallery_enqueue_styles() {
    wp_enqueue_style('artgallery-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'artgallery_enqueue_styles');
