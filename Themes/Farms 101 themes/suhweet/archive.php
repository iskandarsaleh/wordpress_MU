<?php get_header(); ?>

<?php include (TEMPLATEPATH . "/sidebar1.php"); ?>	

		<div id="content">

		<?php if (have_posts()) : ?>

		 <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
<?php /* If this is a category archive */ if (is_category()) { ?>
				
<h2 class="sectionhead"><a href="<?php echo get_category_link($cat); ?>feed"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/rss.gif" alt="RSS Feed for <?php echo single_cat_title(); ?>" title="RSS Feed for the '<?php echo single_cat_title(); ?>' Category" style="float:right;margin: 2px 0 0 5px;" /></a>Category: <?php echo single_cat_title(); ?></h2>
		
<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
<h2 class="sectionhead"><?php _e('Archive for');?>
    <?php the_time(__('F jS, Y')); ?></h2>
		
<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
<h2 class="sectionhead"><?php _e('Archive for');?>
    <?php the_time('F, Y'); ?></h2>

<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
<h2 class="sectionhead"><?php _e('Archive for');?>
    <?php the_time('Y'); ?></h2>
		
<?php /* If this is a search */ } elseif (is_search()) { ?>
<h2 class="sectionhead"><?php _e('Search Results');?></h2>
		
<?php /* If this is an author archive */ } elseif (is_author()) { ?>
<h2 class="sectionhead"><?php _e('Author Archive');?></h2>

<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
<h2 class="sectionhead"><?php _e('Blog Archives');?></h2>

		<?php } ?>

<?php while (have_posts()) : the_post(); ?>

			
				<div class="post" id="post-<?php the_ID(); ?>">
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("46860graphite"); } ?>
					<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>"><?php the_title(); ?> &raquo;</a></h2>

					<p class="postinfo">By <?php the_author_posts_link(); ?> <?php _e('on');?> <?php the_time('M j, Y') ?> <?php _e('in');?> <?php the_category(', ') ?> | <?php comments_popup_link(__('0 Comments'), __('1 Comment'), __('% Comments')); ?><?php edit_post_link(__('Edit'), ' | ', ''); ?></p>
			
					<div class="entry"><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280graphite"); } ?>
						<?php the_excerpt(); ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280graphite"); } ?>
					</div>
				</div>        

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

		</div>

<?php get_sidebar(); ?>

	</div>

<?php get_footer(); ?>