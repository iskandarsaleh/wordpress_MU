<?php
// enable widget support
if ( function_exists('register_sidebars') )
	register_sidebars(1,array(
		'name'=>'widgets1',
		'before_widget' => '<li id="%1$s" class="section %2$s">',
		'after_widget' => "</li>",
		'before_title' => '<h3 class="sansRed">',
		'after_title' => "</h3>"
		));
		
//localization
load_theme_textdomain('commentpress');

// useful constant variables
define('COMMENTPRESS_BETA', FALSE);
define('COMMENTPRESS_VERSION', "1.4.1");
define('COMMENTPRESS_SERVER', "http://www.futureofthebook.org/commentpress/");
define('COMMENTPRESS_DOWNLOAD_URI', COMMENTPRESS_SERVER."downloads/");
define('COMMENTPRESS_LATEST_DOWNLOAD', COMMENTPRESS_DOWNLOAD_URI . "commentpress-" . COMMENTPRESS_VERSION . ".zip");
define('COMMENTPRESS_IMAGE_PATH', get_bloginfo('wpurl')."/wp-content/themes/". get_template() . "/images/");
if(COMMENTPRESS_BETA) define('COMMENTPRESS_LATEST_VERSION_URI', COMMENTPRESS_SERVER."downloads/beta.php"); else define('COMMENTPRESS_LATEST_VERSION_URI', COMMENTPRESS_SERVER."downloads/version.php");



// the hooks 
add_action('wp_head','commentpress');
add_action('comment_form', 'commentpress_add_extra_formfield');
add_action('comment_post','commentpress_add_post_extras');
add_action('admin_menu', 'commentpresss_menu');
add_action('admin_head', 'commentpress_admin_head');

add_filter('the_content', 'commentpress_the_content');
add_filter('the_title', 'commentpress_the_title');
add_filter('the_excerpt', 'commentpress_the_excerpt');




//register widgets
if ( function_exists('register_sidebar_widget') ){
	register_sidebar_widget('Browse Comments', 'commentpress_browse_comments_widget');
}

//
class CommentPressPost {
	var $post_title = null;
	var $post_content = null;
	var	$post_author = 1;
	var	$post_name = null;
	var	$post_category = 1;
	var	$post_date = null;
	var	$post_date_gmt = null;
	var	$post_modified = null;
	var	$post_modified_gmt = null;
	var	$post_excerpt = null;
	var	$post_status = 'publish';
	var	$comment_status = 'open';
	var	$post_parent = 0;
	var	$post_type = 'page';
	var	$comment_count = 0;	
	
	//the default values for a new post
	function CommentPressPost(){
	 $this->post_date = date("Y-m-d H:i:s");
	 $this->post_date_gmt = date("Y-m-d H:i:s");
	 $this->post_modified = date("Y-m-d H:i:s");
	 $this->post_modified_gmt = date("Y-m-d H:i:s");	 
	}
	
}

$comment_index_array = null;

//get the current version of commentpress
function commentpress_version(){
 	return COMMENTPRESS_VERSION;
}


