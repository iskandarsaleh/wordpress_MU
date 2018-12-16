<?php
  load_theme_textdomain('mandigo');

  // directories
  $dirs = array();
  $dirs['loc']['theme'] = TEMPLATEPATH ."/";
  $dirs['www']['theme'] = get_bloginfo('template_directory') ."/";

  foreach(array('loc','www') as $i) {
    foreach(array('images','js','schemes','images/patterns','images/headers','images/icons') as $j) {
      $dirs[$i][preg_replace('/.+\//','',$j)] = $dirs[$i]['theme'].$j.'/';
    }
  }

  // schemes
  $schemes = array();
  if (($dir = opendir($dirs['loc']['schemes'])) !== false) {
    while (($node = readdir($dir)) !== false) {
      if (!preg_match('/^\.{1,2}$/',$node) && file_exists($dirs['loc']['schemes']."$node/scheme.css")) {
        $schemes[] = $node;
      }
    }
  }
  sort($schemes);

  // Set default values
  if (!get_option('mandigo_scheme') || !array_search(get_option('mandigo_scheme'),$schemes)) update_option('mandigo_scheme',$schemes[0]);
  if (!get_option('mandigo_bgcolor'              )) update_option('mandigo_bgcolor'              ,'#44484F');
  if (!get_option('mandigo_wp_repeat'            )) update_option('mandigo_wp_repeat'            ,'repeat' );

  if (!get_option('mandigo_title_scheme_index'   )) update_option('mandigo_title_scheme_index'   ,'%blogname% - %tagline%');
  if (!get_option('mandigo_title_scheme_single'  )) update_option('mandigo_title_scheme_single'  ,'%blogname% &raquo; %post%');
  if (!get_option('mandigo_title_scheme_page'    )) update_option('mandigo_title_scheme_page'    ,'%blogname% &raquo; %post%');
  if (!get_option('mandigo_title_scheme_category')) update_option('mandigo_title_scheme_category','%blogname% &raquo; Archive for %category%');
  if (!get_option('mandigo_title_scheme_date'    )) update_option('mandigo_title_scheme_date'    ,'%blogname% &raquo; Archive for %date%');
  if (!get_option('mandigo_title_scheme_search'  )) update_option('mandigo_title_scheme_search'  ,'%blogname% &raquo; Search Results for &quot;%search%&quot;');

  if (!get_option('mandigo_tag_blogname'         )) update_option('mandigo_tag_blogname'         ,'h1');
  if (!get_option('mandigo_tag_blogdesc'         )) update_option('mandigo_tag_blogdesc'         ,'h6');
  if (!get_option('mandigo_tag_posttitle_multi'  )) update_option('mandigo_tag_posttitle_multi'  ,'h2');
  if (!get_option('mandigo_tag_posttitle_single' )) update_option('mandigo_tag_posttitle_single' ,'h2');
  if (!get_option('mandigo_tag_pagetitle'        )) update_option('mandigo_tag_pagetitle'        ,'h2');
  if (!get_option('mandigo_tag_sidebar'          )) update_option('mandigo_tag_sidebar'          ,'h2');

  if (!get_option('mandigo_posts_bgcolor'        )) update_option('mandigo_posts_bgcolor'        ,'#FAFAFA');
  if (!get_option('mandigo_posts_bdcolor'        )) update_option('mandigo_posts_bdcolor'        ,'#EEEEEE');
  if (!get_option('mandigo_sidebars_bgcolor'     )) update_option('mandigo_sidebars_bgcolor'     ,'#EEEEEE');
  if (!get_option('mandigo_sidebars_bdcolor'     )) update_option('mandigo_sidebars_bdcolor'     ,'#DDDDDD');

  // some global vars
  $ie      = preg_match("/MSIE [4-6]/",$_SERVER['HTTP_USER_AGENT']);
  $ie7     = preg_match("/MSIE 7/",    $_SERVER['HTTP_USER_AGENT']);
  $wpmu    = function_exists('is_site_admin');
  $dirs['loc']['scheme'] = $dirs['loc']['schemes'] . get_option('mandigo_scheme') ."/";
  $dirs['www']['scheme'] = $dirs['www']['schemes'] . get_option('mandigo_scheme') ."/";


  // Register sidebars
  $tag_sidebar = get_option('mandigo_tag_sidebar');
  if (function_exists('register_sidebar')) {
    register_sidebar(array('before_title' => "<$tag_sidebar class=\"widgettitle\">", 'after_title' => "</$tag_sidebar>\n"));
  }





  /* -------------------------------------------------
                      SEARCH WIDGET
  -------------------------------------------------- */
  function widget_mandigo_search() {
    global $tag_sidebar;
?>
			<li><<?php echo $tag_sidebar; ?> class="widgettitle"><?php _e('Search','mandigo'); ?></<?php echo $tag_sidebar; ?>>
				<?php include(TEMPLATEPATH . '/searchform.php'); ?>
			</li>
<?php
  }
  if (function_exists('register_sidebar_widget')) register_sidebar_widget('Search','widget_mandigo_search');





  /* -------------------------------------------------
                    CALENDAR WIDGET
  -------------------------------------------------- */
  function widget_mandigo_calendar() {
    global $tag_sidebar;
?>
			<li><<?php echo $tag_sidebar; ?> class="widgettitle">&nbsp;</<?php echo $tag_sidebar; ?>>
				<?php get_calendar(); ?>
			</li>
<?php
  }
  if (function_exists('register_sidebar_widget')) register_sidebar_widget('Calendar','widget_mandigo_calendar');





  /* -------------------------------------------------
                       META WIDGET
  -------------------------------------------------- */
  function widget_mandigo_meta() {
    global $dirs, $tag_sidebar, $wpmu;
    $options = get_option('widget_meta');
?>
				<li><<?php echo $tag_sidebar; ?> class="widgettitle"><?php echo ($options['title'] ? $options['title'] : __('Meta','mandigo')); ?></<?php echo $tag_sidebar; ?>>
                                <span id="rss"><a href="<?php bloginfo('rss2_url'); ?>" title="RSS feed for <?php bloginfo('name'); ?>"><img src="<?php echo $dirs['www']['scheme']; ?>/images/rss_l.gif" alt="Entries (RSS)" id="rssicon" onmouseover="hover(1,'rssicon','rss_l')" onmouseout="hover(0,'rssicon','rss_l')" /></a></span>
				<ul>
					<?php wp_register(); ?>
					<li><?php wp_loginout(); ?></li>
<?php if ($wpmu): ?>
					<li><a href="http://mu.wordpress.org/" title="Powered by WordPress MU, state-of-the-art semantic personal publishing platform.">WordPress MU</a></li>
<?php else: ?>
					<li><a href="http://wordpress.org/" title="Powered by WordPress, state-of-the-art semantic personal publishing platform.">WordPress</a></li>
<?php endif; ?>
					<li><a href="http://www.onehertz.com/portfolio/wordpress/" title="More WordPress themes by the same author" target="_blank">Mandigo theme</a></li>
					<?php wp_meta(); ?>
				</ul>
				</li>
<?php
  }
  if (function_exists('register_sidebar_widget')) register_sidebar_widget('Meta','widget_mandigo_meta');



  function mandigo_author_link($author_id,$author_nicename) {
    // I'm not sure why, but the get_author_posts_url() function is undefined in some translated versions of WP
    if (function_exists('get_author_posts_url')) {
      return '<a href="'. get_author_posts_url($author_id) .'" title="'. sprintf(__("Posts by %s"), attribute_escape($author_nicename)).' ">'. $author_nicename .'</a>';
    }
    return $author_nicename;
  }




  /* -------------------------------------------------
                  THEME OPTIONS PAGES
  -------------------------------------------------- */
  add_action('admin_menu', 'add_mandigo_options_page');

  function add_mandigo_options_page() {
    global $dirs;
    add_theme_page(
      'Theme Options',
      '<img src="'. $dirs['www']['images'] .'/attention_catcher.png" alt="" /> Theme Options',
      'edit_themes',
      basename(__FILE__),
      'mandigo_options_page'
    );
  }

  function add_mandigo_readme_page()  {
    add_theme_page(
      'README',
      'README',
      'switch_themes',
      'README',
      'mandigo_readme_page'
    );
  }

  function mandigo_set_var($var,$value) { update_option('mandigo_'. $var, $value); }
  function mandigo_color($value,$default) { 
    if (!preg_match("/^#/",$value)) $value = '#'. $value;
    if (!preg_match("/^#([0-9A-F]{3}){1,2}$/i",$value)) $value = $default;
    return $value;
  }
  function mandigo_escape($string)      {
    $string = str_replace('\\"','&#34;',$string);
    $string = str_replace("\\'",'&#39;',$string);
    return $string;
  }

  function mandigo_options_page() {
    global $dirs, $schemes;

    if ( $_GET['page'] == basename(__FILE__) ) {
      $ct = current_theme_info();

      if (isset($_POST['updated'])) {
        $exclude[] = '';
        foreach ($_POST as $field => $value) {
          if (preg_match("/exclude_(\d+)/",$field,$id)) { $exclude[] = $id[1]; }
        }
        mandigo_set_var('exclude_pages'             ,implode(",",$exclude)          );
        mandigo_set_var('bgcolor'                   ,mandigo_color($_POST['bgcolor']         ,'#44484F'));
        mandigo_set_var('posts_bgcolor'             ,mandigo_color($_POST['posts_bgcolor']   ,'#FAFAFA'));
        mandigo_set_var('posts_bdcolor'             ,mandigo_color($_POST['posts_bdcolor']   ,'#EEEEEE'));
        mandigo_set_var('sidebars_bgcolor'          ,mandigo_color($_POST['sidebars_bgcolor'],'#EEEEEE'));
        mandigo_set_var('sidebars_bdcolor'          ,mandigo_color($_POST['sidebars_bdcolor'],'#DDDDDD'));
        mandigo_set_var('dates'                     ,$_POST['dates']                );
        mandigo_set_var('scheme'                    ,$_POST['scheme']               );
        mandigo_set_var('wp'                        ,$_POST['wp']                   );
        mandigo_set_var('scheme_random'             ,$_POST['random']               );
        mandigo_set_var('headoverlay'               ,$_POST['headoverlay']          );
        mandigo_set_var('bold_links'                ,$_POST['boldlinks']            );
        mandigo_set_var('1024'                      ,$_POST['wide']                 );
        mandigo_set_var('nofloat'                   ,$_POST['nofloat']              );
        mandigo_set_var('footer_stats'              ,$_POST['footstats']            );
        mandigo_set_var('nosidebars'                ,($_POST['sidebars'] == 0 ? 1:0));
        mandigo_set_var('3columns'                  ,($_POST['sidebars'] == 2 ? 1:0));
        mandigo_set_var('sidebar1_left'             ,$_POST['sidebar1']             );
        mandigo_set_var('sidebar2_left'             ,$_POST['sidebar2']             );
        mandigo_set_var('headnav_left'              ,$_POST['headnavleft']          );
        mandigo_set_var('always_show_sidebars'      ,$_POST['alwayssidebars']       );
        mandigo_set_var('em_italics'                ,$_POST['em']                   );
        mandigo_set_var('stroke'                    ,$_POST['stroke']               );
        mandigo_set_var('headers_random'            ,$_POST['randomheaders']        );
        mandigo_set_var('slim_header'               ,$_POST['slimheader']           );
        mandigo_set_var('hide_blogname'             ,$_POST['hideblogname']         );
        mandigo_set_var('hide_blogdesc'             ,$_POST['hideblogdesc']         );
        mandigo_set_var('noborder'                  ,$_POST['noborder']             );
        mandigo_set_var('small_title'               ,$_POST['smalltitle']           );
        mandigo_set_var('wp_fixed'                  ,$_POST['wpfixed']              );
        mandigo_set_var('wp_repeat'                 ,$_POST['wprepeat']             );
        mandigo_set_var('wp_position'               ,$_POST['wpposition']           );
        mandigo_set_var('number_comments'           ,$_POST['numbercomments']       );
        mandigo_set_var('full_search_results'       ,$_POST['fullsearchresults']    );
        mandigo_set_var('drop_shadow'               ,$_POST['dropshadow']           );
        mandigo_set_var('author_comments'           ,$_POST['authorcomments']       );
        mandigo_set_var('floatright'                ,$_POST['floatright']           );
        mandigo_set_var('xhtml_comments'            ,$_POST['xhtmlcomments']        );
        mandigo_set_var('nojustify'                 ,$_POST['nojustify']            );
        mandigo_set_var('title_scheme_index'        ,mandigo_escape($_POST['title_scheme_index']   ));
        mandigo_set_var('title_scheme_single'       ,mandigo_escape($_POST['title_scheme_single']  ));
        mandigo_set_var('title_scheme_page'         ,mandigo_escape($_POST['title_scheme_page']    ));
        mandigo_set_var('title_scheme_category'     ,mandigo_escape($_POST['title_scheme_category']));
        mandigo_set_var('title_scheme_date'         ,mandigo_escape($_POST['title_scheme_date']    ));
        mandigo_set_var('title_scheme_search'       ,mandigo_escape($_POST['title_scheme_search']  ));
        mandigo_set_var('tag_blogname'              ,$_POST['tag_blogname']         );
        mandigo_set_var('tag_blogdesc'              ,$_POST['tag_blogdesc']         );
        mandigo_set_var('tag_posttitle_multi'       ,$_POST['tag_posttitle_multi']  );
        mandigo_set_var('tag_posttitle_single'      ,$_POST['tag_posttitle_single'] );
        mandigo_set_var('tag_pagetitle'             ,$_POST['tag_pagetitle']        );
        mandigo_set_var('tag_sidebar'               ,$_POST['tag_sidebar']          );
        mandigo_set_var('tags_after'                ,$_POST['tags_after']           );
        mandigo_set_var('no_animations'             ,$_POST['no_animations']        );
        mandigo_set_var('trackbacks_after'          ,$_POST['trackbacksafter']      );
      }
      $exclude              = split(",",get_option('mandigo_exclude_pages'));
      $scheme               = get_option('mandigo_scheme'                  );
      $headoverlay          = get_option('mandigo_headoverlay'             );
      $dates                = get_option('mandigo_dates'                   );
      $sidebar1             = get_option('mandigo_sidebar1_left'           );
      $sidebar2             = get_option('mandigo_sidebar2_left'           );
      $headnavleft          = get_option('mandigo_headnav_left'            );
      $wp                   = get_option('mandigo_wp'                      );
      $stroke               = get_option('mandigo_stroke'                  );
      $wp_fixed             = get_option('mandigo_wp_fixed'                );
      $wp_repeat            = get_option('mandigo_wp_repeat'               );

      $tag_blogname         = get_option('mandigo_tag_blogname'            );
      $tag_blogdesc         = get_option('mandigo_tag_blogdesc'            );
      $tag_posttitle_multi  = get_option('mandigo_tag_posttitle_multi'     );
      $tag_posttitle_single = get_option('mandigo_tag_posttitle_single'    );
      $tag_pagetitle        = get_option('mandigo_tag_pagetitle'           );
      $tag_sidebar          = get_option('mandigo_tag_sidebar'             );

      $dirs['www']['scheme'] = $dirs['www']['scheme'] . "$scheme/";

      foreach ($schemes as $i) {
	$select_schemes .= '<input type="radio" name="scheme" value="'. $i .'" '. ($scheme == $i ? 'checked="checked"' : '') .' /><img src="'. $dirs['www']['schemes'] . $i .'/preview.jpg" alt="'. $i .'" /> &nbsp;';
      }

      $patternsdir = opendir($dirs['loc']['patterns']);
      $select_patterns = '<option value=""'. (!$wp ? ' selected="selected"' : '') .'>none</option>';
      while (false !== ($i = readdir($patternsdir))) {
        if (preg_match("/\.(?:jpe?g|png|gif|bmp)$/i",$i)) {
          $select_patterns .= '<option value="'. $i .'"'. ($i == $wp ? ' selected="selected"' : '') .'>images/patterns/'. $i .'</option>';
        }
      }

      $pages = &get_pages('sort_column=menu_order');
      foreach ($pages as $i) {
        if (!$i->post_parent) {
          $select_pages .= '<input type="checkbox" name="exclude_'. $i->ID .'"'. (array_search($i->ID, $exclude) ? ' checked' : '') .' /> '. $i->post_title . '<br />';
        }
      }

      echo '
		<div class="wrap">
		<h2>Mandigo Options</h2>
	
		<form name="mandigo_options_form" method="post" action="?page=functions.php">
		<input type="hidden" name="updated" value="1" />
		<p class="submit"><input type="submit" name="Submit" value="'.__('Update Options &raquo;').'"/></p>
		
		<fieldset class="options">
		<legend>Color Scheme</legend>
		'.$select_schemes.'
		<br /><br />

		<input type="checkbox" name="random" value="1" ' .(get_option('mandigo_scheme_random') ? 'checked="checked"' : '') .' /> I like them all, change schemes randomly!<br /><br />

		<label><b>Background</b></label><br />
		<table border="0">
			<tr>
				<td align="right">Background color:</td>
				<td>
					<input type="text" name="bgcolor" value="'. get_option('mandigo_bgcolor') .'" /> <a href="#" onclick="javascript:document.forms.mandigo_options_form.bgcolor.value=\'#44484F\';">restore default</a>
				</td>
			</tr>
			<tr>
				<td align="right">Background pattern:</td>
				<td>
					<select name="wp">
						'.$select_patterns.'
					</select>
				</td>
			</tr>
			<tr>
				<td align="right">Attachment :</td>
				<td>
					<input type="radio" name="wpfixed" value="0" '. ($wp_fixed ? '' : 'checked="checked"') .' />scroll &nbsp; 
					<input type="radio" name="wpfixed" value="1" '. ($wp_fixed ? 'checked="checked"' : '') .' />fixed
				</td>
			</tr>
			<tr>
				<td align="right">Repeat :</td>
				<td>
					<select name="wprepeat">
						<option value="repeat" '.    ($wp_repeat == 'repeat'    ? 'selected="selected"' : '') .'>both horizontally and vertically</option>
						<option value="repeat-x" '.  ($wp_repeat == 'repeat-x'  ? 'selected="selected"' : '') .'>horizontally only</option>
						<option value="repeat-y" '.  ($wp_repeat == 'repeat-y'  ? 'selected="selected"' : '') .'>vertically only</option>
						<option value="no-repeat" '. ($wp_repeat == 'no-repeat' ? 'selected="selected"' : '') .'>do not repeat</option>
					</select>
				</td>
			</tr>
			<tr>
				<td align="right">Position :</td>
				<td>
					<input type="text" name="wpposition" value="'. get_option('mandigo_wp_position') .'" size="30" /> <a href="http://www.w3.org/TR/CSS21/colors.html#propdef-background-position" target="_blank">help</a>
				</td>
			</tr>
		</table>

		<label><b>Colors</b></label><br />
		<table>
			<tr>
				<td align="right">Posts background color :</td>
				<td><input type="text" name="posts_bgcolor" value="'. get_option('mandigo_posts_bgcolor') .'" /> <a href="#" onclick="javascript:document.forms.mandigo_options_form.posts_bgcolor.value=\'#FAFAFA\';">restore default</a></td>
			</tr>
			<tr>
				<td align="right">Posts border color :</td>
				<td><input type="text" name="posts_bdcolor" value="'. get_option('mandigo_posts_bdcolor') .'" /> <a href="#" onclick="javascript:document.forms.mandigo_options_form.posts_bdcolor.value=\'#EEEEEE\';">restore default</a></td>
			</tr>
			<tr>
				<td align="right">Sidebars background color :</td>
				<td><input type="text" name="sidebars_bgcolor" value="'. get_option('mandigo_sidebars_bgcolor') .'" /> <a href="#" onclick="javascript:document.forms.mandigo_options_form.sidebars_bgcolor.value=\'#EEEEEE\';">restore default</a></td>
			</tr>
			<tr>
				<td align="right">Sidebars border color :</td>
				<td><input type="text" name="sidebars_bdcolor" value="'. get_option('mandigo_sidebars_bdcolor') .'" /> <a href="#" onclick="javascript:document.forms.mandigo_options_form.sidebars_bdcolor.value=\'#DDDDDD\';">restore default</a></td>
			</tr>
		</table>
		</fieldset>

		<br/>

		<fieldset class="options">
		<legend>Layout Options</legend>
		<input type="checkbox" name="wide" '. (get_option('mandigo_1024') ? 'checked="checked"' : '') .' /> Use the 1024px theme look instead of the default 800px one<br />
		<input type="checkbox" name="alwayssidebars" '. (get_option('mandigo_always_show_sidebars') ? 'checked="checked"' : '') .' /> Show sidebars even in single post view<br />

		Columns: <select name="sidebars">
				<option value="0" '.  (get_option('mandigo_nosidebars') ? 'selected="selected"' : '') .'>1 column (no sidebar at all)</option>
				<option value="1" '.  (!get_option('mandigo_nosidebars') && !get_option('mandigo_3columns') ? 'selected="selected"' : '') .'>2 columns (1 sidebar, default)</option>
				<option value="2" '.  (get_option('mandigo_3columns') ? 'selected="selected"' : '') .'>3 columns (2 sidebars, 1024px must be selected)</option>
		</select><br /><br />

		<label><b>Sidebars position</b></label><br/>
		<table border="0">
			<tr>
				<td align="right">First sidebar :</td>
				<td>
					<input type="radio" name="sidebar1" value="1"  '. ($sidebar1 ? 'checked="checked"' : '') .' />left &nbsp; 
					<input type="radio" name="sidebar1" value="0"  '. ($sidebar1 ? '' : 'checked="checked"') .' />right
				</td>
			</tr>
			<tr>
				<td align="right">Second sidebar :</td>
				<td>
					<input type="radio" name="sidebar2" value="1"  '. ($sidebar2 ? 'checked="checked"' : '') .' />left &nbsp; 
					<input type="radio" name="sidebar2" value="0"  '. ($sidebar2 ? '' : 'checked="checked"') .' />right
				</td>
			</tr>
		</table>
		</fieldset>

		<br/>

		<fieldset class="options">
		<legend>Header Options</legend>
		Align navigation : 
		<input type="radio" name="headnavleft" value="1"  '. ($headnavleft ? 'checked="checked"' : '') .' />left &nbsp; 
		<input type="radio" name="headnavleft" value="0"  '. ($headnavleft ? '' : 'checked="checked"') .' />right<br />
		<input type="checkbox" name="slimheader" '. (get_option('mandigo_slim_header') ? 'checked="checked"' : '') .' /> Use slim (100px smaller) headers<br />
		<input type="checkbox" name="randomheaders" '. (get_option('mandigo_headers_random') ? 'checked="checked"' : '') .' /> Use random images from the images/headers/ subfolder <strong>*only effect if the custom header image not active</strong><br />
		<cite>It is also possible to use a different image on each page (per-page header images). Please consult the <a href="themes.php?page=README">README page</a> for more information.</cite><br /><br />

		<label><b>Blog Name &amp; Description</b></label><br />
		<input type="checkbox" name="smalltitle" '. (get_option('mandigo_small_title') ? 'checked="checked"' : '') .' /> Reduce the size font for the blog name (useful for looong titles)<br /> 
		<input type="checkbox" name="hideblogname" '. (get_option('mandigo_hide_blogname') ? 'checked="checked"' : '') .' /> Do not display the blog name<br /> 
		<input type="checkbox" name="hideblogdesc" '. (get_option('mandigo_hide_blogdesc') ? 'checked="checked"' : '') .' /> Do not display the tagline (blog description)<br />
		<input type="checkbox" name="dropshadow" '. (get_option('mandigo_drop_shadow') ? 'checked="checked"' : '') .' /> Add a drop shadow to blog name and description<br /><br />
                Apply a black stroke to blog name and blog description for better readability on lighter header images.<br/><br/>
		<input type="radio" name="stroke" value="0"  '. ($stroke ? '' : 'checked="checked"') .' /><img src="'. get_bloginfo('template_directory') .'/option-stroke-off.jpg" alt="off" /> &nbsp; 
		<input type="radio" name="stroke" value="1"  '. ($stroke ? 'checked="checked"' : '') .' /><img src="'. get_bloginfo('template_directory') .'/option-stroke-on.jpg"  alt="on"  /><br /><br />

		<label><b>Page Navigation Overlay</b></label><br />
                Apply a translucent black stripe to the header for better readability.<br/><br/>
		<input type="radio" name="headoverlay" value="0"  '. ($headoverlay ? '' : 'checked="checked"') .' /><img src="'. get_bloginfo('template_directory') .'/option-headoverlay-off.jpg" alt="off" /> &nbsp; 
		<input type="radio" name="headoverlay" value="1"  '. ($headoverlay ? 'checked="checked"' : '') .' /><img src="'. get_bloginfo('template_directory') .'/option-headoverlay-on.jpg"  alt="on"  /><br /><br />

		<label><b>Pages to Exclude from Header Navigation</b></label><br />
		'. $select_pages .'<br />
		</fieldset>

		<br/>
	
		<fieldset class="options">
		<legend>Comments</legend>
		<input type="checkbox" name="authorcomments" '. (get_option('mandigo_author_comments') ? 'checked="checked"' : '') .' /> Highlight comments made by the author of the current post<br />
		<input type="checkbox" name="numbercomments" '. (get_option('mandigo_number_comments') ? 'checked="checked"' : '') .' /> Number comments<br />
		<input type="checkbox" name="xhtmlcomments" '. (get_option('mandigo_xhtml_comments') ? 'checked="checked"' : '') .' /> Display allowed XHTML tags above the comment field<br />
		<input type="checkbox" name="trackbacksafter" '. (get_option('mandigo_trackbacks_after') ? 'checked="checked"' : '') .' /> Display trackbacks after the comments<br /><br />
		</fieldset>

		<br/>
	
		<fieldset class="options">
	

		<label><b>Custom header levels</b></label><br/>
		Customize which tags you want to use for the blog name, blog description, posts title, ... This does not affect styles.
		<table>
			<tr>
				<td style="text-align: right;">Blog name:</td>
				<td>
					<select name="tag_blogname">
						<option value="h1"'. ($tag_blogname == 'h1' ? ' selected="selected"' : '') .'>h1</option>
						<option value="h2"'. ($tag_blogname == 'h2' ? ' selected="selected"' : '') .'>h2</option>
						<option value="h3"'. ($tag_blogname == 'h3' ? ' selected="selected"' : '') .'>h3</option>
						<option value="h4"'. ($tag_blogname == 'h4' ? ' selected="selected"' : '') .'>h4</option>
						<option value="h5"'. ($tag_blogname == 'h5' ? ' selected="selected"' : '') .'>h5</option>
						<option value="h6"'. ($tag_blogname == 'h6' ? ' selected="selected"' : '') .'>h6</option>
						<option value="div"'. ($tag_blogname == 'div' ? ' selected="selected"' : '') .'>div</option>
					</select>
				</td>
			</tr>
			<tr>
				<td style="text-align: right;">Blog description (tagline):</td>
				<td>
					<select name="tag_blogdesc">
						<option value="h1"'. ($tag_blogdesc == 'h1' ? ' selected="selected"' : '') .'>h1</option>
						<option value="h2"'. ($tag_blogdesc == 'h2' ? ' selected="selected"' : '') .'>h2</option>
						<option value="h3"'. ($tag_blogdesc == 'h3' ? ' selected="selected"' : '') .'>h3</option>
						<option value="h4"'. ($tag_blogdesc == 'h4' ? ' selected="selected"' : '') .'>h4</option>
						<option value="h5"'. ($tag_blogdesc == 'h5' ? ' selected="selected"' : '') .'>h5</option>
						<option value="h6"'. ($tag_blogdesc == 'h6' ? ' selected="selected"' : '') .'>h6</option>
						<option value="div"'. ($tag_blogdesc == 'div' ? ' selected="selected"' : '') .'>div</option>
					</select>
				</td>
			</tr>
			<tr>
				<td style="text-align: right;">Post title (when showing multiple posts):</td>
				<td>
					<select name="tag_posttitle_multi">
						<option value="h1"'. ($tag_posttitle_multi == 'h1' ? ' selected="selected"' : '') .'>h1</option>
						<option value="h2"'. ($tag_posttitle_multi == 'h2' ? ' selected="selected"' : '') .'>h2</option>
						<option value="h3"'. ($tag_posttitle_multi == 'h3' ? ' selected="selected"' : '') .'>h3</option>
						<option value="h4"'. ($tag_posttitle_multi == 'h4' ? ' selected="selected"' : '') .'>h4</option>
						<option value="h5"'. ($tag_posttitle_multi == 'h5' ? ' selected="selected"' : '') .'>h5</option>
						<option value="h6"'. ($tag_posttitle_multi == 'h6' ? ' selected="selected"' : '') .'>h6</option>
						<option value="div"'. ($tag_posttitle_multi == 'div' ? ' selected="selected"' : '') .'>div</option>
					</select>
				</td>
			</tr>
			<tr>
				<td style="text-align: right;">Post title (single post view):</td>
				<td>
					<select name="tag_posttitle_single">
						<option value="h1"'. ($tag_posttitle_single == 'h1' ? ' selected="selected"' : '') .'>h1</option>
						<option value="h2"'. ($tag_posttitle_single == 'h2' ? ' selected="selected"' : '') .'>h2</option>
						<option value="h3"'. ($tag_posttitle_single == 'h3' ? ' selected="selected"' : '') .'>h3</option>
						<option value="h4"'. ($tag_posttitle_single == 'h4' ? ' selected="selected"' : '') .'>h4</option>
						<option value="h5"'. ($tag_posttitle_single == 'h5' ? ' selected="selected"' : '') .'>h5</option>
						<option value="h6"'. ($tag_posttitle_single == 'h6' ? ' selected="selected"' : '') .'>h6</option>
						<option value="div"'. ($tag_posttitle_single == 'div' ? ' selected="selected"' : '') .'>div</option>
					</select>
				</td>
			</tr>
			<tr>
				<td style="text-align: right;">Page title (\'Archives\', \'Search Results\'):</td>
				<td>
					<select name="tag_pagetitle">
						<option value="h1"'. ($tag_pagetitle == 'h1' ? ' selected="selected"' : '') .'>h1</option>
						<option value="h2"'. ($tag_pagetitle == 'h2' ? ' selected="selected"' : '') .'>h2</option>
						<option value="h3"'. ($tag_pagetitle == 'h3' ? ' selected="selected"' : '') .'>h3</option>
						<option value="h4"'. ($tag_pagetitle == 'h4' ? ' selected="selected"' : '') .'>h4</option>
						<option value="h5"'. ($tag_pagetitle == 'h5' ? ' selected="selected"' : '') .'>h5</option>
						<option value="h6"'. ($tag_pagetitle == 'h6' ? ' selected="selected"' : '') .'>h6</option>
						<option value="div"'. ($tag_pagetitle == 'div' ? ' selected="selected"' : '') .'>div</option>
					</select>
				</td>
			</tr>
			<tr>
				<td style="text-align: right;">Widget title:</td>
				<td>
					<select name="tag_sidebar">
						<option value="h1"'. ($tag_sidebar == 'h1' ? ' selected="selected"' : '') .'>h1</option>
						<option value="h2"'. ($tag_sidebar == 'h2' ? ' selected="selected"' : '') .'>h2</option>
						<option value="h3"'. ($tag_sidebar == 'h3' ? ' selected="selected"' : '') .'>h3</option>
						<option value="h4"'. ($tag_sidebar == 'h4' ? ' selected="selected"' : '') .'>h4</option>
						<option value="h5"'. ($tag_sidebar == 'h5' ? ' selected="selected"' : '') .'>h5</option>
						<option value="h6"'. ($tag_sidebar == 'h6' ? ' selected="selected"' : '') .'>h6</option>
						<option value="div"'. ($tag_sidebar == 'div' ? ' selected="selected"' : '') .'>div</option>
					</select>
				</td>
			</tr>
		</table>
		</fieldset>

		<br/>

		<fieldset class="options">
		<legend>Miscellaneous Options</legend>

		<label><b>Images</b></label><br/>
		<input type="checkbox" name="nofloat" '. (get_option('mandigo_nofloat') ? 'checked="checked"' : '') .' /> Do not wrap text around images<br />
		<input type="checkbox" name="floatright" '. (get_option('mandigo_floatright') ? 'checked="checked"' : '') .' /> Float images to the right (requires text wrapping)<br />
		<input type="checkbox" name="noborder" '. (get_option('mandigo_noborder') ? 'checked="checked"' : '') .' /> Display images without a border<br /><br />
					
		<label><b>Animations</b></label><br/>
		<input type="checkbox" name="no_animations" '. (get_option('mandigo_no_animations') ? 'checked="checked"' : '') .' /> Disable js animations (also removes show/hide buttons in posts)<br /><br />
					
		<label><b>Readability</b></label><br/>
		<input type="checkbox" name="boldlinks" '. (get_option('mandigo_bold_links') ? 'checked="checked"' : '') .' /> Display all links in bold for better readability<br /><br />
					
		<label><b>Posts</b></label><br/>
		<input type="checkbox" name="tags_after" '. (get_option('mandigo_tags_after') ? 'checked="checked"' : '') .' /> Display tags after the content instead of next to categories (WP2.3+)<br />
		<input type="checkbox" name="nojustify" '. (get_option('mandigo_nojustify') ? 'checked="checked"' : '') .' /> Align content to the left instead of using justify alignment<br />
		<input type="checkbox" name="em" '. (get_option('mandigo_em_italics') ? 'checked="checked"' : '') .' /> Display &lt;em&gt; tags as italics<br /><br />

		<label><b>Date Format</b></label><br/>
		<input type="radio" name="dates" value="0"  '. ($dates ? '' : 'checked="checked"') .' />dd/mm/yyyy &nbsp; 
		<input type="radio" name="dates" value="1"  '. ($dates ? 'checked="checked"' : '') .' />month/dd/yyyy<br /><br />

		<label><b>Really miscellaneous options</b></label><br/>
		<input type="checkbox" name="fullsearchresults" '. (get_option('mandigo_full_search_results') ? 'checked="checked"' : '') .' /> Display full search results, not just titles and metadata<br />
		<input type="checkbox" name="footstats" '. (get_option('mandigo_footer_stats') ? 'checked="checked"' : '') .' /> Display rendering time and SQL statistics in the footer<br />
		</fieldset>

		<p class="submit"><input type="submit" name="Submit" value="'.__('Update Options &raquo;').'"/></p>
		</form>

		</div>

		
		<div id="preview" class="wrap">
		<h2 id="preview-post">Preview (updated when options are saved)</h2>
		<iframe src="../?preview=true" width="100%" height="600" ></iframe>
		</div>';
    }	
  }



  function mandigo_set_insert($key,$value)  { update_option('mandigo_inserts_'.$key,str_replace("\\","",$value)); }
  function mandigo_inserts_page() {
    if (isset($_POST['updated'])) {
      mandigo_set_insert('header',$_POST['header']);
      mandigo_set_insert('body'  ,$_POST['body']  );
      mandigo_set_insert('top'   ,$_POST['top']   );
      mandigo_set_insert('footer',$_POST['footer']);
    }

    echo '
		<div class="wrap">
		<h2>Mandigo Options</h2>
		
		<form name="mandigo_options_form" method="post" action="?page=Inserts">
		<input type="hidden" name="updated" value="1" />
		
		<p class="submit"><input type="submit" name="Submit" value="'.__('Update Inserts &raquo;').'"/></p>

		<fieldset class="options">
		<legend>HTML Inserts</legend>

		<p>The fields on this page allow you to save pieces of code required by third-party plugins and widgets. You can also use them to save Google Maps/Analytics/AdSense javascript snippets, or whatever you want. This way you will never have to insert code manually each time you update Mandigo.</p>

		<p>NO validation is made on the field values, so be careful not to paste invalid code. Also note that backslashes will be stripped.</p>

		<label><b>header.php</b></label><br/>
                right before &lt;/HEAD&gt; (<i>useful for links to external stylesheets, javascript files, or inline CSS</i>):<br />
		<textarea name="header" rows=7 style="width: 100%">'. str_replace("\\","",get_option('mandigo_inserts_header')) .'</textarea><br /><br />

                custom &lt;BODY&gt; tag (<i>useful for onload actions</i>):<br />
		<textarea name="body" rows=1 style="width: 100%">'. str_replace("\\","",get_option('mandigo_inserts_body')) .'</textarea><br /><br />

                right before the content and sidebars area. This differs from the top widget container in that it displays on all pages, and it spans the whole layout width.<br />
		<textarea name="top" rows=7 style="width: 100%">'. str_replace("\\","",get_option('mandigo_inserts_top')) .'</textarea><br /><br />

		<label><b>footer.php</b></label><br/>
                before the "Powered by WordPress" credits, still inside the #main div. This differs from the bottom widget container in that it displays on all pages, and it spans the whole layout width.<br />
		<textarea name="footer" rows=7 style="width: 100%">'. str_replace("\\","",get_option('mandigo_inserts_footer')) .'</textarea>
		</fieldset>
					
		<p class="submit"><input type="submit" name="Submit" value="'.__('Update Inserts &raquo;').'"/></p>
		</form>
		</div>';
  }




/* all custom editing of the mandigo theme start here....check 1 2 */

/* well no need for read me at the moment
function mandigo_readme_page() {
    echo '<div class="wrap">';
    echo '<pre>';
    echo htmlspecialchars(file_get_contents(TEMPLATEPATH.'/README.txt'));
    echo '</pre>';
    echo '</div>';
  }
*/





////////////////////////////////////////////////////////////////////////////////
// theme option menu for custom header
////////////////////////////////////////////////////////////////////////////////

$themecolors = array(

	'bg' => 'ffffff',

	'text' => '000000',

	'link' => '0060ff'

);


///////////* hack for double cache function *///////////////////

// No CSS, just IMG call

$it_is_wide = get_option('mandigo_1024');
if($it_is_wide != ''){
$the_header_wide = '1000';
} else {
$the_header_wide = '800';
}

$it_is_slim = get_option('mandigo_slim_header');
if($it_is_slim != ''){
$the_header_slim = '100';
} else {
$the_header_slim = '250';
}

//////////////* end */////////////////


define('HEADER_TEXTCOLOR', '');

define('HEADER_IMAGE', ''); // %s is theme dir uri - empty - this to set the default image if custom heade null - don't edit

define('HEADER_IMAGE_WIDTH', $the_header_wide);

define('HEADER_IMAGE_HEIGHT', $the_header_slim);

define( 'NO_HEADER_TEXT', true );




function cutline_admin_header_style() { ?>

<style type="text/css">
#headimg {
height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
width: <?php echo HEADER_IMAGE_WIDTH; ?>px;
}

#headimg h1, #headimg #desc {
display: none;
}
</style>

<?php }



if ( function_exists('register_sidebar') ) { register_sidebar(); }



add_custom_image_header('', 'cutline_admin_header_style');



?>
