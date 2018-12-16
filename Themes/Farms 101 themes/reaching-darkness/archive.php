<?php get_header(); ?>
<?php if (is_archive()) { $posts = query_posts($query_string . '&orderby=date&showposts=-1'); } ?>
<?php /* If this is a category archive */ if (is_category()) { ?>
<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
<h2 class="post-title"><span><?php _e('Archive for');?>
    <?php the_time(__('F jS, Y')); ?></span></h2>
<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
<h2 class="post-title"><span><?php _e('Archive for');?>
    <?php the_time('F Y'); ?></span></h2>
<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
<h2 class="post-title"><span><?php _e('Archive for');?>
    <?php the_time('Y'); ?></span></h2>
<?php /* If this is a search */ } elseif (is_search()) { ?>
<h2 class="post-title"><span><?php _e('Search Results');?></span></h2>
<?php /* If this is an author archive */ } elseif (is_author()) { ?>
<h2 class="post-title"><span><?php _e('Author Archive');?></span></h2>
<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
<h2 class="post-title"><span><?php _e('Blog Archives');?></span></h2>
<?php } ?>
<?php if (have_posts()) : ?>
<div class="post">
<ul>
<?php while(have_posts()) : the_post(); ?>
<li>
<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280graphite"); } ?>
<?php comments_popup_link('(0)', '(1)', '(%)')?><br />
<small><?php _e('Posted on'); ?> <?php the_time('F j, Y g:i A') ?></small><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280graphite"); } ?>
</li>
<?php endwhile; ?>
</ul>
</div>

<?php else : ?>
<div class="entry">
<p><b><?php _e('Not Found');?></b></p>
<?php include (TEMPLATEPATH . '/searchform.php'); ?>
</div>
<?php endif; ?>

<?php get_footer(); ?>