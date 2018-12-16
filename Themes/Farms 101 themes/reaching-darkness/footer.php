<!-- BEGIN FOOTER.PHP -->

</div><!-- content -->

<div id="sidebar">
<?php get_sidebar(); ?>
</div>

<div id="sidebar2">
<?php include (TEMPLATEPATH . '/sidebar2.php'); ?>
</div>

<div id="sidebar3">
<?php include (TEMPLATEPATH . '/sidebar3.php'); ?>
</div>

<div id="sidebar4">
<?php include (TEMPLATEPATH . '/sidebar4.php'); ?>
</div>

<div id="footer">
<p>
Copyright &#169; <?php print(date(Y)); ?> <a href="<?php bloginfo('url'); ?>"><span><?php bloginfo('name'); ?></span></a>
<br />
Design by <a href="http://justintadlock.com" title="Justin Tadlock's Website"> Justin Tadlock</a>. Powered by <a href="http://wordpressmu.org">WordPress MU</a>.
</p>
<p class="wordpress">
<a href="http://wordpress.org/" title="<?php _e('Powered by WordPress, state-of-the-art semantic personal publishing platform.');?>"><span> WordPress</span></a>
</p>
</div>

</div><!-- container -->
</div><!-- body-container -->
</body>
<?php wp_footer(); ?>
</html>