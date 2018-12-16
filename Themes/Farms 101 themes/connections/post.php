<p class="post-date"><?php the_time(get_option('date_format')); ?></p>
<div class="post-info"><h2 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link:');?> <?php the_title(); ?>"><?php the_title(); ?></a></h2>
<?php _e('Posted by');?> <?php the_author(); ?> under <?php the_category(', '); ?> <?php the_tags( ' | ' . __( 'Tags' ) . ': ', ', ', ' | '); ?><?php edit_post_link('(edit this)'); ?><br/><?php comments_popup_link('No Comments', '1 Comment', '[%] Comments'); ?>&nbsp;</div>
<div class="post-content">
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
	<?php the_content(); ?>
	<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
	<div class="post-info">
		<?php wp_link_pages(); ?>											
	</div>
	<div class="post-footer">&nbsp;</div>
</div>
