<?php get_header(); ?>
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336x280-solipsus-top"); } ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		
		<div class="post">
	
			<h2 class="posttitle" id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent link to'); ?> <?php the_title(); ?>"><?php the_title(); ?></a></h2>
			
			<p class="postmeta"> 
			{ <?php the_time(get_option('date_format')) ?> @ <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent link to'); ?> <?php the_title(); ?>"><?php the_time() ?></a> }
			&#183; 
			{ <?php the_category(', ') ?> }
			<br />
			{ <?php the_tags(__('Tags: '), ', ', ''); ?> }
			</p>
			
			<div class="postentry">
			
<?php the_content("<p>__('Read the rest of this entry &raquo;')</p>"); ?>

			<?php wp_link_pages(); ?>
			</div>
			
			<p class="postfeedback">
			<?php edit_post_link(__('Edit'), '&nbsp; {', '}'); ?>
			</p>
			
		</div>
		
		<?php comments_template(); ?>
				
	<?php endwhile; else : ?>

		<h2><?php _e('Not Found'); ?></h2>

		<p><?php _e('Sorry, but the page you requested cannot be found.'); ?></p>
		
		<h3><?php _e('Search'); ?></h3>
		
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>

	<?php endif; ?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>


