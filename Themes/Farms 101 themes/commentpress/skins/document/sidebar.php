<ul class="sidebar" id="widgetSidebar1"> 
<?php if ( !function_exists('dynamic_sidebar')|| !dynamic_sidebar('widgets1') ) : ?>
	<li class="section"> 
		<h3 class="sansRed">Browse Comments</h3> 
		<ul class="sidebarList"> 
			<? $siteurl = get_settings('siteurl'); ?>
			<li><a href="<?= $siteurl."/comments-by-user" ?>" class="sidebarLink">by Commenter</a></li> 
			<li><a href="<?= $siteurl."/comments-by-section" ?>" class="sidebarLink">by Section</a></li> 
			<li><a href="<?= $siteurl."/general-comments" ?>" class="sidebarLink">General Comments</a></li>
		</ul> 
	</li> 
	<li class="section"> 
		<h3 class="sansRed">Contents</h3> 
		<ul class="sidebarList"> 
		 <?php
			 $myposts = get_posts("numberposts=-1&order=ASC");
			 foreach($myposts as $post) :
			 ?>
			 <li class="sidebarLink"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
		 <?php endforeach; ?>
		</ul> 
	</li> 
	<li class="section">
	<h3 class="sansRed">Recent Comments</h3> 
		<ul class="sidebarList"> 
			<?php $recent_comments = getRecentComments();

				foreach($recent_comments as $c){
				?>
				<li class="sidebarLink"><a href="<?= get_permalink($c->comment_post_ID); ?>#<?= $c->comment_contentIndex; ?>"><?php echo $c->post_title."</a><br /><i>".$c->comment_author; ?> <?php _e('says');?>: </i><?php echo (strlen($c->comment_content) > 90) ? substr(strip_tags($c->comment_content),0 , 90) . "<a href=\"".get_permalink($c->comment_post_ID)."#". $c->comment_contentIndex."\">[...]</a>" : strip_tags($c->comment_content); ?></li>
				<?php } ?>
		</ul>
	</li>
	<li class="section">
	<h3 class="sansRed">Links</h3> 
		<ul class="sidebarList"> 
<?php get_links('-1', '<li>', '</li>', '', FALSE, 'name', FALSE, 
FALSE, -1, FALSE, TRUE); ?>
		</ul>
	</li>
	<? endif; /*end of default sidebar (no widgets) */ ?>
</ul> 
