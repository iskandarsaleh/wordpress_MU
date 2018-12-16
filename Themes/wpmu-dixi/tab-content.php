<?php include (TEMPLATEPATH . '/options.php'); ?>

<?php
if (file_exists(ABSPATH . WPINC . '/rss.php')) {
require_once (ABSPATH . WPINC . '/rss.php');
}
else if(file_exists(ABSPATH . WPINC . '/rss-functions.php')){
require_once(ABSPATH . WPINC . '/rss-functions.php');
}
?>

<div id="tab-content">

<div class="tabber">






<?php if($tn_wpmu_dixi_rss_one_url == ''){ ?>
<?php } else { ?>
<div class="tabbertab">
<h3><?php echo "$tn_wpmu_dixi_rss_one"; ?></h3>
<?php
$get_net_gfeed_url = $tn_wpmu_dixi_rss_one_url;
$rss = @fetch_rss("$get_net_gfeed_url");
if ((isset($rss->items)) && (count($rss->items)>=1)) {
foreach(array_slice($rss->items,0,$tn_wpmu_dixi_rss_one_sum) as $item){

$feed_livelink = $item['link'];
$feed_livelink = str_replace("&", "&amp;", $item['link']);
$feed_livelink = str_replace("&amp;&amp;", "&amp;", $item['link']);

$feed_authorlink = $item['dc']['creator'];

$feed_categorylink = $item['category'];

$feed_livetitle = ucfirst($item['title']);

if (isset($item['description'])) {
$feed_descriptions = $item['description'];
$feed_descriptions = strip_tags($feed_descriptions);
$feed_descriptions = substr_replace($feed_descriptions,"...","$tn_wpmu_dixi_rss_one_wordcount");
} else {
$feed_descriptions = '';
}
$msg .= "
<div class=\"feed-pull\"><h1>
<a href=\"".trim($feed_livelink)."\" rel=\"external nofollow\" title=\"".trim($feed_livetitle)."\">".trim($feed_livetitle)."</a>
</h1>
<div class=\"rss-author\">by $feed_authorlink</div>
<div class=\"rss-content\">$feed_descriptions</div></div>\n";
}
echo "$msg";
} else {
_e("<div class=\"rss-content\">Currently there is no feed available</div>");
}
?>
</div>
<?php } ?>





<?php if($tn_wpmu_dixi_rss_two_url == ''){ ?>
<?php } else { ?>
<div class="tabbertab">
<h3><?php echo "$tn_wpmu_dixi_rss_two"; ?></h3>
<?php
$get_net_gfeed_url2 = $tn_wpmu_dixi_rss_two_url;
$rss2 = @fetch_rss("$get_net_gfeed_url2");
if ((isset($rss2->items)) && (count($rss2->items)>=1)) {
foreach(array_slice($rss2->items,0,$tn_wpmu_dixi_rss_two_sum) as $item2){

$feed_livelink2 = $item2['link'];
$feed_livelink2 = str_replace("&", "&amp;", $item2['link']);
$feed_livelink2 = str_replace("&amp;&amp;", "&amp;", $item2['link']);

$feed_authorlink2 = $item2['dc']['creator'];

$feed_categorylink2 = $item2['category'];

$feed_livetitle2 = ucfirst($item2['title']);

if (isset($item2['description'])) {
$feed_descriptions2 = $item2['description'];
$feed_descriptions2 = strip_tags($feed_descriptions2);
$feed_descriptions2 = substr_replace($feed_descriptions2,"...","$tn_wpmu_dixi_rss_two_wordcount");
} else {
$feed_descriptions2 = '';
}
$msg2 .= "
<div class=\"feed-pull\"><h1>
<a href=\"".trim($feed_livelink2)."\" rel=\"external nofollow\" title=\"".trim($feed_livetitle2)."\">".trim($feed_livetitle2)."</a>
</h1>
<div class=\"rss-author\">by $feed_authorlink2</div>
<div class=\"rss-content\">$feed_descriptions2</div></div>\n";
}
echo "$msg2";
} else {
_e("<div class=\"rss-content\">Currently there is no feed available</div>");
}
?>
</div>
<?php } ?>





