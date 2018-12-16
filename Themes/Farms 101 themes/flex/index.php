<?php 
get_header();
?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<div class="entry">
			<!--
				<h2 class="entrydate"><?php the_date() ?></h2>
			-->
			<h3 class="entrytitle" id="post-<?php the_ID(); ?>">
				<a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a>
			</h3>
			<div class="entrybody">
				<div class="entrymeta">
					<?php _e('Posted by');?> <?php the_author() ?> <?php _e('on');?> <?php the_time('F dS Y') ?> <?php _e('to');?>  <?php the_category(',') ?> <?php the_tags( '&nbsp;' . __( 'Tagged' ) . ' ', ', ', ''); ?>
				</div><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
				<?php the_content(__('(more...)')); ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
				<p class="comments_link">
					<?php 
						$comments_img_link = '<img src="' . get_stylesheet_directory_uri() . '/images/comments.gif"  title="comments" alt="*" />';
						comments_popup_link('No Comments', $comments_img_link . ' 1 Comment', $comments_img_link . ' % Comments'); 
					?>
				</p>
			</div>
	<!--
	<?php trackback_rdf(); ?>
	-->
</div>

<?php comments_template(); // Get wp-comments.php template ?>

<?php endwhile; else: ?>
<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
<?php endif; ?>

<?php posts_nav_link(' &#8212; ', __('&laquo; Previous Page'), __('Next Page &raquo;')); ?>
</div>
</div><!-- The main content column ends  -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>
