<?php get_header(); ?>

<?php if ( $paged < 2 ) { // Do stuff specific to first page?>

<?php $my_query = new WP_Query('category_name=featured&showposts=1');
while ($my_query->have_posts()) : $my_query->the_post();
$do_not_duplicate = $post->ID; ?>

				<h2 class="sectionhead"><a href="<?php bloginfo('rss2_url'); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/rss.gif" alt="Main Content RSS Feed" title="Main Content RSS Feed" style="float:right;margin: 2px 0 0 5px;" /></a>Feature Article</h2>
	
				<div class="featurepost" id="post-<?php the_ID(); ?>">
						
					<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>"><?php the_title(); ?> &raquo;</a></h2>

					<p class="postinfo">By <?php the_author_posts_link(); ?> <?php _e('on');?> <?php the_time('M j, Y') ?> <?php _e('in');?> <?php the_category(', ') ?><?php the_tags( '&nbsp;' . __( 'and tagged' ) . ' ', ', ', ''); ?> | <?php comments_popup_link(__('0 Comments'), __('1 Comment'), __('% Comments')); ?><?php edit_post_link(__('Edit'), ' | ', ''); ?></p>

					<div class="entry"><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280graphite"); } ?>
						<?php the_content('Read the rest'); ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280graphite"); } ?>
					</div>

				</div>
  	
<?php endwhile; ?>

<?php include (TEMPLATEPATH . "/sidebar1.php"); ?>

			<div id="content">
	
				<h2 class="sectionhead"><a href="<?php bloginfo('rss2_url'); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/rss.gif" alt="Main Content RSS Feed" title="Main Content RSS Feed" style="float:right;margin: 2px 0 0 5px;" /></a>Recent Articles</h2>

<?php if (have_posts()) : while (have_posts()) : the_post();
if( $post->ID == $do_not_duplicate ) continue; update_post_caches($posts); ?>

				<div class="post" id="post-<?php the_ID(); ?>">
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("46860graphite"); } ?>
					<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>"><?php the_title(); ?> &raquo;</a></h2>

					<p class="postinfo">By <?php the_author_posts_link(); ?> <?php _e('on');?> <?php the_time('M j, Y') ?> <?php _e('in');?> <?php the_category(', ') ?> | <?php comments_popup_link(__('0 Comments'), __('1 Comment'), __('% Comments')); ?><?php edit_post_link(__('Edit'), ' | ', ''); ?></p>

					<div class="entry"><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280graphite"); } ?>
						<?php the_content('Read the rest'); ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280graphite"); } ?>
					</div>

				</div>

<?php endwhile; endif; ?>

<?php } else { // Do stuff specific to non-first page ?>

<?php include (TEMPLATEPATH . "/sidebar1.php"); ?>

			<div id="content">
	
				<h2 class="sectionhead"><a href="<?php bloginfo('rss2_url'); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/rss.gif" alt="Main Content RSS Feed" title="Main Content RSS Feed" style="float:right;margin: 2px 0 0 5px;" /></a>Recent Articles</h2>

<?php if (have_posts()) : while (have_posts()) : the_post();
if( $post->ID == $do_not_duplicate ) continue; update_post_caches($posts); ?>

				<div class="post" id="post-<?php the_ID(); ?>">

					<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>"><?php the_title(); ?> &raquo;</a></h2>

					<p class="postinfo">By <?php the_author_posts_link(); ?> <?php _e('on');?> <?php the_time('M j, Y') ?> <?php _e('in');?> <?php the_category(', ') ?> | <?php comments_popup_link(__('0 Comments'), __('1 Comment'), __('% Comments')); ?><?php edit_post_link(__('Edit'), ' | ', ''); ?></p>

					<div class="entry">
						<?php the_content('Read the rest'); ?>
					</div>

				</div>

<?php endwhile; endif; ?>

<?php } ?>

				<div class="navigation">

					<div class="alignleft">
						<?php next_posts_link(__('&laquo; Previous Entries')) ?>
					</div>

					<div class="alignright">
						<?php previous_posts_link(__('Next Entries &raquo;')) ?>
					</div>

                		</div>

			</div>

		</div>

<?php get_sidebar(); ?>

	</div>

<?php get_footer(); ?>