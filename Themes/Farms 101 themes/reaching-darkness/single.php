<?php get_header(); ?>

<?php if(have_posts()) : ?><?php while(have_posts()) : the_post(); ?>

<div id="post-<?php the_ID(); ?>" class="post">
<h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>

<p class="post-time">
<?php _e('Posted on'); ?> <?php the_time(__('F jS, Y')) ?> <?php _e('in'); ?> <?php the_category(', ') ?> <?php the_tags( '&nbsp;' . __( 'and tagged' ) . ' ', ', ', ''); ?> <?php edit_post_link(__('Edit'), ' &#124; ', ''); ?></p>

<div class="entry"><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280graphite"); } ?>
<?php the_content(); ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280graphite"); } ?>
<?php link_pages('<p><strong>'.__('Pages').':</strong> ', '</p>', 'number'); ?>
</div><!-- entry -->

</div><!-- post -->

<?php endwhile; ?>

<div id="comments-template">
<?php comments_template(); ?>
</div>

<div class="navigation">
<span class="previous"><?php previous_post_link('&laquo; %link'); ?></span>
<span class="next"><?php next_post_link(' %link &raquo;'); ?></span>
</div>

<?php endif; ?>

<?php get_footer(); ?>