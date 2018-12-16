<?php get_header(); ?>

	<div id="content_box">
	
		<div id="content" class="posts">
			<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("cutline-top"); } ?>	
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			
			<?php include (TEMPLATEPATH . '/navigation.php'); ?>
			
			<h2><?php the_title(); ?></h2>
			<h4><?php the_time(get_option('date_format')); ?><!-- by <?php the_author() ?> --> &middot; <a href="<?php the_permalink() ?>#comments"><?php comments_number(__('No Comments'), __('1 Comment'), __('% Comments')); ?></a></h4>
			<div class="entry">
			
				<?php the_content(__('<p>Read the rest of this entry &raquo;</p>')); ?>
				<?php link_pages('<p><strong>'.__('Pages:').'</strong> ', '</p>', 'number'); ?>
			</div>
			<p class="tagged"><strong><?php _e('Categories:');?></strong> <?php the_category(' &middot; ') ?> <?php the_tags( '<br /><strong>' . __( 'Tagged' ) . ':</strong> ', ', ', ''); ?></p>
			
			<?php comments_template(); ?>
	
		<?php endwhile; else: ?>
		
			<h2 class="page_header"><?php _e('Uh oh.')?></h2>
			<div class="entry">
				<p><?php _e('Sorry, no posts matched your criteria. Wanna search instead?');?></p>
				<?php include (TEMPLATEPATH . '/searchform.php'); ?>
			</div>
			
		<?php endif; ?>
		
		</div>
		
		<?php get_sidebar(); ?>
			
	</div>

<?php get_footer(); ?>
