<div id="main-column">

<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); $bcc == 0; ?>
<?php if ($bcc < 1) { ?>

<div id="main-news">
<p class="normal-class"><?php _e('From The Blog'); ?> - <?php the_category(', ') ?></p>
<h1><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1>
<p class="thenews"><?php the_excerpt_feature(); ?></p>
</div>

<div id="other-news">
<h2><?php _e('More News &raquo;'); ?></h2>
<ul>

<?php } else { ?>

<li><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></li>

<?php } ?>

<?php $bcc++; ?>

<?php endwhile; ?>

</ul>

<?php endif; ?>

</div>

</div>