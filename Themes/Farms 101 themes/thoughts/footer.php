<div class="footertext"><?php $current_site = get_current_site(); ?>
<a href="http://<?php echo $current_site->domain . $current_site->path ?>"><?php echo $current_site->site_name ?></a>
		<br />Designed by  <a href="http://justagirlintheworld.com">Lisa Sabin</a> &#8226; <a href="http://ewebscapes.com">E.Webscapes</a>. Powered by <a href="http://wordpressmu.org">WordPress MU</a>.<br / ><a href="<?php bloginfo('url'); ?>/wp-login.php">Log in to this blog</a><br />

<?php do_action('wp_footer'); ?>

</div>
</div>