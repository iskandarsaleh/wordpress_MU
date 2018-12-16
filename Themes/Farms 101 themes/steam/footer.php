
<hr />
<div id="footer">
	<p>
		<?php bloginfo('name'); ?> is proudly powered by 
		<a href="http://wordpress.org">WordPress</a> and Powered by <a href="http://wordpressmu.org">WordPress MU</a>.
		<br /><a href="feed:<?php bloginfo('rss2_url'); ?>"><?php _e('Entries (RSS)');?></a>
		and <a href="feed:<?php bloginfo('comments_rss2_url'); ?>"><?php _e('Comments (RSS)');?></a>.
		<!-- <?php echo $wpdb->num_queries; ?> <?php _e('queries');?>. <?php timer_stop(1); ?> <?php _e('seconds');?>. -->
	</p>
</div>
</div>

<!--
	Gorgeous design by Samir M. Nassar - http://steamedpenguin.com/design/Steam/
	Based on Kubrick by Michael Heilemann - http://binarybonsai.com/kubrick/
-->
<?php /* "Just what do you think you're doing Dave?" */ ?>

		<?php do_action('wp_footer'); ?>

</body>
</html>