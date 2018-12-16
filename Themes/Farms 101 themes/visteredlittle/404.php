<?php get_header(); ?>
<?php get_sidebar(); ?>

<div id="contentcontainer">

<div class="blogbefore">
    	<div class="left"></div>
    	<div class="right"></div>
    	<div class="middle"></div>
</div>
<div class="post">
<h1><?php _e('Page not found', VL_DOMAIN); ?></h1>
<div class="headertext"><?php _e('You have reached a non-existant url. This address is either outdated or incorrectly linked.', VL_DOMAIN); ?></div>
<p><?php

function selfURL() { $s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : ""; $protocol = strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s; $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]); return $protocol."://".$_SERVER['HTTP_HOST'].$port.$_SERVER['REQUEST_URI']; } function strleft($s1, $s2) { return substr($s1, 0, strpos($s1, $s2)); }

print( htmlspecialchars(selfURL()));

?></p>

</div>
<div class="blogafter">
    	<div class="left"></div>
    	<div class="right"></div>
    	<div class="middle"></div>
</div>


<?php get_footer(); ?>
