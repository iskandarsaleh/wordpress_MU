	<div id="footer">
		
		
<?php $current_site = get_current_site(); ?>
<p><a href="http://<?php echo $current_site->domain . $current_site->path ?>"><?php echo $current_site->site_name ?></a></p>

		<p><?php _e('Powered by');?> <a href="http://mu.wordpress.org">WordPress WU</a> &amp; <?php _e('designed by');?> <a href="http://scottwallick.com/" title="scottwallick.com" rel="follow">Scott Allan Wallick</a>. Powered by <a href="http://wordpressmu.org">WordPress MU</a>.</p>
		
		<p>Valid <a href="http://validator.w3.org/check?uri=<?php echo get_settings('home'); ?>&amp;outline=1&amp;verbose=1" title="Valid XHTML 1.0 Strict" rel="nofollow">XHTML</a> &amp; <a href="http://jigsaw.w3.org/css-validator/validator?uri=<?php bloginfo('stylesheet_url'); ?>&amp;profile=css2&amp;warning=no" title="Valid CSS" rel="nofollow">CSS</a></p>
	
		<?php do_action('wp_footer'); ?>
	</div><!-- END FOOTER -->

<!-- The "Simpr" theme copyright (c) 2006 Scott Allan Wallick - http://www.plaintxt.org/themes/ -->

</div><!-- END CONTAINER -->
</body>
</html>
