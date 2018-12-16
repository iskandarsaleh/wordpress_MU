<!-- uncomment the "by <?php the_author(); ?> <?php _e('to');?>  put the author's name on the post -->
<div class="post">
		<h2 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title();?>"><?php the_title(); ?></a></h2>
<small><?php _e('Posted in ');?> <?php the_category(', '); ?> <?php _e('on');?> <?php the_time(__('F jS, Y')); ?> and <?php the_tags( '' . __( 'tagged' ) . ' ', ', ', ''); ?>
<!-- by <?php the_author(); ?> --></small>
<div class="entry">
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?><?php the_content(__('Read the rest of this entry &raquo;')); ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?></div>

<p class="postmetadata"><?php edit_post_link(__('Edit'), '','<strong>|</strong>'); ?><?php comments_popup_link(' Leave A Comment &#187;', '1 Comment &#187;', '% Comments &#187;'); ?></p>
<?php trackback_rdf(); ?>
</div>