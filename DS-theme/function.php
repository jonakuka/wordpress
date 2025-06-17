<?php 
function ds_enqueue_script()  {
    wp_enqueue_stle('main-style', get_stylesheet_uri());

}
add_action( 'wp_enqueu_scripts'.'ds_enqueue_scripts' );

?>