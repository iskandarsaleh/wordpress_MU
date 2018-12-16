<?php get_header(); ?>

<div id="post-entry">
	

<div <?php if(function_exists("post_class")) : ?><?php post_class(); ?><?php else: ?>class="post"<?php endif; ?> id="post-<?php the_ID(); ?>">


<div class="register bp_core_widget_welcome">
<h2 class="widgettitle"><?php _e( 'Activate your Account', 'buddypress' ) ?></h2>
<?php bp_core_activation_do_activation() ?>
</div>


</div>

</div>

<?php get_sidebar(); ?>


<?php get_footer(); ?>
