	<div id="footer">
		<p>
			<?php $current_site = get_current_site(); ?>
<a href="http://<?php echo $current_site->domain . $current_site->path ?>"><?php echo $current_site->site_name ?></a>
		<br /><?php _e('Powered by');?> <a href="http://mu.wordpress.org">WordPress MU</a> &amp; <?php _e('designed by');?> <a href="http://www.fightingfriends.com">Jim Whimpey</a>. Powered by <a href="http://wordpressmu.org">WordPress MU</a>.
			
		</p>
	</div>
</div>
<?php wp_footer(); ?>
</body>
</html>
