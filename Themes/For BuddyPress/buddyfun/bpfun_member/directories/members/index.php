<?php
/*
 * /directories/members/index.php
 * Site directory for all the members across an install.
 * 
 * Loads: 'directories/members/members-loop.php'
 *
 * Loaded on URL:
 * 'http://example.org/members/
 */
?>

<?php get_header() ?>

<div id="directory-main">
	
	<form action="<?php echo site_url() . '/' ?>" method="post" id="members-directory-form">
		<h3><?php _e( 'Members Directory', 'buddypress' ) ?></h3>
		
		<ul id="letter-list">
			<li><a href="#a" id="letter-a">A</a></li>
			<li><a href="#b" id="letter-b">B</a></li>
			<li><a href="#c" id="letter-c">C</a></li>
			<li><a href="#d" id="letter-d">D</a></li>
			<li><a href="#e" id="letter-e">E</a></li>
			<li><a href="#f" id="letter-f">F</a></li>
			<li><a href="#g" id="letter-g">G</a></li>
			<li><a href="#h" id="letter-h">H</a></li>
			<li><a href="#i" id="letter-i">I</a></li>
			<li><a href="#j" id="letter-j">J</a></li>
			<li><a href="#k" id="letter-k">K</a></li>
			<li><a href="#l" id="letter-l">L</a></li>
			<li><a href="#m" id="letter-m">M</a></li>
			<li><a href="#n" id="letter-n">N</a></li>
			<li><a href="#o" id="letter-o">O</a></li>
			<li><a href="#p" id="letter-p">P</a></li>
			<li><a href="#q" id="letter-q">Q</a></li>
			<li><a href="#r" id="letter-r">R</a></li>
			<li><a href="#s" id="letter-s">S</a></li>
			<li><a href="#t" id="letter-t">T</a></li>
			<li><a href="#u" id="letter-u">U</a></li>
			<li><a href="#v" id="letter-v">V</a></li>
			<li><a href="#w" id="letter-w">W</a></li>
			<li><a href="#x" id="letter-x">X</a></li>
			<li><a href="#y" id="letter-y">Y</a></li>
			<li><a href="#z" id="letter-z">Z</a></li>
		</ul>

		<div class="clear"></div>

		<div id="members-directory-listing" class="directory-listing">
			<h3><?php _e( 'Member Listing', 'buddypress' ) ?></h3>
			
			<div id="member-dir-list">
				<?php load_template( TEMPLATEPATH . '/directories/members/members-loop.php' ) ?>
			</div>

		</div>

		<?php do_action( 'bp_core_directory_members_content' ) ?>
		<?php wp_nonce_field( 'directory_members', '_wpnonce-member-filter' ) ?>

	</form>
	
</div>



<?php get_footer() ?>