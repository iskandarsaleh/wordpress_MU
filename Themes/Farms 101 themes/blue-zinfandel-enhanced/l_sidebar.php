<!-- begin l_sidebar -->





	<div id="l_sidebar">


	<ul id="l_sidebarwidgeted">


	<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(1) ) : else : ?>


	


	<li id="Recent">


	<h2><?php ('Recently Written');?></h2>


	<ul>


	<?php get_archives('postbypost', 10); ?>


	</ul>





	<li id="Categories">


	<h2><?php ('Categories');?></h2>


		<ul>


		<?php wp_list_cats('sort_column=name'); ?>


		</ul>


		


	<li id="Archives">


	<h2><?php ('Archives');?></h2>


		<ul>


		<?php wp_get_archives('type=monthly'); ?>


		</ul>


		


	<li id="Blogroll">


	<h2><?php ('Blogroll');?></h2>


		<ul>


		<?php get_links(-1, '<li>', '</li>', ' - '); ?>


		</ul>


		


	<li id="Admin">


	<h2><?php ('Admin');?></h2>


		<ul>


		<?php wp_register(); ?>


		<li><?php wp_loginout(); ?></li>


		<li><a href="http://www.wordpress.org/"><?php ('Wordpress');?></a></li>


		<?php wp_meta(); ?>


		<li><a href="http://validator.w3.org/check?uri=referer">XHTML</a></li>


		</ul>


		


	<h2><?php ('Search');?></h2>


	   	<form id="searchform" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">


		<input type="text" name="s" id="s" size="30" value=__("search this site...")/></form>


		


		<?php endif; ?>


		</ul>


			


</div>





<!-- end l_sidebar -->