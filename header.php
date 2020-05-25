<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes() ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="content-type" content="<?php bloginfo('html_type') ?>; charset=<?php bloginfo('charset') ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="pingback" href="<?php bloginfo('pingback_url') ?>" />
<?php wp_head() ?>
</head>

<body <?php body_class(); ?>>

<div id="wrapperpub" class="container">
  <div id="header">
    <div class="sixteen columns">
      <h1 id="blog-title" class="blogtitle"><a href="<?php echo esc_url(home_url( '/' )); ?>" title="<?php bloginfo('name') ?>"><?php bloginfo('name') ?></a></h1>
      <div class="description"><?php bloginfo('description'); ?> </div>
    </div><!-- sixteen columns -->
  </div><!--  #header -->
</div><!--  #wrapperpub -->
<div class="clear"></div>
<div id="wrapper" class="container">
    <div id="access" class="sixteen columns">
      <?php wp_nav_menu(array( 'container_class' => 'menu-header', 'theme_location' => 'main-menu',)); ?>
    </div><!--  #access -->
<div class="clear"></div>
