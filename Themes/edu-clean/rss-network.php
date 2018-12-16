<?php include (TEMPLATEPATH . '/options.php'); ?>

<?php
if (file_exists(ABSPATH . WPINC . '/rss.php')) {
require_once (ABSPATH . WPINC . '/rss.php');
}
else if(file_exists(ABSPATH . WPINC . '/rss-functions.php')){
require_once(ABSPATH . WPINC . '/rss-functions.php');
}
?>

<?php $show_rss_network = "$tn_edus_rss_network_status"; ?>
<?php if($show_rss_network==yes): ?>

<div class="tabber">

<?php $show_rss_one = "$tn_edus_feedone_status"; ?>
<?php if($show_rss_one==yes): ?>

<div class="tabbertab">
<h3><?php echo "$tn_edus_network_one"; ?></h3>

<div class="rss-feeds">

<?php
$get_net_gfeed_url = $tn_edus_network_one_url;
$rss = @fetch_rss("$get_net_gfeed_url");
if ((isset($rss->items)) && (count($rss->items)>=1)) {
foreach(array_slice($rss->items,0,$tn_edus_network_one_sum) as $item){

$feed_livelink = $item['link'];
$feed_livelink = str_replace("&", "&amp;", $item['link']);
$feed_livelink = str_replace("&amp;&amp;", "&amp;", $item['link']);

$feed_authorlink = $item['dc']['creator'];

$feed_categorylink = $item['category'];

$feed_livetitle = ucfirst($item['title']);

if (isset($item['description'])) {
$feed_descriptions = $item['description'];
$feed_descriptions = strip_tags($feed_descriptions);
$feed_descriptions = substr_replace($feed_descriptions,"...","$tn_edus_feed_word");
} else {
$feed_descriptions = '';
}

$msg .= "
<div class=\"feed-pull\"><h1>
<a href=\"".trim($feed_livelink)."\" rel=\"external nofollow\" title=\"".trim($feed_livetitle)."\">".trim($feed_livetitle)."</a>
</h1>
<div class=\"rss-author\">By $feed_authorlink</div>
<div class=\"rss-content\">$feed_descriptions</div></div>\n";
}


echo "$msg";
} else {
_e("<div class=\"rss-content\">Currently there is no feed available</div>");
}
?>

</div>

</div>

<?php endif; ?>

<?php $show_rss_two = "$tn_edus_feedtwo_status"; ?>
<?php if($show_rss_two==yes): ?>

<div class="tabbertab">
<h3><?php echo "$tn_edus_network_two"; ?></h3>
<div class="rss-feeds">
<?php
$get_net_gfeed_url2 = $tn_edus_network_two_url;
$rss2 = @fetch_rss("$get_net_gfeed_url2");
if ((isset($rss2->items)) && (count($rss2->items)>=1)) {
foreach(array_slice($rss2->items,0,$tn_edus_network_two_sum) as $item2){

$feed_livelink2 = $item2['link'];
$feed_livelink2 = str_replace("&", "&amp;", $item2['link']);
$feed_livelink2 = str_replace("&amp;&amp;", "&amp;", $item2['link']);

$feed_authorlink2 = $item2['dc']['creator'];

$feed_categorylink2 = $item2['category'];

$feed_livetitle2 = ucfirst($item2['title']);

if (isset($item2['description'])) {
$feed_descriptions2 = $item2['description'];
$feed_descriptions2 = strip_tags($feed_descriptions2);
$feed_descriptions2 = substr_replace($feed_descriptions2,"...","$tn_edus_feed_word");
} else {
$feed_descriptions2 = '';
}

$msg2 .= "
<div class=\"feed-pull\"><h1>
<a href=\"".trim($feed_livelink2)."\" rel=\"external nofollow\" title=\"".trim($feed_livetitle2)."\">".trim($feed_livetitle2)."</a>
</h1>
<div class=\"rss-author\">By $feed_authorlink2</div>
<div class=\"rss-content\">$feed_descriptions2</div></div>\n";
}

echo "$msg2";
} else {
_e("<div class=\"rss-content\">Currently there is no feed available</div>");
}
?>
</div>

</div>

<?php endif; ?>

<?php $show_rss_three = "$tn_edus_feedthree_status"; ?>
<?php if($show_rss_three==yes): ?>

<div class="tabbertab">
<h3><?php echo "$tn_edus_network_three"; ?></h3>

<div class="rss-feeds">

