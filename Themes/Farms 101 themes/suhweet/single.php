<?php get_header(); ?>

			<div id="content">

<?php if (have_posts()) : ?>

				<h2 class="sectionhead"><a href="<?php the_permalink() ?>feed"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/rss.gif" alt="RSS Feed for This Post" title="RSS Feed for This Post" style="float:right;margin: 2px 0 0 5px;" /></a>Current Article</h2>

<?php while (have_posts()) : the_post(); ?>
			
				<div class="post" id="post-<?php the_ID(); ?>">
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("46860graphite"); } ?>
					<h1><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>"><?php the_title(); ?></a></h1>

					<p class="postinfo">By <?php the_author_posts_link(); ?> <?php _e('on');?> <?php the_time('M j, Y') ?> <?php _e('in');?> <?php the_category(', ') ?><?php the_tags( '&nbsp;' . __( 'and tagged' ) . ' ', ', ', ''); ?><?php edit_post_link(__('Edit'), ' | ', ''); ?></p>
			
					<div class="entry"><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280graphite"); } ?>
						<?php the_content(); ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280graphite"); } ?>
					</div>
				</div>

				<p class="tb"><a href="<?php trackback_url(); ?>">Trackback URL</a></p>

<?php if (function_exists('related_posts')) { ?>
				<h2 class="related">Related Posts</h2>
				<div class="related">
					<ul><?php related_posts(); ?></ul>
				</div>
<?php } ?>

				<?php comments_template(); ?>

<?php endwhile; endif; ?>

				<div class="navigation">
					<div class="alignleft">
						<?php next_posts_link('&laquo; Previous Posts') ?>
					</div>
					<div class="alignright">
						<?php previous_posts_link('Next Posts  &raquo;') ?>
					</div>
	               		</div>

			</div>

<?php include (TEMPLATEPATH . "/sidebar1.php"); ?>	

		</div>

<?php get_sidebar(); ?>

	</div>

<?php get_footer(); ?>