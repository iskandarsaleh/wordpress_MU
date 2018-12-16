<?php get_header(); ?>

<!-- open wrapper --><div id="wrapper">

<!-- open content --><div id="content">

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<!-- open navigation --><div class="navigation">
<span class="alignleft">
<?php next_posts_link(__('Previous Entries')) ?>
</span>
<span class="alignright">
<?php previous_posts_link(__('Next Entries')) ?>
</span>
<!-- close navigation --></div>

<!-- open post --><div class="post" id="post-<?php the_ID(); ?>">

<!-- open date --><div class="date">
<span><?php the_time('M') ?></span> <?php the_time('d') ?>
<!-- close date --></div>

<!-- open title --><div class="title">
<h2>
<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>">
<?php the_title(); ?></a>
</h2>

<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("72890nocolor"); } ?>
<!-- open postdata --><div class="postdata">
<span class="category">
<?php _e('Posted in ');?> <?php the_category(' ') ?><?php the_tags( '&nbsp;' . __( 'Tagged' ) . ' ', ', ', ''); ?></span> 
<span class="right mini-add-comment">
<?php comments_popup_link(__('No Comments &#187;'), __('1 Comment &#187;'), __('% Comments &#187;')); ?></span>
<!-- close postdata --></div>
<!-- close title --></div>

<!-- open clearing --><div class="clearing"><!-- close clearing --></div>

<!-- open entry --><div class="entry">
<?php the_content(__('Read the rest of this entry &raquo;')); ?>
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("72890nocolor"); } ?>
<!-- close entry --></div>

<!-- close post --></div>

<!-- close content --></div>

<!-- close wrapper --></div>

<!-- close page --></div>

<?php comments_template(); ?>

<?php endwhile; else: ?>

<p><?php _e('Sorry, no posts matched your criteria.');?></p>

<?php endif; ?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>