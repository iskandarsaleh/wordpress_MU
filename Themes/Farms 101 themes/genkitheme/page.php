<?php get_header(); ?>
<div id="contentwrapper">
<div id="content">

	<?php if (have_posts()) :?>
		<?php $postCount=0; ?>
		<?php while (have_posts()) : the_post();?>
			<?php $postCount++;?>
	<div class="entry entry-<?php echo $postCount ;?>">
		<div class="entrytitle">
			<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>"><?php the_title(); ?></a></h2>
		</div>

		<div class="entrybody">
			<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?><?php the_content(); ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
			<?php edit_post_link('&raquo; Edit this page'); ?>
		</div>

	</div>

	<div class="commentsblock">
		<?php comments_template(); ?>
	</div>

	<?php endwhile; ?>

	<?php else : ?>

		<h2><?php _e('Not Found');?></h2>
		<div class="entrybody"><?php _e("Sorry, but you are looking for something that isn't here.");?></div>

	<?php endif; ?>

</div>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>