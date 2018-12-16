</div>
</div>

</div>


<div id="footer">
<div class="footer-inner">
<div class="footer-inner-class">

<div class="fbox">
<?php if ( !function_exists('dynamic_sidebar')
|| !dynamic_sidebar('footer-left') ) : ?>

<div id="text" class="widget widget_text">
<h2 class="widgettitle"><?php _e( 'Footer Left Widget', 'buddypress' ) ?>  </h2>
<div class="textwidget">
<?php _e( 'Please log in and add widgets to this footer.', 'buddypress' ) ?>
&nbsp;<a href="<?php echo get_option('siteurl') ?>/wp-admin/widgets.php?s=&amp;show=&amp;sidebar=sidebar-5"><?php _e( 'Add Widgets', 'buddypress' ) ?></a>
</div>
</div>

<?php endif; ?>
</div>


<div class="fbox">
<?php if ( !function_exists('dynamic_sidebar')
|| !dynamic_sidebar('footer-center') ) : ?>

<div id="text" class="widget widget_text">
<h2 class="widgettitle"><?php _e( 'Footer Center Widget', 'buddypress' ) ?>  </h2>
<div class="textwidget">
<?php _e( 'Please log in and add widgets to this footer.', 'buddypress' ) ?>
&nbsp;<a href="<?php echo get_option('siteurl') ?>/wp-admin/widgets.php?s=&amp;show=&amp;sidebar=sidebar-6"><?php _e( 'Add Widgets', 'buddypress' ) ?></a>
</div>
</div>

<?php endif; ?>
</div>


<div class="fbox">
<?php if ( !function_exists('dynamic_sidebar')
|| !dynamic_sidebar('footer-right') ) : ?>

<div id="text" class="widget widget_text">
<h2 class="widgettitle"><?php _e( 'Footer Right Widget', 'buddypress' ) ?>  </h2>
<div class="textwidget">
<?php _e( 'Please log in and add widgets to this footer.', 'buddypress' ) ?>
&nbsp;<a href="<?php echo get_option('siteurl') ?>/wp-admin/widgets.php?s=&amp;show=&amp;sidebar=sidebar-7"><?php _e( 'Add Widgets', 'buddypress' ) ?></a>
</div>
</div>

<?php endif; ?>
</div>




</div>


<div id="footer-cb" class="footer-inner-class">

<div class="alignleft">&copy;<?php echo gmdate(__('Y')); ?> <a href="<?php echo get_settings('home'); ?>"><?php bloginfo('name'); ?></a><br /><?php wp_footer(); ?></div>

<div class="alignright"><a title="BuddyPress Corporate theme by WPMU Dev" href="http://premium.wpmudev.org/themes/">BuddyPress Corporate</a> theme by <a title="Premium Resources for WordPress MU" href="http://premium.wpmudev.org/">Premium WPMU Dev</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="#top-header"><?php _e('Go back to top &uarr;'); ?></a></div> 


</div>
</div>
</div>

</body>
</html>
