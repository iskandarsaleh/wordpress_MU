<hr />
<div id="footer">
	<p>
			<?php $current_site = get_current_site(); ?>
<a href="http://<?php echo $current_site->domain . $current_site->path ?>"><?php echo $current_site->site_name ?></a>
		<br /><?php _e('Powered by');?> <a href="http://mu.wordpress.org">WordPress MU</a> &amp; <?php _e('designed by');?> <a href="http://www.nikynik.com/wpstyles">NikyNik WpStyles</a>. Powered by <a href="http://wordpressmu.org">WordPress MU</a>.
	
	</p>
</div>
</div>

<!-- Gorgeous design by Michael Heilemann - http://binarybonsai.com/kubrick/ -->
<?php /* "Just what do you think you're doing Dave?" */ ?>
<?php do_action('wp_footer'); ?>

</body>
</html>
