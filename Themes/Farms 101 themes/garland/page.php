<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<div class="post">

<h2><?php the_title(); ?></h2>
<span class="submitted"><?php the_time(get_option('date_format')) ?> &#8212; <?php the_author() ?> <?php edit_post_link('Edit', ' | ', ''); ?></span>

<div class="content">
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?><?php the_content('Read the rest of this entry &raquo;'); ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
<?php link_pages('<p><strong>Pages:</strong> ', '</p>', 'number'); ?>
</div>

<div class="meta">
<?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?>
</div>

</div>
<?php endwhile; endif; ?>

<?php if ( comments_open() ) comments_template(); ?>


<?php get_footer(); ?>
