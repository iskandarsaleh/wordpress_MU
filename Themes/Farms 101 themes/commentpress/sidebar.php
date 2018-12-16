<div id="container_sidebar"> 
<?php if ( !function_exists('dynamic_sidebar')|| !dynamic_sidebar() ) : ?>
	<div class="sidebarSection"> 
		<h3 class="sansLight">Also See</h3> 
		<ul class="sidebarList"> 
			<? $siteurl = get_settings('siteurl');; ?>
			<li><a href="<?= $siteurl."/comments-by-user" ?>" class="sidebarLink">by commenter</a></li> 
			<li><a href="<?= $siteurl."/comments-by-section" ?>" class="sidebarLink">by section</a></li> 
			<li><a href="<?= $siteurl."/general-comments" ?>" class="sidebarLink">general comments</a></li> 
		</ul> 
	</div> 
	<div class="sidebarSection"> 
		<h3 class="sansLight">Recent Posts</h3> 
		<ul class="sidebarList"> 
		 <?php
			 $myposts = get_posts('numberposts=10');
			 foreach($myposts as $post) :
			 ?>
			 <li class="sidebarLink"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
		 <?php endforeach; ?>
		</ul> 
	</div> 
<?php endif; ?>
</div> 