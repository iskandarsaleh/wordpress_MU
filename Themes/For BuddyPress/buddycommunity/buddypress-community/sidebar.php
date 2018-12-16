<div id="sidebar">

<div id="right-column" class="bpside">


<?php if ( !function_exists('dynamic_sidebar')
|| !dynamic_sidebar('blog-sidebar') ) : ?>

<div id="text" class="widget widget_text">
<h2 class="widgettitle"><?php _e( 'Sidebar Widget', 'buddypress' ) ?></h2>
<div class="textwidget">
<?php _e( 'Please log in and add widgets to this sidebar.', 'buddypress' ) ?>
&nbsp;<a href="<?php echo get_option('siteurl') ?>/wp-admin/widgets.php?s=&amp;show=&amp;sidebar=sidebar-4"><?php _e( 'Add Widgets', 'buddypress' ) ?></a>
</div>
</div>

<?php endif; ?>


</div>
</div>