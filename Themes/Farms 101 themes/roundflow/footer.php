<div id="footer">&nbsp;&nbsp;
<?php $current_site = get_current_site(); ?>
<small><a href="http://<?php echo $current_site->domain . $current_site->path ?>"><?php echo $current_site->site_name ?></a> - <?php _e('Powered by');?> <a href="http://mu.wordpress.org">WordPress MU</a> &amp; <?php _e('designed by');?> <a href="http://theundersigned.net">the undersigned</a>. Powered by <a href="http://wordpressmu.org">WordPress MU</a>.</small>
<?php do_action('wp_footer'); ?>

</div>

</div>
</body>
</html>