// the constructor (installer) 
function commentpress() {	
 	global $tablecomments ,$user_ID,  $commentpress_default_front_page;
	$comments_section_id = $comments_user_id = $general_comments = null;
	$installing = false;
	commentpress_altertable();
	
	// installation 
	$comments_section_id = getPostID('comments-by-section');	
	$comments_user_id = getPostID('comments-by-user');
	$general_comments = getPostID('general-comments');

	if(!$comments_section_id){
	 commentpress_create_page("Comments By Section");
	 $comments_section_id = getPostID('comments-by-section');	
	 $installing = true;	 
	}
	if(!$comments_user_id){
	 commentpress_create_page("Comments By User");
	 $comments_user_id = getPostID('comments-by-user');
	 $installing = true;	 
	}
	if(!$general_comments){
	 commentpress_create_page("General Comments");
	 $general_comments = getPostID('general-comments');
	 $installing = true;	 
	}

	if ( !get_option('commentpress_id_comment_by_section') ) {
		add_option('commentpress_id_comment_by_section', $comments_section_id, "The ID of Comments by Section Page");
	}
	if ( !get_option('commentpress_id_comment_by_user') ) {
		add_option('commentpress_id_comment_by_user', $comments_user_id, "The ID of Comments by User Page");
	}
	if ( !get_option('commentpress_id_general_comments') ) {
		add_option('commentpress_id_general_comments', $general_comments, "The ID of General Comments Page");
	}
	if ( !get_option('commentpress_table_contents') ) {
		add_option('commentpress_table_contents', "Table of Contents", "The title of the table of contents in front page");
	}	
	if ( !get_option('commentpress_default_front_page') ) {
		add_option('commentpress_default_front_page', 'document', "Front Page Layout");
	}
	if(!get_option('commentpress_show_quicktag')) {
		add_option('commentpress_show_quicktag', true);	
	}
	if(!get_option('commentpress_welcome_message')) {
		add_option('commentpress_welcome_message', 'about');	
	}
	if(!get_option('commentpress_content_license')) {
		add_option('commentpress_content_license', '');	
	}
	if(!get_option('commentpress_page_enabled')) {
		add_option('commentpress_page_enabled', '1');	
	}
	if(!get_option('commentpress_post_enabled')) {
		add_option('commentpress_post_enabled', '1');	
	}
	if(!get_option('skin')) {
		add_option('skin', 'document');	
	}
	
	
	/* UPGRADE FROM 1.0 */
	if (get_option('commentpress_default_front_page') == "1") {
		update_option('commentpress_default_front_page', 'blog');
	}
	if (get_option('commentpress_default_front_page') == "2") {
		update_option('commentpress_default_front_page', 'document');
	}
	
	/* change default options */
	update_option('posts_per_page', 5);		
	//update_usermeta($user_ID, 'rich_editing', 'false');
}

/* add the menu in the admin interface */
function commentpresss_menu() {
 	//make sure we install;
 	commentpress();
 	$commentpress_options = 'commentpress_options';
	add_submenu_page('themes.php', 'CommentPress', 'CommentPress Options', 5,  'commentpress_options', 'commentpress_menu_content'); // calls the function commentpress_menu_content
}




/* overwrite the_title code */
function commentpress_the_title($the_title){
	global $commentpress_stylize;
	global $comment_index_array;
 	$post_type_hash['post'] = 1;//get_option('commentpress_post_enabled');	
	$post_type_hash['page'] = 0; //get_option('commentpress_page_enabled');	
 	$page_comments['comments-by-section'] = get_option('commentpress_id_comment_by_section');	
	$page_comments['comments-by-user'] = get_option('commentpress_id_comment_by_user');	
	$page_comments['general-comments'] = get_option('commentpress_id_general_comments');	
	//$the_title = get_the_title();
 	$post_type = get_post_type();
	$postdata = get_page(get_the_ID());
	
	if($commentpress_stylize){
	 	$comments = get_approved_comments(get_the_ID());
		
		$contentIndex_count = 0;
		for($j = 0; $j < count($comments); $j++){
			$c = $comments[$j];
			if( $c->comment_contentIndex == 0){
				$contentIndex_count++;
			}
		}
                $comment_index_array[0] = $contentIndex_count;
                $contentIndex_count = ($contentIndex_count == 0) ? " " : $contentIndex_count;

                // MJE: the following code fixes a compatibility problem with WP 2.3 and later versions
                // Wordpress 2.3.x calls filters in get_the_title where previous versions did not do so.
                // The filters cause some sort of problem with CommentPress, so those are avoided with the
                // code below, which was copied from a previous version of Wordpress: 
                $post = &get_post($id);
                $title = $post->post_title;
                if ( !empty($post->post_password) )
                        $title = 'Protected: '.$title;
                else if ( 'private' == $post->post_status )
                        $title = 'Private: '.$title;
                //-------------------------

                return '<div class="lexia" id="contentblock_0"><a name="0"></a>
		<div class="icons"><a title="Read/Write comments on the whole page" href="javascript:void(0)"><img class="paragraph_read"  alt="read paragraph" id="para-0"  src="' . COMMENTPRESS_IMAGE_PATH . 'pageread.png" /></a><br/>'.$contentIndex_count.'</div>
                <h2 class="content"><a href="'.$_SERVER['REQUEST_URI'].'">'.$title.'</a></h2>
                </div>';

	}		
	else{
		return $the_title;
	}
}

