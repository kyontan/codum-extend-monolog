<?php
/*
This file is part of codium_extend. Hack and customize by henri labarre and based on the marvelous sandbox theme

codium_extend is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 2 of the License, or (at your option) any later version.

*/

  if ( ! function_exists( 'codium_extend_setup' ) ) :
    function codium_extend_setup() {
      // Make theme available for translation
      // Translations can be filed in the /languages/ directory
      load_theme_textdomain( 'codium_extend', get_template_directory() . '/languages' );

      // add_editor_style support
      add_editor_style( 'editor-style.css' );

      //feed
      add_theme_support('automatic-feed-links');

      add_theme_support( 'html5', array(
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
      ) );

      register_nav_menus( array(
        'main-menu' => __( 'Main menu', 'codium_extend' ),
      ) );

        // Post thumbnails support for post
      add_theme_support( 'post-thumbnails', array( 'post' ) ); // Add it for posts
      set_post_thumbnail_size( 220, 165, true ); // Normal post thumbnails

        // This theme allows users to set a custom background
      add_theme_support( 'custom-background' );

        // This theme allows users to set a custom header image
        //custom header for 3.4 and compatability for prior version

      $args = array(
        'width'               => 980,
        'height'              => 250,
        'default-image'       => '',
        'default-text-color'  => '444',
        'wp-head-callback'    => 'codium_extend_header_style',
        'admin-head-callback' => 'codium_extend_admin_header_style',
      );

      $args = apply_filters( 'codium_extend_custom_header', $args );

      add_theme_support( 'custom-header', $args );
    }
  endif; // codium_setup
  add_action( 'after_setup_theme', 'codium_extend_setup' );

  add_theme_support( 'title-tag' );

  if ( ! function_exists( '_wp_render_title_tag' ) ) {
      function theme_slug_render_title() {
  ?>
  <title><?php wp_title( '|', true, 'right' ); ?></title>
  <?php
      }
      add_action( 'wp_head', 'theme_slug_render_title' );
  }

  if ( ! function_exists( 'codium_extend_scripts_styles' ) ) :
    function codium_extend_scripts_styles() {

      if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
        wp_enqueue_script( 'comment-reply' );

      // Loads our main stylesheet.
      wp_enqueue_style( 'codium_extend-style', get_stylesheet_uri(), array(), '2020-05-26' );
    }
  endif; // codium_scripts_styles
  add_action( 'wp_enqueue_scripts', 'codium_extend_scripts_styles' );


  if ( ! function_exists( 'codium_extend_header_style' ) ) :
  // gets included in the site header
  function codium_extend_header_style() {
    if (get_header_image() != '') { ?>
<style>
  header {
    background: url(<?php header_image(); ?>); height :230px; -moz-border-radius-topleft:6px;border-top-left-radius:6px;-moz-border-radius-topright:6px;border-top-right-radius:6px;
  }
  <?php if ( 'blank' == get_header_textcolor() ) { ?>
  h1.blogtitle,.description { display: none; }
  <?php } else { ?>
  h1.blogtitle a,.description { color:#<?php header_textcolor() ?>; }
    <?php
  } ?>
</style>
<?php }
  if ( 'blank' == get_header_textcolor() ) { ?>
<style>
  h1.blogtitle,.description,.blogtitle { display: none; }
</style>
<?php } else { ?>
<style>
  h1.blogtitle a,.blogtitle a,.description,.menu-toggle:before, .search-toggle:before, .site-navigation a { color:#<?php header_textcolor() ?>; }
  .site-navigation a:hover { background:#<?php header_textcolor() ?>; }
</style>
<?php }
  }
endif; // codium_header_style

if ( ! function_exists( 'codium_extend_admin_header_style' ) ) :
  // gets included in the admin header
  function codium_extend_admin_header_style() { ?>
<style>
  #headimg {
    width: <?php echo HEADER_IMAGE_WIDTH; ?>px;
    height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
  }
</style>
<?php
  }
  endif; // codium_admin_header_style


// Set the content width based on the theme's design and stylesheet.
  if ( ! isset( $content_width ) )
  $content_width = 620;

// Generates semantic classes for BODY and POST element
function codium_extend_category_id_class($classes) {
  global $post;
  if (!is_404() && isset($post))
  foreach((get_the_category($post->ID)) as $category)
    $classes[] = $category->category_nicename;
  return $classes;
}
add_filter('body_class', 'codium_extend_category_id_class');

function codium_extend_tag_id_class($classes) {
  global $post;
  if (!is_404() && isset($post))
  if ( $tags = get_the_tags() )
    foreach ( $tags as $tag )
      $classes[] = 'tag-' . $tag->slug;
  return $classes;
}
add_filter('body_class', 'codium_extend_tag_id_class');

function codium_extend_author_id_class($classes) {
  global $post;
  if (!is_404() && isset($post))
    $classes[] = 'author-' . sanitize_title_with_dashes(strtolower(get_the_author_meta('login')));
  return $classes;
}
add_filter('post_class', 'codium_extend_author_id_class');

// count comment
function codium_extend_comment_count( $print = true ) {
  global $comment, $post, $codium_extend_comment_alt;

  // Counts trackbacks and comments
  if ( $comment->comment_type == 'comment' ) {
    $count[] = "$codium_extend_comment_alt";
  } else {
    $count[] = "$codium_extend_comment_alt";
  }

  $count = join( ' ', $count ); // Available filter: comment_class

  // Tada again!
  echo $count;
  //return $print ? print($count) : $count;
}


// Generates time- and date-based classes for BODY, post DIVs, and comment LIs; relative to GMT (UTC)
function codium_extend_date_classes( $t, &$c, $p = '' ) {
  $t = $t + ( get_option('gmt_offset') * 3600 );
  $c[] = $p . 'y' . gmdate( 'Y', $t ); // Year
  $c[] = $p . 'm' . gmdate( 'm', $t ); // Month
  $c[] = $p . 'd' . gmdate( 'd', $t ); // Day
  $c[] = $p . 'h' . gmdate( 'H', $t ); // Hour
}


// For category lists on category archives: Returns other categories except the current one (redundant)
function codium_extend_cats_meow($glue) {
  $current_cat = single_cat_title( '', false );
  $separator = "\n";
  $cats = explode( $separator, get_the_category_list($separator) );
  foreach ( $cats as $i => $str ) {
    if ( strstr( $str, ">$current_cat<" ) ) {
      unset($cats[$i]);
      break;
    }
  }

  if ( empty($cats) )
    return false;

  return trim(join( $glue, $cats ));
}

// For tag lists on tag archives: Returns other tags except the current one (redundant)
function codium_extend_tag_ur_it($glue) {
  $current_tag = single_tag_title( '', '',  false );
  $separator = "\n";
  $tags = explode( $separator, get_the_tag_list( "", "$separator", "" ) );
  foreach ( $tags as $i => $str ) {
    if ( strstr( $str, ">$current_tag<" ) ) {
      unset($tags[$i]);
      break;
    }
  }
  if ( empty($tags) )
    return false;

  return trim(join( $glue, $tags ));
}

if ( ! function_exists( 'codium_extend_posted_on' ) ) :
// data before post
function codium_extend_posted_on() {
  printf( '<a class="permalink" href="%1$s"><span class="entry-date">',
    get_permalink()
  );

  codium_extend_print_datetime();

  printf( '</span></a>');
}
endif;

if ( ! function_exists( 'codium_extend_posted_in' ) ) :
  // data after post
  function codium_extend_posted_in() {
    codium_extend_category_list();
    codium_extend_tag_list('<br>');
  }
endif;

if ( ! function_exists( 'codium_extend_category_list' ) ) :
  function codium_extend_category_list($before = '', $after = '') {
    if ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
      printf(
        __( '%2$sCategory: %1$s%3$s', 'codium_extend' ),
        get_the_category_list( ', ' ),
        $before,
        $after
      );
    }
  }
endif;

if ( ! function_exists( 'codium_extend_tag_list' ) ) :
  function codium_extend_tag_list($before = '', $after = '') {
    // Retrieves tag list of current post, separated by commas.
    $tag_list = get_the_tag_list( '', ', ' );
    if ( $tag_list ) {
      printf(
        __( '%2$sTags: %1$s%3$s', 'codium_extend' ),
        $tag_list,
        $before,
        $after
      );
    }
  }
endif;

if ( ! function_exists( 'codium_extend_category_list_links' ) ) :
  function codium_extend_category_list_links() {
?><span class='cat-links'><?php printf(__('%s', 'codium_extend'), get_the_category_list(' ')) ?></span><?php
  }
endif;

if ( ! function_exists( 'codium_extend_tag_list_links' ) ) :
  function codium_extend_tag_list_links() {
?><span class='tag-links'><?php printf(__('%s', 'codium_extend'), get_the_tag_list('', ' ')) ?></span><?php
  }
endif;

if ( ! function_exists( 'codium_extend_permalink' ) ) :
  // data after post
  function codium_extend_permalink() {
    $posted_in = __( 'Permalink: <a href="%1$s" title="Permalink to %2$s">%1$s</a>.', 'codium_extend' );
    printf(
      $posted_in,
      get_permalink(),
      the_title_attribute( 'echo=0' )
    );
  }
endif;

if ( ! function_exists( 'codium_extend_print_datetime' ) ) :
  function codium_extend_print_datetime() {
    printf('%1$s %2$s', the_date('Y-m-d', '', '', false), get_the_time());
  }
endif;

// Widgets plugin: intializes the plugin after the widgets above have passed snuff
function codium_extend_widgets_init() {
    register_sidebar(array(
    'name' => 'SidebarTop',
    'description'   => 'Top sidebar',
    'id'            => 'sidebartop',
    'before_widget' =>   "\n    " . '<li id="%1$s" class="widget %2$s"><div class="widgetblock">',
    'after_widget'  =>   "\n    " . "</div></li>\n",
    'before_title'  =>   "\n      ". '<div class="widgettitleb"><h3 class="widgettitle">',
    'after_title'   =>   "</h3></div>\n" .''
    ));
  }

// Runs our code at the end to check that everything needed has loaded
add_action( 'widgets_init', 'codium_extend_widgets_init' );


// Adds filters for the description/meta content in archives.php
add_filter( 'archive_meta', 'wptexturize' );
add_filter( 'archive_meta', 'convert_smilies' );
add_filter( 'archive_meta', 'convert_chars' );
add_filter( 'archive_meta', 'wpautop' );

// Remember: the codium_extend is for play.

// footer link
add_action('wp_footer', 'footer_link');

function footer_link() {
  if ( is_front_page() && !is_paged()) {
    $anchorthemeowner='<a href="http://codiumextend.code-2-reduction.fr/" title="code reduction" target="blank">code reduction</a>';
    $textfooter = __('Proudly powered by <a href="http://www.wordpress.org">WordPress</a> and designed by ', 'codium_extend' );
    $content = '<div id="footerlink">' . "\n  ". '<div class="alignright"><p>' .$textfooter. $anchorthemeowner.'</p></div>' . "\n" . '</div>' . "\n";
    echo $content;
  } else {
    $textfooter = __('Proudly powered by <a href="http://www.wordpress.org">WordPress</a>', 'codium_extend' );
    $content = '<div id="footerlink">' . "\n  " . '<div class="alignright"><p>' .$textfooter.'</p></div>' . "\n" . '</div>' . "\n";
    echo $content;
  }
}

//Remove <p> in excerpt
function codium_extend_strip_para_tags ($content) {
  if ( is_home() && ($paged < 2 )) {
    $content = str_replace( '<p>', '', $content );
    $content = str_replace( '</p>', '', $content );
    return $content;
  }
}

if ( ! function_exists( 'codium_extend_comment' ) ) :
//Comment function
function codium_extend_comment($comment, $args, $depth) {
  $GLOBALS['comment'] = $comment;
  switch ( $comment->comment_type ) :
    case '' : ?>
  <li id="comment-<?php comment_ID() ?>" <?php comment_class(); ?>>
    <div class="comment-author vcard">
      <?php echo get_avatar( $comment, 48 ); ?>
      <?php printf(__('<div class="fn">%s</div> ', 'codium_extend'), get_comment_author_link()) ?>
    </div>

    <?php if ($comment->comment_approved == '0') : ?>
       <em><?php _e('Your comment is in moderation.', 'codium_extend') ?></em>
       <br>
    <?php endif; ?>

    <div class="comment-meta"><?php printf(__('%1$s - %2$s <span class="meta-sep">|</span> <a href="%3$s" title="Permalink to this comment">Permalink</a>', 'codium_extend'),
        aget_comment_date(), get_comment_time(), '#comment-' . get_comment_ID() );
        edit_comment_link(__('Edit', 'codium_extend'), ' <span class="meta-sep">|</span> <span class="edit-link">', '</span>'); ?></div>
    <div class="clear"></div>

    <div class="comment-body"><?php comment_text(); ?></div>
    <div class="reply">
       <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
    </div>
    <?php
    break;
  case 'pingback'  :
  case 'trackback' :
?>
<li class="post pingback">
  <p><?php _e( 'Pingback:', 'codium_extend' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'codium_extend' ), ' ' ); ?></p>
<?php
    break;
endswitch;
}
endif;

//font for the title and code blocks
function codium_extend__google_font() { ?>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300&family=Source+Code+Pro&display=swap" rel="stylesheet">
<?php
}

add_action('wp_head', 'codium_extend__google_font');
?>

<?php

add_filter( 'scriptlesssocialsharing_locations', 'prefix_change_sss_locations' );
function prefix_change_sss_locations( $locations ) {
  // scriptlesssocialsharing sets priority to 99
  // to make scriptlesssocialsharing to locate above ads, lowering priority
  $locations['after']['priority'] = 5;

  return $locations;
}

?>
