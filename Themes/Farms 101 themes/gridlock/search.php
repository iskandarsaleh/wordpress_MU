<?php
/*
Template Name: Search Results
*/
?>

<?php get_header(); ?>

<div id="main_content">

	<?php if (have_posts()) : ?>

	<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. From Kubrick. ?>
	
		<h3 class="subhead"><?php _e('Search Results');?></h3>
	
	<h4 class="comment"><?php next_posts_link(__('next page')); ?> &middot; 
		<?php previous_posts_link(__('previous page'));  ?></h4>
	
	<?php include (TEMPLATEPATH . '/searchform.php'); ?>
	
	
	 <?php while (have_posts()) : the_post(); ?>
	<div class="excerpt">
		<h3 class="substory_subhead"><?php the_time('F j Y'); ?></h3>
		<h3 class="substory_head"><a href="<?php the_permalink(); ?>" rel="bookmark">
		<?php the_title(); ?>
		</a></h2>
		
		<?php the_excerpt(); ?>
		
		<h4 class="comment"><a href="<?php the_permalink(); ?>" rel="bookmark">
		<strong><?php _e('continue reading.');?>..</strong></a> &raquo; 
		<?php comments_popup_link(__('0 Comments'), __('One Comment'), __('% Comments'), '', __('Comments Locked')); ?>
		</h4>
	
	</div>
	<?php endwhile; ?>
	
	<h4 class="comment"><?php next_posts_link(__('next page')); ?> &middot; 
		<?php previous_posts_link(__('previous page')); ?></h4>
		
	<?php else: ?>
	
	<p><em><?php _e("No entries were found with this query. If you think you've reached this 
	in error");?>, <a href="mailto:<?php bloginfo('admin_email'); ?>"><?php _e("e-mail the administrator(s)");?></a><?php _e("of this site.");?>.</em></p>
	
	<?php endif; ?>
	
</div>
		

<?php get_sidebar(); ?>

<?php get_footer(); ?>