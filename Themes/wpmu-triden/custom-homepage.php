<?php include (TEMPLATEPATH . '/options.php'); ?>

<div id="top-content">

<div class="box">

<ul class="list">


<li>
<h3>
<?php if($tn_wpmu_tri_intro_header == '') { ?>
<?php _e('This is intro header'); ?>
<?php } else { ?>
<?php echo stripslashes($tn_wpmu_tri_intro_header); ?>
<?php } ?>
</h3>
<ul>
<li>
<?php if($tn_wpmu_tri_intro_header_text == '') { ?>
<?php _e('You can replace area on this page with a new text in <a href="wp-admin/themes.php?page=site-intro.php">your theme options</a>'); ?>
<?php } else { ?>
<?php echo stripslashes($tn_wpmu_tri_intro_header_text); ?>
<?php } ?>
</li>
</ul>
</li>



<?php if ( !function_exists('dynamic_sidebar')
|| !dynamic_sidebar('Top-Left') ) : ?>

<li>
<h3><?php _e('Top Left Widget'); ?></h3>
<ul>
<li><?php _e('All you need to do is to visit your <a href="wp-admin/widgets.php">widget</a> tab replace this with your widget'); ?></li>
</ul>
</li>

<?php endif; ?>

</ul>

</div>



<div class="box" id="center-box">

<ul class="list">

<?php if ( !function_exists('dynamic_sidebar')
|| !dynamic_sidebar('Top-Center') ) : ?>

<li>
<h3><?php _e('Top Center Widget'); ?></h3>
<ul>
<li><?php _e('All you need to do is to visit your <a href="wp-admin/widgets.php">widget</a> tab replace this with your widget'); ?></li>
</ul>
</li>

<?php endif; ?>

</ul>

</div>




<div class="box">


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
|| !dynamic_sidebar('Top-Right') ) : ?>


<li>
<h3><?php _e('Top Right Widget'); ?></h3>
<ul>
<li><?php _e('All you need to do is to visit your <a href="wp-admin/widgets.php">widget</a> tab replace this with your widget'); ?></li>
</ul>
</li>


<?php endif; ?>

</ul>

</div>



</div>



<div id="bottom-content">



<div id="tab-content">

<ul class="list">

<?php if ( !function_exists('dynamic_sidebar')
|| !dynamic_sidebar('Bottom-Left') ) : ?>

<li>
<h3><?php _e('Bottom Left Widget'); ?></h3>
<ul>
<li><?php _e('All you need to do is to visit your <a href="wp-admin/widgets.php">widget</a> tab replace this with your widget'); ?></li>
</ul>
</li>

<?php endif; ?>

</ul>

<?php include (TEMPLATEPATH . '/tab-content.php'); ?>

</div>


<div id="editor-content">

<ul class="list">

<?php if ( !function_exists('dynamic_sidebar')
|| !dynamic_sidebar('Bottom-Right') ) : ?>

<li>
<h3><?php _e('Bottom Right Widget'); ?></h3>
<ul>
<li><?php _e('All you need to do is to visit your <a href="wp-admin/widgets.php">widget</a> tab replace this with your widget'); ?></li>
</ul>
</li>

<?php endif; ?>

</ul>

</div>



</div>