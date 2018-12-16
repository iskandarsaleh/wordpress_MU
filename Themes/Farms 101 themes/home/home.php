<?php get_header(); ?>

<div id="content" class="widecolumn">
				
<h2>Welcome to <a href="http://<?php echo $current_site->domain . $current_site->path ?>">your new Edublogs Premium site.</a></h2>
<p></p>
<p>If you haven't already, you should soon receive your login information for Site Admin access. Once that's arrived you can start setting up your site, enabling themes, turning on plugins and generally configuring it to your liking.</p>
<p></p>
<h3>Dive straight in: </h3> <ul><li> <a href="wp-login.php">Login</a> </li><li> <a href="wp-signup.php">Create a new blog</a></li></ul></p>
<h3>Support for setting up your new site: </h3> <ul><li> <a href="http://edublogs.org/services/support/video-tutorials/">Site Admin video tutorials to get you going</a> </li><li><a href="http://edublogs.org/videos/">Video tutorials and resources for your users</a></li><li> <a href="http://edublogs.org/forums/">Forums for users and site admins alike</a></li></ul></p>

<h3>The Latest:</h3>
<ul>
<strong>Posts on this blog:</strong>
<?php 
query_posts('showposts=7');
if (have_posts()) : ?><?php while (have_posts()) : the_post(); ?>
<li><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>"><?php the_title();?> </a></li>
<?php endwhile; ?><?php endif; ?>
</ul>
<?php
$blogs = get_last_updated();
if( is_array( $blogs ) ) {
	?>
	<ul>
	<strong>Updated blogs on this site:</strong>
	<?php foreach( $blogs as $details ) {
		?><li><a href="http://<?php echo $details[ 'domain' ] . $details[ 'path' ] ?>"><?php echo get_blog_option( $details[ 'blog_id' ], 'blogname' ) ?></a></li><?php
	}
	?>
	</ul>
	<?php
}
?>
</div>

<?php get_footer(); ?>
