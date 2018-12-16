<?php get_header(); ?>

<div id="main">
<h2></h2><br />

<div class="archive_title"><?php _e('Error 404');?>- <?php _e('File not Found');?>!</div>

<div class="main_post">
You are <em>totally</em> in the wrong place. Do not pass GO; do not collect $200.<br />
Instead, try one of the following:
<ul>
<li>Hit the "back" button on your browser.</li>
<li>Head on over to the <a href="<?php bloginfo('url'); ?>">front page</a>.</li>
<li>Try searching using the form below.</li>
<li>Click on a link in the sidebar.</li>
<li>Use the navigation menu at the top of the page.</li>
<li>Punt.</li>
</ul><br /><br />

Searching for something in particular?  Enter your keywords below:
<form method="get" action="<?php echo $PHP_SELF; ?>" />
<input type="text" name="s" id="s" />&nbsp;&nbsp;
<input type="submit" id="button" name="submit" value="Go!" />
</form><br /></div>


</div> 


<div id="menu">
<?php get_sidebar(); ?>
</div>

</div>
<div class="clearfix"></div>
<div id="footer"><?php get_footer(); ?></div>
</div>

</body>
</html>