<?php
/*
Plugin Name: Personal Welcome
Plugin URI: http://www.stillbreathing.co.uk/projects/personalwelcome/
Description: A plugin for Wordpress MU which allows you to create and send personal welcome messages to new users
Version: 0.1
Author: Chris Taylor
Author URI: http://www.stillbreathing.co.uk
*/

// add the wp_foot action
if (function_exists("add_action"))
{
	add_action("admin_menu", "personalwelcome_add_admin");
	add_action("admin_head", "personalwelcome_css");
}

// add the css
function personalwelcome_css()
{
	echo '
<style type="text/css">
#personalwelcome label {
float: left;
width: 20%;
}
#personalwelcome input.text, #personalwelcome textarea.text {
	width: 75%; 
}
</style>
	';
}

// add the admin menu option
function personalwelcome_add_admin()
{
	if (is_site_admin())
	{
		add_submenu_page('wpmu-admin.php', __("Personal Welcomes"), __("Personal Welcomes"), 10, 'personalwelcome', 'personalwelcome');
	}
}
	
// load the personal welcome admin page
function personalwelcome()
{
	global $wpdb;
	global $current_blog;
	global $current_user;
	
	echo '
	<div id="personalwelcome" class="wrap">
	';
	
	if (!isset($_GET["send"]) || $_GET["send"] == "")
	{

		echo '
		<h2>' . __("Personal welcomes") . '</h2>
		
			<form action="wpmu-admin.php?page=personalwelcome" method="post">
			<p><label for="personalwelcome_q">' . __("Search for a user") . '</label>
			<input type="text" name="personalwelcome_q" id="personalwelcome_q" /></p>
			<p><label for="personalwelcome_s">' . __("Search") . '</label>
			<input type="submit" name="personalwelcome_s" id="personalwelcome_s" class="button" value="' . __("Search users") . '" /></p>
			</form>
		
		';
		
		$start = @$_GET["start"];
		if ($start == ""){ $start = 0; }
	
		if (isset($_POST["personalwelcome_q"]) && trim($_POST["personalwelcome_q"]) != "")
		{
	
			// search users
			$sql = "select u.id, u.user_login, u.user_nicename, u.display_name, 
								UNIX_TIMESTAMP(u.user_registered) as user_registered, u.user_email,
								m.meta_value as personalinvite
								from " . $wpdb->users . " u 
								left outer join wp_usermeta m on m.user_id = u.id and m.meta_key = 'personal_welcome_sent' 
								where u.display_name like '%" . $wpdb->escape(trim($_POST["personalwelcome_q"])) . "%'
								or u.user_login like '%" . $wpdb->escape(trim($_POST["personalwelcome_q"])) . "%'
								or u.user_email like '%" . $wpdb->escape(trim($_POST["personalwelcome_q"])) . "%'
								or u.user_nicename like '%" . $wpdb->escape(trim($_POST["personalwelcome_q"])) . "%'
								order by u.user_registered desc limit " . $wpdb->escape($start) . ", 25;";
	
		} else {
	
			// get new users
			$sql = $wpdb->prepare("select u.id, u.user_login, u.user_nicename, u.display_name, 
								UNIX_TIMESTAMP(u.user_registered) as user_registered, u.user_email 
								from " . $wpdb->users . " u 
								left outer join wp_usermeta m on m.user_id = u.id and m.meta_key = 'personal_welcome_sent' 
								where IFNULL(m.meta_value, '') = '' 
								order by u.user_registered desc limit %d, 25;", 
								$start);
							
		}

		$users = $wpdb->get_results($sql);

		if ($users && is_array($users) && count($users) > 0)
		{
		
			if (isset($_POST["bulkset"]) && $_POST["bulkset"] != "")
			{
			
				$i = personalinvite_set_all_as_sent();
				
				echo '
				<p>' . $i . ' ' . __("users have been set as personally welcomed") . '.</p>
				';
			
			} else {
			
				echo '
				<form action="wpmu-admin.php?page=personalwelcome" method="post">
				<p><label for="bulkset">' . __("Set all users as personally welcomed") . '</label>
				<input type="submit" name="bulkset" id="bulkset" class="button" value="' . __("Bulk set users") . '" /></p>
				</form>
				';
			
			}
		
			echo '
			<table class="widefat post fixed">
				<thead>
				<tr>
					<th>' . __("Username") . '</th>
					<th>' . __("Full name") . '</th>
					<th>' . __("Display name") . '</th>
					<th>' . __("Email") . '</th>
					<th>' . __("Date registered") . '</th>
					';
					if (isset($_POST["personalwelcome_q"]) && trim($_POST["personalwelcome_q"]) != "")
					{
						echo '
						<th>' . __("Personal invite") . '</th>
						';
					}
					echo'
				</tr>
				</thead>
				<tbody>
				';
			foreach($users as $user)
			{
				echo '
				<tr>
					<td><a href="wpmu-admin.php?page=personalwelcome&amp;send=' . $user->id . '">' . $user->user_login . '</a></td>
					<td>' . $user->user_nicename . '</td>
					<td>' . $user->display_name . '</td>
					<td><a href="mailto:' . $user->user_email . '">' . $user->user_email . '</a></td>
					<td>' . date("F j, Y, g:i a", $user->user_registered) . '</td>
					';
					if (isset($_POST["personalwelcome_q"]) && trim($_POST["personalwelcome_q"]) != "")
					{
						echo '
						<td>' . $user->personalinvite . '</td>
						';
					}
					echo'
				</tr>
				';
			}
				echo '
				</tbody>
			</table>
			';
			
		} else {
		
			if (isset($_POST["personalwelcome_q"]) && trim($_POST["personalwelcome_q"]) != "")
			{
				echo '
				<div class="updated"><p>' . __("No users found for your search") . '.</p></div>
				';
			} else {
				echo '
				<div class="updated"><p>' . __("No users found that require a personal welcome") . '.</p></div>
				';
			}
		
		}
		
		echo '
		<h3 id="templates">' . __("Welcome templates") . '</h3>
		<p>' . __("Use the following shortcodes in the subject or body to automatically add the users name or email address:") . '</p>
		<ul>
			<li><strong>[user_email]</strong> - ' . __("enters the users email address") . '</li>
			<li><strong>[display_name]</strong> - ' . __("enters the users display name") . '</li>
			<li><strong>[user_nicename]</strong> - ' . __("enters the users full name") . '</li>
			<li><strong>[user_login]</strong> - ' . __("enters the users login name") . '</li>
		</ul>
		';
		
		$templates = maybe_unserialize(get_site_option("personal_welcome_templates"));
		
		if (isset($_POST["action"]))
		{
			if ($_POST["action"] == "savenewtemplate")
			{
				if (trim($_POST["subject"]) != "" && trim($_POST["message"]) != "")
				{
					$templates[] = array("subject"=>$_POST["subject"], "message"=>$_POST["message"]);
				} else {
					echo '
					<div class="error"><p>' . __("You must enter a subject and message for this new template") . '.</p></div>
					';
				}
			}
			if ($_POST["action"] == "savetemplates")
			{
				$newtemplates = array();
				$num = $_POST["num"];
				if ($num != "")
				{
					for($i = 1; $i <= $num; $i++)
					{
						if (trim($_POST["subject".$i]) != "" && trim($_POST["message".$i]) != "")
						{
							if (@$_POST["delete".$i] != "1")
							{
								$newtemplates[] = array("subject"=>$_POST["subject".$i], "message"=>$_POST["message".$i]);
							}
						} else {
							echo '
							<div class="error"><p>' . __("You must enter a subject and message for template number") . ' ' . $i . '.</p></div>
							';
						}
					}
				}
				$templates = $newtemplates;
			}
			update_site_option("personal_welcome_templates", maybe_serialize($templates));
			$templates = maybe_unserialize(get_site_option("personal_welcome_templates"));
			echo '
			<div class="updated"><p>' . __("The templates have been updated") . '.</p></div>
			';
		}
		
		if ($templates && is_array($templates) && count($templates) > 0)
		{
		
			$i = 1;
			
			echo '
			<form action="wpmu-admin.php?page=personalwelcome#templates" method="post">
			';
		
			foreach($templates as $template)
			{
			
				echo '
				
				<h4>Template ' . $i . '</h4>
				<p><label for="subject' . $i . '">' . __("Subject") . '</label>
				<input type="text" name="subject' . $i . '" id="subject' . $i . '" value="' . stripslashes($template["subject"]) . '" class="text" /></p>
				<p><label for="message' . $i . '">' . __("Message") . '</label>
				<textarea name="message' . $i . '" id="message' . $i . '" rows="12" cols="30" class="text">' . stripslashes($template["message"]) . '</textarea></p>	
				<p><label for="delete' . $i . '">' . __("Delete this template") . '</label>
				<input type="checkbox" name="delete' . $i . '" id="delete' . $i . '" value="1" /></p>
				
				';
				
				$i++;
			
			}
			
			echo '
			<p><label for="saveall">' . __("Save templates") . '</label>
			<input type="submit" name="saveall" id="saveall" class="button" value="' . __("Save all these templates") . '" />
			<input type="hidden" name="num" value="' . ($i-1) . '" />
			<input type="hidden" name="action" value="savetemplates" /></p>
			</form>
			';
		
		} else {
		
			echo '
			<div class="updated"><p>' . __("You do not have any personal welcome templates yet, please add one below") . '.</p></div>
			';
		
		}
		
		echo '
			<h3>' . __("Add a new template") . '</h3>
			<form action="wpmu-admin.php?page=personalwelcome#templates" method="post">
			<p><label for="subject">' . __("Subject") . '</label>
			<input type="text" name="subject" id="subject" value="" class="text" /></p>
			<p><label for="message">' . __("Message") . '</label>
			<textarea name="message" id="message" rows="12" cols="30" class="text"></textarea></p>
			<p><label for="save">' . __("Save template") . '</label>
			<input type="submit" name="save" id="save" class="button" value="' . __("Save this new template") . '" />
			<input type="hidden" name="action" value="savenewtemplate" /></p>
			</form>
		';
		
	} else {
	
		$sql = $wpdb->prepare("select id, user_email, user_nicename, user_login, display_name
				from " . $wpdb->users . "
				where id = %d;",
				$_GET["send"]);
		$user = $wpdb->get_row($sql);
		if ($user->id != "")
		{
		
			$templates = maybe_unserialize(get_site_option("personal_welcome_templates"));
		
			echo '
			<h2>' . __("Send a personal welcome message to") . ': ' . $user->display_name . '</h2>
			';
			
			if (!isset($_POST["templatenumber"]))
			{
				
				if ($templates && is_array($templates) && count($templates) > 0)
				{
				
					echo '
					<form action="wpmu-admin.php?page=personalwelcome&amp;send=' . $user->id . '" method="post">
					<p>' . __("Choose a template to use") . ':</p>
					<p><label for="templatenumber">' . __("Template") . '</label>
					<select name="templatenumber" id="templatenumber">
					';
					
					$i = 0;
					
					foreach($templates as $template)
					{
						echo '
						<option value="' . $i . '">' . stripslashes($template["subject"]) . '</option>
						';
						
						$i++;
					}
					
					echo '
					</select></p>
					<p><label for="choose">' . __("Choose template") . '</label>
					<input type="submit" name="choose" id="choose" class="button" value="' . __("Choose template") . '" /></p>
					</form>
					';
				
				} else {
				
					echo '
					<div class="error"><p>' . __("You do not have any templates") . '. <a href="wpmu-admin.php?page=personalwelcome">' . __("Please add one here") . '</a>.</p></div>
					';
				
				}
				
			} else {
			
				if (isset($_POST["subject"]) && trim($_POST["subject"]) != "" && isset($_POST["message"]) && trim($_POST["message"]) != "")
				{
					
					// send the message
					personalinvite_send($user);
					echo '
					<div class="updated"><p>' . __("The message has been sent to") . ': ' . $user->user_email . '.</p></div>
					';
				}
			
				$template = $templates[$_POST["templatenumber"]];
				
				echo '
				<h3>Send a message</h3>
				<form action="wpmu-admin.php?page=personalwelcome&amp;send=' . $user->id . '" method="post">
				<p><label for="subject">' . __("Subject") . '</label>
				<input type="text" name="subject" id="subject" value="' . personalinvite_prepare($user, stripslashes($template["subject"])) . '" class="text" /></p>
				<p><label for="message">' . __("Message") . '</label>
				<textarea name="message" id="message" rows="12" cols="30" class="text">' . personalinvite_prepare($user, stripslashes($template["message"])) . '</textarea></p>
				<p><label for="send">' . __("Send message") . '</label>
				<input type="submit" name="send" id="send" class="button" value="' . __("Send message") . '" />
				<input type="hidden" name="templatenumber" value="' . $_POST["templatenumber"] . '" /></p>
				</form>
				';
			
			}
		
		} else {
		
			echo '
			<div class="updated"><p>' . __("Sorry, that user cannot be found. Please click back and try again") . '.</p></div>
			';
		
		}
	
	}
	
	echo '
	</div>';
}

