<?php
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php bloginfo('name'); ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header>
    <h1><a href="<?php echo home_url(); ?>" style="color:#fff;text-decoration:none;">Art Gallery</a></h1>
    <nav>
        <?php wp_nav_menu(['theme_location' => 'main-menu', 'fallback_cb' => false]); ?>
    </nav>
</header>