<?php
$get_net_gfeed_url3 = $tn_edus_network_three_url;
$rss3 = @fetch_rss("$get_net_gfeed_url3");
if ((isset($rss3->items)) && (count($rss3->items)>=1)) {
foreach(array_slice($rss3->items,0,$tn_edus_network_three_sum) as $item3){

$feed_livelink3 = $item3['link'];
$feed_livelink3 = str_replace("&", "&amp;", $item3['link']);
$feed_livelink3 = str_replace("&amp;&amp;", "&amp;", $item3['link']);

$feed_authorlink3 = $item3['dc']['creator'];

$feed_categorylink3 = $item3['category'];

$feed_livetitle3 = ucfirst($item3['title']);

if (isset($item3['description'])) {
$feed_descriptions3 = $item3['description'];
$feed_descriptions3 = strip_tags($feed_descriptions3);
$feed_descriptions3 = substr_replace($feed_descriptions3,"...","$tn_edus_feed_word");
} else {
$feed_descriptions3 = '';
}

$msg3 .= "
<div class=\"feed-pull\"><h1>
<a href=\"".trim($feed_livelink3)."\" rel=\"external nofollow\" title=\"".trim($feed_livetitle3)."\">".trim($feed_livetitle3)."</a>
</h1>
<div class=\"rss-author\">By $feed_authorlink3</div>
<div class=\"rss-content\">$feed_descriptions3</div></div>\n";
}

echo "$msg3";
} else {
_e("<div class=\"rss-content\">Currently there is no feed available</div>");
}
?>

</div>

</div>

<?php endif; ?>

<?php $show_rss_four = "$tn_edus_feedfour_status"; ?>
<?php if($show_rss_four==yes): ?>

<div class="tabbertab">
<h3><?php echo "$tn_edus_network_four"; ?></h3>

<div class="rss-feeds">

<?php
$get_net_gfeed_url4 = $tn_edus_network_four_url;
$rss4 = @fetch_rss("$get_net_gfeed_url4");
if ((isset($rss3->items)) && (count($rss4->items)>=1)) {
foreach(array_slice($rss4->items,0,$tn_edus_network_four_sum) as $item4){

$feed_livelink4 = $item4['link'];
$feed_livelink4 = str_replace("&", "&amp;", $item4['link']);
$feed_livelink4 = str_replace("&amp;&amp;", "&amp;", $item4['link']);

$feed_authorlink4 = $item4['dc']['creator'];

$feed_categorylink4 = $item4['category'];

$feed_livetitle4 = ucfirst($item4['title']);

if (isset($item4['description'])) {
$feed_descriptions4 = $item4['description'];
$feed_descriptions4 = strip_tags($feed_descriptions4);
$feed_descriptions4 = substr_replace($feed_descriptions4,"...","$tn_edus_feed_word");
} else {
$feed_descriptions4 = '';
}

$msg4 .= "
<div class=\"feed-pull\"><h1>
<a href=\"".trim($feed_livelink4)."\" rel=\"external nofollow\" title=\"".trim($feed_livetitle4)."\">".trim($feed_livetitle4)."</a>
</h1>
<div class=\"rss-author\">By $feed_authorlink4</div>
<div class=\"rss-content\">$feed_descriptions4</div></div>\n";
}

echo "$msg4";
} else {
_e("<div class=\"rss-content\">Currently there is no feed available</div>");
}
?>
</div>

</div>

<?php endif; ?>

<!--[if !IE]> List class usage <![endif]-->

<!--[if !IE]>

<div class="tabbertab">
<h3>Links</h3>
<ul class="nolist">
<li><a href="#">Testing Comments Here&nbsp;<strong>(19)</strong></a></li>
<li><a href="#">April post test with long title tag&nbsp;<strong>(9)</strong></a></li>
<li><a href="#">Caption right within post with links&nbsp;<strong>(5)</strong></a></li>
<li><a href="#">Center Image with text&nbsp;<strong>(2)</strong></a></li>
<li><a href="#">Aloha Newstimes&nbsp;<strong>(2)</strong></a></li>
<li><a href="#">September Walking Dog Post Is Insane&nbsp;<strong>(2)</strong></a></li>
<li><a href="#">Finally Upgrade To WordPress Dexter 2.3...looking good so far&nbsp;<strong>(2)</strong></a></li>
<li><a href="#">Ji Eun - Love - in radio station lock room..superb!&nbsp;<strong>(2)</strong></a></li><li><a href="#">Right Image with text&nbsp;<strong>(1)</strong></a></li><li><a href="#">Test UL&nbsp;<strong>(1)</strong></a></li>
</ul>
</div>

<div class="tabbertab">
<h3>Links</h3>
<ul class="list-alt">
<li><a href="#">Testing Comments Here&nbsp;<strong>(19)</strong></a></li>
<li><a href="#">April post test with long title tag&nbsp;<strong>(9)</strong></a></li>
<li><a href="#">Caption right within post with links&nbsp;<strong>(5)</strong></a></li>
<li><a href="#">Center Image with text&nbsp;<strong>(2)</strong></a></li>
<li><a href="#">Aloha Newstimes&nbsp;<strong>(2)</strong></a></li>
<li><a href="#">September Walking Dog Post Is Insane&nbsp;<strong>(2)</strong></a></li>
<li><a href="#">Finally Upgrade To WordPress Dexter 2.3...looking good so far&nbsp;<strong>(2)</strong></a></li>
<li><a href="#">Ji Eun - Love - in radio station lock room..superb!&nbsp;<strong>(2)</strong></a></li><li><a href="#">Right Image with text&nbsp;<strong>(1)</strong></a></li><li><a href="#">Test UL&nbsp;<strong>(1)</strong></a></li>
</ul>
</div>

<![endif]-->

</div>

<!-- end all rss feeds -->
<?php endif; ?>