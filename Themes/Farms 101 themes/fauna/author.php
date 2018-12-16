<?php get_header(); ?>

	<div id="body">

		<div id="main" class="entry">
			<div class="box">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			
				<?php if ($about_text != true) { /* This shows the "about text" only once */ ?>
			
				<h2><?php _e('About') ?> <?php the_author(); ?></h2>
				<? $author_nicename = $wpdb->get_var("SELECT user_nicename FROM $wpdb->users WHERE ID = " . $author); ?>
				<p><?php the_author_description(); ?></p>
				<ul>
					<li><?php _e('Full name:') ?> <?php the_author_firstname(); ?> <?php the_author_lastname(); ?></li>
					<li><?php _e('Web site:') ?> <a href="<?php the_author_url(); ?>"><?php the_author_url(); ?></a></li>
					<li><?php _e('Contact via ICQ:') ?> <?php the_author_icq(); ?></li>
					<li><?php _e('Contact via AOL Instant Messenger:') ?> <?php the_author_aim(); ?></li>
					<li><?php _e('Contact via Yahoo Messenger:') ?> <?php the_author_yim(); ?></li>
					<li><?php _e('Contact via MSN Messenger:') ?> <?php the_author_msn(); ?></li>
				</ul>
				
				<h2><?php _e('Entries Authored by') ?> <?php the_author(); ?></h2>

				<p><?php _e('You can follow entries authored by') ?> <?php the_author(); ?> <?php _e('via an') ?> <a href="<? echo get_author_rss_link(0, $author, $author_nicename); ?>" title="<?php _e('RSS 2.0') ?>"><?php _e('author-only XML feed') ?></a>.</p>
				<p><?php the_author(); ?> <?php _e('has authored') ?> <?php the_author_posts(); ?> <?php _e('on this weblog') ?>:</p>
				
				<ul><?php } $about_text = true; ?>
					<li><a href="<?php the_permalink() ?>" title="<?php _e('Permanent Link:');?> <?php the_title(); ?>"><?php the_title(); ?></a></li>
					<?php endwhile; ?>
				</ul>
					
				<hr />
			
			</div>

			<? $numposts = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts WHERE post_status = 'publish'"); ?>
			<? if ($numposts > $posts_per_page) { ?>
			<div class="box">
				<div class="align-left"><?php posts_nav_link('','',__('&laquo; Previous Entries')) ?></div>
				<div class="align-right"><?php posts_nav_link('',__('Next Entries &raquo;'),'') ?></div>
				<br class="clear" />
			</div>
			<? } ?>
			
			<?php else : ?>
			<div class="box">
				<h2><?php _e('Not Found');?></h2>
				<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
			</div>
			<?php endif; ?>
			
			<hr />
		</div>

		<?php get_sidebar(); ?>

	</div>
				
	<?php get_footer(); ?>