/* overwrite the_excerpt code */
function commentpress_the_excerpt(){
 $excerpt = strip_tags(trim(get_the_excerpt()));
 //$excerpt = substr($excerpt, 1);
 $excerpt = preg_replace("/\n(\d)+\n/", "", $excerpt);
 return ( $excerpt );
}

/* overwrite the_content code */
function commentpress_the_content(){
	global $commentpress_stylize;
	global $comment_index_array;

 	$post_type_hash['post'] = 1;	 //get_option('commentpress_post_enabled')
	$post_type_hash['page'] = 0; 	//get_option('commentpress_page_enabled');	
 	$post_type = get_post_type();

 	$page_comments['comments-by-section'] = get_option('commentpress_id_comment_by_section');	
	$page_comments['comments-by-user'] = get_option('commentpress_id_comment_by_user');	
	$page_comments['general-comments'] = get_option('commentpress_id_general_comments');	
	
	
	
	$postdata = get_page(get_the_ID());

	//var_dump( $commentpress_stylize );
	if($post_type_hash[$post_type] == "1" && $commentpress_stylize){
	 $comments = get_approved_comments(get_the_ID());
	
	 $thecontent = get_the_content();	
	
	 //$thecontent = apply_filters('the_content', $thecontent);
	 //if(str)
	 $thecontent = balancetags(wpautop($thecontent));
	 
	 $content_array =  explode("</p>", $thecontent);
	 
	 $content = null;
	
	 $contentIndex_count = 0;
	 for($j = 0; $j < count($comments); $j++){
		 $c = $comments[$j];
		 if( $c->comment_contentIndex == 0){
			 $contentIndex_count++;
		 }
	 }
	 
	 //replace <p> with <p class="content">, cause this should all this be done with REGEX
	 $content_array = str_replace('<p></p>', '', $content_array); //remove blank paragraphs
	 $content_array = str_replace('<p>','<p class="content">',$content_array);
	 $content_array = str_replace('<p><img','<p class="content"><img',$content_array);
	 $content_array = str_replace('<embed','<p class="content"><embed',$content_array);
	 $content_array = str_replace('<ol','<p class="content"><ol',$content_array);
	 $content_array = str_replace('<ul','<p class="content"><ul',$content_array);	 
	 $content_array = str_replace('<p class="content"><p class="content">', '<p class="content">', $content_array); //remove any doubles
	 $content_array = str_replace('</ul>','</ul></p>',$content_array);	 

	 
	 //$queue = array("orange", "banana");
	 array_unshift($content_array, " ");
	
	 $cindex = 1;
	 for($i=1; $i < (count($content_array)+1); $i++){
		 
		 //loop through the content
		 $contentIndex_count = 0;
		 
		 for($j = 0; $j < count($comments); $j++){
			 $c = $comments[$j];
			 if( $c->comment_contentIndex == $i){
				 $contentIndex_count++;
			 }
		 }

		 
		 // build the paragraph 
		 $paragraph = null;
		 $current_content = $content_array[$i];
		 if( strlen($current_content) > 1 ){
		  	$comment_index_array[$cindex] = $contentIndex_count;
			$paragraph  = "<a name=\"$cindex\"></a><div class='lexia' id='contentblock_$cindex'>";
			$paragraph .= "<div class='icons'>";
			$paragraph .= "<a title='read/write comments on this paragraph' href='javascript:void(0)'>";
			$paragraph .= "<img  class='paragraph_read' id='para-$cindex' src='".COMMENTPRESS_IMAGE_PATH."pararead.png' /></a>";
			$paragraph .= ($contentIndex_count > 0 ) ? "<br />".$contentIndex_count : "";
			$paragraph .= "</div>";
			$paragraph .= "<div class='lexiaNumber'><a target=\"_self\" title=\"paragraph permalink\" href=\"".get_permalink(get_the_ID())."#$cindex\" id='paragraph_number_$g'>$cindex</a></div>";						
   
			$content .= $paragraph.$current_content."</p></div>\n\n";					
			$cindex++;
		 }
	 }			
	 return $content."\n<input type='hidden' id='paragraph_count' value='".$cindex."' />";
	}
	else{
		return balancetags(wpautop(get_the_content()));
	}
 
}

function commentpress_comment_index_array(){
 global $comment_index_array;
 return $comment_index_array;
}

