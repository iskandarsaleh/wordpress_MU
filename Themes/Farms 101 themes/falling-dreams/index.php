<?php 
get_header();
?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<div class="post"> 
  <div class="data">
    <?php the_time(__('F jS, Y')) ?>
  </div>
  <h3 class="storytitle" id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>">
    <?php the_title(); ?>
    </a></h3>
  <div class="autor"><?php _e('Posted by');?> <?php the_author() ?> <?php _e('in');?> <?php the_category(', ') ?> <?php the_tags( '&nbsp;' . __( 'Tagged' ) . ' ', ', ', ''); ?>
    <?php edit_post_link(__('Edit'), '|',''); ?>
  </div>
  <div class="storycontent"> <?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
    <?php the_content(__('(more...)')); ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
  </div>
  <div class="feedback"> 
    <?php wp_link_pages(); ?>
    <?php comments_popup_link(__('0 Comments'), __('1 Comments'), __('% Comments')); ?>
  </div>
  <!--
	<?php trackback_rdf(); ?>
	-->
</div>
<?php comments_template(); // Get wp-comments.php template ?>
<?php endwhile; else: ?>
<p>
  <?php _e('Sorry, no posts matched your criteria.'); ?>
</p>
<?php endif; ?>
<?php posts_nav_link(' &#8212; ', __('&laquo; Previous Page'), __('Next Page &raquo;')); ?>
<?php get_footer(); ?>
