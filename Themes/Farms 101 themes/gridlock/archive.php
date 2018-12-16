<?php
/*
Template Name: Archives
*/
?>

<?php get_header(); ?>

<div id="main_content">

<?php is_tag(); ?>
	<?php if (have_posts()) : ?>

	<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. From Kubrick. ?>
	
	<?php /* If this is a category archive */ if (is_category()) { ?>
		<h3 class="subhead"><?php bloginfo('name'); ?> <?php _e('Archives');?>: <?php single_cat_title(); ?></h3>

	<?php /* If this is a tag archive */ } elseif (is_tag()) { ?>
		<h3 class="subhead"><?php bloginfo('name'); ?> <?php _e('Archives');?>: <?php single_tag_title(); ?></h3>

	<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
		<h3 class="subhead"><?php bloginfo('name'); ?> <?php _e('Archives');?>: <?php the_time('F Y'); ?></h2>
	
	<?php /* If this is a search */ } elseif (is_search()) { ?>
		<h3 class="subhead"><?php _e('Search Results for ');?> <?php echo($_GET['s']); ?></h3>
	
	<?php } // end dynamic header ?>
	
	<h4 class="comment"><?php next_posts_link(__('next page')); ?>  &middot;
		<?php previous_posts_link(__('previous page')); ?></h4>
	
	<?php include (TEMPLATEPATH . '/searchform.php'); ?>
	
	
	 <?php while (have_posts()) : the_post(); ?>
	<div class="excerpt">
		<h3 class="substory_subhead"><?php the_time('j F Y'); ?></h3>
		<h3 class="substory_head"><a href="<?php the_permalink(); ?>" rel="bookmark">
		<?php the_title(); ?>
		</a></h3>
		<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
		<?php the_excerpt(); ?>
		<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
		<h4 class="comment"><a href="<?php the_permalink(); ?>" rel="bookmark">
		<strong><?php _e('continue reading.');?>...</strong></a> &raquo; 
		<?php comments_popup_link(__('0 Comments'), __('One Comment'), __('% Comments'), '', __('Comments Locked')); ?>
		</h4>
	
	</div>
	<?php endwhile; ?>
	
	<h4 class="comment"><?php next_posts_link(__('next page')); ?>  &middot;
		<?php previous_posts_link(__('previous page'));  ?></h4>
		
	<?php else: ?>
	
	<p><em><?php _e("No posts were found with this query. If you think you've reached this 
	in error");?>, <a href="mailto:<?php bloginfo('admin_email'); ?>"><?php _e("e-mail the administrator(s)");?></a> <?php _e('of this site');?>.</em></p>
	
	<?php endif; ?>
	
</div>
		

<?php get_sidebar(); ?>

<?php get_footer(); ?>