function commentpress_browse_comments_widget($args) {
 	extract($args);
	/*		
	echo $before_widget; 
	echo $before_title. 'My Unique Widget'. $after_title;
	echo "widget coe";
	echo $after_widget;
	*/
	$permalink_structure = get_option('permalink_structure');

	$comments_by_section = ('' != $permalink_structure ) ? "comments-by-section/" : "?page_id=".get_option('commentpress_id_comment_by_section') ;
	$comments_by_user = ('' != $permalink_structure ) ? "comments-by-user/" : "?page_id=".get_option('commentpress_id_comment_by_user');
	$general_comments = ('' != $permalink_structure ) ? "general-comments/" : "?page_id=".get_option('commentpress_id_general_comments');
	?>
	<li class="section"> 
		   <h3 class="sansRed">Browse Comments</h3> 
			<ul class="sidebarList"> 
				<li><a href="<?php bloginfo('url'); ?>/<?php echo $comments_by_user ?>">by Commenters</a></li>
				
				<?php if(get_option('skin') == "document"){ ?>
				 <li><a href="<?php bloginfo('url'); ?>/<?php echo $comments_by_section ?>">by Section</a></li>
				<?php 
				} 
				else{ ?>
				 <li><a href="<?php bloginfo('url'); ?>/<?php echo $comments_by_section ?>">by Post</a></li>			 
				<?php } 				
				if(get_option('skin') == "document"){ ?>
				 <li><a href="<?php bloginfo('url'); ?>/<?php echo $general_comments ?>">General Comments</a></li>				 
				<?php } ?> 					 					 
			</ul> 
		   </li>
<?php 
}


/* the content when someone clicks the custom menu option */
function commentpress_menu_content(){
	$wpurl = get_bloginfo('wpurl');
	$license_dir =  $wpurl.'/wp-content/themes/'.get_template().'/images/';	
	$theme_dir =  $wpurl.'/wp-content/themes/'.get_template().'/themes/';	
	$available_themes = commentpress_detect_themes();
	$by = $license_dir."by.gif";
	$nc = $license_dir."nc.gif";
	$nd = $license_dir."nd.gif";
	$sa = $license_dir."sa.gif";
	$pd = $license_dir."pd.gif";
	$lgpl = $license_dir."lgpl.gif";
	$gpl = $license_dir."gpl.gif";	
	
	/* they've submited the form.*/	
	if($_GET['factory_default'] == "true"){
	 commentpress_factory_settings();	 
	 commentpress();	 
	}

	if($_POST['page_options'])
	update_option('commentpress_default_front_page', $_POST['commentpress_default_front_page']);

	if($_POST['commentpress_table_contents'])
	update_option('commentpress_table_contents', $_POST['commentpress_table_contents']);
	
	if($_POST['commentpress_welcome_message'])
	update_option('commentpress_welcome_message', $_POST['commentpress_welcome_message']);
	
	if($_POST['commentpress_content_license'])
	update_option('commentpress_content_license', $_POST['commentpress_content_license']);

	
	if($_POST['commentpress_post_enabled']){ update_option('commentpress_post_enabled',   1); }
	else if($_POST){ update_option('commentpress_post_enabled',   0); }
	
	if($_POST['commentpress_page_enabled']){ update_option('commentpress_page_enabled',   1); }
	else if($_POST){ update_option('commentpress_page_enabled',   0);}
	
	
		
	$commentpress_default_front_page = get_option('commentpress_default_front_page');
	$commentpress_table_contents = get_option('commentpress_table_contents');
	$commentpress_welcome_message = get_option('commentpress_welcome_message');	
	$commentpress_content_license = get_option('commentpress_content_license');	
	$commentpress_post_enabled = get_option('commentpress_post_enabled');	
	$commentpress_page_enabled = get_option('commentpress_page_enabled');	
	
	
?>
	<div class="wrap">

		<h2><? _e('Settings', 'commentpress') ?></h2>
		<form name="dofollow" action="" method="post">
		<input type="hidden" name="page_options" value="'dofollow_timeout'">		
		 <table>	
			<tr>
				<td></td>				
				<td><? _e('The title for table of contents', 'commentpress') ?><br/><input type="text" name="commentpress_table_contents" value="<?= $commentpress_table_contents ?>"></td>
			</tr>
			
			<tr>
				<td></td>				
				<td><? _e('The slug of post to appear as welcome message', 'commentpress') ?><br/><input type="text" name="commentpress_welcome_message" value="<?= $commentpress_welcome_message ?>"></td>
			</tr>

<!--
			<tr>
				<td colspan="2">
				<p>
				<input type="checkbox" <?php echo ( $commentpress_page_enabled == '1' ) ? " checked " : " "; ?> name="commentpress_page_enabled" value="1" >
				<? _e('Enable commentpress for Pages ', 'commentpress') ?>
				&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" <?= ( $commentpress_post_enabled == '1' ) ? " checked " : " "; ?> name="commentpress_post_enabled" value="1" ><? _e('Posts', 'commentpress') ?><br/>
				</p>
				</td>
			</tr>
-->
			<tr>
				<td>&nbsp;</td>
				<td>
					<input type="submit" value="Save Options" />
					<table border="0">
					 <tr>
						 <td>
							 <form name="dofollow" action="" method="post">
							 <input type="button" style="border: solid #F00 2px" onclick="confirm_reverter();" name="factory_default" value="Revert to Factory Defaults" />
							 </form>
						 </td>
					 </tr>
					</table>
				</td>
			</tr>
		<table>
		</form>
		
	</div>
	<? 
} 


