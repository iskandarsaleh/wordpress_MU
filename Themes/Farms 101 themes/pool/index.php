<?php get_header(); ?>
			
	<div id="bloque">
		
		<div id="noticias">
		
<?php is_tag(); ?>
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		
			<div class="entrada">
				<h2 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>"><?php the_title(); ?></a></h2>
				<small><?php the_time(get_option('date_format')); ?> <?php _e('at');?> <? the_time(); ?> | <?php _e('In');?> <?php the_category(', ') ?> | <?php comments_popup_link(__('No Comments'), __('1 Comment'), __('% Comments')); ?> <?php edit_post_link(__('Edit this post'), ' | ', ''); ?><br /><?php the_tags(__('Tags: '), ', ', '<br />'); ?></small>
						
	<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>		<?php the_content(__("Continue reading ").the_title('', '', false)."..."); ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
							
				<div class="feedback"><?php link_pages(__('<p><strong>Pages:</strong> '), '</p>', 'number'); ?></div>

			</div>
				
		<?php comments_template(); // Get wp-comments.php template ?>
			
		<?php endwhile; else: ?>
		<h2 class="center"><?php _e('Not Found');?></h2>
		<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
		<?php endif; ?>

		<?php posts_nav_link(' &#8212; ', __('&laquo; Previous Page'), __('Next Page &raquo;')); ?>
		</div>

<?php get_footer(); ?>
