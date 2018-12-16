<?php get_header(); ?>

	<div id="content" class="narrowcolumn">

		<?php if (have_posts()) : ?>

		 <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
<?php /* If this is a category archive */ if (is_category()) { ?>				
		<h2 class="pagetitle">Archive for the '<?php echo single_cat_title(); ?>' Category</h2>
		
 	  <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
		<h2 class="pagetitle"><?php _e('Archive for');?> <?php the_time(__('F jS, Y')); ?></h2>
		
	 <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
		<h2 class="pagetitle"><?php _e('Archive for');?> <?php the_time('F, Y'); ?></h2>

		<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
		<h2 class="pagetitle"><?php _e('Archive for');?> <?php the_time('Y'); ?></h2>
		
	  <?php /* If this is a search */ } elseif (is_search()) { ?>
		<h2 class="pagetitle"><php _e('Search Results');?></h2>
		
	  <?php /* If this is an author archive */ } elseif (is_author()) { ?>
		<h2 class="pagetitle"><php _e('Author Archive');?></h2>

		<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
		<h2 class="pagetitle"><php _e('Blog Archives');?></h2>

		<?php } ?>
<?php _e('You are currently browsing the archives for the');?> <?php single_cat_title(''); ?> <?php _e('category.');?>

		<div class="navigation">
			<div class="alignleft"><?php next_posts_link(__('Previous Entries')) ?></div>
			<div class="alignright"><?php previous_posts_link(__('Next Entries')) ?></div>
		</div>

		<?php while (have_posts()) : the_post(); ?>
		<div class="post">
				<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>"><?php the_title(); ?></a></h2>
			<div class="metaright"><div class="articlemeta"><span class="editentry"><?php edit_post_link('<img src="'.get_bloginfo(template_directory).'/images/pencil.png" alt="'.__("Edit Link").'"  />','<span class="editlink">','</span>'); ?></span>	<li class="date"><?php the_time('M jS, Y') ?></li> | <li class="cat"><?php the_category(', ') ?></li> | <li class="comm"> <?php comments_popup_link(__('No Comments'), __('1 Comment'), __('% Comments')); ?></li> <br/></div></div>
		<div class="metaright">	<?php if(function_exists('UTW_ShowTagsForCurrentPost')) : ?><div class="utwtags"><?php UTW_ShowTagsForCurrentPost("commalist"); ?></div> <?php endif; ?></div>
				
				
				<div class="entrytext">
					<?php the_excerpt() ?>
				</div>
		
				

			</div>
	
		<?php endwhile; ?>

		<div class="navigation">
			<div class="alignleft"><?php next_posts_link(__('Previous Entries')) ?></div>
			<div class="alignright"><?php previous_posts_link(__('Next Entries')) ?></div>
		</div>
	
	<?php else : ?>

		<h2 class="center"><?php _e('Not Found');?></h2>
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>

	<?php endif; ?>
		
	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>