function commentpress_factory_settings(){
  if ( get_option('commentpress_id_comment_by_section') ) {
   wp_delete_post(get_option('commentpress_id_comment_by_section')); 
  }
  if ( get_option('commentpress_id_comment_by_user') ) {
   wp_delete_post(get_option('commentpress_id_comment_by_section')); 
  }
  if ( get_option('commentpress_id_general_comments') ) {
   wp_delete_post(get_option('commentpress_id_general_comments')); 
  }


  if ( get_option('commentpress_id_comment_by_section') ) {
   delete_option('commentpress_id_comment_by_section');
  }	
  if ( get_option('commentpress_id_comment_by_user') ) {
   delete_option('commentpress_id_comment_by_user');
  }	
  if ( get_option('commentpress_id_general_comments') ) {
   delete_option('commentpress_id_general_comments');
  }	

  
  if ( get_option('commentpress_table_contents') ) {
   delete_option('commentpress_table_contents');
  }	
  if ( get_option('commentpress_default_front_page') ) {
   delete_option('commentpress_default_front_page');
  }
  if( get_option('commentpress_show_quicktag')) {
   delete_option('commentpress_show_quicktag');	
  }
  if( get_option('commentpress_welcome_message')) {
   delete_option('commentpress_welcome_message');	
  }
  if( get_option('commentpress_content_license')) {
   delete_option('commentpress_content_license');	
  }
  if( get_option('commentpress_page_enabled')) {
   delete_option('commentpress_page_enabled');	
  }
  if( get_option('commentpress_post_enabled')) {
   delete_option('commentpress_post_enabled');	
  }
  if( get_option('skin')) {
   delete_option('skin');
  } 
}

function commentpress_admin_head(){
?>  
<script type="text/javascript">
 function confirm_reverter(){
  var revert=confirm("Are you sure you want revert to factory settings?");
  if(revert){
   window.location="<?php bloginfo('wpurl'); ?>/wp-admin/themes.php?page=commentpress_options&factory_default=true";
  }
  else{
   	window.location="<?php bloginfo('wpurl'); ?>/wp-admin/themes.php?page=commentpress_options&factory_default=false";
  }
 }
</script> 
<?
}


//http://mattread.com/projects/wp-plugins/custom-query-string-plugin/
function commentpress_post_order(){

}


/* add new property values to each comment */
function commentpress_add_post_extras($comment_id){
	commentpress_add_context_id($comment_id);
	commentpress_add_parent_id($comment_id);
}

/* get the latest post, and add the parent */
function commentpress_add_parent_id($id){
	global $wpdb;	
	$parent_id = mysql_escape_string($_POST['comment_parent']);	
	$sql = "UPDATE $wpdb->comments SET comment_parent='$parent_id' WHERE comment_ID='$id'";
	$wpdb->query($sql);
}

/* get the latest post, and add the context id */
function commentpress_add_context_id($id){
	global $wpdb;	
	$contentIndex = mysql_escape_string($_POST['comment_contentIndex']);	
	$sql = "UPDATE $wpdb->comments SET comment_contentIndex='$contentIndex' WHERE comment_ID='$id'";	
	$wpdb->query($sql);
}


