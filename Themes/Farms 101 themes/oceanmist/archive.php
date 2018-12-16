<?php get_header(); ?>

	<div id="content" class="narrowcolumn">

	<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336x280-oceanmist-top"); } ?>

<?php is_tag(); ?>
		<?php if (have_posts()) : ?>

		<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
		
        <?php /* If this is a category archive */ if (is_category()) { ?>				
		<div class="title">
		  <h2><?php _e('Archive for the');?> '<?php echo single_cat_title(); ?>' <?php _e('Category');?></h2>
		</div>



		<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
		<div class="title">
        <h2><?php _e('Posts Tagged');?> &#8216;<?php single_tag_title(); ?>&#8217;</h2>
		</div>


		
 	    <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
		<div class="title">
		  <h2><?php _e('Archive for');?>
    <?php the_time(__('F jS, Y')); ?></h2>
		</div>
		
	    <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
		<div class="title">
		  <h2><?php _e('Archive for');?>
    <?php the_time('F, Y'); ?></h2>
		</div>
		
	    <?php /* If this is a search */ } elseif (is_search()) { ?>
		<div class="title">
		  <h2><?php _e('Search Results');?></h2>
		</div>
		
		<?php } ?>

		<?php while (have_posts()) : the_post(); ?>
		    <div class="archive">
			
				<h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>"><?php the_title(); ?></a></h3>
				
			      <p><?php _e('Posted by');?>: <strong><?php the_author() ?></strong> <?php _e('on');?> <?php the_time(get_option('date_format')) ?></p>
			</div>
	
		<?php endwhile; ?>
	
	<?php else : ?>

		<div class="title">
		  <h2><?php _e('Not Found');?></h2>
		</div>
        <div class="post">
		  <p class="center"><?php _e("Sorry, but you are looking for something that isn't here.");?></p>
		  <?php include (TEMPLATEPATH . "/searchform.php"); ?>
	    </div>
	<?php endif; ?>

		<div class="navigation">
			<div class="alignleft"><?php posts_nav_link('','',__('&laquo; Previous Entries')) ?></div>
			<div class="alignright"><?php posts_nav_link('',__('Next Entries &raquo;'),'') ?></div>
		</div>
	<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336x280-oceanmist-bottom"); } ?>	
	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
