<?php get_header(); ?>

			<div class="narrow_column">

<?php function post_style() {
	static $post_count;
	$post_count++;
		if ($post_count % 2) {
			echo "post";
		}
		else {
			echo "post_alt";
		}
}
?>

<?php if(have_posts()) : ?><?php while(have_posts()) : the_post(); ?>
<div class="<?php post_style(); ?>" id="post-<?php the_ID(); ?>">

	<h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
	<div class="postdate"><?php _e('Posted on'); ?> <?php the_time(__('F jS, Y')) ?> <?php _e('by'); ?> <?php the_author() ?></div>
	<div class="entry">
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
		<?php the_excerpt(); ?>
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
		<p class="postinfo">
<?php comments_popup_link(__('No Comments &#187;'), __('1 Comment &#187;'), __('% Comments &#187;')); ?><br />
<?php _e('Filed under&#58;'); ?> <?php the_category(', ') ?> <?php edit_post_link(__('Edit'), ' &#124; ', ''); ?>
		</p>

		<!--
		<?php trackback_rdf(); ?>
		-->

	</div><!-- end entry -->

</div><!-- end post -->
<?php endwhile; ?>

<?php include (TEMPLATEPATH . '/browse.php'); ?>

<?php else : ?>

<div class="post">

	<h2><?php _e('Not Found'); ?></h2>
	<div class="entry">
<p class="notfound"><?php _e('Sorry, but you are looking for something that isn&#39;t here.'); ?></p>
	</div>

</div>

<?php endif; ?>

			</div><!-- end narrow column -->

<?php get_footer(); ?>