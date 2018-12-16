<div id="footer">
  <?php $current_site = get_current_site(); ?>
  <p> <a href="http://<?php echo $current_site->domain . $current_site->path ?>"><?php echo $current_site->site_name ?></a>
	<br /><?php _e('Powered by');?> <a href="http://mu.wordpress.org">WordPress MU</a> &amp; <?php _e('designed by');?> <a href="http://vaguedream.com/wordpress-themes">Stephen Reinhardt</a>. Powered by <a href="http://wordpressmu.org">WordPress MU</a>.</p>
</div>
</div>
<?php do_action('wp_footer'); ?>
</body></html>
