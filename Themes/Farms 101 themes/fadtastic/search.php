<?php get_header(); ?>

		<div id="content_wrapper">
			<div id="content">
			
			<?php if (have_posts()) : ?>

		<h1><?php _e('Search Results');?></h1>

		<?php while (have_posts()) : the_post(); ?>
				
			<div class="post">
				<h2 id="post-<?php the_ID(); ?>" class="top_border"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>"><?php the_title(); ?></a></h2>
				<p class="author">Posted on <em><?php the_time(get_option('date_format')) ?></em>.</p>

							<?php the_excerpt(); ?>
							
							<strong><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>">Read Full Post</a></strong> | <strong><a href="<?php the_permalink() ?>#respond" title="Make a comment">Make a Comment</a></strong> <small> ( <strong><?php comments_popup_link('None', '1', '%'); ?></strong> so far ) </small>
			</div>
	
				<?php endwhile; ?>
		
				<br />
				<?php next_posts_link(__('&laquo; Previous Entries')) ?> | <?php previous_posts_link(__('Next Entries &raquo;')) ?>
				
			
			<?php else : ?>
		
				<h2 class="center"><?php _e('No posts found. Try a different search?');?></h2>
				<?php include (TEMPLATEPATH . '/searchform.php'); ?>
		
			<?php endif; ?>
				
			</div>
		</div>
			
	
	<?php include("sidebar.php") ?>

<?php get_footer(); ?>
