<div id="foot"><br /><form id="searchform" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<div>
 <input type="text" name="s" id="search" size="15" />
 <input type="submit" id="searchbutton" value="<?php _e('search'); ?>" />
</div>
<span class="credit"><?php echo $wpdb->num_queries; ?> <?php _e('queries');?>. <?php timer_stop(1); ?> <?php _e('seconds');?>.<br/>
<?php _e('Powered by');?> <a href="http://www.wordpress.org">wordpress</a> 
<?php bloginfo('version'); ?>
| theme by <a href="http://www.tonystreet.com" target="_blank">tony</a> modified 
by <a href="http://www.kupywrestlingwallpapers.info">mr. kupy</a> | <a href="http://www.pinkseo.info/ituloy-angsulong">Ituloy Angsulong</a><a href="http://www.guitarchic.net">!</a>. Powered by <a href="http://wordpressmu.org">WordPress MU</a>.</span> 

<?php do_action('wp_footer'); ?>


<!-- End of StatCounter Code -->