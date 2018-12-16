<?php
/*
Plugin Name: WibStats
Plugin URI: http://www.stillbreathing.co.uk/projects/wibstats/
Description: A simple statistics plugin for Wordpress MU, in use at http://wibsite.com (hence the name)
Version: 0.1
Author: Chris Taylor
Author URI: http://www.stillbreathing.co.uk
*/

global $current_blog;

// start the session if the id is not set
if (session_id() == "")
{
	session_start();
}

// add the wp_foot action
if (function_exists("add_action"))
{
	add_action("wp_footer", "wibstats");
	add_action("admin_menu", "wibstats_add_admin");
	add_action("admin_head", "wibstats_css");
}

// add the admin menu option
function wibstats_add_admin()
{
	add_submenu_page('index.php', __('Blog statistics'), __('Blog statistics'), 1, 'wibstats_reports', 'wibstats_reports');
}

// add the CSS for the reports
function wibstats_css()
{
	echo '
<style type="text/css">
#wibstats .wibstats_col1 {
clear: left;
float: left;
width: 48%;
}
#wibstats .wibstats_col2 {
clear: right;
float: right;
width: 48%;
}
#wibstats td {
vertical-align: bottom;
}
</style>';
}
	
// load the reports page
function wibstats_reports()
{
	global $wpdb;
	global $current_blog;
	
	$bloglink = "";
	
	$blogid = $current_blog->blog_id;
	
	if (is_site_admin() && isset($_POST["blogid"]) && $_POST["blogid"] != "")
	{
		$blogid = trim($_POST["blogid"]);
		$bloglink = "&amp;blogid=".$blogid;
	}
	if (is_site_admin() && isset($_GET["blogid"]) && $_GET["blogid"] != "")
	{
		$blogid = trim($_GET["blogid"]);
		$bloglink = "&amp;blogid=".$blogid;
	}
	
	if (isset($_POST["recreate"]) && $_POST["recreate"] != "")
	{
		wibstats_createtables(true);
		echo '
		<p>' . __("Your statistics database table has been recreated. Your statistics should start working soon.") . '</p>
		';
	}
	
	$wibstats_table = $wpdb->base_prefix . $blogid . "_wibstats";
	
	echo '
	<div id="wibstats" class="wrap">
	';
	
	if (is_site_admin())
	{
		echo '<h2>' . __("Choose a blog to view their statistics") . '</h2>
		<form action="index.php?page=wibstats_reports" method="post">
		<p><label for="blogid">' . __("Choose blog") . '</label>
		<select name="blogid" id="blogid">
		';
		$blog_list = get_blog_list( 0, 'all' );
		foreach ($blog_list AS $blog) {
		    echo '<option value="'.$blog['blog_id'].'"';
			if ($blog['blog_id'] == $blogid) {
				echo ' selected="selected"';
			}
			echo '>'.$blog['domain'].trim($blog['path'], '/').' ('.$blog['blog_id'].')</option>
			';
		}
		echo '
		</select></p>
		<p><label for="go">' . __("View statistics") . '</label>
		<button type="subit" name="go" id="go" class="button">' . __("View statistics") .'</button></p>
		</form>
		';
	}
	
	if (!isset($_GET["view"]) || $_GET["view"] == "")
	{
	
		// get total number of visitors ever
		$sql = "select count(distinct(sessionid)) as num from " . $wibstats_table . ";";
		$totalvisitors = $wpdb->get_var($sql);
		
		// get total number of pageviews ever
		$sql = "select count(id) as num from " . $wibstats_table . ";";
		$totalpages = $wpdb->get_var($sql);
		
		if ($totalvisitors != "" && $totalpages != "")
		{
		
		// get total number of visitors in the last 28 days
		$start = time() - (60 * 60 * 24 * 28);
		$sql = "select count(distinct(sessionid)) as num from " . $wibstats_table . " where timestamp > " . $start . ";";
		$visitors28days = $wpdb->get_var($sql);
		
		// get total number of page views in the last 28 days
		$start = time() - (60 * 60 * 24 * 28);
		$sql = "select count(id) as num from " . $wibstats_table . " where timestamp > " . $start . ";";
		$pages28days = $wpdb->get_var($sql);
		
		// get total number of visitors in the last 7 days
		$start = time() - (60 * 60 * 24 * 7);
		$sql = "select count(distinct(sessionid)) as num from " . $wibstats_table . " where timestamp > " . $start . ";";
		$visitors7days = $wpdb->get_var($sql);
		
		// get total number of page views in the last 7 days
		$start = time() - (60 * 60 * 24 * 7);
		$sql = "select count(id) as num from " . $wibstats_table . " where timestamp > " . $start . ";";
		$pages7days = $wpdb->get_var($sql);
		
		// get total number of visitors in the last 24 hours
		$start = time() - (60 * 60 * 24);
		$sql = "select count(distinct(sessionid)) as num from " . $wibstats_table . " where timestamp > " . $start . ";";
		$visitors24hours = $wpdb->get_var($sql);
		
		// get total number of page views in the last 24 hours
		$start = time() - (60 * 60 * 24);
		$sql = "select count(id) as num from " . $wibstats_table . " where timestamp > " . $start . ";";
		$pages24hours = $wpdb->get_var($sql);
		
		echo '
		<h2>' . __("Blog statistics") . '</h2>

		<table class="widefat post fixed">
			<thead>
			<tr>
				<th></th>
				<th>' . __("Ever") . '</th>
				<th>' . __("In the last 28 days") . '</th>
				<th>' . __("In the last 7 days") . '</th>
				<th>' . __("In the last 24 hours") . '</th>
			</tr>
			</thead>
			<tbody>
			<tr>
				<th>' . __("Unique visitors") . '</th>
				<td>' . $totalvisitors . '</td>
				<td>' . $visitors28days . '</td>
				<td>' . $visitors7days . '</td>
				<td>' . $visitors24hours . '</td>
			</tr>
			<tr>
				<th>' . __("Page views") . '</th>
				<td>' . $totalpages . '</td>
				<td>' . $pages28days . '</td>
				<td>' . $pages7days . '</td>
				<td>' . $pages24hours . '</td>
			</tr>
			</tbody>
		</table>
		';
		
		$begin = time() - (60 * 60 * 24 * 13);
		
		$start = $begin;
		
		for($i = 0; $i < 14; $i++)
		{
			$days[] = date("jS M", $start);
		
			$sql = "select count(distinct(sessionid)) as num
				from " . $wibstats_table . "
				where day(FROM_UNIXTIME(timestamp)) = day(FROM_UNIXTIME(" . $start . "))
				and month(FROM_UNIXTIME(timestamp)) = month(FROM_UNIXTIME(" . $start . "))
				and year(FROM_UNIXTIME(timestamp)) = year(FROM_UNIXTIME(" . $start . "));";

			$visitorsnum[] = $wpdb->get_var($sql);
			
			$sql = "select count(id) as num
				from " . $wibstats_table . "
				where day(FROM_UNIXTIME(timestamp)) = day(FROM_UNIXTIME(" . $start . "))
				and month(FROM_UNIXTIME(timestamp)) = month(FROM_UNIXTIME(" . $start . "))
				and year(FROM_UNIXTIME(timestamp)) = year(FROM_UNIXTIME(" . $start . "));";

			$pagesnum[] = $wpdb->get_var($sql);
			
			$start = $start + (60 * 60 * 24);			
		}
		
		$visitorsmax = 0;
		$pagesmax = 0;
		
		for($i = 0; $i < 14; $i++)
		{
			if ($visitorsnum[$i] > $visitorsmax) { $visitorsmax = $visitorsnum[$i]; }
			if ($pagesnum[$i] > $pagesmax) { $pagesmax = $pagesnum[$i]; }
		}
		
		echo '
		<h3>' . __("Visitors in the last 14 days") . '</h3>
		<table class="widefat post fixed">
			<thead>
			<tr>
				<th></th>
			';
		for($i = 0; $i < 14; $i++)
		{
			echo '
				<th>' . $days[$i] . '</th>
			';
		}
		echo '
			</tr>
			</thead>
			<tbody>
			<tr>
			<th>' . __("Visitors") . '</th>
			';
			
		for($i = 0; $i < 14; $i++)
		{
			echo '
				<td>';
			if ($visitorsnum[$i] != "0" && $visitorsmax != "0")
			{
			echo '
				<div style="background:#6F6F6F;width:10px;height:' . (round(($visitorsnum[$i]/$visitorsmax)*100)) . 'px"></div>';
				}
			echo '
				' . $visitorsnum[$i] . '</td>
			';
		}
		echo '
			</tr>
			
			<tr>
			<th>' . __("Page views") . '</th>
			';
			
		for($i = 0; $i < 14; $i++)
		{
			echo '
				<td>';
			if ($pagesnum[$i] != "0" && $pagesmax != "0")
			{
			echo '
				<div style="background:#6F6F6F;width:10px;height:' . (round(($pagesnum[$i]/$pagesmax)*100)) . 'px"></div>';
				}
			echo '
				' . $pagesnum[$i] . '</td>
			';
		}
		echo '
			</tr>
			</tbody>
		</table>
		';
		
		$sql = "select terms, country, city, timestamp
				from " . $wibstats_table . "
				where terms <> ''
				order by timestamp desc
				limit 10;";
		$recentterms = $wpdb->get_results($sql);
		
		echo '
		<div class="wibstats_col1">
		<h3>' . __("Last 10 search words used") . ' <a href="index.php?page=wibstats_reports&amp;view=recentterms'.$bloglink.'">...' . __("more") . '</a></h3>
		<table class="widefat post fixed">
			<thead>
			<tr>
				<th>' . __("When") . '</th>
				<th>' . __("Search words") . '</th>
				<th>' . __("Country") . '</th>
				<th>' . __("City") . '</th>
			</tr>
			</thead>
			<tbody>
		';
		foreach ($recentterms as $term)
		{
			echo '
			<tr>
				<td>' . wibstats_date($term->timestamp) . '</td>
				<td>' . $term->terms . '</td>
				<td>' . strip_tags($term->country) . '</td>
				<td>' . strip_tags($term->city) . '</td>
			</tr>
			';
		}
		echo '
			</tbody>
		</table>
		</div>
		';
		
		$sql = "select terms, count(id) as num
				from " . $wibstats_table . "
				where terms <> ''
				group by terms
				order by count(id) desc
				limit 10;";
		$popularterms = $wpdb->get_results($sql);
		
		echo '
		<div class="wibstats_col2">
		<h3>' . __("10 most popular search words") . ' <a href="index.php?page=wibstats_reports&amp;view=popularterms'.$bloglink.'">...' . __("more") . '</a></h3>
		<table class="widefat post fixed">
			<thead>
			<tr>
				<th>' . __("Search words") . '</th>
				<th>' . __("Times used") . '</th>
			</tr>
			</thead>
			<tbody>
		';
		foreach ($popularterms as $term)
		{
			echo '
			<tr>
				<td>' . $term->terms . '</td>
				<td>' . $term->num . '</td>
			</tr>
			';
		}
		echo '
			</tbody>
		</table>
		</div>
		';
		
		$sql = "select country, city, timestamp
				from " . $wibstats_table . "
				where country <> ''
				group by sessionid
				order by timestamp desc
				limit 10;";
		$recentlocations = $wpdb->get_results($sql);
		
		echo '
		<div class="wibstats_col1">
		<h3>' . __("Last 10 visitor locations") . ' <a href="index.php?page=wibstats_reports&amp;view=recentlocations'.$bloglink.'">...' . __("more") . '</a></h3>
		<table class="widefat post fixed">
			<thead>
			<tr>
				<th>' . __("When") . '</th>
				<th>' . __("Country") . '</th>
				<th>' . __("City") . '</th>
			</tr>
			</thead>
			<tbody>
		';
		foreach ($recentlocations as $location)
		{
			echo '
			<tr>
				<td>' . wibstats_date($location->timestamp) . '</td>
				<td>' . strip_tags($location->country) . '</td>
				<td>' . strip_tags($location->city) . '</td>
			</tr>
			';
		}
		echo '
			</tbody>
		</table>
		</div>
		';
		
		$sql = "select country, count(distinct(sessionid)) as num
				from " . $wibstats_table . "
				where country <> ''
				group by country
				order by count(id) desc
				limit 10;";
		$popularlocations = $wpdb->get_results($sql);
		
		echo '
		<div class="wibstats_col2">
		<h3>' . __("10 most popular visitor locations") . ' <a href="index.php?page=wibstats_reports&amp;view=popularlocations'.$bloglink.'">...' . __("more") . '</a></h3>
		<table class="widefat post fixed">
			<thead>
			<tr>
				<th>' . __("Country") . '</th>
				<th>' . __("Number of visitors") . '</th>
			</tr>
			</thead>
			<tbody>
		';
		foreach ($popularlocations as $location)
		{
			echo '
			<tr>
				<td>' . strip_tags($location->country) . '</td>
				<td>' . $location->num . '</td>
			</tr>
			';
		}
		echo '
			</tbody>
		</table>
		</div>
		';
		
		$sql = "select count(distinct(sessionid)) as num, page, title
				from " . $wibstats_table . "
				where page <> ''
				group by page, title
				order by count(distinct(sessionid)) desc
				limit 10;";
		$popularpages = $wpdb->get_results($sql);
		
		echo '
		<div class="wibstats_col1">
		<h3>' . __("10 most popular pages") . ' <a href="index.php?page=wibstats_reports&amp;view=popularpages'.$bloglink.'">...' . __("more") . '</a></h3>
		<table class="widefat post fixed">
			<thead>
			<tr>
				<th>' . __("Visitors") . '</th>
				<th>' . __("Page") . '</th>
			</tr>
			</thead>
			<tbody>
		';
		foreach ($popularpages as $page)
		{
			if ($page->title == "")
			{
				$page->title = wibstats_shorten($page->page);
			}
			echo '
			<tr>
				<td>' . $page->num . '</td>
				<td><a href="' . $page->page . '">' . $page->title . '</a></td>
			</tr>
			';
		}
		echo '
			</tbody>
		</table>
		</div>
		';
		
		$sql = "select count(distinct(sessionid)) as num, platform
				from " . $wibstats_table . "
				where platform <> ''
				group by platform
				order by count(distinct(sessionid)) desc
				limit 10;";
		$popularplatforms = $wpdb->get_results($sql);
		
		echo '
		<div class="wibstats_col2">
		<h3>' . __("10 most popular platforms") . '</h3>
		<table class="widefat post fixed">
			<thead>
			<tr>
				<th>' . __("Visitors") . '</th>
				<th>' . __("Platform") . '</th>
			</tr>
			</thead>
			<tbody>
		';
		foreach ($popularplatforms as $platform)
		{
			echo '
			<tr>
				<td>' . $platform->num . '</td>
				<td>' . $platform->platform . '</td>
			</tr>
			';
		}
		echo '
			</tbody>
		</table>
		</div>
		';
		
		$sql = "select count(distinct(sessionid)) as num, browser
				from " . $wibstats_table . "
				where browser <> ''
				group by browser
				order by count(distinct(sessionid)) desc
				limit 10;";
		$popularbrowsers = $wpdb->get_results($sql);
		
		echo '
		<div class="wibstats_col1">
		<h3>' . __("10 most popular browsers") . '</h3>
		<table class="widefat post fixed">
			<thead>
			<tr>
				<th>' . __("Visitors") . '</th>
				<th>' . __("Browser") . '</th>
			</tr>
			</thead>
			<tbody>
		';
		foreach ($popularbrowsers as $browser)
		{
			echo '
			<tr>
				<td>' . $browser->num . '</td>
				<td>' . $browser->browser . '</td>
			</tr>
			';
		}
		echo '
			</tbody>
		</table>
		</div>
		';
		
		$sql = "select count(distinct(sessionid)) as num, screensize
				from " . $wibstats_table . "
				where screensize <> ''
				group by screensize
				order by count(distinct(sessionid)) desc
				limit 10;";
		$popularscreensizes = $wpdb->get_results($sql);
		
		echo '
		<div class="wibstats_col2">
		<h3>' . __("10 most popular screen sizes") . '</h3>
		<table class="widefat post fixed">
			<thead>
			<tr>
				<th>' . __("Visitors") . '</th>
				<th>' . __("Screensize") . '</th>
			</tr>
			</thead>
			<tbody>
		';
		foreach ($popularscreensizes as $screensize)
		{
			echo '
			<tr>
				<td>' . $screensize->num . '</td>
				<td>' . $screensize->screensize . '</td>
			</tr>
			';
		}
		echo '
			</tbody>
		</table>
		</div>
		';
		
		} else {
		
			echo '
			<p>' . __("Sorry, it looks like you haven't had any visitors yet. This may be a system error. Click the button below which will recreate the database table that stores your visitor information. This *may* completely remove all information for visitors you\'ve already had (depending on which part of the database is broken).") . '</p>
			<form action="index.php?page=wibstats_reports" method="post">
			<p><label for="blogid">' . __("Choose blog") . '</label>
			<select name="blogid" id="blogid">
			';
			$blog_list = get_blog_list( 0, 'all' );
			foreach ($blog_list AS $blog) {
			    echo '<option value="'.$blog['blog_id'].'"';
				if ($blog['blog_id'] == $blogid) {
					echo ' selected="selected"';
				}
				echo '>'.$blog['domain'].trim($blog['path'], '/').' ('.$blog['blog_id'].')</option>
				';
			}
			echo '
			</select></p>
			<p><label for="recreate">' . __("Recreate table") . '</label>
			<button class="button" type="submit" name="recreate" id="recreate" value="1">' . __("Recreate statistics table") . '</button>
			<strong>' . __("This *may* remove all visitor information stored for your blog") . '</strong</p>
			</form>
			';
		
		}
	
	} else {
	
		if ($_GET["view"] == "recentterms")
		{
			echo '
			<h2><a href="index.php?page=wibstats_reports'.$bloglink.'">' . __("Blog statistics") . '</a> &raquo; ' . __("Recent search words") . '</h2>
			';
			$sql = "select terms, country, city, page, title
					from " . $wibstats_table . "
					where terms <> ''
					order by timestamp desc
					limit 100;";
			$recentterms = $wpdb->get_results($sql);
			echo '
			<table class="widefat post fixed">
				<thead>
				<tr>
					<th>' . __("Search words") . '</th>
					<th>' . __("Country") . '</th>
					<th>' . __("City") . '</th>
					<th>' . __("Page") . '</th>
				</tr>
				</thead>
				<tbody>
			';
			foreach ($recentterms as $term)
			{
				if ($term->title == "")
				{
					$term->title = wibstats_shorten($term->page);
				}
				echo '
				<tr>
					<td>' . $term->terms . '</td>
					<td>' . strip_tags($term->country) . '</td>
					<td>' . strip_tags($term->city) . '</td>
					<td><a href="' . $term->page . '">' . $term->title . '</a></td>
				</tr>
				';
			}
			echo '
				</tbody>
			</table>
			';
		}
		
		if ($_GET["view"] == "popularterms")
		{
			echo '
			<h2><a href="index.php?page=wibstats_reports'.$bloglink.'">' . __("Blog statistics") . '</a> &raquo; ' . __("Popular search words") . '</h2>
			';
			$sql = "select terms, count(id) as num
					from " . $wibstats_table . "
					where terms <> ''
					group by terms
					order by count(id) desc
					limit 100;";
			$popularterms = $wpdb->get_results($sql);
			echo '
			<table class="widefat post fixed">
				<thead>
				<tr>
					<th>' . __("Search words") . '</th>
					<th>' . __("Times used") . '</th>
				</tr>
				</thead>
				<tbody>
			';
			foreach ($popularterms as $term)
			{
				echo '
				<tr>
					<td>' . $term->terms . '</td>
					<td>' . $term->num . '</td>
				</tr>
				';
			}
			echo '
				</tbody>
			</table>
			';
		}
		
		if ($_GET["view"] == "recentlocations")
		{
			echo '
			<h2><a href="index.php?page=wibstats_reports'.$bloglink.'">' . __("Blog statistics") . '</a> &raquo; ' . __("Recent visitor locations") . '</h2>
			';
			$sql = "select country, city, timestamp
					from " . $wibstats_table . "
					where country <> ''
					group by sessionid
					order by timestamp desc
					limit 100;";
			$recentlocations = $wpdb->get_results($sql);
			echo '
			<table class="widefat post fixed">
				<thead>
				<tr>
					<th>' . __("When") . '</th>
					<th>' . __("Country") . '</th>
					<th>' . __("City") . '</th>
				</tr>
				</thead>
				<tbody>
			';
			foreach ($recentlocations as $location)
			{
				echo '
				<tr>
					<td>' . wibstats_date($location->timestamp) . '</td>
					<td>' . strip_tags($location->country) . '</td>
					<td>' . strip_tags($location->city) . '</td>
				</tr>
				';
			}
			echo '
				</tbody>
			</table>
			';
		}
		
		if ($_GET["view"] == "popularlocations")
		{
		
			$sql = "select country, count(distinct(sessionid)) as num
					from " . $wibstats_table . "
					where country <> ''
					group by country
					order by count(id) desc
					limit 100;";
			$popularlocations = $wpdb->get_results($sql);
		
			echo '
			<h2><a href="index.php?page=wibstats_reports'.$bloglink.'">' . __("Blog statistics") . '</a> &raquo; ' . __("Most popular visitor locations") . '</h2>
			<table class="widefat post fixed">
				<thead>
				<tr>
					<th>' . __("Country") . '</th>
					<th>' . __("Number of visitors") . '</th>
				</tr>
				</thead>
				<tbody>
			';
			foreach ($popularlocations as $location)
			{
				echo '
				<tr>
					<td>' . strip_tags($location->country) . '</td>
					<td>' . $location->num . '</td>
				</tr>
				';
			}
			echo '
				</tbody>
			</table>
			';
		}
		
		if ($_GET["view"] == "popularpages")
		{
		
			$sql = "select count(distinct(sessionid)) as num, page, title
					from " . $wibstats_table . "
					where page <> ''
					group by page, title
					order by count(distinct(sessionid)) desc
					limit 100;";
			$popularpages = $wpdb->get_results($sql);
		
			echo '
			<h2><a href="index.php?page=wibstats_reports'.$bloglink.'">' . __("Blog statistics") . '</a> &raquo; ' . __("Most popular pages") . '</h2>
			<table class="widefat post fixed">
				<thead>
				<tr>
					<th>' . __("Page") . '</th>
					<th>' . __("Number of visitors") . '</th>
				</tr>
				</thead>
				<tbody>
			';
			foreach ($popularpages as $page)
			{
				if ($page->title == "")
				{
					$page->title = $page->page;
				}
				echo '
				<tr>
					<td><a href="' . $page->page . '">' . $page->title . '</a></td>
					<td>' . $page->num . '</td>
				</tr>
				';
			}
			echo '
				</tbody>
			</table>
			';
		}
	
	}
	
	echo '
	<div class="clear"></div>
	<p>My grateful thanks go to the clever chaps at <a href="http://www.hostip.info">hostip.info</a>, <a href="http://iplocationtools.com">iplocationtools.com</a> and <a href="http://ipmango.com/">ipmango.com</a> for their geolocation APIs.</p>
	</div>';
}