function commentpress_add_extra_formfield(){
	echo "<input type='hidden' id='comment_reply_ID' name='comment_reply_ID' value='0' />";
	echo "<input type='hidden' id='comment_contentIndex' name='comment_contentIndex' value='-1' />";
	echo "<input type='hidden' id='comment_parent' name='comment_parent' value='0' />";
	echo "<script>createCookie('commentpress_comment_count',".getAllCommentCount().",7);</script>";
}





	
	

/*  here is a little tool we are going to use during installation. */

/**
 * commentpress_maybe_add_column()
 * Add column to db table if it doesn't exist - shamelessly copied from wp core code and renamed
 * Returns:  true if already exists or on successful completion
 *           false on error
 */
function commentpress_maybe_add_column($table_name, $column_name, $create_ddl) {
	global $wpdb, $debug;
	foreach ($wpdb->get_col("DESC $table_name", 0) as $column ) {
		if ($debug) echo("checking $column == $column_name<br />");
		if ($column == $column_name) {
	    return true;
		}
	}
  //didn't find it try to create it.
  $q = $wpdb->query($create_ddl);
  // we cannot directly tell that whether this succeeded!
  foreach ($wpdb->get_col("DESC $table_name", 0) as $column ) {
	 if ($column == $column_name) {
	  return true;
	 }
  }
  return false;
}


// MJE: The code below was changed because some servers disallow use of file_get_contents for security reasons.
// Therefore it's best to use CURL instead since it is widely supported

if ( function_exists('curl_init') ) {

// if ( function_exists('file_get_contents') &&  (int)ini_get('allow_url_fopen')) {

	//$latest_version = file_get_contents(COMMENTPRESS_LATEST_VERSION_URI);

	// MJE: Curl way of accomplishing the same thing as above: :
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,COMMENTPRESS_LATEST_VERSION_URI);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $latest_version = curl_exec($ch);
        curl_close($ch);

	// MJE: Added erroring check to avoid displaying errors to readers when the connection fails: 
	if (!$latest_version) return;

	$current_version = commentpress_version();

 	function upgrade_message() {		
		global $latest_version, $current_version;
		echo "<div id='akismet-warning' class='updated fade-ff0000'><p><strong>".__('You are currently using CommentPress '.$current_version.' and the latest version is '.$latest_version).". <a href=\"http://futureofthebook.org/commentpress/downloads/commentpress-$latest_version.zip\">Click here to download the update</a></strong></p></div>
		<style type='text/css'>
		#adminmenu { margin-bottom: 5em; }
		#akismet-warning { position: absolute; top: 7em; }
		</style>";
		return;
	}

	if($latest_version > $current_version){
	 add_action('admin_footer', 'upgrade_message');
	}
}

/* utility functions */
function commentpress_altertable(){	
	global $wpdb;	
	$contentIndex = "ALTER TABLE $wpdb->comments ADD COLUMN comment_contentIndex INT NOT NULL DEFAULT 0;";
	commentpress_maybe_add_column($wpdb->comments, 'comment_contentIndex', $contentIndex);
}



function commentpress_create_page($title) {
 
	$post_object = new CommentPressPost();
	$title = strip_tags($title);
	
	$post_object->post_title = $title;
	$post_object->post_content = "<!-- reserved page for $title -->";
	$post_object->post_author = 1;
	$post_object->post_name = strtolower(str_replace(" ", "-", trim($title)));;
	$post_object->post_category = 1;
	$post_object->post_date = date("Y-m-d H:i:s");
	$post_object->post_date_gmt = date("Y-m-d H:i:s");
	$post_object->post_modified = date("Y-m-d H:i:s");
	$post_object->post_modified_gmt = date("Y-m-d H:i:s");
	$post_object->post_excerpt = '';
	$post_object->post_status = 'publish';
	$post_object->comment_status = ($title == "General Comments") ? 'open' : 'closed';
	$post_object->post_parent = 0;
	$post_object->post_type = 'page';
	$post_object->comment_count = 0;

	wp_insert_post($post_object); 	
}



