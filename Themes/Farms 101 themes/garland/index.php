<?php get_header(); ?>

<?php is_tag(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<div class="post">

<h2><a href="<?php echo get_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
<span class="submitted"><?php the_time(get_option('date_format')) ?> &#8212; <?php the_author() ?> <?php edit_post_link(__('Edit'), ' | ', ''); ?></span>

<div class="content">
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?><?php the_content(__('Read the rest of this entry &raquo;')); ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
<?php link_pages('<p><strong>'.__('Pages:').'</strong> ', '</p>', 'number'); ?>
</div>

<div class="meta">
<?php _e('Posted in ');?> <?php the_category(', ') ?>. <?php if (is_callable('the_tags')) the_tags(__('Tags: '), ', ', '.'); ?> <?php comments_popup_link(__('No Comments &#187;'), __('1 Comment &#187;'), __('% Comments &#187;')); ?>
</div>

</div>
<?php endwhile; endif; ?>

<?php comments_template(); ?>

<div class="nextprev">
<div class="alignleft"><?php next_posts_link('&laquo; Older posts') ?> <?php previous_post_link('&laquo; %link') ?></div>
<div class="alignright"><?php previous_posts_link('Newer posts &raquo;') ?> <?php next_post_link('%link &raquo;') ?></div>
</div>

<?php get_footer(); ?>
