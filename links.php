<?php
/*
Template Name: Links Page
*/
?>
<?php get_header() ?>

<main>

<?php the_post() ?>
  <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <h2 class="entry-title"><?php the_title() ?></h2>
    <div class="entry-content">
<?php the_content() ?>

      <ul id="links-page" class="xoxo">
<?php wp_list_bookmarks('title_before=<h3>&title_after=</h3>') ?>
      </ul>
<?php edit_post_link(__('Edit', 'codium_extend'),'<span class="edit-link">','</span>') ?>

    </div>
  </article>

<?php comments_template(); ?>

</main>

<?php get_sidebar() ?>
<?php get_footer() ?>
