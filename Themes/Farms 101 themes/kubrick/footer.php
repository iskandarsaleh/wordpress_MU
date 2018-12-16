
<?php $current_site = get_current_site(); ?>
<hr />
<div id="footer">
<!-- If you'd like to support WordPress, having the "powered by" link somewhere on your blog is the best way; it's our only promotion or advertising. -->
	<p>
		<a href="<?php bloginfo('rss2_url'); ?>"><?php _e('Entries (RSS)');?></a>
		<?php _e('and ');?> <a href="<?php bloginfo('comments_rss2_url'); ?>"><?php _e('Comments (RSS)');?></a>.<br />
		 Powered by <a href="http://wordpressmu.org">WordPress MU</a>.
		<!-- <?php echo get_num_queries(); ?> <?php _e('queries');?>. <?php timer_stop(1); ?> <?php _e('seconds');?>. -->
	</p>
</div>
</div>

<!-- Gorgeous design by Michael Heilemann - http://binarybonsai.com/kubrick/ -->
<?php /* "Just what do you think you're doing Dave?" */ ?>

		<?php wp_footer(); ?>
</body>
</html>
