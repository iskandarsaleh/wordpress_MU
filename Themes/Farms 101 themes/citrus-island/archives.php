<?php get_header(); ?>


<?php get_sidebar(); ?>


	<div id="main">





		<h1><?php _e('Archives by Month:');?></h1>


        <ul>


		    <?php wp_get_archives('type=monthly'); ?>


        </ul>





        <h1><?php _e('Archives by Subject:');?></h1>


        <ul>


		    <?php wp_list_cats('sort_column=name&optioncount=1&hierarchical=0'); ?>


		</ul>





    </div>


<?php include (TEMPLATEPATH . '/rbar.php'); ?>		


<?php get_footer(); ?>