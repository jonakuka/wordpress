<?php 
function ds_enqueue_script()  {
    wp_enqueue_stle('main-style', get_stylesheet_uri());

}



function ds_setup(){
    add_theme_support('menus');
    register_nav_menu('primary','Primary Navigation');
}
add_action('init','ds_setup');
?>