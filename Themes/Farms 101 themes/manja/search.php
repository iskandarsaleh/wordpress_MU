<?php get_header(); ?>

	<div id="content" class="narrowcolumn">

	<?php if (have_posts()) : ?>

		<h2 class="pagetitle"><php _e('Search Results');?></h2>

		<div class="navigation">
			<div class="alignleft"><?php posts_nav_link('','','&laquo; Previous Entries') ?></div>
			<div class="alignright"><?php posts_nav_link('','Next Entries &raquo;','') ?></div>
		</div>


		<?php while (have_posts()) : the_post(); ?>

			<div class="post">
				<h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>"><?php the_title(); ?></a></h3>
				<h4><?php the_time(__('F jS, Y')) ?> <!-- by <?php the_author() ?> --></h4>

				<div class="entry">
					<?php the_excerpt() ?>
				</div>

				<p class="postmetadata alt">
				<?php _e('Posted by');?> <?php the_author() ?> at <a href="<?php echo get_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link:');?> <?php the_title(); ?>"><?php the_time() ?></a>
				& <?php _e('Filed under');?> <?php the_category(', ') ?>
				</p>

				<!--
				<?php trackback_rdf(); ?>
				--><br /><br />
			</div>

		<?php endwhile; ?>

		<div class="navigation">
			<div class="alignleft"><?php posts_nav_link('','','&laquo; Previous Entries') ?></div>
			<div class="alignright"><?php posts_nav_link('','Next Entries &raquo;','') ?></div>
		</div>

	<?php else : ?>

		<h2><?php _e('No results were found.');?></h2><br /> <?php _e('Try the links or try using different search terms.');?>
		<?php /* include (TEMPLATEPATH . '/searchform.php'); */ ?>

		<div class="noresult">
				<br />
				<?php /* If this is a category archive */ if (is_category()) { ?>
				<p><?php _e('You are currently browsing the archives for the');?> <?php single_cat_title(''); ?> <?php _e('category.');?></p>

				<?php /* If this is a yearly archive */ } elseif (is_day()) { ?>
				<p><?php _e('You are currently browsing the');?> <a href="<?php echo get_settings('siteurl'); ?>"><?php echo bloginfo('name'); ?></a> <?php _e('weblog archives');?>
				<?php _e('for the day');?> <?php the_time('l, F jS, Y'); ?>.</p>

				<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
				<p><?php _e('You are currently browsing the');?> <a href="<?php echo get_settings('siteurl'); ?>"><?php echo bloginfo('name'); ?></a> <?php _e('weblog archives');?>
				for <?php the_time('F, Y'); ?>.</p>

				<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
				<p><?php _e('You are currently browsing the');?> <a href="<?php echo get_settings('siteurl'); ?>"><?php echo bloginfo('name'); ?></a> <?php _e('weblog archives');?>
				<?php _e('for the year');?> <?php the_time('Y'); ?>.</p>

				<?php /* If this is a monthly archive */ } elseif (is_search()) { ?>
				<p><?php _e('You have searched the');?> <a href="<?php echo get_settings('siteurl'); ?>"><?php echo bloginfo('name'); ?></a> <?php _e('weblog archives');?>
				<?php _e('for');?> <strong>'<?php echo wp_specialchars($s); ?>'</strong>. If you are unable to find anything in these search results, you can try one of the links.</p>
				<?php /* If this is a monthly archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
				<p><?php _e('You are currently browsing the');?> <a href="<?php echo get_settings('siteurl'); ?>"><?php echo bloginfo('name'); ?></a> <?php _e('weblog archives');?>.</p>

				<?php } ?>
		</div>

	<?php endif; ?>

	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>