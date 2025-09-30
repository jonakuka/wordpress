<?php
/**
 * DS Theme complete with Bootstrap via CDN
 */

// Enqueue styles & scripts (Bootstrap 5 CDN + theme CSS)
function ds_enqueue_assets() {
  // Bootstrap CSS
  wp_enqueue_style( 'bootstrap-cdn', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' );

  // Main stylesheet
  wp_enqueue_style( 'style', get_stylesheet_uri(), array(), '1.2', 'all' );

  // Bootstrap JS (bundle includes Popper) in footer
  wp_enqueue_script( 'bootstrap-cdn', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js', array(), null, true );


  if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
    wp_enqueue_script( 'comment-reply' );
  }
}
add_action( 'wp_enqueue_scripts', 'ds_enqueue_assets' );

function ds_setup() {
  add_theme_support( 'menus' );
  register_nav_menu( 'primary', 'Primary Navigation' );
  register_nav_menu( 'footer', 'Footer Navigation' );

  add_theme_support( 'title-tag' );
  add_theme_support( 'post-thumbnails' );
  add_theme_support( 'post-formats', array( 'aside', 'image', 'video' ) );
}
add_action( 'init', 'ds_setup' );

function ds_widgets_init() {
  register_sidebar( array(
    'name'          => __( 'Primary Sidebar', 'dstheme' ),
    'id'            => 'primary',
    'description'   => __( 'Main sidebar that appears on the right.', 'dstheme' ),
    'class'         => 'sidebar-primary',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget'  => '</aside>',
    'before_title'  => '<h3 class="widget-title">',
    'after_title'   => '</h3>',
  ) );

  register_sidebar( array(
    'name'          => __( 'Secondary Sidebar', 'dstheme' ),
    'id'            => 'secondary',
    'description'   => __( 'Optional secondary sidebar (e.g., footer or left side).', 'dstheme' ),
    'class'         => 'sidebar-secondary',
    'before_widget' => '<ul><li id="%1$s" class="widget %2$s">',
    'after_widget'  => '</li></ul>',
    'before_title'  => '<h3 class="widget-title">',
    'after_title'   => '</h3>',
  ) );
}
add_action( 'widgets_init', 'ds_widgets_init' );


class DS_Simple_Text_Widget extends WP_Widget {

  public function __construct() {
    parent::__construct(
      'ds_simple_text', // Base ID
      __( 'DS Simple Text', 'dstheme' ), // Name
      array( 'description' => __( 'A simple text widget for DS Theme.', 'dstheme' ) )
    );
  }

  public function widget( $args, $instance ) {
    echo $args['before_widget'];
    $title = ! empty( $instance['title'] ) ? $instance['title'] : '';
    $text  = ! empty( $instance['text'] ) ? $instance['text'] : '';
    if ( ! empty( $title ) ) {
      $title = apply_filters( 'widget_title', $title );
      echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
    }
    if ( ! empty( $text ) ) {
      echo '<div class="textwidget">' . wp_kses_post( $text ) . '</div>';
    }
    echo $args['after_widget'];
  }

  public function form( $instance ) {
    $title = ! empty( $instance['title'] ) ? $instance['title'] : '';
    $text  = ! empty( $instance['text'] ) ? $instance['text'] : '';
    ?>
    <p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'dstheme' ); ?></label>
      <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
             name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text"
             value="<?php echo esc_attr( $title ); ?>">
    </p>
    <p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"><?php _e( 'Text:', 'dstheme' ); ?></label>
      <textarea class="widefat" rows="5" id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"
                name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>"><?php echo esc_textarea( $text ); ?></textarea>
    </p>
    <?php
  }

  public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = (! empty( $new_instance['title'] )) ? sanitize_text_field( $new_instance['title'] ) : '';
    $instance['text']  = (! empty( $new_instance['text'] )) ? wp_kses_post( $new_instance['text'] ) : '';
    return $instance;
  }
}

add_action( 'widgets_init', function() {
  register_widget( 'DS_Simple_Text_Widget' );
} );

