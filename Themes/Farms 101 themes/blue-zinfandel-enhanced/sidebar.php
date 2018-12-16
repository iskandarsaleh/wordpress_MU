<!-- begin sidebar -->





	<div id="sidebar">





	<h2><?php ('Recently Written');?></h2>


	<ul>


	<?php get_archives('postbypost', 10); ?>


	</ul>





	<h2><?php _e('Categories');?></h2>


		<ul>


		<?php wp_list_cats('sort_column=name'); ?>


		</ul>


		


	<h2><?php ('Archives');?></h2>


		<ul>


		<?php wp_get_archives('type=monthly'); ?>


		</ul>


		


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


		<input type="text" name="s" id="s" value="search this site..."/></form>


			


</div>





<!-- end sidebar -->