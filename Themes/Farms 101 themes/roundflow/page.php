<?php get_header(); ?>

<div id="maincontent">
<?php if (have_posts()) : while(have_posts()) : the_post(); ?>
    <div class="post"><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("72890nocolor"); } ?>
        <h2 class="posttitle"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <p class="postinfo">Author: <?php the_author(); ?> - Date: <?php the_time(__('F jS, Y')) ?></p>
        <div class="postcontent"><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("72890nocolor"); } ?>
        <?php the_content(''); ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("72890nocolor"); } ?>
        </div>
    </div>
    <?php endwhile; endif; ?>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>