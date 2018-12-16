<?php get_header(); ?>

		<div id="content_wrapper">
			<div id="content">
			
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				
				<h1 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>"><?php the_title(); ?></a></h1>
				<p class="author">Posted on <em><?php the_time(get_option('date_format')) ?><?php the_tags( ' &#183;' . __( 'Tagged' ) . ' ', ', ', ''); ?></em>.</p>
				
			<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>	<?php the_content(); ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
				
				<?php if ('open' == $post->comment_status) : ?> 
				
				<? endif;?>
								
				<?php endwhile; ?>
				
				
				<?php else : ?>

				<h2><?php _e('Not Found');?></h2>
				<p><?php _e("Sorry, but you are looking for something that isn't here.");?></p>
				<?php include (TEMPLATEPATH . "/searchform.php"); ?>
			
				<?php endif; ?>
				
				<!-- Story ends here -->
				
				<?php comments_template(); ?>

			</div>
		</div>
			
	
	<?php include("sidebar.php") ?>

<?php get_footer(); ?>