// show a date
function wibstats_date($time)
{
	// get the start of today
	$startoftoday = mktime(0, 0, 0, date("n"), date("j"), date("Y"));
	if ($startoftoday < $time)
	{
		return date("g:i a", $time);
	} else {
		return date("F j, Y, g:i a", $time);
	}
}

// shorten long text
function wibstats_shorten($str)
{
	if (strlen($str) > 24)
	{
		return substr($str, 0, 3) . "..." . substr($str, -19);
	} else {
		return $str;
	}
}

// load the JavaScript which calls this page
function wibstats()
{
	global $user_ID;
	if ($user_ID == 0)
	{
		$js = '
// thanks to PPK (http://www.quirksmode.org/js/detect.html) for this fantastic code
var BrowserDetect = {
	init: function () {
		this.browser = this.searchString(this.dataBrowser) || "An unknown browser";
		this.version = this.searchVersion(navigator.userAgent)
			|| this.searchVersion(navigator.appVersion)
			|| "an unknown version";
		this.OS = this.searchString(this.dataOS) || "an unknown OS";
	},
	searchString: function (data) {
		for (var i=0;i<data.length;i++)	{
			var dataString = data[i].string;
			var dataProp = data[i].prop;
			this.versionSearchString = data[i].versionSearch || data[i].identity;
			if (dataString) {
				if (dataString.indexOf(data[i].subString) != -1)
					return data[i].identity;
			}
			else if (dataProp)
				return data[i].identity;
		}
	},
	searchVersion: function (dataString) {
		var index = dataString.indexOf(this.versionSearchString);
		if (index == -1) return;
		return parseFloat(dataString.substring(index+this.versionSearchString.length+1));
	},
	dataBrowser: [
		{
			string: navigator.userAgent,
			subString: "Chrome",
			identity: "Chrome"
		},
		{ 	string: navigator.userAgent,
			subString: "OmniWeb",
			versionSearch: "OmniWeb/",
			identity: "OmniWeb"
		},
		{
			string: navigator.vendor,
			subString: "Apple",
			identity: "Safari",
			versionSearch: "Version"
		},
		{
			prop: window.opera,
			identity: "Opera"
		},
		{
			string: navigator.vendor,
			subString: "iCab",
			identity: "iCab"
		},
		{
			string: navigator.vendor,
			subString: "KDE",
			identity: "Konqueror"
		},
		{
			string: navigator.userAgent,
			subString: "Firefox",
			identity: "Firefox"
		},
		{
			string: navigator.vendor,
			subString: "Camino",
			identity: "Camino"
		},
		{		// for newer Netscapes (6+)
			string: navigator.userAgent,
			subString: "Netscape",
			identity: "Netscape"
		},
		{
			string: navigator.userAgent,
			subString: "MSIE",
			identity: "Explorer",
			versionSearch: "MSIE"
		},
		{
			string: navigator.userAgent,
			subString: "Gecko",
			identity: "Mozilla",
			versionSearch: "rv"
		},
		{ 		// for older Netscapes (4-)
			string: navigator.userAgent,
			subString: "Mozilla",
			identity: "Netscape",
			versionSearch: "Mozilla"
		}
	],
	dataOS : [
		{
			string: navigator.platform,
			subString: "Win",
			identity: "Windows"
		},
		{
			string: navigator.platform,
			subString: "Mac",
			identity: "Mac"
		},
		{
			   string: navigator.userAgent,
			   subString: "iPhone",
			   identity: "iPhone/iPod"
	    },
		{
			string: navigator.platform,
			subString: "Linux",
			identity: "Linux"
		}
	]
};
BrowserDetect.init();
var page = escape(window.location.href);
var ref = escape(top.document.referrer);
var title = escape(document.title);
var color = window.screen.colorDepth; 
var res = window.screen.width + "x" + window.screen.height;
var browser = escape(BrowserDetect.browser);
var version = escape(BrowserDetect.version);
var platform = escape(BrowserDetect.OS);
document.write(\'<\' + \'img src="/wp-content/mu-plugins/wibstats.php?color=\' + color + \'&res=\' + res + \'&browser=\' + browser + \'&version=\' + version + \'&platform=\' + platform + \'&referrer=\' + ref + \'&page=\' + page + \'&title=\' + title + \'" height="1" width="1" />\');
		';
		print '<script type="text/javascript">';
		print JSMin::minify($js);
		print '</script>';
	}
}

// if all the parameters are set, run the main WibStats function
if (
isset($_GET["color"]) &&
isset($_GET["res"]) &&
isset($_GET["browser"]) &&
isset($_GET["version"]) &&
isset($_GET["platform"]) &&
isset($_GET["referrer"])
)
{
	// include Wordpress
	require_once("../../wp-blog-header.php");

	// check the statistics tables exist
	if (!wibstats_checktables())
	{
		wibstats_createtables();
	}
	// save the visit
	wibstats_savevisit();
}

// check the statistics tables exist
function wibstats_checktables()
{
	global $wpdb;
	global $current_blog;
	
	$sql1 = "show tables like '" . $wpdb->base_prefix . $current_blog->blog_id . "_wibstats';";
	$sql1 = "select latitude from " . $wpdb->base_prefix . $current_blog->blog_id . "_wibstats limit 1;";
	if ($wpdb->get_var($sql1) && $wpdb->get_var($sql1))
	{
		return true;
	} else {
		return false;
	}
}

// create the tables
function wibstats_createtables($drop = false)
{
	global $wpdb;
	global $current_blog;

	$blogid = $current_blog->blog_id;
	
	if (is_site_admin() && isset($_POST["blogid"]) && $_POST["blogid"] != "")
	{
		$blogid = trim($_POST["blogid"]);
	}
	
	require_once(ABSPATH . "wp-admin/includes/upgrade.php");
	
	if ($drop)
	{
		$sql = "DROP TABLE " . $wpdb->base_prefix . $blogid . "_wibstats;";
		dbDelta($sql);
	}
	
	// create the main stats table
	$sql = "CREATE TABLE " . $wpdb->base_prefix . $blogid . "_wibstats (
id mediumint(9) NOT NULL AUTO_INCREMENT,
timestamp bigint(11),
page VARCHAR(255),
title varchar(255),
ipaddress VARCHAR(24),
sessionid VARCHAR(24),
colordepth VARCHAR(3),
screensize VARCHAR(12),
browser VARCHAR(50),
version VARCHAR(12),
platform VARCHAR(50),
referrer VARCHAR(255),
terms VARCHAR(255),
city VARCHAR(50),
country VARCHAR(50),
countrycode VARCHAR(3),
latitude FLOAT(10,6),
longitude FLOAT(10,6),
PRIMARY KEY  (id)
);";
	dbDelta($sql);
}

