<?php get_header(); ?>
<div id="left">
<div id="content" class="widecolumn">
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336x280-anubis-top"); } ?>
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
  <div class="navigation">
    <div class="alignleft">
      <?php previous_post_link('&larr; %link') ?>
    </div>
    <div class="alignright">
      <?php next_post_link('%link &rarr;') ?>
    </div>
  </div>
  <br class="clear" />
  <div class="post" id="post-<?php the_ID(); ?>">
    <h2><a href="<?php echo get_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link:');?> <?php the_title(); ?>">
      <?php the_title(); ?>
      </a></h2>
      <div class="entry">
      <?php the_content(__('<p class="serif">Read the rest of this entry &raquo;</p>')); ?>
      <?php wp_link_pages(array('before' => '<p><strong>'.__('Pages:').'</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
    </div>
  <p class="postmetadata"><span class="timr">
      <?php the_time(__('F jS, Y')) ?>
      </span>
      <!-- by <?php the_author() ?> -->
	  in
      <span class="catr">
      <?php the_category(', ') ?>&nbsp;&nbsp;<?php the_tags( '' . __( 'Tagged' ) . ' ', ', ', ''); ?>
      </span> |
      <?php edit_post_link(__('Edit'), '<span class="editr">', ' | </span>'); ?>
      </p>
  </div>
  <?php comments_template(); ?>
  <?php endwhile; else: ?>
  <p><?php _e('Sorry, no posts matched your criteria.');?></p>
  <?php endif; ?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
