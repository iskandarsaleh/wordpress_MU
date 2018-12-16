<?php get_header(); ?>
<?php get_sidebar(); ?>

<div id="content">

	<?php if (have_posts()) : ?>

		 <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
	<?php /* If this is a category archive */ if (is_category()) { ?>
		<h2 class="pagetitle"><?php _e('Archive for the');?> &#8216;<?php echo single_cat_title(); ?>&#8217; <?php _e('Category');?></h2>

	<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
		<h2 class="pagetitle"><?php _e('Archive for');?>
    <?php the_time(__('F jS, Y')); ?></h2>

	<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
		<h2 class="pagetitle"><?php _e('Archive for');?>
    <?php the_time('F, Y'); ?></h2>

	<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
		<h2 class="pagetitle"><?php _e('Archive for');?>
    <?php the_time('Y'); ?></h2>

	<?php /* If this is an author archive */ } elseif (is_author()) { ?>
		<h2 class="pagetitle"><?php _e('Author Archive');?></h2>

	<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
		<h2 class="pagetitle"><?php _e('Blog Archives');?></h2>

	<?php } ?>

		<div class="navigation">
			<div style="float:right" class="alignright"><?php previous_post_link('&laquo; %link') ?></div>
			<div class="alignleft"><?php next_post_link('%link &raquo;') ?></div>
		</div>

	<?php while (have_posts()) : the_post(); ?>
	<div class="entry entry-<?php echo $postCount ;?>">

		<div class="entrytitle">
			<h2 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>"><?php the_title(); ?></a></h2> 
			<h3><?php the_time(__('F jS, Y')) ?></h3>
		</div>
		<div class="entrybody">
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
			<?php the_content(__('Read the rest of this entry &raquo;')); ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
		</div>
		
		<div class="entrymeta">
		<div class="postinfo">
			<p class="postedby"><?php _e('Posted by');?> <?php the_author() ?> 		<?php comments_popup_link(__('No Comments &#187;'), __('1 Comment &#187;'),__('% Comments &#187;'), 'commentslink'); ?></p>
			<p class="filedto"><?php _e('Filed under');?>: <?php the_category(', ') ?> <?php edit_post_link(__('Edit'), ' | ', ''); ?></p>
		</div>

			<div class="feedback">
			<?php comments_popup_link(__('No Response'), __('1 Pings'),__('% Pings'), 'commentslink'); ?>
			</div>
		</div>

	</div>

		<?php endwhile; ?>

		<div class="navigation">
			<div style="float:right" class="alignright"><?php previous_post_link('&laquo; %link') ?></div>
			<div class="alignleft"><?php next_post_link('%link &raquo;') ?></div>
		</div>

	<?php else : ?>

		<h2><?php _e('Not Found');?></h2>
		<div class="entrybody"><?php _e("Sorry, but you are looking for something that isn't here.");?></div>

	<?php endif; ?>
	
</div>

<?php get_footer(); ?>