function commentpress_detect_themes(){
 	$themes = null;
	if ($handle = opendir(TEMPLATEPATH ."/skins/")) {
	 while ( (false !== ($file = readdir($handle)))  ) {
		$theme_screenshot = TEMPLATEPATH ."/skins/". $file. "/screenshot.png";
		$theme_stylesheet = TEMPLATEPATH ."/skins/". $file. "/style.css";
		if(is_file($theme_screenshot) && is_file($theme_stylesheet) && ( $file != "." ) && ( $file != ".." ) )
			$themes[] = $file;
	 	}
	closedir($handle);
 }
 return ($themes == null) ? false : $themes;
}

function commentpress_comments_by_section($name){
 	global $wpdb;
	$name = addslashes($name);
	$comment_sql = "comment_post_ID ='".getPostID($name)."' AND ";
	$sql = "SELECT * FROM $wpdb->comments, $wpdb->posts WHERE $comment_sql comment_approved = '1' AND comment_post_ID = ID ORDER BY comment_date DESC";
	//echo $sql;
	$comments = $wpdb->get_results($sql);
	
	foreach($comments as $key=>$item){
		if($item->comment_parent == 0){
			$commentsReorder[] = $item;
			foreach($comments as $child){
				if($child->comment_parent == $item->comment_ID){
					$commentsReorder[] = $child;
				}
			}
		}
	}
	return $comments;	 
}


function commentpress_list_sections(){
?>
<!-- START THE PAGE -->
<!-- already in pageContainer -->
 <div id="narrowcolumn"> 
	<h2>Table of Comments (<?= getAllCommentCount(); ?>)</h2> 
	<? $commentpress_default_front_page = get_option('commentpress_default_front_page');  /* 1 = blog, 2 = document */ ?>
	<h3 style="margin-top: -20px;margin-bottom: 22px;"><?= ($commentpress_default_front_page=='blog')? "by post" : "by section"; ?></h3> 

	<ul class="indexCommentsList">
		<?php
		$post_menu = getParentPosts();
		foreach($post_menu as $item){
		?>
			<li><a href="<?php bloginfo('url'); ?>/comments-by-section/?comments=<?= $item->post_name; ?>"><?= $item->post_title; ?></a>  <span class="normalLight">(<?= $item->comment_count; ?>)</span> </li>
		<?
		}
		?>
			<li style="padding-top: 1em;"><a href="<?php bloginfo('url'); ?>/comments-by-section/?comments=general-comments&menu=general-comments">General Comments</a>  <span class="normalLight">(<?= getCommentCount('general-comments') ?>)</span> </li>
		
	</ul>	
	<!-- END disc_leftCol --> 
</div> 
<?
}

function commentpress_list_commenting_users(){ 
?>
<!-- START THE PAGE -->
<!-- already in pageContainer -->
 <div id="narrowcolumn"> 
	<h2>Table of Comments (<?= getAllCommentCount(); ?>)</h2> 
	<h3 style="margin-top: -20px;margin-bottom: 22px;">by commenter</h3> 
	<ul class="indexCommentsList">
		 <? foreach($usersWhoHaveCommented as $key=>$u) { ?> 
		 <li><a href="<?php bloginfo('url'); ?>/comments-by-user/?id=<?= ($u->user_id > 0) ? $u->user_id : $u->comment_author; ?>"><? echo $u->comment_author; ?></a> <span class="normalLight">(<? echo $u->comments_per_user; ?>)</span></li>
		 <? }?> 
	 </ul> 
	<!-- END disc_leftCol --> 
</div> 
<?
}
	
/* do these functions exist in wordpress by default? I was too lazy to find out.. lets replace 
the ones that are implemented in the default wp api. */
function getCommentCount($title){
	global $wpdb;
	$title = strip_tags($title);
	$title = addslashes($title);
	$sql = "SELECT * FROM $wpdb->comments, $wpdb->posts WHERE comment_post_ID=ID AND post_status='publish' AND comment_approved='1' AND post_name = '$title' AND post_status='publish'";
	$result = $wpdb->get_results($sql);
	return ( count($result) );
}

