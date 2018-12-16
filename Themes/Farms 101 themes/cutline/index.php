<?php get_header(); ?>

	<div id="content_box">

		<div id="content" class="posts">

	<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("cutline-top"); } ?>
		
		
		<?php if (have_posts()) : ?>
			
			<?php while (have_posts()) : the_post(); ?>
					
			<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>"><?php the_title(); ?></a></h2>
			<h4><?php the_time(get_option('date_format')) ?><!-- by <?php the_author() ?> --> &middot; <?php comments_popup_link(__('No Comments'), __('1 Comment'), __('% Comments')); ?></h4>
			<div class="entry">
			
				<?php the_content('Keep reading &rarr;'); ?>
			</div>	
			<p class="tagged"><span class="add_comment"><?php comments_popup_link(__('&rarr; No Comments'), __('&rarr; 1 Comment'), __('&rarr; % Comments')); ?></span><strong>Categories:</strong> <?php the_category(' &middot; ') ?>
			<?php the_tags( '<br /><strong>' . __( 'Tagged' ) . ':</strong> ', ', ', ''); ?></p>
		
			<?php endwhile; ?>
			
			<?php include (TEMPLATEPATH . '/navigation.php'); ?>
			
		<?php else : ?>
	
			<h2 class="page_header center"><?php _e('Not Found');?></h2>
			<div class="entry">
				<p class="center"><?php _e("Sorry, but you are looking for something that isn't here.");?></p>
				<?php include (TEMPLATEPATH . "/searchform.php"); ?>
			</div>
	
		<?php endif; ?>
		

		</div>

		<?php get_sidebar(); ?>
	
	</div>

<?php get_footer(); ?>
