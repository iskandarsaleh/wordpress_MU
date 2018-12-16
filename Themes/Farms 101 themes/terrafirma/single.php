<?php get_header();?>

		<div id="content">
		
			<!-- primary content start -->
			<?php if (have_posts()) : ?>
		
		<?php while (have_posts()) : the_post(); ?>
			<div class="post" id="post-<?php the_ID(); ?>">
				<div class="header">
					<div class="date"><em class="user"><?php the_author() ?></em> <br/><em class="postdate"><?php the_time('M jS, Y') ?></em></div>
					<h3><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h3>					
				</div>
				<div class="entry">
			<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>		<?php the_content('Continue Reading &raquo;'); ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
				</div>
				<div class="footer">
					<ul>
						<li class="readmore"><?php the_category(' , ') ?> <?php the_tags( '&nbsp;' . __( 'tagged' ) . ' ', ', ', ''); ?><?php edit_post_link('Edit'); ?></li>						
					</ul>
				</div>
				<?php comments_template(); ?>
			</div>	
		<?php endwhile; ?>
		<p align="center"><?php posts_nav_link(' - ','&#171; Prev','Next &#187;') ?></p>		
	<?php else : ?>

		<h2 class="center">Not Found</h2>
		<p class="center">Sorry, but you are looking for something that isn't here.</p>
	<?php endif; ?>
			<!-- primary content end -->	
		</div>		
	<?php get_sidebar();?>	
<?php get_footer();?>