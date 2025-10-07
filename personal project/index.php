<?php get_header(); ?>
<main>
    <h1>Welcome to the Art Gallery</h1>
    <div class="gallery">
        <?php
        $args = array(
            'post_type' => 'artwork',
            'posts_per_page' => 12
        );
        $artworks = new WP_Query($args);
        if ($artworks->have_posts()) :
            while ($artworks->have_posts()) : $artworks->the_post(); ?>
                <div class="artwork">
                    <?php if (has_post_thumbnail()) {
                        the_post_thumbnail('medium');
                    } ?>
                    <h2><?php the_title(); ?></h2>
                    <div><?php the_excerpt(); ?></div>
                </div>
            <?php endwhile;
            wp_reset_postdata();
        else : ?>
            <p>No artworks found.</p>
        <?php endif; ?>
    </div>
</main>
<?php get_footer(); ?>
