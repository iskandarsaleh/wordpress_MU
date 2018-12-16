<div id="sidebar">
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("20090linkunitnocolor"); } ?>
<?php if ( !function_exists('dynamic_sidebar')
        || !dynamic_sidebar() ) : ?>
	<?php /* About Blog */ if (is_home()) { ?>
	<?php $blogdesc = $wpdb->get_var("SELECT option_value FROM $wpdb->options WHERE option_name = 'blogdescription'"); 
	if ($blogdesc != '') { ?>
	<div class="box">
		<?php bloginfo('description'); ?>
	</div>
	<hr />
	<?php } } ?>
	
	<? /* Single */ if(is_single()) { ?>
	<div class="box">
		<h4><?php _e('This Entry');?></h4>
		<?php rewind_posts(); ?>
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	
			<p>"<a href="<?php the_permalink() ?>" title="<?php _e('Permanent Link:');?> <?php the_title(); ?>"><?php the_title(); ?></a>" was written <?php the_time(__('F jS, Y')) ?>
				by <?php the_author_posts_link(); ?>, <?php _e('and is filed under');?><?php the_category(',') ?> <?php the_tags( ' and ' . __( 'tagged' ) . ' ', ', ', '.'); ?></p>
	
		<?php endwhile; endif; ?>
		<?php rewind_posts(); ?>

		<?php if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
			// Both Comments and Pings are open ?>

			<p><?php _e('There are');?> <?php comments_number(__('No Responses'), __('One Response'), __('% Responses' ));?>.</p>
			<p>&darr; <a href="#comments">Read comments</a>, <a href="#respond">respond</a> or follow responses via <?php comments_rss_link(__("XML")); ?>.</p>
			<?php if (function_exists('show_manual_subscription_form')) { show_manual_subscription_form(); }; ?>

			<span id="trackback">
				<a href="<?php trackback_url(display) ?>" onclick="show('trackback');return false;" title="Trackback URI to this entry" rel="nofollow">Trackback</a> this entry.
			</span>
			<span id="trackback-hidden" style="display: none;">
				<input name="textfield" type="text" value="<?php trackback_url() ?>" class="inputbox" onclick="select();" />
				<input name="hide" type="button" id="hide" value="Hide" onclick="hide('trackback');return false;" />
			</span>
		<?php } elseif (!('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
			// Only Pings are Open ?>

			<span id="trackback">
				<a href="<?php trackback_url(display) ?>" onclick="show('trackback');return false;" title="Trackback URI to this entry" rel="nofollow">Trackback</a> this entry.
			</span>
			<span id="trackback-hidden" style="display: none;">
				<input name="textfield" type="text" value="<?php trackback_url() ?>" class="inputbox" onclick="select();" />
				<input name="hide" type="button" id="hide" value="Hide" onclick="hide('trackback');return false;" />
			</span>
		<?php } elseif (('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
			// Comments are open, Pings are not ?>

			<p><?php _e('There are');?> <?php comments_number(__('No Responses'), __('One Response'), __('% Responses' ));?>.</p>
			<p>&darr; <a href="#comments"><?php _e('Jump to Comments');?></a> or follow responses via <?php comments_rss_link(__("XML")); ?>.</p>
			<?php if (function_exists('show_manual_subscription_form')) { show_manual_subscription_form(); }; ?>
		<?php } elseif (!('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
			// Neither Comments, nor Pings are open ?>
		<?php } ?>
	</div>
	<? } ?>
	
	<? /* Recent Activity */ if (!is_category() && !is_page() && !is_search() || is_single() || is_date()) { ?>
	<?php if (function_exists('blc_latest_comments')) { ?>
	<div class="box">
		<h4><?php _e('Ongoing Discussions') ?></h4>
		<ul id="recent-activity">
			<?php blc_latest_comments(3,3); ?>
		</ul>
	</div>
	<? } ?>
	<? } ?>
	
	<?php /* Search Meta */ if(is_search()) { ?>
	<div class="box">
		<h4><?php _e('Search'); ?></h4>
		<p><?php _e('All keywords are searched for.') ?></p>
		<?php _e('If only one article contains the keywords you searched for, you will be taken directly to that article.') ?>
	</div>
	<?php } ?>
	
	<?php /* Calendar, Links, Meta */ if (!is_category() && !is_single() && !is_date() && !is_page() && !is_search() && !is_author()) { ?>
	<?php /* Calendar functionality is disabled by default. To enable, remove these comments.
	<div class="box">
		<h4><?php _e('Calendar'); ?></h4>
		<?php get_calendar(); ?>
	</div>
	*/ ?>
	
	<div class="box">
		<h4><?php _e('Links'); ?></h4>
		<ul>
			<?php get_links('','<li>&raquo; ','</li>','\n',0,'updated',0,0,200,0); ?>
		</ul>

		<h4><?php _e('Meta'); ?></h4>
		<ul>
			<?php wp_register(); ?>
			<li><?php wp_loginout(); ?></li>
			<?php wp_meta(); ?>
		</ul>
	</div>
	<?php } ?>
	
	<?php /* Category Meta */ if (is_category()) { ?>
	<div class="box">
		<h4><?php _e('Category: '); ?><?php single_cat_title('', 'display'); ?></h4>
		<p><?php echo category_description(); ?></p>
		<p><?php _e('Also available:') ?>
		<br /><a rel="nofollow" href="<? echo get_category_rss_link(0, $cat, $post->cat_name); ?>" title="<?php _e('RSS 2.0') ?>"><?php _e('RSS Feed for entries in this category') ?></a>.</p>
	</div>
	<?php } ?>

	<?php /* Archive Meta */ if (is_page("archives")) { ?>
	<div class="box">
		<h4><?php _e('Archives') ?></h4>
		<p><?php _e('You are viewing the archives for ') ?> <?php bloginfo('name'); ?>.</p>
		<?php
		$numposts = $wpdb->get_var("SELECT COUNT(ID) FROM $wpdb->posts WHERE post_status = 'publish'");
		if (0 < $numposts) $numposts = number_format($numposts); 
		
		$numcomms = $wpdb->get_var("SELECT COUNT(comment_ID) FROM $wpdb->comments WHERE comment_approved = '1'");
		if (0 < $numcomms) $numcomms = number_format($numcomms);
		
		$numcats = $wpdb->get_var("SELECT COUNT(taxonomy) FROM $wpdb->term_taxonomy WHERE taxonomy = 'category'");
		if (0 < $numcats) $numcats = number_format($numcats);
		?>
		<p><?php _e('There are currently ' . $numposts . ' posts and ' . $numcomms . ' comments, contained within ' . $numcats . ' categories.') ?></p>
	</div>
	<?php } ?>

	<?php /* Category List */ if (is_category() || is_page("archives")) { ?>
	<?php /* Guess special categories */
		$sidenote_cat = $wpdb->get_var("SELECT t.term_id FROM {$wpdb->terms} AS t LEFT JOIN {$wpdb->term_taxonomy} AS tt ON ( tt.term_id = t.term_id ) WHERE ( (t.slug = 'sidenotes' OR  t.slug = 'asides' OR  t.slug = 'dailies') AND tt.taxonomy = 'category')");
	?>
	<div class="box">
		<h4><?php _e('Categories') ?></h4>
		<ul>
		<?php wp_list_cats("children=1&hide_empty=0&sort_column=name&optioncount=1&feed=XML&exclude=".$sidenote_cat.",".$noteworthy_cat." '") ?>
		</ul>
		

		<? if ($noteworthy_cat != "" || $sidenote_cat != "") { ?>
		<h4><?php _e('Special Categories') ?></h4>
		<ul>
			<? if ($sidenote_cat != "") { ?><li><?php echo(get_category_parents($sidenote_cat,TRUE,'')); ?></li><? } ?>
			<? if ($noteworthy_cat != "") { ?><li><?php echo(get_category_parents($noteworthy_cat,TRUE,'')); ?></li><? } ?>
		</ul>
		<? } ?>
	
	</div>
	<?php } ?>
	
	<?php /* Author Meta */ if (is_author()) { ?>
	<?php $num_authors = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->users"); ?>
	<div class="box">
		<h4><?php _e('Author Archive') ?></h4>
		<p><?php _e('This page details authors of this weblog.') ?></p>

		<?php /* Fix an annoying WP bug where wp_list_authors borks when there's only one user */
		$numauthors = $wpdb->get_results("SELECT COUNT(*) FROM $wpdb->users");
		if (sizeof($numauthors) > 1) { ?> 
		<p><?php _e('There are ' . $num_authors . ' authors/users attached to this weblog: ') ?></p>
		<ul>
			<?php wp_list_authors('optioncount=1&feed=XML'); ?>
		</ul>
		<?php } else { ?>
		<p><?php _e('There is one author attached to this weblog.') ?></p>
		<?php } ?>
	</div>
	<?php } ?>
	
	
	<?php /* Page List */ if (is_page() && !is_page('archives')) { ?>
	<?php
	$currentpage = $post->ID;
	$parent = 1;

	while($parent) {
		$subpages = $wpdb->get_row("SELECT ID, post_name, post_parent FROM $wpdb->posts WHERE ID = '$currentpage'");
		$parent = $currentpage = $subpages->post_parent;
	}
	$parent_id = $subpages->ID;
	$haschildren = $wpdb->get_results("SELECT * FROM $wpdb->posts WHERE post_parent = '$parent_id'"); 
	if($haschildren) { ?>
	<div class="box">
		<h4><?php _e('In this Section') ?></h4>
		<ul>
			<?php wp_list_pages('title_li=&child_of='. $parent_id); ?>
		</ul>
	</div>
	<?php } } ?>

	<? /* Pages */ if (is_page()) { ?>
	<? /* Included Scott Reilly's Get Custom Fields plugin, for custom use. Thanks Scott!
		
	Copyright (c) 2004-2005 by Scott Reilly (aka coffee2code)
	
	Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation 
	files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, 
	modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the 
	Software is furnished to do so, subject to the following conditions:
	
	The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
	
	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
	OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
	LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR
	IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
	*/
	
	if (!isset($wpdb->posts)) {	// For WP 1.2 compatibility
		global $tableposts, $tablepostmeta;
		$wpdb->posts = $tableposts;
		$wpdb->postmeta = $tablepostmeta;
	}
	
	// This works inside "the loop"
	function c2c_get_custom ($field, $before='', $after='', $none='', $between='', $before_last='') {
		return c2c__format_custom($field, (array)get_post_custom_values($field), $before, $after, $none, $between, $before_last);
	} //end c2c_get_custom()
	
	// This works outside "the loop"
	function c2c_get_recent_custom ($field, $before='', $after='', $none='', $between=', ', $before_last='', $limit=1, $unique=false, $order='DESC', $include_static=true, $show_pass_post=false) {
		global $wpdb;
		if (empty($between)) $limit = 1;
		if ($order != 'ASC') $order = 'DESC';
		$now = current_time('mysql');
	
		$sql = "SELECT ";
		if ($unique) $sql .= "DISTINCT ";
		$sql .= "meta_value FROM $wpdb->posts AS posts, $wpdb->postmeta AS postmeta ";
		$sql .= "WHERE posts.ID = postmeta.post_id AND postmeta.meta_key = '$field' ";
		$sql .= "AND ( posts.post_status = 'publish' ";
		if ($include_static) $sql .= " OR posts.post_type = 'page' ";
		$sql .= " ) AND posts.post_date < '$now' ";
		if (!$show_pass_post) $sql .= "AND posts.post_password = '' ";
		$sql .= "AND postmeta.meta_value != '' ";
		$sql .= "ORDER BY posts.post_date $order LIMIT $limit";
		$results = array(); $values = array();
		$results = $wpdb->get_results($sql);
		if (!empty($results))
			foreach ($results as $result) { $values[] = $result->meta_value; };
		return c2c__format_custom($field, $values, $before, $after, $none, $between, $before_last);
	} //end c2c_get_recent_custom()
	
	/* Helper function */
	function c2c__format_custom ($field, $meta_values, $before='', $after='', $none='', $between='', $before_last='') {
		$values = array();
		if (empty($between)) $meta_values = array_slice($meta_values,0,1);
		if (!empty($meta_values))
			foreach ($meta_values as $meta) {
				$meta = apply_filters("the_meta_$field", $meta);
				$values[] = apply_filters('the_meta', $meta);
			}
	
		if (empty($values)) $value = '';
		else {
			$values = array_map('trim', $values);
			if (empty($before_last)) $value = implode($values, $between);
			else {
				switch ($size = sizeof($values)) {
					case 1:
						$value = $values[0];
						break;
					case 2:
						$value = $values[0] . $before_last . $values[1];
						break;
					default:
						$value = implode(array_slice($values,0,$size-1), $between) . $before_last . $values[$size-1];
				}
			}
		}
		if (empty($value)) {
			if (empty($none)) return;
			$value = $none;
		}
		return $before . $value . $after;
	} //end c2c__format_custom()
	
	// Some filters you may wish to perform: (these are filters typically done to 'the_content' (post content))
	add_filter('the_meta', 'convert_chars');
	
	// Other optional filters (you would need to obtain and activate these plugins before trying to use these)
	if (function_exists(do_textile)) { 			add_filter('the_meta', 'do_textile', 6); }
	else if (function_exists(textile)) { 		add_filter('the_meta', 'textile', 6); }
	else if (function_exists(Markdown)) { 		add_filter('the_meta', 'Markdown', 6); }
	else if (function_exists(wptexturize)) { 	add_filter('the_meta', 'wptexturize'); }
	?>

	<?php /* rewind_posts(); ?>
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	
		<?php if (get_post_custom_values('sidebar') != "") { ?>
		<div class="box">
			<?php echo c2c_get_custom('sidebar'); ?>
		</div>
		<? } ?>

	<?php endwhile; endif; ?>
	<?php rewind_posts(); ?>
	<? */ } ?>

	<hr />
<?php endif; ?>
</div>
