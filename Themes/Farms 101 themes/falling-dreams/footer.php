<!-- begin footer --></div>
<?php 
get_sidebar();
?>
<!-- Please leave current credits intact and on display -->
<div id="footer"> 
  <?php _e('Powered by');?> <a href="http://wordpress.org">WordPress</a> with 
  Falling Dreams Theme design by <a href="http://teo.esuper.ro">Razvan Teodorescu</a>. Powered by <a href="http://wordpressmu.org">WordPress MU</a>. 
  <!-- <?php echo $wpdb->
  num_queries; ?> <?php _e('queries');?>. 
  <?php timer_stop(1); ?>
  seconds. --> </div>
<?php do_action('wp_footer'); ?>
</body>
</html>