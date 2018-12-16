<div id="side-entry">
<div id="center-column">

<?php if ( !function_exists('dynamic_sidebar')
|| !dynamic_sidebar('center-column') ) : ?>

<div id="text" class="widget widget_text">
<h2 class="widgettitle"><?php _e( 'Center Column Widget', 'buddypress' ) ?></h2>
<div class="textwidget">
<?php _e( 'Please log in and add widgets to this column.', 'buddypress' ) ?>
&nbsp;<a href="<?php echo get_option('siteurl') ?>/wp-admin/widgets.php?s=&amp;show=&amp;sidebar=sidebar-2"><?php _e( 'Add Widgets', 'buddypress' ) ?></a>
</div>
</div>

<?php endif; ?>

</div>



<div id="right-column">

<?php if ( !function_exists('dynamic_sidebar')
|| !dynamic_sidebar('right-column') ) : ?>

<div id="text" class="widget widget_text">
<h2 class="widgettitle"><?php _e( 'Right Column Widget', 'buddypress' ) ?> </h2>
<div class="textwidget">
<?php _e( 'Please log in and add widgets to this column.', 'buddypress' ) ?>
&nbsp;<a href="<?php echo get_option('siteurl') ?>/wp-admin/widgets.php?s=&amp;show=&amp;sidebar=sidebar-3"><?php _e( 'Add Widgets', 'buddypress' ) ?></a>
</div>
</div>

<?php endif; ?>

</div>


</div>