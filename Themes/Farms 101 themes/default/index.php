<?php get_header(); ?>

	<div id="content_box">
	
		<?php include (TEMPLATEPATH . '/l_sidebar.php'); ?>

		

		<div id="content" class="posts">
	
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336x280-default-top"); } ?>
		<?php if (have_posts()) : ?>
			
			<?php while (have_posts()) : the_post(); ?>
					
			<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>"><?php the_title(); ?></a></h2>
			<h4><?php the_time(__('F jS, Y')) ?> <?php _e('by');?> <?php the_author() ?> <?php _e('in');?> <?php the_category(' &middot; ') ?> &middot; <a href="<?php the_permalink() ?>#comments"><?php comments_number(__('No Comments'), __('1 Comment'), __('% Comments')); ?></a> </h4>
			<div class="entry">
			
				<?php the_content(__('[Read more &rarr;]')); ?>
				
			</div>	
			<p class="tagged"><span class="add_comment"><?php comments_popup_link(__('&rarr; No Comments'), __('&rarr; 1 Comment'), __('&rarr; % Comments')); ?></span><strong><?php the_tags( '&nbsp;' . __( 'Tagged:' ) . ' ', ', ', ''); ?></strong> </p>
			<div class="clear"></div>
			
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
	
		<?php include (TEMPLATEPATH . '/r_sidebar.php'); ?>
	
	</div>

<?php get_footer(); ?>