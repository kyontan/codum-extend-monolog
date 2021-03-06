<?php get_header() ?>

<main>
    
<?php the_post() ?>

  <h2 class="page-title"><a href="<?php echo get_permalink($post->post_parent) ?>" rev="attachment"><?php printf(__('Attachment : ', 'codium_extend' )) ?><?php echo get_the_title($post->post_parent) ?></a></h2>
  <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <h3 class="entry-title"><?php the_title() ?></h3>
    <div class="entry-content">
      <p style="text-align: center;"><a href="<?php echo wp_get_attachment_url($post->ID); ?>"><?php echo wp_get_attachment_image( $post->ID, 'medium' ); ?></a></p>
<?php the_content(''.__('Read More <span class="meta-nav">&raquo;</span>', 'codium_extend').''); ?>

<?php wp_link_pages("          <div class='page-link'>".__('Pages: ', 'codium_extend'), "</div>\n", 'number'); ?>
<?php printf(__('Back to post : ', 'codium_extend')) ?><a href="<?php echo get_permalink($post->post_parent) ?>" rev="attachment"><?php echo get_the_title($post->post_parent) ?></a> 
    </div>
    <span>
    <?php previous_image_link('thumbnail') ?>
    </span>
    <span>
    <?php next_image_link('thumbnail') ?>
    </span>
    <div class="clear"></div>

    <div class="entry-meta">
      <?php codium_extend_posted_on(); ?>
      <?php codium_extend_posted_in(); ?> 
      <?php edit_post_link(__('Edit', 'codium_extend'), "\n          <span class=\"edit-link\">", "</span>"); ?>
    </div>
  </article>

<?php comments_template(); ?>

</main>

<?php get_sidebar() ?>
<?php get_footer() ?>
