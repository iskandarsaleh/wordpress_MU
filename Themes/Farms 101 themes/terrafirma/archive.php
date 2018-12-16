<?php get_header();?>

		<div id="content">
		
			<!-- primary content start -->
			<?php if (have_posts()) : ?>
			<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
    
			<?php /* If this is a category archive */ if (is_category()) { ?>				
			<h2 class="pagetitle"><?php _e('Archive for the');?> '<?php echo single_cat_title(); ?>' <?php _e('Category');?></h2>
		
			<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
			<h2 class="pagetitle"><?php _e('Archive for');?>
    <?php the_time(__('F jS, Y')); ?></h2>
		
			<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
			<h2 class="pagetitle"><?php _e('Archive for');?>
    <?php the_time('F, Y'); ?></h2>

			<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
			<h2 class="pagetitle"><?php _e('Archive for');?>
    <?php the_time('Y'); ?></h2>
		
			<?php /* If this is a search */ } elseif (is_search()) { ?>
			<h2 class="pagetitle"><?php _e('Search Results');?></h2>
		
			<?php /* If this is an author archive */ } elseif (is_author()) { ?>
			<h2 class="pagetitle"><?php _e('Author Archive');?></h2>

			<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
			<h2 class="pagetitle"><?php _e('Blog Archives');?></h2>

			<?php } ?>			
		<?php while (have_posts()) : the_post(); ?>
			<div class="post" id="post-<?php the_ID(); ?>">
				<div class="header">
					<div class="date"><em class="user"><?php the_author() ?></em> <br/><em class="postdate"><?php the_time('M jS, Y') ?></em></div>
					<h3><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>"><?php the_title(); ?></a></h3>					
				</div>
				<div class="entry"><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
					<?php the_content('Continue Reading &raquo;'); ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
				</div>
				<div class="footer">
					<ul>
						<li class="readmore"><?php the_category(' , ') ?> <?php edit_post_link(__('Edit')); ?></li>
						<li class="comments"><?php comments_popup_link('Comments (0)', 'Comments (1)', 'Comments (%)'); ?></li>						
					</ul>
				</div>				
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