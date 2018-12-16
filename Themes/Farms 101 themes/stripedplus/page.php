<?php get_header(); ?>

<?php if (have_posts()) : while(have_posts()) : the_post(); ?>

	<div class="post"><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("46860nocolor"); } ?>
		<h3 class="posth3"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
        <?php the_content(''); ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
		<p class="postdata">Filed by <?php the_author(); ?> <?php _e('at');?> <?php the_time(__('F jS, Y')) ?> under <?php the_category(', ') ?></p>
    </div>
	
	
	<div id="commentwrapper">
	<?php comments_template(); ?>
	</div>
		
<?php endwhile; endif; ?>

<?php get_footer(); ?>