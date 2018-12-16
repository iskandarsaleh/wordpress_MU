<!-- begin footer -->

<div style="clear:both;"></div>
<div style="clear:both;"></div>

<div id="footerbg">
<div id="footer">

	<div id="footerleft">
		<h2>Recently Written</h2>
			<ul>
				<?php get_archives('postbypost', 8); ?>
			</ul>
	</div>
	
	<div id="footermiddle1">
		<h2><?php _e('Monthly Archives');?></h2>
			<ul>
				<?php wp_get_archives('type=monthly&limit=8'); ?>
			</ul><br />
	</div>
	
	<div id="footermiddle2">
		<h2><?php _e('Blogroll');?></h2>
			<ul>
				 <?php wp_list_bookmarks('limit=4'); ?> 
			</ul>
	</div>
	
	<div id="footerright">
		<h2>Find It</h2>
	   		<form id="searchform" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	   		<input type="text" value="To search, type and hit enter..." name="s" id="s" onfocus="if (this.value == 'To search, type and hit enter...') {this.value = '';}" onblur="if (this.value == '') {this.value = 'To search, type and hit enter...';}" />
			</form>
		
		<h2>Admin</h2>
			<ul>
				<?php wp_register(); ?>
				<li><?php wp_loginout(); ?></li>
				<li><a href="http://wordpress.org/">WordPress</a></li>
				<?php wp_meta(); ?>
				<li><a href="http://validator.w3.org/check?uri=referer">XHTML</a></li>
			</ul>
			
		<h2>Credits</h2>
			<p><a href="http://www.briangardner.com/themes/vertigo-wordpress-theme.htm" >Vertigo Theme</a> by <a href="http://www.briangardner.com" >Brian Gardner</a>.<br /><?php _e('Powered by');?> <a href="http://wordpress.org">WordPress</a>. Powered by <a href="http://wordpressmu.org">WordPress MU</a>.</p>
		</div>
	
</div>

<div id="footerbottom">
</div>

</div>

<?php do_action('wp_footer'); ?>

</body>
</html>