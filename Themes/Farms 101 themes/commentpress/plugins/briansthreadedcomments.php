<?php
/*
Plugin Name: Brian's Threaded Comments
Plugin URI: http://meidell.dk/threadedcomments/
Version: 1.5.12
Description: This gives you threaded comments and a "wandering" comment form.
Author: Brian Meidell
Author URI: http://meidell.dk/

Changelog:
   version 1.5: 	Released for WP1.5
   version 1.5.1:	Added error message for missing form field
   version 1.5.2:	Fixed stupid bug from last release	
   version 1.5.3:	Much more comprehensive error messages to help with diagnosis of problems.
   			Added login patch from Salil Deshpande.
			Added auto-integration with subscribe-to-comments.
   version 1.5.4:	A fix to Salil Deshpandes patch - proper login required code, thanks to Salil again.
   			Renamed maybe_add_column to prevent conflicts with other plugins.
   version 1.5.5:	Added an options panel called "Threaded Comments" for the few settings
   version 1.5.6:	Changed comment_reply_ID form field to use comment_form hook instead, making it 
   			compatible with other plugins using this hook. Thanks to Martey of www.marteydodoo.com for pointing this out.
   version 1.5.7:       Included bugfix from Zhou Qingbo
   version 1.5.8:	Fixed php opening tags to be verbose, as suggested by Michael Carrino
   version 1.5.9:	Changed plugin to use only existing database columns, and added migration code from older versions
   version 1.5.10:	Changed nesting levels setting so it correctly reflects the nesting level (it was one off)
	version 1.5.11: Fixed taborder. Thanks to RJ Matthis (http://blog.reformatthis.com) / Ryan J Parker (http://www.ryanjparker.net)
	version 1.5.12: Fixed missing php opening tag
*/

 
/**
 * Images
 */

if(isset($_GET['image'])){
	header("content-type: image/png");
	print base64_decode($images[$_GET['image']]);
	exit;
}

function btc_options_page()
{
	global $wpdb;
?>
 
<div class="wrap"> 
<?php 
	$col = $wpdb->get_col("DESCRIBE {$wpdb->comments} comment_reply_ID");
	$col = count( $col );
?>
  <?php if( $col && !get_option("btc_migrated") ) { ?>
  <h2><?php _e('Upgrade Threading'); ?></h2>
  <form name="form2" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
    <table width="100%" cellspacing="2" cellpadding="5" class="editform"> 
      <tr valign="top"> 
        <th width="33%" scope="row"><?php _e('Migrate Threading') ?></th> 
        <td>
	<?php if( isset($_REQUEST['btc_upgrade']) ) { 
	 	$wpdb->query("UPDATE {$wpdb->comments} SET comment_parent=comment_reply_ID WHERE comment_parent = 0");
		update_option("btc_migrated", 1 );
	?>
           Done migrating comments.
	<?php } else { ?>
	  <input type="submit" name="btc_upgrade" value="Migrate now" />
	<br />
	Migrate threading from older version of Brians Threaded Comments plugin. 
	<?php
	} ?>
	</td> 
      </tr> 
      </table>
  </form>
  <?php } ?>
  <h2><?php _e('Brians Threaded Comments Options') ?></h2> 
  <form name="form1" method="post" action="options.php"> 
	<input type="hidden" name="action" value="update" /> <input type="hidden" name="page_options" value="btc_nestinglevels,btc_shrinkby,btc_customtarget" /> 
    <table width="100%" cellspacing="2" cellpadding="5" class="editform"> 
      <tr valign="top"> 
        <th width="33%" scope="row"><?php _e('Max Nesting Levels:') ?></th> 
        <td><input name="btc_nestinglevels" type="text" id="btc_nestinglevels" value="<?php form_option('btc_nestinglevels'); ?>" size="5" /></td> 
      </tr> 
      <tr valign="top"> 
        <th scope="row"><?php _e('Shrink Font By %:') ?></th> 
        <td><input name="btc_shrinkby" type="text" id="btc_shrinkby" value="<?php form_option('btc_shrinkby'); ?>" size="5" />
        <br />
<?php _e('Enables shrinking the font by n percent per nesting level. Recommended is 0%-2%.') ?></td> 
      </tr> 
      <tr valign="top"> 
        <th width="33%" scope="row"><?php _e('Custom Comments Target:') ?></th> 
        <td><input name="btc_customtarget" type="text" id="btc_customtarget" value="<?php form_option('btc_customtarget'); ?>" size="40" />
	<br /> 
<?php _e('If you have renamed your wp-comments-post.php file to prevent comment spam, set the filename here (relative to the site root).') ?></td> 
      </tr> 
</table>

    </fieldset> 
    <p class="submit">
      <input type="submit" name="Submit" value="<?php _e('Update Options') ?> &raquo;" />
    </p>
  </form> 
</div> 
<?php 
	include("admin-footer.php");
	exit;
}
	
/**
 * Settings   
 */
 $shrinkby = get_option("btc_shrinkby");  	//	Each level of nesting makes the font size 2% smaller
 $btc_cutoff_level = get_option("btc_nestinglevels")-1; 		// 	At what level of nesting should we flatten the tree

function bnc_altertable()
{
	global $tablecomments;
	if(get_option("btc_shrinkby") == false)
		add_option("btc_shrinkby", 0, "Shrink percentage per nesting level for Brians Threaded Comments");
	if(get_option("btc_nestinglevels") == false)
		add_option("btc_nestinglevels", 3, "Max numver of nesting levels for Brians Threaded Comments");
	if(get_option("btc_customtarget") == false)
		add_option("btc_customtarget", "wp-comments-post.php", "Custom post target script name for Brians Threaded Comments");
}

function briansthreadedcomments() {
global $shrinkby;
if (!($withcomments) && ($single)) return;

// You can safely delete the single line below if your threaded comments are up and running
	bnc_altertable();
	
?>
<style type="text/css">
.comment 
{
/*	position: 				relative;
	margin:					3px;
	margin-top:				6px;
	border: 				1px solid #666; 
	padding:				4px 4px 4px 8px;
<?php if($shrinkby > 0) { ?>
	font-size:				<?php echo (100-$shrinkby); ?>%;
<?php } ?>
	background-color:		#fff;
*/
}
</style>
<?php
}

function btc_add_reply_id($id){
	global $wpdb;	
	$reply_id = mysql_escape_string($_REQUEST['comment_reply_ID']);
	$q = $wpdb->query("UPDATE $wpdb->comments SET comment_parent='$reply_id' WHERE comment_ID='$id'");
}

function btc_add_options()
{
	add_options_page("Threaded Comments", "Threaded Comments", 7, __FILE__, 'btc_options_page');
	
}

function btc_add_reply_id_formfield()
{
	print "<input type='hidden' id='comment_reply_ID' name='comment_reply_ID' value='0' />";
}

add_action('wp_head','briansthreadedcomments');
//add_action('comment_post','btc_add_reply_id');
//add_action('admin_menu', 'btc_add_options');
add_action('comment_form', 'btc_add_reply_id_formfield');
?>
