<?php get_header(); ?>

	<div id="body">

		<div id="main" class="entry">
		
			<?php /* Guess Sidenote category */
			$sidenote_cat = $wpdb->get_var("SELECT t.term_id FROM {$wpdb->terms} AS t LEFT JOIN {$wpdb->term_taxonomy} AS tt ON ( tt.term_id = t.term_id ) WHERE ( (t.slug = 'sidenotes' OR  t.slug = 'asides' OR  t.slug = 'dailies') AND tt.taxonomy = 'category')");
			?>

			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			
				<?php if ( in_category($sidenote_cat) ) { ?>

					<?php /* Sidenotes box start */ if (!$sidenotes) { ?><div class="box sidenotes"><?php } $sidenotes = true; ?>

					<?php include (TEMPLATEPATH . '/template-sidenote.php'); ?>

				<?php } else { ?>
				
					<?php /* Sidenotes box end */ if ($sidenotes && !$sidenotes_end) { ?></div><hr /><?php } $sidenotes_end = true; $sidenotes = false; $sidenotes_end = false; ?>
					
					<?php include (TEMPLATEPATH . '/template-postloop.php'); ?>
					
				<?php } ?>
		
			<?php endwhile; ?>
			
			<?php /* Sidenotes box end */ if ($sidenotes && !$sidenotes_end) { ?></ul></div><hr /><?php } $sidenotes_end = true; $sidenotes = false; $sidenotes_end = false; ?>
			
			<div class="box">
				<div class="align-left"><?php posts_nav_link('','',__('&laquo; Previous Entries')) ?></div>
				<div class="align-right"><?php posts_nav_link('',__('Next Entries &raquo;'),'') ?></div>
				<br class="clear" />
			</div>

			<?php else : ?>
			
			<div class="box">
				<h2><?php _e('Not Found') ?></h2>
				<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
			</div>		
			
		<?php endif; ?>
			
		</div>

		<?php get_sidebar(); ?>

	</div>

	<?php get_footer(); ?>