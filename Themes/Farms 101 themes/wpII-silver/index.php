<?php get_header(); ?>
<?php get_sidebar(); ?>
<div id="content">

<?php
if( file_exists( ABSPATH . WPINC . '/rss.php') ) {
	require_once(ABSPATH . WPINC . '/rss.php');
} else {
	require_once(ABSPATH . WPINC . '/rss-functions.php');
}
$flickr_tag = get_option('flickrock');
if (!empty($flickr_tag)){
	echo '<div id="flickr">';
	$rss_url = 'http://www.flickr.com/services/feeds/photos_public.gne?tags='.$flickr_tag.'&format=rss_200';
	$rss = @fetch_rss($rss_url);
	$items = array_slice($rss->items, 0, 7);
	foreach ( $items as $item ) {
	if(preg_match('<img src="([^"]*)" [^/]*/>', $item['description'],$imgUrlMatches)) {
		$imgurl = $imgUrlMatches[1];
             	$imgurl = str_replace("_m.jpg", "_s.jpg", $imgurl);
           }
	echo '<img alt="flickr Photo" src="'.$imgurl.'" />';
	}
	echo '</div>';
}
?>
	<?php if (have_posts()) :?>
		<?php $postCount=0; ?>
		<?php while (have_posts()) : the_post();?>
			<?php $postCount++;?>
	<div class="entry entry-<?php echo $postCount ;?>">
		<div class="entrytitle">
			<h2 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>"><?php the_title(); ?></a></h2> 
			<h3><?php the_time(__('F jS, Y')) ?></h3>
		</div>
		<div class="entrybody">
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
			<?php the_content(__('Read the rest of this entry &raquo;')); ?>
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
		</div>
		
		<div class="entrymeta">
		<div class="postinfo">
			<p class="postedby"><?php _e('Posted by');?> <?php the_author() ?> 		<?php comments_popup_link(__('No Comments &#187;'), __('1 Comment &#187;'),__('% Comments &#187;'), 'commentslink'); ?></p>
			<p class="filedto"><?php _e('Filed under:');?> <?php the_category(', ') ?><?php the_tags( '&nbsp;' . __( 'and tagged' ) . ' ', ', ', ''); ?><?php edit_post_link(__('Edit'), ' | ', ''); ?></p>
		</div>

			<div class="feedback">
			<?php comments_popup_link(__('No Response'), __('1 Pings'),__('% Pings'),  'commentslink'); ?>
			</div>
		</div>
		
	</div>
	<div class="commentsblock">
		<?php comments_template(); ?>
	</div>
		<?php endwhile; ?>
		<div class="navigation">
			<div style="float:right" class="alignright"><?php previous_posts_link(__('Newer Entries &raquo;')) ?></div>
			<div class="alignleft"><?php next_posts_link(__('&laquo; Older Entries')) ?></div>
		</div>
		
	<?php else : ?>

		<h2><?php _e('Not Found');?></h2>
		<div class="entrybody"><?php _e("Sorry, but you are looking for something that isn't here.");?></div>

	<?php endif; ?>

</div>
<?php get_footer(); ?>