function getCommentCountByCategory($cat){
	global $wpdb;
	$cat = strip_tags($cat);
	$cat = addslashes($cat);
	$sql = "SELECT p.ID, p.comment_count FROM $wpdb->posts AS p
		LEFT JOIN $wpdb->term_relationships as tr ON (p.ID = tr.object_id)
		LEFT JOIN $wpdb->term_taxonomy AS tt ON (tr.term_taxonomy_id = tt.term_taxonomy_id)
		LEFT JOIN $wpdb->terms as t ON (t.term_id = tt.term_id)
		WHERE t.slug = '{$cat}' AND tt.taxonomy = 'category'
	";
	
	$commentCategories = $wpdb->get_results($sql);
	$count = 0;
	foreach($commentCategories as $c){
		$count += $c->comment_count;
	}
	return $count;
}

function getUsersWhoHaveCommented(){
	global $wpdb;
	$sql = "SELECT * , COUNT( * ) AS comments_per_user FROM $wpdb->comments, $wpdb->posts WHERE comment_post_ID=ID AND comment_approved='1' AND post_status='publish' GROUP BY comment_author";		
	return $wpdb->get_results($sql);
}

function getCommentsFromUser($id){
 	global $wpdb;	
	$sql = null;
	if(is_numeric($id))
	 $sql = "SELECT c.*, u.*, p.post_name, p.post_title FROM $wpdb->comments c, $wpdb->users u, $wpdb->posts p  WHERE c.comment_approved='1' AND p.post_status='publish' AND c.user_id = u.ID AND u.ID=$id AND c.comment_post_ID = p.ID ORDER BY comment_ID DESC";
	else
	 $sql = "SELECT c.*, p.post_name, p.post_title FROM $wpdb->comments c, $wpdb->posts p  WHERE c.comment_approved='1' AND p.post_status='publish' AND c.comment_post_ID = p.ID AND c.comment_author = '$id' ORDER BY comment_ID DESC";
	return $wpdb->get_results($sql);
}

function getAuthorInformation($id){
	global $wpdb;
	$sql = "SELECT * FROM $wpdb->users WHERE ID = $id";
	$users = $wpdb->get_results($sql);
	$user = $users[0];
	
	$sql = "SELECT * FROM $wpdb->usermeta WHERE user_id = $id";
	$details = $wpdb->get_results($sql);
	
	foreach($details as $d){
		$name = $d->meta_key;
		$user->$name = $d->meta_value;
	}	
	return $user;	
}

function getContributorsWhoHaveCommented(){
	global $wpdb;
	$sql = "SELECT * , COUNT( * ) AS comments_per_user FROM $wpdb->usermeta m, $wpdb->comments c, $wpdb->users u WHERE  u.ID = m.user_id  AND p.post_status='publish' AND c.user_id = u.ID GROUP BY ID ORDER BY u.user_login";
	//$users = $wpdb->get_results($sql);
	return $wpdb->get_results($sql);              
}

function getParentPosts(){
	global $wpdb;
	$sql = "SELECT * FROM `$wpdb->posts` WHERE post_status='publish' AND post_parent='0' AND post_type = 'post'";
	$result = $wpdb->get_results($sql);
	return $result;
}

/* this might be useless */
function getAllCommentCount(){
	global $wpdb;
	$sql = "SELECT * FROM $wpdb->comments, $wpdb->posts WHERE comment_post_ID=ID AND post_status='publish' AND comment_approved='1'";
	$result = $wpdb->get_results($sql);
	return (count($result));
}

function getRecentComments($limit = 5){
	global $wpdb;
	$sql = "SELECT * FROM $wpdb->comments, $wpdb->posts WHERE comment_post_ID=ID AND post_status='publish' AND comment_approved='1' ORDER BY comment_date DESC LIMIT $limit ";
	return $wpdb->get_results($sql);               
}

function getPostID($slug){
	global $wpdb;
	$sql = "SELECT * FROM $wpdb->posts WHERE post_name = '$slug' AND post_status='publish'";
	$data = $wpdb->get_results($sql);
	$p = $data[0];
	return ($p->ID > 0 ) ? $p->ID : false ;
}





/* i like these plugins for search and threading.. lets include them! */
if ( !class_exists('SearchExcerpt') )
include(TEMPLATEPATH . '/plugins/ylsy_search_excerpt.php');

//if ( function_exists('register_sidebars') )
include(TEMPLATEPATH . '/plugins/briansthreadedcomments.php');

if (!function_exists('skinner_init') )
include(TEMPLATEPATH . '/plugins/skinner/skinner.php');


?>
