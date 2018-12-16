<?php get_header(); ?>

<?php if(have_posts()) : ?>
<div class="post">
<ol>
<?php while(have_posts()) : the_post(); ?>
<li>
<strong><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
<?php comments_popup_link('(0)', '(1)', '(%)')?></strong><br />
<small><?php _e('Posted on'); ?> <?php the_time('F j, Y g:i A') ?></small>
<div><?php the_excerpt(); ?></div>
</li>
<?php endwhile; ?>
</ul>
</div>

<div class="navigation">
<?php posts_nav_link(" | ","<span>&laquo; Previous</span>","<span>Next &raquo;</span>"); ?>
</div>

<?php else : ?>
<div class="post">
<h2><?php _e('Not Found'); ?></h2>
<div class="entry">
<p><?php _e('Sorry, but you are looking for something that isn&#39;t here.'); ?></p>
<?php include (TEMPLATEPATH . '/searchform.php'); ?>
</div>
</div>

<?php endif; ?>

<?php get_footer(); ?>