<?php get_header(); ?>

<div id="post-entry">

<?php include (TEMPLATEPATH . '/main-entry.php'); ?>


<div class="ad-spot"></div>


<div id="bottom-entry">


<div class="bpside" id="left-column">

<?php if ( !function_exists('dynamic_sidebar')
|| !dynamic_sidebar('left-column') ) : ?>

<div id="text" class="widget widget_text">
<h2 class="widgettitle"><?php _e('Left Column Widget'); ?></h2>
<div class="textwidget">
<?php _e( 'Please log in and add widgets to this column.', 'buddypress' ) ?>
&nbsp;<a href="<?php echo get_option('siteurl') ?>/wp-admin/widgets.php?s=&amp;show=&amp;sidebar=sidebar-1"><?php _e( 'Add Widgets', 'buddypress' ) ?></a>
</div>
</div>

<?php endif; ?>

</div>



<div class="bpside" id="right-column">

<?php if ( !function_exists('dynamic_sidebar')
|| !dynamic_sidebar('center-column') ) : ?>

<div id="text" class="widget widget_text">
<h2 class="widgettitle"><?php _e('Center Column Widget'); ?></h2>
<div class="textwidget">
<?php _e( 'Please log in and add widgets to this column.', 'buddypress' ) ?>
&nbsp;<a href="<?php echo get_option('siteurl') ?>/wp-admin/widgets.php?s=&amp;show=&amp;sidebar=sidebar-2"><?php _e( 'Add Widgets', 'buddypress' ) ?></a>
</div>
</div>

<?php endif; ?>

</div>



</div>
</div>

<?php include (TEMPLATEPATH . '/home-sidebar.php'); ?>

<?php get_footer(); ?>