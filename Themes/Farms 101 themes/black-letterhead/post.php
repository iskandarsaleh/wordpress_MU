<div class="post">

<h2 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title();?>"><?php the_title(); ?></a></h2>

<small><?php printf(__('Posted in %s %s on %s by %s'), get_the_category_list(', '), get_the_tag_list(__('with tags '), ', ', ' '), get_the_time(get_option('date_format')), get_the_author()); ?></small>

<div class="entry">

<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280ink"); } ?>

<?php the_content(__('Read more &raquo;')); ?></div>

<p class="postmetadata"><?php edit_post_link(__('Edit'),'',' | '); ?><?php comments_popup_link(' '.__('Leave A Comment &#187;'), __('1 Comment &#187;'), __('% Comments &#187;')); ?></p>
<?php trackback_rdf(); ?>

</div>