// get the phrase searched for, from http://www.roscripts.com/snippets/show/74
function wibstats_get_search_phrase($referer)
{
  $key_start = 0;
  $search_phrase = "";
  // used by dogpile, excite, webcrawler, metacrawler
  if (strpos($referer, '/search/web/') !== false) $key_start = strpos($referer, '/search/web/') + 12;
  // used by chubba             
  if (strpos($referer, 'arg=') !== false) $key_start = strpos($referer, 'arg=') + 4;
  // used by dmoz              
  if (strpos($referer, 'search=') !== false) $key_start = strpos($referer, 'query=') + 7;
  // used by looksmart              
  if (strpos($referer, 'qt=') !== false) $key_start = strpos($referer, 'qt=') + 3;
  // used by scrub the web          
  if (strpos($referer, 'keyword=') !== false) $key_start = strpos($referer, 'keyword=') + 8;
  // used by overture, hogsearch            
  if (strpos($referer, 'keywords=') !== false) $key_start = strpos($referer, 'keywords=') + 9;
  // used by mamma, lycos, kanoodle, snap, whatuseek              
  if (strpos($referer, 'query=') !== false) $key_start = strpos($referer, 'query=') + 6;
  // don't allow encrypted key words by aol            
  if (strpos($referer, 'encquery=') !== false) $key_start = 0; 
  // used by ixquick              
  if (strpos($referer, '&query=') !== false) $key_start = strpos($referer, '&query=') + 7;
  // used by aol
  if (strpos($referer, 'qry=') !== false) $key_start = strpos($referer, 'qry=') + 4;
  // used by yahoo, hotbot
  if (strpos($referer, 'p=') !== false) $key_start = strpos($referer, 'p=') + 2;
  // used by google, msn, alta vista, ask jeeves, all the web, teoma, wisenut, search.com
  if (strpos($referer, 'q=') !==  false) $key_start = strpos($referer, 'q=') + 2;
  // if present, get the search phrase from the referer
  if ($key_start > 0){    
    if (strpos($referer, '&', $key_start) !== false){
      $search_phrase = substr($referer, $key_start, (strpos($referer, '&', $key_start) - $key_start));
    } elseif (strpos($referer, '/search/web/') !== false){
        if (strpos($referer, '/', $key_start) !== false){
          $search_phrase = urldecode(substr($referer, $key_start, (strpos($referer, '/', $key_start) - $key_start)));
        } else {
          $search_phrase = urldecode(substr($referer, $key_start));
        }
    } else {
      $search_phrase = substr($referer, $key_start);
    } 
  } 
  $search_phrase = urldecode($search_phrase);
  return $search_phrase;
}

