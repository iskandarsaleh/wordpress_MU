<?php 
	get_header(); 
	$homelink = get_settings('home');

?>

<!-- BEGIN PAGE CONTAINER -->
<div id="pageContainer"> 

	<div id="pages_leftCol" style="width: 600px;">

<div id="static_content"> 
<?php 
    	if (have_posts()) :
?> 
	<br/><br/>
	<h2><?php _e('Search Results');?></h2> 
	<p>for term <i><?php echo $_GET[s] ?></i>
	<br />
  	<!--<div class="navigation" style="width: 585px; border-bottom: 1px solid #ff0099;"> -->
		<div class="text2" style="padding-bottom: 5px;"><?php previous_posts_link(__('&laquo; Previous Entries'))?> <? if($_GET['paged'] > 1) {echo "||"; } ?> <?php next_posts_link(__('Next Entries &raquo;')) ?></div> 
   	</div> 
  	<div class="static_post"> 
    <?php while (have_posts()) : the_post(); ?> 
     	<div class="searchresults"> 
			<h3><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>"> 
			<?php the_title(); ?></a></h3> 
			<div class="smLight" style="margin: .5em 0;"><?php the_time('l, F jS, Y') ?></div> 
			<div class="text2"><?php the_excerpt(); ?></div> 
		  
			<!--<p class="text3"><?php the_category(', ') ?> 		
			</p>-->
		</div> 
    <?php endwhile; ?>
  	 
    </div>
	<br />
</div>

<?php else : ?> 
<h2 class="center"><?php _e('No posts found. Try a different search?');?></h2> <br><br>
</div>
<div style="margin:auto; height: 350px;">
    <form method="get" action="<?= get_settings('siteurl'); ?>/?order=asc"> 
      <input type="text" value="search" name="s" id="s" style="font-size: 9pt; color: #888888; width: 150px;" onFocus="this.value=''" /> <input type="hidden" value="asc" name="order">
    </form> 
  </div> 
<?php endif; ?> 
</div>


<?php get_footer(); ?> 

 