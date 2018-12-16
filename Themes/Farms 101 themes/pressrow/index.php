<?php get_header(); ?>

		<div id="content_box">
		
			<div id="content">
		<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("250x250-pressrow-top"); } ?>

			
				<?php if (have_posts()) : ?>
					
					<?php while (have_posts()) : the_post(); ?>
							
						<div class="post" id="post-<?php the_ID(); ?>">
							<h4><?php the_time(__('F jS, Y')) ?> <!-- by <?php the_author() ?> --></h4>
							<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>"><?php the_title(); ?></a></h2>
							
							<div class="entry">
							
							<?php the_content('Keep reading &rarr;'); ?>
							
							</div>
							
							<div class="post_meta">
								<p class="num_comments"><?php comments_popup_link(__('0 Comments'), __('1 Comment'), __('% Comments')); ?></p>
								<p class="tagged"><?php _e('Filed under');?> <?php the_category(', ') ?> and <?php the_tags( '' . __( 'tagged' ) . ' ', ', ', ''); ?></p>
							</div>
						
						</div>

				
					<?php endwhile; ?>
					
				<?php else : ?>
			
					<h2 class="center"><?php _e('Not Found');?></h2>
					<p class="center"><?php _e("Sorry, but you are looking for something that isn't here.");?></p>
					<?php include (TEMPLATEPATH . "/searchform.php"); ?>
			
				<?php endif; ?>
			
			<p align="center"><?php posts_nav_link() ?></p>	
			</div>

			<?php get_sidebar(); ?>
		
		</div>

<?php get_footer(); ?>