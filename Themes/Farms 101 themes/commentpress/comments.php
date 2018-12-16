<?php
/**
 * This is a modified version of wp-commments that comes with the Brian's Nested Comments plugin.
 * Version: 1.5.12
 * Author: Brian Meidell
 * Author URI: http://meidell.dk/blog
 */ 

if ('wp-comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not load this page directly. Thanks!');

include(ABSPATH . WPINC . "/version.php");

$is_new = (isset($wp_version) && $wp_version > '1.2');

if (($is_new) or ($withcomments) or ($single)) {
        if (!empty($post->post_password)) { // if there's a password
            if ($_COOKIE['wp-postpass_'.$cookiehash] != $post->post_password) {  // and it doesn't match the cookie
?>
<p><?php _e("Enter your password to view comments."); ?><p>
<?php
				return;
            }
        }

 		$comment_author = (isset($_COOKIE['comment_author_'.$cookiehash])) ? trim($_COOKIE['comment_author_'.$cookiehash]) : '';
		$comment_author_email = (isset($_COOKIE['comment_author_email_'.$cookiehash])) ? trim($_COOKIE['comment_author_email_'.$cookiehash]) : '';
 		$comment_author_url = (isset($_COOKIE['comment_author_url_'.$cookiehash])) ? trim($_COOKIE['comment_author_url_'.$cookiehash]) : '';

		if(!$tablecomments && $wpdb->comments) // this makes it work in both 1.2 and 1.3
			$tablecomments = $wpdb->comments;

			//$sql = "SELECT * FROM $tablecomments WHERE comment_post_ID = '$id' ORDER BY comment_date";
			$sql = "SELECT * FROM $wpdb->comments, $wpdb->posts WHERE comment_post_ID=ID AND post_status='publish' AND comment_approved='1' AND comment_post_ID = '$id' AND post_status='publish' ORDER BY comment_date ASC";	
			$comments = $wpdb->get_results($sql);
			
			
			$cookie_name = substr(str_replace("/", "-",$_SERVER['REQUEST_URI'])."comment-count", 1 );
			$new_comment = false;
			if(!$_COOKIE[$cookie_name]){
			 $_COOKIE[$cookie_name] = count($comments);			 			
			}
			else if(count($comments) > $_COOKIE[$cookie_name]) {
			 $new_comment = true;
			 $total_new_comments = (count($comments) - $_COOKIE[$comment_cookie]);			 
			 $sql = "SELECT * FROM $wpdb->comments, $wpdb->posts WHERE comment_post_ID=ID AND post_status='publish' AND comment_approved='1' AND comment_post_ID = '$id' AND post_status='publish' ORDER BY comment_date DESC LIMIT 1";
			 $the_new_comment = $wpdb->get_results($sql);
			 $the_new_comment  = $the_new_comment[0];
			 $_COOKIE[$cookie_name] = count($comments);			 
			}

?>



<?	

	$wpurl = get_bloginfo('wpurl'); 

?>



<?php
$GLOBALS['threaded_comments'] = array();

function write_comment(&$c) {
	$threaded_comments = $GLOBALS['threaded_comments'];
	$odd = ($GLOBALS['__writeCommentDepth']%2? " odd" : "");
?>

<div class="cp_commentBody" id="comment-index-<?php echo $c->comment_contentIndex; ?>">				
<div  id="div-comment-<?php comment_ID() ?>" class='comment<?php echo $odd?>'>
 <div  style="display: none"><a id='comment-link-<?php comment_ID() ?>' name='comment-<?php comment_ID() ?>' ><?php echo $c->comment_contentIndex; ?></a></div>

 <?php if ($c->comment_approved == '0') : ?>
 <p>Your comment is awaiting moderation.</p>
 <? else: ?>
 
 <div class="title">
	 <!-- <a href='javascript:collapseThread("div-comment-<?php comment_ID() ?>")'><abbr title="Toggle comment collapse">[T]</abbr></a>-->
 <? if($GLOBALS['__writeCommentDepth'] < 1){ ?>
 <? 
 	$author_on_paragraph = ($c->comment_contentIndex == 0) ? " whole page " : "paragraph ".$c->comment_contentIndex;
 
 ?>
	 <b><?php comment_author_link() ?><a href="#comment-<?php comment_ID() ?>"></a></b><span class="author_on_paragraph"> <?php _e('on');?> <?php echo $author_on_paragraph; ?></span>:
 <? }else{ ?>			
	 <cite><?php comment_author_link() ?><a href="#comment-<?php comment_ID() ?>"></a> <span class="smLight"></span></cite>:
 <? } ?>
 </div>
 <div class='body'>				
   <div class='content'>
	 <?php 
	 
	 	comment_text();	 
	 	if(preg_match('|<trackback />|', $c->comment_content)) {
		 	echo "<small>Read the rest at ";
			comment_author_link();
			echo "</small>";
		}
	 ?>
   </div>
   <div class="cp_commentMeta">
   <? if($GLOBALS['__writeCommentDepth'] < 2){ ?>
	   <div class="cp_replyLink">
	   <a href="<?php bloginfo('url'); ?>/<?php echo $c->post_name."/#".$c->comment_contentIndex ?>" id="goto-thread-<?php echo $c->comment_contentIndex ?>" class="cp_goToText">go to text  &raquo;</a> 
	   
	   <a class="reply_link" href='javascript:moveAddCommentBelow("div-comment-<?php comment_ID() ?>", <?php comment_ID() ?>)'>Reply &raquo;</a></div>
   	<? } ?>
	   <div class='cp_datePosted'>
	   <?php comment_date() ?> <?php comment_time() ?>						
	   </div>
   </div>
 </div>

 <?php endif; ?>

<?php
		
		if($threaded_comments[$c->comment_ID]) {
			$id = $c->comment_ID;
			foreach($threaded_comments[$id] as $c) {
				$GLOBALS['__writeCommentDepth']++;
				write_comment($c);
				$GLOBALS['__writeCommentDepth']--;
			}
		}
?>
</div>
</div>
<?php
	}// end function
?>

<!-- start comments.php --> 
<!-- You can start editing here. --> 
<?php if (true){ ?> 

 <!--
<div id="newcomment">
</div>
-->
	
<div id="comments">
	<input type="hidden" name="comment_total_count" value="<?= count($comments) ?>" />

	<div id="cp_newComment"></div>
	
	
	<?php if($new_comment): ?>
	<div class="normalRed"><a onclick="paragraph_read_event(<? echo $the_new_comment->comment_contentIndex ?>)" href="javascript:void(0)"><?php echo $total_new_comments ?> new comment<?php echo ($total_new_comments > 0) ? "s" : ""; ?></a></div>
	<?php endif; ?>
	<div id="cp_commentsTotal" class="normalLight">Total comments on this page: <span id="cp_count"><?= count($comments) ?></span></div>  
		<!--<div id="cp_helpIcon" class="smLight"><a href="javascript:void(0)" id="show_help_action">[?]</a></div>-->

	
	<div class="activity_box" id="container_commentContent"> 
<?php // SECTION EXPAND/COLLAPSE ALL 
?>	
		<div id="cp_showAll" class="smRed"><a id="show_all_comments_action" href="javascript:void(0)">help</a></div>
<?php // SECTION FOR HELP TEXT 
?>	
		<div id="comment_help">
			<h3>How to read/write comments</h3>
			<div id="cp_comments">						
			 <div class="commentlist">
				 				 
				 <h4>Comments on specific paragraphs:</h4>
					 <p>Click the <img src="<?php bloginfo('url'); ?>/wp-content/themes/commentpress/images/pararead.png"> icon to the right of a paragraph</p>
					 <ul><li>If there are no prior comments there, a comment entry form will appear automatically</li>
						<li>If there are already comments, you will see them and the form will be at the bottom of the thread</li>
					</ul>
					 
				 <h4>Comments on the page as a whole: </h4>
					 <p>Click the <img src="<?php bloginfo('url'); ?>/wp-content/themes/commentpress/images/pageread.png"> icon to the right of the page title (works the same as paragraphs)</p>	 
			 </div>
			</div>
			
		</div>
<?php // SECTION FOR COMMENT OVERVIEW LIST 
?>
		<div id="comment_index">
			<h3>Comments Overview</h3>
			<div id="cp_comments">						
			 <div class="commentlist">				 							 				 
			  <ul>
			  <?
				  $comment_index_array = commentpress_comment_index_array();
				  foreach($comment_index_array as $key=>$count){
					  $block_title = ($key != 0) ? "Paragraph $key" : " Whole page";  
					  ?>
					  <li><a class="paragraph_read_index"  id="cpar-<?php echo $key; ?>" href="<?php echo $_SERVER['REQUEST_URI']; ?>#<?php echo $key ?>"> <?php echo $block_title ?> (<?php echo $count; ?>)</a></li>
					  <?
				  }
			  ?>
			  </ul>
			 </div>
			</div>
		</div>

<?php // SECTION FOR COMMENT LISTING FOR A SINGLE PARAGRAPH 
?>
		<div id="comment_read">
			<h3>Comments <span class="normalLight"><span id='active_paragraph'></span></span></h3>
			<div id="cp_comments">
			
			<div class="commentlist" id="commentlist">

			<p id='no_comments_yet'><?php _e('No comments yet.'); ?></p>

			<?php 
			
				if ( $comments ) { 
				 	foreach($comments as $c){
					 $GLOBALS['threaded_comments'][$c->comment_parent][] = $c;
					}
				
					$GLOBALS['__writeCommentDepth'] = 0;
					foreach($GLOBALS['threaded_comments'][0] as $comment) {
						$GLOBALS['comment'] = &$comment;
						write_comment($GLOBALS['comment']);
					}
				}	
				
				else { 
				?>
				
			<?php } ?>			
			</div>
			
			
			<?php if ('open' == $post->comment_status) { ?>
			<?php
			$comment_author = (isset($_COOKIE['comment_author_' . COOKIEHASH])) ? trim($_COOKIE['comment_author_'. COOKIEHASH]) : '';
			$comment_author_email = (isset($_COOKIE['comment_author_email_'. COOKIEHASH])) ? trim($_COOKIE['comment_author_email_'. COOKIEHASH]) : '';
			$comment_author_url = (isset($_COOKIE['comment_author_url_'. COOKIEHASH])) ? trim($_COOKIE['comment_author_url_'. COOKIEHASH]) : '';			
			?>
			
			<div id="base_comment_box">
			<div id="addcomment">
			<a id="addcommentanchor" class="addcommentanchor"></a>
			
			<?
			 	global $user_ID;
				global $userdata;
				get_currentuserinfo();
			
			 if( get_option('comment_registration') && !$user_ID):
			 
			?>
			 <p>

			<div class="add">
			 <div id="reroot" style="display: none;">
				 <small><a href="javascript:reRoot()">Cancel reply</a></small>
			 </div>

			 <input type="hidden" id="comment">			 
			</div>
			<?php do_action('comment_form', $post->ID); ?>
			
			<?= (get_option('users_can_register')) ? "You must be login to comment. <br><a href=\"$wpurl/wp-login.php?action=register\">Create an account </a> or " : " Comments are by invitation only. "; ?>
			<?= (get_option('users_can_register')) ? "<a href=\"$wpurl/wp-login.php\">login</a>" : ""; ?>
			</p>
			<?					
			 else:
			?>			 

			
			<form action="<?php bloginfo('url'); ?>/<?php echo get_option('btc_customtarget') ? "wp-comments-post.php" : get_option('btc_customtarget'); ?>" method="post" id="commentform">
			<div class="add">
			 <div id="reroot" style="display: none;">
				 <small><a href="javascript:reRoot()">Cancel reply</a></small>
			 </div>
			 
			 <!-- start -->
			 <?
				if($user_ID){
			 ?>
			 		<small>You are logged in as <b><?= $userdata->user_login ?></b> (<a href="<?php bloginfo('url'); ?>/wp-login.php?action=logout&redirect=<?= $_SERVER['REQUEST_URI'] ?>"><?php _e('Logout');?> </a>)</small>

			 <?
				}
				else {
			 ?>
				<small>
					<?php _e('Name'); ?> <?php if ($req) _e('(required)'); ?>
				</small>
				<div>
					<input type="text" name="author" id="author" class="textarea" value="<?php echo $comment_author; ?>" size="28" tabindex="1" />
				</div>
				<small>
					<?php _e('E-mail'); ?> <?php if ($req) _e('(required - never shown publicly)'); ?>
				</small>
				<div>
					<input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="28" tabindex="2" />
				</div>
				<small>
					<acronym title="<?php _e('Uniform Resource Identifier');?>">URI</acronym>
					</small>
				<div>
					<input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="28" tabindex="3" />	
				</div>				
				<? } ?>							
				<small>

				</small>
				<div style="width: 100%;">
					<textarea name="comment" id="comment" cols="60" rows="9" tabindex="4"></textarea>
				</div>
				<div>
					<input type="hidden" name="comment_post_ID" value="<?php echo $post->ID; ?>" />
					<input type="hidden" name="redirect_to" value="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" />
					<input onclick="if(typeof(onAddComment) == 'function') { onAddComment(); } else { alert('ERROR:\nIt looks like the website administrator hasn\'t activated the Brians Threaded Comments plugin from the plugin page'); };" name="addcommentbutton" type="button" id="addcommentbutton" value="Add comment" tabindex="5" />
				</div>
			</div>
			<?php do_action('comment_form', $post->ID); ?>
			</form>
			
			<?= (get_option('users_can_register')) ? "<a href=\"$wpurl/wp-login.php?action=register&redirect=".$_SERVER['REQUEST_URI']."\">Create an account (optional)</a> | " : ""; ?>
			<?= (get_option('users_can_register')) ? ( ($user_ID) ? "<a href=\"$wpurl/wp-login.php?action=logout\">Logout</a>" :"<a href=\"$wpurl/wp-login.php?redirect=".$_SERVER['REQUEST_URI']."\">Login</a>") : ""; ?>
			<? endif; ?>

			</div>
			<?php 
				} 
				else { /* Comments are closed */ ?>
			<p><?php _e('Sorry, the comment form is closed at this time.'); ?></p>
			<?php } ?>
<?php } ?>			
			<!-- END COMMENTS FOR TESTING -->
			</div>
			</div>
		</div>
	</div> 
	<div>
	<!-- <span id="resize_comment_area" style="cursor: row-resize;">a</span> -->
	</div>

</div>



<? } ?>
