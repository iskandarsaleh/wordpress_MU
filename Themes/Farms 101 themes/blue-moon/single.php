<?php
get_header();
?>
<div id="content">
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
  <div class="entry">
    <h3 class="entrytitle" id="post-<?php the_ID(); ?>"> <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>">
      <?php the_title(); ?>
      </a> </h3>
    <div class="entrymeta">
   Posted <?php 
			the_time('F j, Y ');
			$comments_img_link= '<img src="' . get_stylesheet_directory_uri() . '/images/comments.gif"  title="'.__('comments').'" alt="*" /><strong>';
			comments_popup_link($comments_img_link .__(' Comments(0)'), $comments_img_link .__(' Comments(1)'), $comments_img_link .__(' Comments(%)')); 
			edit_post_link(__(' Edit'));?> | <?php the_tags( '&nbsp;' . __( 'Tagged' ) . ' ', ', ', ''); ?>
      </strong> </div>
    <div class="entrybody"><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280graphite"); } ?>
      <?php the_content(__('Read more &raquo;'));?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280graphite"); } ?>
    </div>

	<?php trackback_rdf(); ?>

  </div>
  <?php comments_template(); // Get wp-comments.php template ?>
  <?php endwhile; else: ?>
  <p>
    <?php _e('Sorry, no posts matched your criteria.'); ?>
  </p>
  <?php endif; ?>
  <p>
    <?php posts_nav_link(' &#8212; ', __('&laquo; Previous Page'), __('Next Page &raquo;')); ?>
  </p>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
