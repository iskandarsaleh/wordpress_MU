</div> <!-- #content -->





<?php


// This code pulls in the sidebar:


include(get_template_directory() . '/sidebar.php');


?>


<div style="clear:both;height:1px;"> </div>


</div><!-- #wrap -->





<p class="credit"><!--<?php echo $wpdb->num_queries; ?> <?php _e('queries');?>. <?php timer_stop(1); ?> <?php _e('seconds');?>. --> <cite><?php echo sprintf(__("Powered by <a href='http://wordpress.org' title='%s'><strong>WordPress</strong></a>"), __("Powered by WordPress, state-of-the-art semantic personal publishing platform.")); ?> Powered by <a href="http://wordpressmu.org">WordPress MU</a>.</cite></p><?php do_action('wp_footer', ''); ?>





</body>


</html>