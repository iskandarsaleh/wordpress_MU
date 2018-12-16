<?php get_header(); ?>
<h2 class="post-title"><?php single_cat_title('Archive For '); ?></h2>
<?php if (is_category()) { $posts = query_posts($query_string . '&orderby=date&showposts=-1'); } ?> 
<?php if(have_posts()) : ?>
<div class="post">
<ul>
<?php while(have_posts()) : the_post(); ?>
<li>
<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
<?php comments_popup_link('(0)', '(1)', '(%)')?><br />
<small><?php _e('Posted on'); ?> <?php the_time('F j, Y g:i A') ?></small>
</li>
<?php endwhile; ?>
</ul>
</div>

<?php else : ?>
<p><b><?php _e('Not Found');?></b></p>
<?php include (TEMPLATEPATH . '/searchform.php'); ?>
<?php endif; ?>

<?php get_footer(); ?>