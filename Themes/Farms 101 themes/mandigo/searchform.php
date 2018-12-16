<?php 
	global $dirs;
?>
<form method="get" id="searchform" action="<?php bloginfo('home'); ?>/">
<div><input type="text" value="<?php echo wp_specialchars($s, 1); ?>" name="s" id="s" /> 
<input type="image" id="searchsubmit" src="<?php echo $dirs['www']['scheme']; ?>images/search.gif" onmouseover="hover(1,'searchsubmit','search');" onmouseout="hover(0,'searchsubmit','search')" />
</div>
</form>
