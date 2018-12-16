<?php get_header(); ?>

	<div id="content_box">
	
		<div id="content">

		<?php if (have_posts()) : ?>
			
			<?php while (have_posts()) : the_post(); ?>
			
			<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
			<p class="post_date"><?php the_time(__('F jS, Y')) ?> &#8212; <?php the_category(', ') ?> <?php the_tags( '&nbsp;' . __( 'Tagged' ) . ' ', ', ', ''); ?></p>
			<div class="entry"><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
				<?php the_content(__("Continue reading &rarr;")); ?>
			</div>
			<p class="post_meta"><span class="add_comment"><?php comments_popup_link(__('No Comments'), __('1 Comment'), __('% Comments')); ?></span></p>
			
			<?php endwhile; ?>
			
			<?php include (TEMPLATEPATH . '/navigation.php'); ?>
			
		<?php else : ?>
	
			<h2>Please add a post to this blog to remove this message</h2>
			<p class="post_date">* * *</p>
			<div class="entry">
				<p><?php _e("Sorry, but you are looking for something that isn't here.");?></p>
				<?php include (TEMPLATEPATH . "/searchform.php"); ?>
			</div>
	
		<?php endif; ?>
		
		</div>

		<?php get_sidebar(); ?>
	
	</div>

<?php get_footer(); ?>