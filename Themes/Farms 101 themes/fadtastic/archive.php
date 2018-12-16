<?php get_header(); ?>

		<div id="content_wrapper">
			<div id="content">
			
			 <?php if (have_posts()) : ?>

			<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
			<?php /* If this is a category archive */ if (is_category()) { ?>				
					<h1 class="pagetitle"><?php echo single_cat_title(); ?></h1>
					
				  <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
					<h1 class="pagetitle"><?php _e('Archive for');?>
    <?php the_time(__('F jS, Y')); ?></h1>
					
				 <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
					<h1 class="pagetitle"><?php _e('Archive for');?>
    <?php the_time('F, Y'); ?></h1>
			
					<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
					<h1 class="pagetitle"><?php _e('Archive for');?>
    <?php the_time('Y'); ?></h1>
					
				  <?php /* If this is a search */ } elseif (is_search()) { ?>
					<h1 class="pagetitle"><?php _e('Search Results');?></h1>
					
				  <?php /* If this is an author archive */ } elseif (is_author()) { ?>
					<h1 class="pagetitle"><?php _e('Author Archive');?></h1>
			
					<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
					<h1 class="pagetitle"><?php _e('Blog Archives');?></h1>
			
					<?php } ?>
			
					<?php while (have_posts()) : the_post(); ?>
					<div class="post">
							<h2 id="post-<?php the_ID(); ?>" class="top_border"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>"><?php the_title(); ?></a></h2>
							<p class="author">Posted on <em><?php the_time(get_option('date_format')) ?></em>.</p>
			<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
							<?php the_excerpt(); ?>
						<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>	
							<strong><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>">Read Full Post</a></strong> | <strong><a href="<?php the_permalink() ?>#respond" title="Make a comment">Make a Comment</a></strong> <small> ( <strong><?php comments_popup_link('None', '1', '%'); ?></strong> so far ) </small>
								
					</div>
				
					<?php endwhile; ?>
			
					<br />
					<?php next_posts_link(__('&laquo; Previous Entries')) ?> <?php previous_posts_link(__('Next Entries &raquo;')) ?>
				
				<?php else : ?>
			
					<h2 class="center"><?php _e('Not Found');?></h2>
					<?php include (TEMPLATEPATH . '/searchform.php'); ?>
			
				<?php endif; ?>
				
			</div>
		</div>
			
	
	<?php include("sidebar.php") ?>

<?php get_footer(); ?>
