<div class="post-category">Categorized in <?php the_category(', ') ?></div>
<div class="post-tag"><?php if(function_exists("UTW_ShowTagsForCurrentPost")) : ?><?php UTW_ShowTagsForCurrentPost("commalist", array('last'=>' and %taglink%', 'first'=>'tagged in: %taglink%',)) ?><?php else : ?><?php if(function_exists("the_tags")) : ?><?php the_tags() ?><?php endif; ?><?php endif; ?></div>


<?php
$get_social = get_option('tn_wpmu_social_status');
if(($get_social == "") || ($get_social == "disable")) { ?>
<?php } else { ?>

<?php if((is_single()) || (is_page())) { ?>
<div class="post-social">
<?php
$plink = get_permalink();
$plink = urlencode($plink);
?>
<script type="text/javascript">
addthis_url    = '<?php echo "$plink"; ?> ';
addthis_title  = '<?php the_title(); ?>';
addthis_pub    = '';
</script><script type="text/javascript" src="http://s7.addthis.com/js/addthis_widget.php?v=12" ></script>
</div>

<?php } ?>

<?php } ?>



<div class="post-mail">
<ul>

<?php if((is_single()) || (is_page())) { ?>
<?php } else { ?>
<li class="mycomment"><?php comments_popup_link('No Comment', '1 Comment', '% Comments'); ?>  </li>
<?php } ?>

<li class="myemail"><a href="mailto:your@friend.com?subject=check this post - <?php the_title(); ?>&amp;body=<?php the_permalink(); ?> " rel="nofollow">Email to friend</a></li>
<li class="myblogit"><a href="<?php trackback_url() ?>">Blog it</a></li>
<li class="myupdate"><a href="<?php bloginfo('rss2_url'); ?>">Stay updated</a></li>

</ul>
</div>