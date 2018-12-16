<!-- begin footer -->
</div>

<?php get_sidebar(); ?>

<p class="credit"><!--<?php echo $wpdb->num_queries; ?> <?php _e('queries');?>.--> generiert in <?php timer_stop(1); ?> Sekunden. |  <cite><?php _e('Powered by');?> <a href='http://wordpress.org' title='%s'><strong>WordPress</strong></a> | Powered by <a href="http://wordpressmu.org">WordPress MU</a>.</cite></p>

</div>

<?php do_action('wp_footer'); ?>
</body>
</html>
