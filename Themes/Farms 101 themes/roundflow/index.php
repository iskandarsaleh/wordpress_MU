<?php get_header(); ?>

<div id="maincontent">
<?php if (have_posts()) : while(have_posts()) : the_post(); ?>
    <div class="post"><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("72890nocolor"); } ?>
        <h2 class="posttitle"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <p class="postinfo"><a href="<?php the_permalink(); ?>"><?php comments_number('Comments: 0', 'Comments: 1', 'Comments: %'); ?></a> - Date: <?php the_time(__('F jS, Y')) ?> - Categories: <?php the_category(', ') ?><?php the_tags( '&nbsp;' . __( 'Tagged:' ) . ' ', ', ', ''); ?></p>
        <div class="postcontent"><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("72890nocolor"); } ?>
        <?php the_content(''); ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("72890nocolor"); } ?>
        </div>
    </div>
    <?php endwhile; else: ?>
    <div class="post">
        <h2 class="posttitle">No posts found</h2>
        <p class="postinfo">&nbsp;</p>
	<div class="postcontent"><p>No posts were found matching your criteria</p></div>
    </div>

<?php endif; ?>


<div class="post"><div class="postcontent"><p class="pagenav"><?php posts_nav_link(); ?></p></div></div>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>