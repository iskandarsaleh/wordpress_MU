<?php get_header(); ?>

	<div id="content" class="sanda">

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
				<h2 class="pagetitle">Search Results for '<?php echo $s; ?>'</h2>
			
			<?php /* If this is an author archive */ } elseif (is_author()) { ?>
				<h2 class="pagetitle"><?php _e('Author Archive');?></h2>
	
			<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
				<h2 class="pagetitle"><?php _e('Blog Archives');?></h2>
	
			<?php } ?>
	
	
				<?php while (have_posts()) : the_post(); ?>
				
					<div class="post">
				
						<h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>"><?php the_title(); ?></a><br />
						<?php the_time('l, F jS, Y') ?></h3>
		
						<div class="entry"><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
							<?php the_excerpt() ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
						</div>
				
						<p class="postmetadata"><?php _e('Posted in ');?> <?php the_category(', ') ?> | <?php edit_post_link(__('Edit'), '', ' | '); ?>  <?php comments_popup_link(__('No Comments &#187;'), __('1 Comment &#187;'), __('% Comments &#187;')); ?></p> 
		
					</div>
			
				<?php endwhile; ?>
	
	
			<?php 
			
				// This young snippet fixes the problem of a grey navigation bar
				// when there is nothing to fill it, a bit pointless having it sitting
				// there all empty and unfufilled
				
				$numposts = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts WHERE post_status = 'publish'");
				$perpage = $wpdb->get_var("SELECT option_value FROM $wpdb->options WHERE option_name = 'posts_per_page'");
	
				if ($numposts > $perpage) {
				
			?>
					
					<div class="navigation">
						<div class="alignleft"><?php next_posts_link(__('&laquo; Previous Entries')) ?></div>
						<div class="alignright"><?php previous_posts_link(__('Next Entries &raquo;')) ?></div>
					</div>
					
			<?php }	?>
	
		<?php else : ?>

			<h2>No Data Found</h2>
			<?php include (TEMPLATEPATH . '/searchform.php'); ?>

		<?php endif; ?>
		
	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>