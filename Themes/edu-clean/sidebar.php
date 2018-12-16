<div id="sidebar">

<ul class="sidebar_list">

<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(3) ) : ?>

<li>
<h3>Sidebar Widget</h3>
<ul>
<li>
<?php _e('Please log in and add widgets to this sidebar'); ?>&nbsp;&nbsp;<a href="<?php echo get_option('siteurl') ?>/wp-admin/widgets.php?s=&amp;show=&amp;sidebar=sidebar-2">
<?php _e( 'Add Widgets') ?></a>
</li>
</ul>
</li>


<?php endif; ?>

</ul>

</div>