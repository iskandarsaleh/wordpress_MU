<?php /*
Template Name: Tags (Don't use here)
This is an example tag archive page.  If you add this to your theme,  
and create a page using the "Tag Archive" template (it'll be there in the list)
you'll get a tag cloud displaying on a page.

You might need to tinker with the header/sidebar/footer to match your theme!
*/ ?>

<?php get_header(); ?>

	<div id="content" class="tags_page">
	
		<h2>Tag Cloud</h2>
		
			<?php if (get_option('dd_tags_desc') == "yes") { ?>
			
				<p>A tag cloud (more traditionally known as a weighted list in the field of visual design) 
				is a visual depiction of content tags used on this blog.</p>
			
			<?php } ?>
		
			<div id="tagcloud">
		
				<?php UTW_ShowWeightedTagSetAlphabetical("coloredsizedtagcloud","",0) ?>
			
			</div>
	
	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>