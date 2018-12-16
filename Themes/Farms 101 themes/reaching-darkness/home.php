<?php get_header(); ?>

<?php 
// CHANGE showposts=3 TO WHATEVER NUMBER YOU WANT
$my_query = new WP_Query('showposts=2');
while ($my_query->have_posts()) : $my_query->the_post();
$do_not_duplicate = $post->ID; 
?>

<div id="post-<?php the_ID(); ?>" class="post">
<h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>

<p class="post-time">
<?php _e('Posted on'); ?> <?php the_time(__('F jS, Y')) ?> <?php _e('in'); ?> <?php the_category(', ') ?> <?php the_tags( '&nbsp;' . __( 'and tagged' ) . ' ', ', ', ''); ?> <?php edit_post_link(__('Edit'), ' &#124; ', ''); ?></p>

<div class="entry"><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280graphite"); } ?>
<?php the_content(); ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280graphite"); } ?>
</div><!-- entry -->

<p class="postmetadata">
<span class="comments"><?php comments_popup_link(__('No Comments &#187;'), __('1 Comment &#187;'), __('% Comments &#187;')); ?></span>
</p>

</div><!-- post -->

<?php endwhile; ?>
<?php get_footer(); ?>