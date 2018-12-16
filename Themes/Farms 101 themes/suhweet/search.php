<?php get_header(); ?>

<?php include (TEMPLATEPATH . "/sidebar1.php"); ?>	

		<div id="content">

	<?php if (have_posts()) : ?>

		<h2 class="sectionhead">Search Results for "<?php echo wp_specialchars($s, 1); ?>"</h2>

	<?php while (have_posts()) : the_post(); ?>
				
				<div class="post" id="post-<?php the_ID(); ?>">

					<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>"><?php the_title(); ?> &raquo;</a></h2>

					<p class="postinfo">By <?php the_author_posts_link(); ?> <?php _e('on');?> <?php the_time('M j, Y') ?> <?php _e('in');?> <?php the_category(', ') ?> | <?php comments_popup_link(__('0 Comments'), __('1 Comment'), __('% Comments')); ?><?php edit_post_link(__('Edit'), ' | ', ''); ?></p>	
		
					<div class="entry">
						<?php the_excerpt(); ?>
					</div>

				</div>

	        <?php endwhile; endif; ?>

		<div class="navigation">
			<div class="alignleft">
				<?php next_posts_link(__('&laquo; Previous Entries')) ?>
			</div>
			<div class="alignright">
				<?php previous_posts_link(__('Next Entries &raquo;')) ?>
			</div>
		</div>	

	</div>

</div>

<?php get_sidebar(); ?>

	</div>

<?php get_footer(); ?>