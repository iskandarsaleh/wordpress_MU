	<hr />
	<div id="footer">
	<!-- If you'd like to support WordPress, having the "powered by" link someone on your blog is the best way, it's our only promotion or advertising. -->
		<p>
			<?php $current_site = get_current_site(); ?>
			<a href="http://<?php echo $current_site->domain . $current_site->path ?>"><?php echo $current_site->site_name ?></a> - <?php _e('Powered by');?> <a href='http://mu.wordpress.org'>WordPress MU</a> &amp; <?php _e('designed by');?> <a href="http://www.adityanaik.com/">Aditya Naik</a>.  Powered by <a href="http://wordpressmu.org">WordPress MU</a>.
			<br /><a href="feed:<?php bloginfo('rss2_url'); ?>"><?php _e('Entries (RSS)');?></a>
			and <a href="feed:<?php bloginfo('comments_rss2_url'); ?>"><?php _e('Comments (RSS)');?></a>.
			<!-- <?php echo get_num_queries(); ?> <?php _e('queries');?>. <?php timer_stop(1); ?> <?php _e('seconds');?>. -->
		</p>
	</div>
</div>
</div>

		<?php wp_footer(); ?>
		<!-- jaanu mei jaan -->
</body>
</html>