// save the visit
function wibstats_savevisit()
{
	global $wpdb;
	global $current_blog;
	
	// default to not saving the visit
	$savevisit = false;

	// get the IP
	if ($_SERVER["HTTP_X_FORWARDED_FOR"]){
		$iparray = split(',', $_SERVER["HTTP_X_FORWARDED_FOR"]); 
		$fullip = $iparray[0];
		$fullip = $_SERVER["HTTP_X_FORWARDED_FOR"];
	} else {
		$fullip = $_SERVER["REMOTE_ADDR"];
	}
	
	// get the IP number
	$iplong = ip2long($fullip);
	$ipnumber = sprintf("%u", $iplong);
		
	// get the start of today
	$startoftoday = mktime(0, 0, 0, date("n"), date("j"), date("Y"));
	
	// get the page
	$page = $_GET["page"];
	
	// check if the visitor has visited this page today
	$sql = $wpdb->prepare("select count(id) from " . $wpdb->base_prefix . $current_blog->blog_id . "_wibstats
			where ipaddress = %s
			and sessionid = %s
			and page = %s
			;",
			$fullip,
			session_id(),
			$page);
	$visited = $wpdb->get_var($sql);
	if ($visited == "0") { $savevisit = true; }
	
	// if saving the visit
	if ($savevisit)
	{
		$country = "Unknown";
		$city = "Unknown";
		
		$sql = $wpdb->prepare("select country, city from " . $wpdb->base_prefix . $current_blog->blog_id . "_wibstats
							where ipaddress = %s
							and sessionid = %s
							;",
							$fullip,
							session_id());
		$geo = $wpdb->get_row($sql);
		if ($geo->country == "" && $geo->city == "")
		{

			// get the geographical data from http://www.hostip.info or http://iplocationtools.com
			$apis = array(
					array("url"=>"http://api.hostip.info/get_html.php?position=true&ip=%","name"=>"hostip.info"),
					array("url"=>"http://iplocationtools.com/ip_query.php?ip=%","name"=>"iplocationtools.com"),
					array("url"=>"http://www.ipmango.com/api.php?ip=%", "name"=>"ipmango.com")
					);
			
			// select a random api
			$api = rand(0, count($apis)-1);

			$apipath = str_replace("%", $fullip, $apis[$api]["url"]);
			$response = wp_remote_fopen($apipath);
			
			// run the function
			
			// hostip
			if ($apis[$api]["name"] == "hostip.info")
			{	
				$parts = explode("\n", $response);
				foreach($parts as $part)
				{
					if (substr($part, 0, 5) == "City:")
					{
						$city = trim(str_replace("City:", "", $part));
					}
					if (substr($part, 0, 8) == "Country:")
					{
						$city = trim(str_replace("Country:", "", $part));
					}
					if (substr($part, 0, 10) == "Longitude:")
					{
						$city = trim(str_replace("Longitude:", "", $part));
					}
					if (substr($part, 0, 9) == "Latitude:")
					{
						$city = trim(str_replace("Latitude:", "", $part));
					}
				}
			}
			
			// iplocationtools
			if ($apis[$api]["name"] == "iplocationtools.com")
			{	
				$xml = simplexml_load_string($response);
				$country = $xml->CountryName;
				$countrycode = $xml->CountryCode;
				$city = $xml->City;
				$lat = $xml->Latitude;
				$long = $xml->Longitude;
			}
			
			// ipmango
			if ($apis[$api]["name"] == "ipmango.com")
			{	
				$xml = simplexml_load_string($response);
				$country = $xml->countryname;
				$countrycode = $xml->countrycode;
				$city = $xml->city;
				$lat = $xml->latitude;
				$long = $xml->longitude;
			}
			
			// debugging
			//print "ID: ".$api."<br />API: ".$apis[$api]["name"]."<br />Country: ".$country."<br />CountryCode: ".$countrycode."<br />City: ".$city."<br />Lat: ".$lat."<br />Lng: ".$long;
		
		} else {
		
			$country = $geo->country;
			$city = $geo->city;
		
		}
		
		// get the parameters
		$colordepth = $_GET["color"];
		$screensize = $_GET["res"];
		$browser = $_GET["browser"];
		$version = $_GET["version"];
		$platform = $_GET["platform"];
		$referrer = $_GET["referrer"];
		$title = $_GET["title"];
		
		// get the search terms
		$terms = wibstats_get_search_phrase($referrer);
		
		// add the visit
		$sql = $wpdb->prepare("insert into " . $wpdb->base_prefix . $current_blog->blog_id . "_wibstats
				(timestamp, page, title, ipaddress, sessionid,
				colordepth, screensize, browser,
				version, platform, referrer, terms,
				city, country, countrycode,
				latitude, longitude)
				values
				(%d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s);",
				time(), $page, $title, $fullip, session_id(), $colordepth, $screensize, $browser,
				$version, $platform, $referrer, $terms, $city, $country, $countrycode, $lat, $long);
		$wpdb->query($sql);
	}

	// output a 1px square transparent GIF
	header("Content-type: image/gif");
	$im = imageCreate(1, 1);
	$backgroundColor = imageColorAllocate($im, 255, 255, 255);
	imageFilledRectangle($im, 0, 0, $width - 1 , $height - 1, $backgroundColor);
	imageColorTransparent($im, $backgroundColor);
	imageInterlace($im);
	imageGif($im);
	imageDestroy($im);
}