function mytheme_pagination( $query = null, $args = array() ) {

    if ( $query instanceof WP_Query ) {
        $q = $query;
    } else {
        global $wp_query;
        $q = $wp_query;
    }

    if ( empty( $q->max_num_pages ) || $q->max_num_pages < 2 ) {
        return;
    }

    $big     = 999999999;
    $current = max( 1, get_query_var( 'paged' ) ? get_query_var( 'paged' ) : get_query_var( 'page' ) );

    $defaults = array(
        'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
        'format'    => '?paged=%#%',
        'current'   => $current,
        'total'     => (int) $q->max_num_pages,
        'mid_size'  => 2,
        'end_size'  => 1,
        'prev_text' => __('« Previous', 'yourtheme'),
        'next_text' => __('Next »', 'yourtheme'),
        'type'      => 'array', 
    );

    $settings = wp_parse_args( $args, $defaults );
    $links    = paginate_links( $settings );

    if ( empty( $links ) ) {
        return;
    }

    echo '<nav class="pagination" role="navigation" aria-label="' . esc_attr__( 'Posts Pagination', 'yourtheme' ) . '">';
    echo '<span class="screen-reader-text">' . esc_html__( 'Navigimi i faqeve', 'yourtheme' ) . '</span>';
    echo '<ul class="pagination__list">';

    foreach ( $links as $link ) {
        $active = strpos( $link, 'current' ) !== false ? ' is-active' : '';
        echo '<li class="pagination__item' . $active . '">' . $link . '</li>';
    }

    echo '</ul>';
    echo '</nav>';
}

function create_posttype() {
  register_post_type(
    'movies',
    array(
      'labels' => array(
        'name' => __('Movies'),
        'singular_name' => __('Movie'),
        'add_new' => __('Add New Movie'),
        'add_new_item' => __('Add New Movie'),
        'edit_item' => __('Edit Movie'),
        'new_item' => __('New Movie'),
        'view_item' => __('View Movie'),
        'search_items' => __('Search Movies'),
        'not_found' => __('No movies found'),
        'not_found_in_trash' => __('No movies found in Trash'),
      ),
      'public' => true,
      'has_archive' => true,
      'supports' => array('title', 'editor', 'thumbnail'),
      'show_in_rest' => true,
    )
  );
}
add_action('init', 'create_posttype');

function register_taxonomy_movie_genres() {
  $labels = [
    'name' => _x('Movie Genres', 'taxonomy general name'),
    'singular_name' => _x('Movie Genre', 'taxonomy singular name'),
    'search_items' => __('Search Movie Genres'),
    'parent_item' => __('Parent Movie Genre'),
    'edit_item' => __('Edit Movie Genre'),
    'update_item' => __('Update Movie Genre'),
    'add_new_item' => __('Add New Movie Genre'),
    'new_item_name' => __('New Movie Genre'),
    'menu_name' => __('Movie Genre'),
  ];

  $args = [
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => ['slug' => 'movie_genre'],
  ];

  register_taxonomy('movie_genre', ['movies'], $args);
}
add_action('init', 'register_taxonomy_movie_genres');

function movies_add_meta_box() {
  add_meta_box(
    'movies_details',
    __('Movie Details', 'dstheme'),
    'movies_meta_box_callback',
    'movies',
    'normal',
    'high'
  );
}
add_action('add_meta_boxes', 'movies_add_meta_box');

function movies_meta_box_callback($post) {
  $genre = get_post_meta($post->ID, '_movie_genre', true);
  $year = get_post_meta($post->ID, '_movie_year', true);
  ?>
  <p>
    <label for="movie_genre"><?php _e('Genre:', 'dstheme'); ?></label>
    <input type="text" name="movie_genre" id="movie_genre" value="<?php echo esc_attr($genre); ?>" />
  </p>
  <p>
    <label for="movie_year"><?php _e('Year:', 'dstheme'); ?></label>
    <input type="number" name="movie_year" id="movie_year" value="<?php echo esc_attr($year); ?>" />
  </p>
  <?php
}

function movies_save_meta_box($post_id) {
  if (array_key_exists('movie_genre', $_POST)) {
    update_post_meta($post_id, '_movie_genre', sanitize_text_field($_POST['movie_genre']));
  }
  if (array_key_exists('movie_year', $_POST)) {
    update_post_meta($post_id, '_movie_year', intval($_POST['movie_year']));
  }
}
add_action('save_post', 'movies_save_meta_box');