// prepare text
function personalinvite_prepare($user, $text)
{
	$text = str_replace("[user_nicename]", $user->user_nicename, $text);
	$text = str_replace("[user_login]", $user->user_login, $text);
	$text = str_replace("[display_name]", $user->display_name, $text);
	$text = str_replace("[user_email]", $user->user_email, $text);
	return $text;
}

// send a personal invite
function personalinvite_send($user)
{
	global $current_user;
	$headers = "MIME-Version: 1.0\n" .
	"From: " . $current_user->user_email . "\n" .
	"Content-Type: text/plain; charset=\"" . get_settings('blog_charset') . "\"\n";
	wp_mail($user->user_email, stripslashes(trim($_POST["subject"])), stripslashes(trim($_POST["message"])), $headers);
	update_usermeta($user->id, "personal_welcome_sent", "Sent by " . $current_user->user_email . " on " . date("F j, Y, g:i a"));
}

// set all users as sent
function personalinvite_set_all_as_sent()
{
	global $wpdb;
	$sql = "select id from " . $wpdb->users . ";";
	$setusers = $wpdb->get_results($sql);
	$i = 0;
	foreach($setusers as $u)
	{
		if (get_usermeta($u->id, "personal_welcome_sent") == "")
		{
			update_usermeta($u->id, "personal_welcome_sent", __("Bulk set by") . " " . $current_user->user_email . " (" . date("F j, Y, g:i a") . ")");
			$i++;
		}
	}
	return $i;
}
?>