/**
 * jsmin.php - PHP implementation of Douglas Crockford's JSMin.
 *
 * This is pretty much a direct port of jsmin.c to PHP with just a few
 * PHP-specific performance tweaks. Also, whereas jsmin.c reads from stdin and
 * outputs to stdout, this library accepts a string as input and returns another
 * string as output.
 *
 * PHP 5 or higher is required.
 *
 * Permission is hereby granted to use this version of the library under the
 * same terms as jsmin.c, which has the following license:
 *
 * --
 * Copyright (c) 2002 Douglas Crockford  (www.crockford.com)
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in
 * the Software without restriction, including without limitation the rights to
 * use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies
 * of the Software, and to permit persons to whom the Software is furnished to do
 * so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * The Software shall be used for Good, not Evil.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 * --
 *
 * @package JSMin
 * @author Ryan Grove <ryan@wonko.com>
 * @copyright 2002 Douglas Crockford <douglas@crockford.com> (jsmin.c)
 * @copyright 2008 Ryan Grove <ryan@wonko.com> (PHP port)
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @version 1.1.1 (2008-03-02)
 * @link http://code.google.com/p/jsmin-php/
 */

class JSMin {
  const ORD_LF    = 10;
  const ORD_SPACE = 32;

  protected $a           = '';
  protected $b           = '';
  protected $input       = '';
  protected $inputIndex  = 0;
  protected $inputLength = 0;
  protected $lookAhead   = null;
  protected $output      = '';

