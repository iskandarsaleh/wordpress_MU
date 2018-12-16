<?php get_header();?>

		<div id="content">
		
			<!-- primary content start -->
			<?php if (have_posts()) : ?>
		<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
    
		<h2 class="pagetitle"><?php _e('Search Results for ');?> <?php echo "'".$s."'";?></h2>
		<?php while (have_posts()) : the_post(); ?>
			<div class="post" id="post-<?php the_ID(); ?>">
				<div class="header">
					<div class="date"><em class="user"><?php the_author() ?></em> <br/><em class="postdate"><?php the_time('M jS, Y') ?></em></div>
					<h3><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>"><?php the_title(); ?></a></h3>					
				</div>
				<div class="entry">
					<?php the_excerpt(); ?>
				</div>
				<div class="footer">
					<ul>
						<li class="readmore"><?php the_category(' , ') ?> <?php edit_post_link(__('Edit')); ?></li>
						<li class="comments"><?php comments_popup_link('Comments (0)', 'Comments (1)', 'Comments (%)'); ?></li>						
					</ul>
				</div>
				<?php comments_template(); ?>
			</div>	
		<?php endwhile; ?>
		<p align="center"><?php posts_nav_link(' - ','&#171; Prev','Next &#187;') ?></p>		
	<?php else : ?>

		<h2 class="center"><?php _e('Not Found');?></h2>
		<p class="center"><?php _e("Sorry, but you are looking for something that isn't here.");?></p>
	<?php endif; ?>
			<!-- primary content end -->	
		</div>		
	<?php get_sidebar();?>	
<?php get_footer();?>