<!-- begin footer -->

<?php get_sidebar(); ?>

<p id="credits">
<?php _e('Powered by');?> <a href="http://wordpress.org">WordPress</a> with <a href="http://www.lamateporunyogur.net/pool" title="Pool Theme for Wordpress, download it">Pool theme</a> design by <a href="http://www.lamateporunyogur.net/">Borja Fernandez</a>. Powered by <a href="http://wordpressmu.org">WordPress MU</a>. <br />

<a href="<?php bloginfo('rss2_url'); ?>"><?php _e('Entries');?></a> <?php _e('and ');?> <a href="<?php bloginfo('comments_rss2_url'); ?>"><?php _e('comments');?></a> feeds. 
Valid <a href="http://validator.w3.org/check/referer">XHTML</a> and <a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a>.  ^<a href="#">Top</a>^<br />

<!-- <?php echo $wpdb->num_queries; ?> <?php _e('queries');?>. <?php timer_stop(1); ?> <?php _e('seconds');?>. -->
</p>

</div>

<?php do_action('wp_footer'); ?>
</body>
</html>