<?php if($tn_wpmu_dixi_rss_three_url == ''){ ?>
<?php } else { ?>
<div class="tabbertab">
<h3><?php echo "$tn_wpmu_dixi_rss_three"; ?></h3>
<?php
$get_net_gfeed_url3 = $tn_wpmu_dixi_rss_three_url;
$rss3 = @fetch_rss("$get_net_gfeed_url3");
if ((isset($rss3->items)) && (count($rss3->items)>=1)) {
foreach(array_slice($rss3->items,0,$tn_wpmu_dixi_rss_three_sum) as $item3){

$feed_livelink3 = $item3['link'];
$feed_livelink3 = str_replace("&", "&amp;", $item3['link']);
$feed_livelink3 = str_replace("&amp;&amp;", "&amp;", $item3['link']);

$feed_authorlink3 = $item3['dc']['creator'];

$feed_categorylink3 = $item3['category'];

$feed_livetitle3 = ucfirst($item3['title']);

if (isset($item3['description'])) {
$feed_descriptions3 = $item3['description'];
$feed_descriptions3 = strip_tags($feed_descriptions3);
$feed_descriptions3 = substr_replace($feed_descriptions3,"...","$tn_wpmu_dixi_rss_three_wordcount");
} else {
$feed_descriptions3 = '';
}
$msg3 .= "
<div class=\"feed-pull\"><h1>
<a href=\"".trim($feed_livelink3)."\" rel=\"external nofollow\" title=\"".trim($feed_livetitle3)."\">".trim($feed_livetitle3)."</a>
</h1>
<div class=\"rss-author\">by $feed_authorlink3</div>
<div class=\"rss-content\">$feed_descriptions3</div></div>\n";
}
echo "$msg3";
} else {
_e("<div class=\"rss-content\">Currently there is no feed available</div>");
}
?>
</div>
<?php } ?>



<?php if($tn_wpmu_dixi_rss_four_url == ''){ ?>
<?php } else { ?>
<div class="tabbertab">
<h3><?php echo "$tn_wpmu_dixi_rss_four"; ?></h3>
<?php
$get_net_gfeed_url4 = $tn_wpmu_dixi_rss_four_url;
$rss4 = @fetch_rss("$get_net_gfeed_url4");
if ((isset($rss4->items)) && (count($rss4->items)>=1)) {
foreach(array_slice($rss4->items,0,$tn_wpmu_dixi_rss_four_sum) as $item4){

$feed_livelink4 = $item4['link'];
$feed_livelink4 = str_replace("&", "&amp;", $item4['link']);
$feed_livelink4 = str_replace("&amp;&amp;", "&amp;", $item4['link']);

$feed_authorlink4 = $item4['dc']['creator'];

$feed_categorylink4 = $item4['category'];

$feed_livetitle4 = ucfirst($item4['title']);

if (isset($item4['description'])) {
$feed_descriptions4 = $item4['description'];
$feed_descriptions4 = strip_tags($feed_descriptions4);
$feed_descriptions4 = substr_replace($feed_descriptions4,"...","$tn_wpmu_dixi_rss_four_wordcount");
} else {
$feed_descriptions4 = '';
}
$msg4 .= "
<div class=\"feed-pull\"><h1>
<a href=\"".trim($feed_livelink4)."\" rel=\"external nofollow\" title=\"".trim($feed_livetitle4)."\">".trim($feed_livetitle4)."</a>
</h1>
<div class=\"rss-author\">by $feed_authorlink4</div>
<div class=\"rss-content\">$feed_descriptions4</div></div>\n";
}
echo "$msg4";
} else {
_e("<div class=\"rss-content\">Currently there is no feed available</div>");
}
?>
</div>
<?php } ?>




<?php if($tn_wpmu_dixi_rss_five_url == ''){ ?>
<?php } else { ?>
<div class="tabbertab">
<h3><?php echo "$tn_wpmu_dixi_rss_five"; ?></h3>
<?php
$get_net_gfeed_url5 = $tn_wpmu_dixi_rss_five_url;
$rss5 = @fetch_rss("$get_net_gfeed_url5");
if ((isset($rss5->items)) && (count($rss5->items)>=1)) {
foreach(array_slice($rss5->items,0,$tn_wpmu_dixi_rss_five_sum) as $item5){

$feed_livelink5 = $item5['link'];
$feed_livelink5 = str_replace("&", "&amp;", $item5['link']);
$feed_livelink5 = str_replace("&amp;&amp;", "&amp;", $item5['link']);

$feed_authorlink5 = $item5['dc']['creator'];

$feed_categorylink5 = $item5['category'];

$feed_livetitle5 = ucfirst($item5['title']);

if (isset($item5['description'])) {
$feed_descriptions5 = $item5['description'];
$feed_descriptions5 = strip_tags($feed_descriptions5);
$feed_descriptions5 = substr_replace($feed_descriptions5,"...","$tn_wpmu_dixi_rss_five_wordcount");
} else {
$feed_descriptions5 = '';
}
$msg5 .= "
<div class=\"feed-pull\"><h1>
<a href=\"".trim($feed_livelink5)."\" rel=\"external nofollow\" title=\"".trim($feed_livetitle5)."\">".trim($feed_livetitle5)."</a>
</h1>
<div class=\"rss-author\">by $feed_authorlink5</div>
<div class=\"rss-content\">$feed_descriptions5</div></div>\n";
}
echo "$msg5";
} else {
_e("<div class=\"rss-content\">Currently there is no feed available</div>");
}
?>
</div>
<?php } ?>








</div>
</div>