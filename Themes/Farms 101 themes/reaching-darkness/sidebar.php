<!-- BEGIN SIDEBAR.PHP -->

<?php rewind_posts(); ?>
<div class="menu">
<h2 class="menu-header"><?php _e('Previous Entries'); ?></h2>
<ul>
<!-- YOU CAN CHANGE THE NUMBER OF POSTS TO BE SHOWN OR WHERE THEY SHOULD START (OFFSET) -->
<?php $posts = get_posts('numberposts=4&offset=0'); foreach ($posts as $post): setup_postdata($post); ?>
<li><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?><br />
<span><?php the_time(__('F jS, Y')) ?> 
(<?php comments_number(__('No Comments'), __('1 Comment'), __('% Comments')); ?>)</span>
</a></li>
<?php endforeach; ?>
<!-- T0 ADD AN ARCHIVES LINK, JUST UNCOMMENT THIS & CHANGE THE PERMALINK NUMBER 
<li class="archives"><a href="<?php echo get_permalink(47); ?>" title="<?php _e('Archives'); ?>"><?php _e('Archives'); ?></a></li>
-->
</ul>
</div>

<div id="search">
<?php include (TEMPLATEPATH . '/searchform.php'); ?>
</div>

<!-- END SIDEBAR.PHP -->