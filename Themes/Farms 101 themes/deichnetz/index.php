<?php
get_header();
?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<?php the_date('','<h2>','</h2>'); ?>

<div class="post">
<h3 class="storytitle" id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h3>
<div class="meta"><?php _e("Filed under:"); ?> <?php the_category(',') ?> &#8212; <?php the_author() ?> @ <?php the_time() ?> <?php the_tags( '&nbsp;' . __( 'Tagged' ) . ' ', ', ', ''); ?> <?php edit_post_link(__('Edit This')); ?></div>

<div class="storycontent"><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
<?php the_content(__('(more...)')); ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
</div>

<div class="feedback">
<?php wp_link_pages(); ?>
<?php comments_popup_link(__('Comments (0)'), __('Comments (1)'), __('Comments (%)')); ?>
</div>

	<!--
	<?php trackback_rdf(); ?>
	-->

</div>

<?php comments_template(); // Get wp-comments.php template ?>

<?php endwhile; else: ?>
<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
<?php endif; ?>

<p id="pagenav"><?php posts_nav_link('          ','<img src="/blog/wp-content/themes/heinsn/pics/page_back.gif" width="9" height="9" border="0" alt="" />&nbsp;&nbsp;zurück&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;','<img src="/blog/wp-content/themes/heinsn/pics/page_vor.gif" width="9" height="9" border="0" alt="" />&nbsp;&nbsp;nächste Seite
'); ?></p>

<?php get_footer(); ?>
