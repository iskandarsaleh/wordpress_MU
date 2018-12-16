<hr />
<div id="footer">
	<p class="center">
		Powered by 
		<a href="http://wordpress.org">WordPress</a>. Powered by <a href="http://wordpressmu.org">WordPress MU</a>.<br>
		<!-- 
		<br /><a href="<?php bloginfo('rss2_url'); ?>"><?php _e('Entries (RSS)');?></a>
		<?php _e('and ');?> <a href="<?php bloginfo('comments_rss2_url'); ?>"><?php _e('Comments (RSS)');?></a>. 
		<?php echo $wpdb->num_queries; ?> <?php _e('queries');?>. -->
		<?php timer_stop(1); ?> <?php _e('seconds');?>. 
	</p>
</div>
</div>

<!-- Design by Robin Hastings - http://www.rhastings.net/ -->
<!-- Colors modified by Ulysses Ronquillo - http://ulyssesonline.com/ -->

		<?php do_action('wp_footer'); ?>

</body>
</html>