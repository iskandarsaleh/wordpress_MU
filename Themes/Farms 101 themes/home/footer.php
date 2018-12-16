
<?php $current_site = get_current_site(); ?>
<hr />
<div id="footer">
<!-- If you'd like to support WordPress, having the "powered by" link someone on your blog is the best way, it's our only promotion or advertising. -->
	<p>
		<a href="http://<?php echo $current_site->domain . $current_site->path ?>"><?php echo $current_site->site_name ?></a>
		<br /> Powered by <a href="http://wordpressmu.org">WordPress MU</a>. <?php _e('Powered by');?> <a href="http://wordpress.org">WordPress</a> & <?php _e('designed by');?> <a href="http://binarybonsai.com/kubrick/">Michael Heilemann</a>.<br / ><a href="<?php bloginfo('url'); ?>/wp-login.php">Log in as admin.</a>
		<!-- <?php echo get_num_queries(); ?> <?php _e('queries');?>. <?php timer_stop(1); ?> <?php _e('seconds');?>. -->
	</p>
</div>
</div>

<!-- Gorgeous design by Michael Heilemann - http://binarybonsai.com/kubrick/ -->
<?php /* "Just what do you think you're doing Dave?" */ ?>

		<?php wp_footer(); ?>
</body>
</html>
