	<div id="rightbar">


	<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(2) ) : else : ?>


	


	    <h1>Recent Posts</h1>


		<ul>


			<?php wp_get_archives('type=postbypost&limit=10'); ?>						


      	</ul>


		


		<h1><?php _e('Latest Links');?></h1>


		<div class="left-box">


		    <ul>				


				<?php get_links( -1, '<li>', '</li>', '', FALSE, '_id', FALSE, FALSE, 10, FALSE ); ?>


			</ul>


		</div>


    <?php endif; ?>


    </div>	