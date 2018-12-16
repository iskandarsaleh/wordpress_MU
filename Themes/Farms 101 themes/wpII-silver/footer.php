</div>
<div id="footer"><?php echo date('Y');?> &copy; <?php bloginfo('name'); ?> is proudly using the <a href="http://patrick.bloggles.info">WordPress II Silver</a> theme. Powered by <a href="http://wordpressmu.org">WordPress MU</a>. <?php _e('Powered by');?> <a href="http://wordpress.org/">Wordpress</a>
<br /><a href="<?php bloginfo('rss2_url'); ?>"><?php _e('Entries (RSS)');?></a>
		<?php _e('and ');?> <a href="<?php bloginfo('comments_rss2_url'); ?>"><?php _e('Comments (RSS)');?></a>.
<!-- <?php echo get_num_queries(); ?> <?php _e('queries');?>. <?php timer_stop(1); ?> <?php _e('seconds');?>. -->
</div>
<?php wp_footer(); ?>
</body>
</html>