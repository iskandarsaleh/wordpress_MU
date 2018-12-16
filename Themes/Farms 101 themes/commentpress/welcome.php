<!-- START THE PAGE -->
<!-- already in pageContainer -->
<div id="pages_leftCol"> 
<div class="post" id="post-<?php the_ID(); ?>"> 
	<h2><?php the_title(); ?></h2> 
	<div class="entrytext"> 
		<?php the_content(__('<p class="serif">Read the rest of this page &raquo;</p>')); ?> 
		<?php link_pages(__('<p><strong>Pages:</strong> '), '</p>', 'number'); ?> 
		<!-- END entrytext --> 
	</div> 
<!-- end pages_leftCol -->
</div>

<div id="pages_rightCol">

<!-- end pages_rightCol --> 
</div> 
