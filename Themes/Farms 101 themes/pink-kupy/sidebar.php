<div class="paddingtop">
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("160x600-pinkkupy-sidebar"); } ?>
<?php if ( !function_exists('dynamic_sidebar')
        || !dynamic_sidebar() ) : ?>

<!-- begin sidebar -->
    <!--  START PAGES LIST  -->
    <span id="menutitle"><?php _e('Pages'); ?></span>
    <?php wp_list_pages('title_li='); ?>
    <!--  END PAGES LIST  -->
    <p>
    <!--  START CATEGORIES  -->
<span id="menutitle"><?php _e('Categories'); ?></span>
        <?php wp_list_cats('sort_column=name'); ?>
    <!--  END CATEGORIES  -->
    <p>
    <!--  START ARCHIVES  -->
<span id="menutitle"><?php _e('Archives'); ?></span>
        <?php wp_get_archives('type=monthly'); ?>
    <!--  END ARCHIVES  -->
    <p>
    <!--  START LINKS LIST  -->
    <p>
    <span id="menutitle"><?php _e('Links'); ?></span><br>
    <?php get_linksbyname('', '', '<br />', '', TRUE, 'name', FALSE, TRUE); ?>


  <P> 
    <!--  END LINKS LIST  -->
    <p>
    <!--  START META  -->
<span id="menutitle"><?php _e('Meta'); ?></span><br/>
        <?php wp_register(); ?>
        <?php wp_loginout(); ?><p>
        <a href="feed:<?php bloginfo('rss2_url'); ?>" title="<?php _e('Syndicate this site using RSS'); ?>"><?php _e('<abbr title="Really Simple Syndication">RSS</abbr>'); ?></a><br/>
        <a href="feed:<?php bloginfo('comments_rss2_url'); ?>" title="<?php _e('The latest comments to all posts in RSS'); ?>"><?php _e('Comments <abbr title="Really Simple Syndication">RSS</abbr>'); ?></a><br/>
        <?php wp_meta(); /* do not remove this line */ ?>
    <!--  END META  -->
<p>
<?php if (function_exists('wp_theme_switcher')) { ?>
    <!--  START THEME SWITCHER -->
<span id="menutitle"><?php _e('Themes'); ?></span>
<?php wp_theme_switcher(); ?>
    <!--  END THEME SWITCHER  -->
<?php } ?><br>

<?php endif; ?>

<!-- end sidebar -->
</div>

