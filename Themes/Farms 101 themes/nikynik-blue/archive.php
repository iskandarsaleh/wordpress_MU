<?php get_header(); ?>

	<div id="content" class="narrowcolumn">

		<?php if (have_posts()) : ?>
<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
<?php /* If this is a category archive */ if (is_category()) { ?>				
		<h2 class="pagetitle"><?php _e('Archive for the','nikynik'); ?> '<?php echo single_cat_title(); ?>' <?php _e('Category','nikynik'); ?></h2>
		
 	  <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
		<h2 class="pagetitle"><?php _e('Archive for ','nikynik'); ?> <?php the_time(__('F jS, Y','nikynik')); ?></h2>
		
	 <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
		<h2 class="pagetitle"><?php _e('Archive for ','nikynik'); ?> <?php the_time('F, Y','nikynik'); ?></h2>

		<?php /* If this is a yearly archive */ } elseif (is_year()) { ?><h2 class="pagetitle"><?php _e('Archive for ','nikynik'); ?> <?php the_time('Y'); ?></h2>
		
	  <?php /* If this is a search */ } elseif (is_search()) { ?>
		<h2 class="pagetitle"><?php _e('Search results','nikynik'); ?></h2>
		
	  <?php /* If this is an author archive */ } elseif (is_author()) { ?>
		<h2 class="pagetitle"><?php _e('Author Archive','nikynik'); ?></h2>

		<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
		<h2 class="pagetitle"><?php _e('Blog Archives','nikynik'); ?></h2>

		<?php } ?>


		<div class="navigation">

			<?php posts_nav_link(' &#8212; ', __('&laquo; Previous Page'), __('Next Page &raquo;')) ?>
		</div>

		<?php while (have_posts()) : the_post(); ?>
		<div class="post">
				<h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>"><?php the_title(); ?></a></h3>
				<small><?php the_time(__('F jS, Y','nikynik')); ?></small>
				
				<div class="entry">
					<?php the_excerpt() ?>
				</div>
		
				<p class="postmetadata"><?php _e('Filed under:','nikynik'); ?>&nbsp;
<?php the_category(', ') ?> <strong>|</strong> <?php edit_post_link(__('Edit','nikynik'),'','<strong>| </strong>'); ?>
<?php comments_popup_link(__('No Comments'), __('1 Comment'), __('% Comments')); ?></p> 
				
				<!--
				<?php trackback_rdf(); ?>
				-->
			</div>
	
		<?php endwhile; ?>

		<div class="navigation">

			<?php posts_nav_link(' &#8212; ', __('&laquo; Previous Page'), __('Next Page &raquo;')) ?>
		</div>
	
	<?php else : ?>

		<h2 class="center"><?php __('Not Found','nikynik'); ?></h2>
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>
<?php endif; ?>
		
	</div>

<?php if(function_exists("se_get_sidebar")){se_get_sidebar();}else{get_sidebar();} ?>
<?php get_footer(); ?>