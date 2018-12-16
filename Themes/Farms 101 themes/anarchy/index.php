<?php 
/* Don't remove this line. */
require('./wp-blog-header.php');
include(get_template_directory() . '/header.php');
?>

<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336x280-anarchy-top"); } ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<?php the_date('','<h2 class="the-date">','</h2>'); ?>
	
<div class="post">

	 <h3 class="storytitle" id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link:');?> <?php the_title(); ?>"><?php the_title(); ?></a></h3>
	<div class="meta"><?php _e("Filed under:"); ?> <?php the_category(',') ?> &#8212;<?php the_tags( '' . __( 'Tagged' ) . ' ', ', ', ''); ?>&#8212; <?php the_author() ?> @ <?php the_time() ?> <?php edit_post_link(__('Edit This')); ?></div>
	
	<div class="storycontent">
	
		<?php the_content(); ?>
	
	</div>
	
	<div class="feedback">
            <?php wp_link_pages(); ?>
            <?php comments_popup_link(__('Comments (0)'), __('Comments (1)'), __('Comments (%)')); ?>
	</div>
	
	<!--
	<?php trackback_rdf(); ?>
	-->
</div>
<?php comments_template(); ?>

<?php endwhile; else: ?>
<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
<?php endif; ?>




<?php include(get_template_directory() . '/footer.php'); ?>