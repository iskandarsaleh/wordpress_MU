<?php include (TEMPLATEPATH . '/options.php'); ?>

<div id="sidebar">

<?php if($tn_wpmu_tri_show_profile == "yes"){ ?>
<?php include (TEMPLATEPATH . '/profiles.php'); ?>
<?php } ?>

<ul class="list">

<!-- video feat -->

<?php
$tn_wpmu_tri_featured_vid = get_option('tn_wpmu_tri_featured_vid');
if($tn_wpmu_tri_featured_vid == ''){ ?>
<?php } else { ?>
<li>
<h3><?php _e('Featured Videos'); ?></h3>
<ul>
<li><?php $tn_wpmu_tri_featured_vid = stripcslashes($tn_wpmu_tri_featured_vid); echo $tn_wpmu_tri_featured_vid; ?> </li>
</ul>
</li>
<?php } ?>

<!-- end -->


<?php if ( !function_exists('dynamic_sidebar')
|| !dynamic_sidebar('Sidebar') ) : ?>


<li>
<h3><?php _e('Categories'); ?></h3>
<ul>
<?php wp_list_categories('orderby=id&show_count=1&use_desc_for_title=0&title_li='); ?>
</ul>
</li>

<li>
<h3><?php _e('Archives'); ?></h3>
<ul>
<?php wp_get_archives('type=monthly&limit=12&show_post_count=1'); ?>
</ul>
</li>

<li>
<h3><?php _e('Pages'); ?></h3>
<ul>
<?php wp_list_pages('title_li=&depth=0'); ?>
</ul>
</li>

<?php endif; ?>

</ul>

</div>