  // -- Public Static Methods --------------------------------------------------

  public static function minify($js) {
    $jsmin = new JSMin($js);
    return $jsmin->min();
  }

  // -- Public Instance Methods ------------------------------------------------

  public function __construct($input) {
    $this->input       = str_replace("\r\n", "\n", $input);
    $this->inputLength = strlen($this->input);
  }

  // -- Protected Instance Methods ---------------------------------------------

  protected function action($d) {
    switch($d) {
      case 1:
        $this->output .= $this->a;

      case 2:
        $this->a = $this->b;

        if ($this->a === "'" || $this->a === '"') {
          for (;;) {
            $this->output .= $this->a;
            $this->a       = $this->get();

            if ($this->a === $this->b) {
              break;
            }

            if (ord($this->a) <= self::ORD_LF) {
              throw new JSMinException('Unterminated string literal.');
            }

            if ($this->a === '\\') {
              $this->output .= $this->a;
              $this->a       = $this->get();
            }
          }
        }

      case 3:
        $this->b = $this->next();

        if ($this->b === '/' && (
            $this->a === '(' || $this->a === ',' || $this->a === '=' ||
            $this->a === ':' || $this->a === '[' || $this->a === '!' ||
            $this->a === '&' || $this->a === '|' || $this->a === '?')) {

          $this->output .= $this->a . $this->b;

          for (;;) {
            $this->a = $this->get();

            if ($this->a === '/') {
              break;
            } elseif ($this->a === '\\') {
              $this->output .= $this->a;
              $this->a       = $this->get();
            } elseif (ord($this->a) <= self::ORD_LF) {
              throw new JSMinException('Unterminated regular expression '.
                  'literal.');
            }

            $this->output .= $this->a;
          }

          $this->b = $this->next();
        }
    }
  }

