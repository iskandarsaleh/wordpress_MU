<?php get_header(); ?>

<div id="main">

<h1 class="main_title">Error - <?php _e('Page not found')?></h1>
Searching for something in particular?  Enter your keywords below:
<form id="searchform" method="get" action="<?php echo $PHP_SELF; ?>">
<input type="text" name="s" id="s" size="15" />&nbsp;<input type="submit" id="b" name="submit" value="<?php _e('Go!'); ?>" />
</form><br />


</div> 


<div id="sidebar">
<?php get_sidebar(); ?>
</div>

</div>
<div id="frame2"><div id="footer"><?php get_footer(); ?></div></div>
</div>

</body>
</html>
