<?php get_header(); ?>
<div id="contentwrapper">
<div id="content">

	<?php if (have_posts()) :?>
		<?php $postCount=0; ?>
		<?php while (have_posts()) : the_post();?>
			<?php $postCount++;?>

	<div class="entry">
		<div class="entrytitle entry-<?php echo $postCount ;?>">
			<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>"><?php the_title(); ?></a></h2> 
			<h3><?php the_category(', ') ?> <?php the_time(__('F jS, Y')) ?></h3>
		</div>

		<div class="entrybody">
			<?php the_excerpt(); ?>
		</div>

		<div class="entrymeta">
		<div class="postinfo">
			<?php comments_popup_link('No Comments', '1 Comment', '% Comments', 'commentmeta'); ?> <?php edit_post_link(__('Edit'), ' | ', ' | '); ?>		
		</div>
		</div>
	</div>

	<?php endwhile; ?>
		<div class="navigation">
			<div class="alignleft"><?php next_posts_link(__('&laquo; Previous Entries')) ?></div>
			<div class="alignright"><?php previous_posts_link(__('Next Entries &raquo;')) ?></div>
		</div>

	<?php else : ?>
		<h2><?php _e('Not Found');?></h2>
		<div class="entrybody"><?php _e("Sorry, but you are looking for something that isn't here.");?></div>

	<?php endif; ?>
</div>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>