  protected function get() {
    $c = $this->lookAhead;
    $this->lookAhead = null;

    if ($c === null) {
      if ($this->inputIndex < $this->inputLength) {
        $c = $this->input[$this->inputIndex];
        $this->inputIndex += 1;
      } else {
        $c = null;
      }
    }

    if ($c === "\r") {
      return "\n";
    }

    if ($c === null || $c === "\n" || ord($c) >= self::ORD_SPACE) {
      return $c;
    }

    return ' ';
  }

  protected function isAlphaNum($c) {
    return ord($c) > 126 || $c === '\\' || preg_match('/^[\w\$]$/', $c) === 1;
  }

  protected function min() {
    $this->a = "\n";
    $this->action(3);

    while ($this->a !== null) {
      switch ($this->a) {
        case ' ':
          if ($this->isAlphaNum($this->b)) {
            $this->action(1);
          } else {
            $this->action(2);
          }
          break;

        case "\n":
          switch ($this->b) {
            case '{':
            case '[':
            case '(':
            case '+':
            case '-':
              $this->action(1);
              break;

            case ' ':
              $this->action(3);
              break;

            default:
              if ($this->isAlphaNum($this->b)) {
                $this->action(1);
              }
              else {
                $this->action(2);
              }
          }
          break;

        default:
          switch ($this->b) {
            case ' ':
              if ($this->isAlphaNum($this->a)) {
                $this->action(1);
                break;
              }

              $this->action(3);
              break;

            case "\n":
              switch ($this->a) {
                case '}':
                case ']':
                case ')':
                case '+':
                case '-':
                case '"':
                case "'":
                  $this->action(1);
                  break;

                default:
                  if ($this->isAlphaNum($this->a)) {
                    $this->action(1);
                  }
                  else {
                    $this->action(3);
                  }
              }
              break;

            default:
              $this->action(1);
              break;
          }
      }
    }

    return $this->output;
  }

  protected function next() {
    $c = $this->get();

    if ($c === '/') {
      switch($this->peek()) {
        case '/':
          for (;;) {
            $c = $this->get();

            if (ord($c) <= self::ORD_LF) {
              return $c;
            }
          }

        case '*':
          $this->get();

          for (;;) {
            switch($this->get()) {
              case '*':
                if ($this->peek() === '/') {
                  $this->get();
                  return ' ';
                }
                break;

              case null:
                throw new JSMinException('Unterminated comment.');
            }
          }

        default:
          return $c;
      }
    }

    return $c;
  }

  protected function peek() {
    $this->lookAhead = $this->get();
    return $this->lookAhead;
  }
}

// -- Exceptions ---------------------------------------------------------------
class JSMinException extends Exception {}
?>
