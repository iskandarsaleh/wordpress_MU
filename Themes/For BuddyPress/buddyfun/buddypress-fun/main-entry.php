<div id="main-entry">
<div class="main-post">

<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); $bcc == 0; $the_post_ids = get_the_ID(); ?>
<?php if ($bcc < 1) { ?>

<?php dez_get_images($the_post_id = $the_post_ids); ?>

<h1><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1>

<div class="post-author"><?php _e('by'); ?> <?php the_author_posts_link(); ?> <?php _e('on'); ?> <?php the_time('jS F Y') ?> </div>

<div class="post-content"><?php the_excerpt_feature_main(); ?></div>

</div>

<div class="alt-post">
<h3><?php _e( 'More articles &raquo;', 'buddypress' ) ?></h3>
<ul>

<?php } else { ?>

<li>
<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a>
<br /><small><?php _e('in'); ?> <?php the_category(', '); ?></small>
</li>

<?php } ?>

<?php $bcc++; ?>

<?php endwhile; ?>

</ul>

<?php endif; ?>

</div>

</div>