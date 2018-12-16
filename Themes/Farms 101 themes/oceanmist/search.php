<?php get_header(); ?>

	<div id="content" class="narrowcolumn">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336x280-oceanmist-top"); } ?>
	<?php if (have_posts()) : ?>

		<div class="title">
		  <h2><?php _e('Search Results');?></h2>
		</div>



		<?php while (have_posts()) : the_post(); ?>
				
		    <div class="archive">
				<h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>"><?php the_title(); ?></a></h3>
			      <p><?php _e('Posted by');?>: <strong><?php the_author() ?></strong> <?php _e('on');?> <?php the_time(get_option('date_format')) ?></p>
			</div>
	
		<?php endwhile; ?>

		<div class="navigation">
			<div class="alignleft"><?php next_posts_link(__('&laquo; Previous Entries')) ?></div>
			<div class="alignright"><?php previous_posts_link(__('Next Entries &raquo;')) ?></div>
		</div>
	
	<?php else : ?>

		<div class="title">
		  <h2><?php _e('Not Found');?></h2>
		</div>
        <div class="post">
		  <p class="center"><?php _e("Sorry, but you are looking for something that isn't here.");?></p>
		  <?php include (TEMPLATEPATH . "/searchform.php"); ?>
	    </div>

	<?php endif; ?>
	<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336x280-oceanmist-bottom"); } ?>
		
	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
