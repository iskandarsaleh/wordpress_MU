<div class="footertext">

<?php $current_site = get_current_site(); ?>
<a href="http://<?php echo $current_site->domain . $current_site->path ?>"><?php echo $current_site->site_name ?></a>
		<br /><?php _e('Powered by');?> <a href="http://mu.wordpress.org">WordPress MU</a><br /> &amp; <?php _e('designed by');?> <a href="http://justagirlintheworld.com">Lisa Sabin</a> &#8226; <a href="http://ewebscapes.com">E.Webscapes</a>. Powered by <a href="http://wordpressmu.org">WordPress MU</a>.<br />
		<?php do_action('wp_footer'); ?>

</div>
