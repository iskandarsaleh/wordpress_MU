<?php
// no kiddies.
if ( !defined("ABSPATH") and !defined("INCSUBSUPPORT") ) {
	die("I don't think so, Tim.");
}

function incsub_support_tickets_output() {
	global $current_site, $current_user, $blog_id, $wpdb, $ticket_status, $ticket_priority;
	// post routine.
	if ( !empty($_POST['addticket']) and $_POST['addticket'] == 1 ) {
		if ( empty($_POST['subject']) or !is_numeric($_POST['category']) or !is_numeric($_POST['priority']) or empty($_POST['message']) ) {
			$notification = __("Ticket Error: All fields are required.");
			$nclass = "error";
		} else {
			$title = wp_specialchars(strip_tags($_POST['subject']));
			$message = wp_specialchars(wpautop(strip_tags($_POST['message'])));
			$category = $_POST['category'];
			$priority = $_POST['priority'];
			$email_message = false;
			$wpdb->query("INSERT INTO {$wpdb->tickets}
				(site_id, blog_id, cat_id, user_id, ticket_priority, ticket_opened, title)
			VALUES (	
				'{$current_site->id}', '{$blog_id}', '{$category}', '{$current_user->id}',
				'{$priority}', NOW(), '{$title}')
			");
			if ( !empty($wpdb->insert_id) ) {
				$ticket_id = $wpdb->insert_id;
				$wpdb->query("INSERT INTO {$wpdb->tickets_messages}
					(site_id, ticket_id, user_id, subject, message)
					VALUES (
						'{$current_site->id}', '{$ticket_id}', '{$current_user->id}', '{$title}', '{$message}')
				");
				if ( !empty($wpdb->insert_id) ) {
					$notification = __("Thank you. Your ticket has been submitted. You will be notified by email of any responses to this ticket.");
					$nclass = "updated fade";
					$title = stripslashes($title);
					$email_message = array(
						"to"		=> incsub_support_notification_admin_email(),
						"subject"	=> __("New Support Ticket: ") . $title,
						"message"	=> _("
	***  DO NOT REPLY TO THIS EMAIL  ***

	Subject: ". $title ."
	Status: ". $ticket_status[$status] ."
	Priority: ". $ticket_priority[$priority] ."

	Visit:

		http://". $current_site->domain . $current_site->path ."wp-admin/wpmu-admin.php?page=ticket-manager&tid={$ticket_id}

	to reply to view the new ticket.


	------------------------------
	     Begin Ticket Message
	------------------------------

	". $wpdb->get_var("SELECT user_nicename FROM {$wpdb->users} WHERE ID = '{$current_user->id}'") ." said:


	". $message ."

	------------------------------
	      End Ticket Message
	------------------------------


	Ticket URL:
		http://". $current_site->domain . $current_site->path ."wp-admin/wpmu-admin.php?page=ticket-manager&tid={$ticket_id}"), // ends lang string

	"headers"	=> "MIME-Version: 1.0\n" . "From: \"". get_site_option("site_name") ."\" <". get_site_option("admin_email") .">\n" . "Content-Type: text/plain; charset=\"" . get_option('blog_charset') . "\"\n",
					); // ends array.
				} else {
				$notification = __("Ticket Error: There was an error submitting your ticket. Please try again in a few minutes.");
					$nclass = "error";
				}
			} else {
				$notification = __("Ticket Error: There was an error submitting your ticket. Please try again in a few minutes.");
				$nclass = "error";
			}
		}
	} elseif ( !empty($_POST['modifyticket']) and $_POST['modifyticket'] == 1 ) {
		if ( !empty($_POST['canelsubmit']) ) {
			wp_redirect("support.php?page=tickets");
			exit();
		}
		if ( empty($_POST['subject']) or !is_numeric($_POST['category']) or !is_numeric($_POST['priority']) or !is_numeric($_POST['status']) or !is_numeric($_POST['ticket_id']) or empty($_POST['message']) ) {
			$notification = __("Ticket Error: All fields are required.");
			$nclass = "error";
		} else {
			$title = wp_specialchars(strip_tags($_POST['subject']));
			$message = wp_specialchars(wpautop(strip_tags($_POST['message'])));
			$category = $_POST['category'];
			$priority = $_POST['priority'];
			$ticket_id = $_POST['ticket_id'];
			$status = ($_POST['closeticket'] == 1) ? 5 : 3;
			$email_message = false;
			$wpdb->query("INSERT INTO {$wpdb->tickets_messages}
				(site_id, ticket_id, user_id, subject, message)
				VALUES ('{$current_site->id}', '{$ticket_id}', '{$current_user->id}', '{$title}', '{$message}')
			");

			if ( !empty($wpdb->insert_id) ) {
				$wpdb->query("UPDATE {$wpdb->tickets}
					SET
						cat_id = '{$category}', last_reply_id = '{$current_user->id}', ticket_priority = '{$priority}', ticket_status = '{$status}', num_replies = num_replies+1
					WHERE site_id = '{$current_site->id}' AND blog_id = '{$blog_id}' AND ticket_id = '{$ticket_id}'
					LIMIT 1
				");

				if ( !empty($wpdb->rows_affected) ) {
					$notification = __("Thank you. Your ticket has been updated. You will be notified by email of any responses to this ticket.");
					$nclass = "updated fade";
					$title = stripslashes($title);
					$email_message = array(
						"to"		=> incsub_support_notification_admin_email(),
						"subject"	=> __("Support Ticket Update: ") . $title,
						"message"	=> _("

	***  DO NOT REPLY TO THIS EMAIL  ***

	Subject: ". $title ."
	Status: ". $ticket_status[$status] ."
	Priority: ". $ticket_priority[$priority] ."

	Visit:

		http://". $current_site->domain . $current_site->path ."wp-admin/wpmu-admin.php?page=ticket-manager&tid={$ticket_id}

	to respond to this ticket update.


	------------------------------
	     Begin Ticket Message
	------------------------------

	". $wpdb->get_var("SELECT user_nicename FROM {$wpdb->users} WHERE ID = '{$current_user->id}'") ." said:


	". $message ."

	------------------------------
	      End Ticket Message
	------------------------------


	Ticket URL:
		http://". $current_site->domain . $current_site->path ."wp-admin/wpmu-admin.php?page=ticket-manager&tid={$ticket_id}"), // ends lang string

	"headers"	=> "MIME-Version: 1.0\n" . "From: \"". get_site_option("site_name") ."\" <". get_site_option("admin_email") .">\n" . "Content-Type: text/plain; charset=\"" . get_option('blog_charset') . "\"\n",

					); // ends array.

				} else {
					$notification = __("Ticket Error: There was an error updating your ticket. Please try again in a few minutes.");
					$nclass = "error";
				}
			} else {
				$notification = __("Ticket Error: There was an error adding your reply. Please try again in a few minutes.");
				$nclass = "error";
			}
		}
	}
	if ( !empty($notification) ) {
		if ( !empty($email_message) and is_array($email_message) ) {
			wp_mail($email_message["to"], $email_message["subject"], $email_message["message"], $email_message["headers"]);
		}
?>
	<div class="<?php echo $nclass; ?>"><?php echo $notification; ?></div>
<?php
	}

	$do_history = ( !empty($_GET['action']) and $_GET['action'] == 'history' ) ? '' : 'AND t.ticket_updated > DATE_SUB(CURDATE(), INTERVAL 1 MONTH)';
	$tickets = $wpdb->get_results("
		SELECT t.ticket_id, t.user_id, t.cat_id, t.admin_id, t.ticket_type, t.ticket_priority, t.ticket_status, t.ticket_updated, t.title, c.cat_name, u.display_name
		FROM $wpdb->tickets AS t
		LEFT JOIN $wpdb->tickets_cats AS c ON (t.cat_id = c.cat_id)
		LEFT JOIN $wpdb->users AS u ON (t.admin_id = u.ID)
		WHERE t.site_id = '{$current_site->id}' AND t.blog_id = '{$blog_id}' {$do_history}
	");
?>
<br />
<div class="wrap">
<?php
	if ( !empty($_GET['tid']) and is_numeric($_GET['tid']) ) {
		$current_ticket = $wpdb->get_results("
		SELECT
			t.ticket_id, t.cat_id, t.user_id, t.admin_id, t.ticket_type, t.ticket_priority, t.ticket_status, t.ticket_opened, t.ticket_updated, t.title,
			c.cat_name, u.display_name AS user_name, a.display_name AS admin_name, l.display_name AS last_user_reply, m.user_id AS user_avatar_id, 
			m.admin_id AS admin_avatar_id, m.message_date, m.subject, m.message, r.display_name AS reporting_name, s.display_name AS staff_member
		FROM $wpdb->tickets_messages AS m
		LEFT JOIN $wpdb->tickets AS t ON (m.ticket_id = t.ticket_id)
		LEFT JOIN $wpdb->users AS u ON (t.user_id = u.ID)
		LEFT JOIN $wpdb->users AS a ON (t.admin_id = a.ID)
		LEFT JOIN $wpdb->users AS l ON (t.last_reply_id = l.ID)
		LEFT JOIN $wpdb->users AS r ON (m.user_id = r.ID)
		LEFT JOIN $wpdb->users AS s ON (m.admin_id = s.ID)
		LEFT JOIN $wpdb->tickets_cats AS c ON (t.cat_id = c.cat_id)
		WHERE (m.ticket_id = '". $_GET['tid'] ."' AND t.site_id = '{$current_site->id}' AND t.blog_id = '{$blog_id}')
		ORDER BY m.message_id ASC
	");

		if ( empty($current_ticket) ) {
			$ticket_error = 1;
?>
	<h2 class="error"><?php _e("Error: Invalid Ticket Selected"); ?></h2>
<?
		} else {
		$message_list = $current_ticket;
		$current_ticket = $current_ticket[0];
		$current_ticket->admin_name = !empty($current_ticket->admin_name) ? $current_ticket->admin_name : __("Not yet assigned");
?>
	<h2><?php _e("Ticket Details"); ?></h2>
		<form action="support.php?page=tickets" method="post" name="updateticket" id="updateticket">
			<table class="form-table" border="1">
				<tr class="form-field form-required">
					<th scope="row" style="background: #464646; color: #FEFEFE; border: 1px solid #242424;"><?php _e("Ticket Subject:"); ?></th>
					<td style="border-bottom:0;">
						<?php echo $current_ticket->title; ?>
						<input type="hidden" name="tickettitle" value="<?php echo "Re: ".$current_ticket->title; ?>" />
						<input type="hidden" name="ticket_id" value="<?php echo $current_ticket->ticket_id; ?>" />
					</td>
					<th scope="row" style="background: #464646; color: #FEFEFE; border: 1px solid #242424;"><?php _e("Current Date/Time:"); ?></th>
					<td style="border-bottom:0;"><?php echo date(get_option("date_format") ." ". get_option("time_format") ." T  (\G\M\T P)", time()); ?></td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row" style="background: #464646; color: #FEFEFE; border: 1px solid #242424;"><?php _e("Reporting User:"); ?></th>
					<td style="border-bottom:0;"><?php echo $current_ticket->user_name; ?></td>
					<th scope="row" style="background: #464646; color: #FEFEFE; border: 1px solid #242424;"><?php _e("Staff Representative:"); ?></th>
					<td style="border-bottom:0;"><?php echo $current_ticket->admin_name; ?></td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row" style="background: #464646; color: #FEFEFE; border: 1px solid #242424;"><?php _e("Last Reply From:"); ?></th>
					<td style="border-bottom:0;"><?php echo $current_ticket->last_user_reply; ?></td>
					<th scope="row" style="background: #464646; color: #FEFEFE; border: 1px solid #242424;"><?php _e("Current Status:"); ?></th>
					<td style="border-bottom:0;">
						<?php echo $ticket_status[$current_ticket->ticket_status]; ?>
						<input type="hidden" name="status" value="<?php echo $current_ticket->ticket_status; ?>" />
					</td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row" style="background: #464646; color: #FEFEFE; border: 1px solid #242424;"><?php _e("Last Updated:"); ?></th>
					<td style="border-bottom:0;"><?php echo date(get_option("date_format") ." ". get_option("time_format") ." T  (\G\M\T P)", strtotime($current_ticket->ticket_updated)); ?></td>
					<th scope="row" style="background: #464646; color: #FEFEFE; border: 1px solid #242424;"><?php _e("Created On:"); ?></th>
					<td style="border-bottom:0;"><?php echo date(get_option("date_format") ." ". get_option("time_format") ." T  (\G\M\T P)", strtotime($current_ticket->ticket_opened)); ?></td>
				</tr>
			</table>
			<br /><br />
			<h2><?php _e("Ticket History"); ?></h2><br />
			<table class="widefat" cellpadding="3" cellspacing="3" border="1">
				<thead>
					<tr>
						<th scope="col"><?php _e("Author"); ?></th>
						<th scope="col"><?php _e("Ticket Message/Reply"); ?></th>
						<th scope="col"><?php _e("Date/Time"); ?></th>
					</tr>
				</thead>
				<tbody>
<?php
			if ( !empty($message_list) ) {
				foreach ( $message_list as $message ) {
					if ( !empty($message->reporting_name) ) {
						$avatar_id = $message->user_avatar_id;
						$avatar = '<img src="'. get_bloginfo("siteurl") . '/wp-admin/support/images/user.gif" alt="User" />';
						$display_name = $message->reporting_name ."<br /><br />";
						$mclass = ' class="alternate"';
					} elseif ( !empty($message->staff_member) ) {
						$avatar_id = $message->admin_avatar_id;
						$avatar = '<img src="'. get_bloginfo("siteurl") . '/wp-admin/support/images/staff.gif" alt="User" />';
						$display_name = $message->staff_member ."<br /><br />";
						$mclass = ' style="background-color: #cccccc;"';
					} else {
						$avatar_id = "";
						$display_name = __("User");
						$mclass = '';
					}
					if ( function_exists("get_blog_avatar") ) {
						// check for blog avatar function, as get_avatar is too common.
						$avatar = get_avatar($avatar_id,'32','gravatar_default');
					}
//					$mclass = ($mclass == "alternate") ? "" : "alternate";
?>
					<tr<?php echo $mclass; ?>>
						<th scope="row" style="text-align: center;"><?php echo $display_name . $avatar; ?></th>
						<td style="padding: 0 5px 5px 5px;">
							<h3 style="margin-top: .5em;"><?php echo $message->subject; ?></h3>
							<div style="padding: 0 20px;">
								<?php echo html_entity_decode($message->message); ?>
							</div>
						</td>
						<td><?php echo date(get_option("date_format") ." ". get_option("time_format") ." T  (\G\M\T P)", strtotime($message->message_date)); ?></td>
					</tr>
<?php
				}
?>

<?php
			}
?>
				</tbody>
			</table>
			<br /><br />
<?php
			if ( $current_ticket->ticket_status != 5 ) {
			// ticket isn't closed
?>
			<h2><?php _e("Update This Ticket"); ?></h2>
			<p><em><?php _e("* All fields are required."); ?></em></p>
			<table class="form-table">
				<tr class="form-field form-required">
					<th scope="row"><label for="subject"><?php _e("Subject"); ?></label></th>
					<td><input type="text" name="subject" id="subject" maxlength="100" size="60" value="Re: <?php echo $current_ticket->title; ?>" />&nbsp;<small>(<?php _e("max: 100 characters"); ?>)</small></td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row">Category:</th>
					<td>
						<select name="category" id="category">
<?php
				$get_cats = $wpdb->get_results("SELECT cat_id, cat_name FROM {$wpdb->tickets_cats} WHERE site_id = '{$current_site->id}' ORDER BY cat_name ASC");
				if ( empty($get_cats) ) {
					$wpdb->query("INSERT INTO {$wpdb->tickets_cats} (site_id, cat_name) VALUES ('{$current_site->id}', 'General')");
					$get_cats = $wpdb->get_results("SELECT cat_id, cat_name FROM {$wpdb->tickets_cats} WHERE site_id = '{$current_site->id}' ORDER BY cat_name ASC");
				}
				$x = 0;
				foreach ($get_cats as $cat) {
					if ( $cat->cat_id == $current_ticket->cat_id ) {
						$selected = ' selected="selected"';
						$x++;
					} else {
						$selected = "";
					}
?>
							<option<?php echo $selected; ?> value="<?php echo $cat->cat_id; ?>"><?php echo $cat->cat_name; ?></option>
<?php
				}
?>
						</select>
					</td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row">Priority:</th>
					<td>
						<select name="priority" id="priority">
<?php
				foreach ($ticket_priority as $key => $val) {
					if ( $key == $current_ticket->ticket_priority ) {
						$selected = ' selected="selected"';
					} else {
						$selected = "";
					}
?>
							<option<?php echo $selected; ?> value="<?php echo $key; ?>"><?php echo $val; ?></option>
<?php
				}
?>
						</select>
					</td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row"><label for="message"><?php _e("Add A Reply"); ?></label></th>
					<td>&nbsp;<small>(<?php _e("Please provide as much information as possible, so that we may better help you."); ?>)</small><br /><textarea name="message" id="message" rows="12" cols="58"></textarea></td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row"><label for="closeticket"><?php _e("Close Ticket?"); ?></label></th>
					<td><input type="checkbox" name="closeticket" id="closeticket" value="1" /> <strong><?php _e("Yes, please close this ticket."); ?></strong><br /><small><em><?php _e("Once a ticket is closed, you can no longer reply to (or update) it."); ?></em></small></td>
				</tr>
			</table>
			<p class="submit">
				<input type="hidden" name="modifyticket" value="1" />
				<input name="updateticket" type="submit" id="updateticket" value="<?php _e("Update Ticket"); ?>" />&nbsp;&nbsp;&nbsp;&nbsp;<input name="canelsubmit" type="submit" id="cancelsubmit" value="<?php _e("Cancel"); ?>" />
			</p>
		</form>
<?php
			} // end if ticket !closed check.
		} // end else check for current ticket
	} // end check for GET tid

	if ( empty($current_ticket) and empty($ticket_error) ) {
?>
	<h2><?php _e("Recent Support Tickets"); ?> <small style="font-size: 12px; padding-left: 10px;">(<a href="support.php?page=tickets&amp;action=history"><?php _e("Ticket History"); ?></a>)</small></h2>
	<br />
		<table width="100%" cellpadding="3" cellspacing="3" class="widefat">
			<thead>
				<tr>
					<th scope="col"><?php _e("Ticket ID"); ?></th>
					<th scope="col"><?php _e("Subject"); ?></th>
					<th scope="col"><?php _e("Status"); ?></th>
					<th scope="col"><?php _e("Priority"); ?></th>
					<th scope="col"><?php _e("Staff Member"); ?></th>
					<th scope="col"><?php _e("Last Updated"); ?></th>
				</tr>
			</thead>
			<tbody id="the-list">
<?php

		if ( empty($tickets) ) {
?>
				<tr class='alternate'>
					<th scope="row" colspan="6">
						<p><?php _e("There aren't any tickets to view at this time."); ?></p>
					</th>
				</tr>
<?php
		} else {
			foreach ($tickets as $ticket) {
			$class = ( $class != "alternate") ? "alternate" : "";
			if ( empty($ticket->display_name) ) { $ticket->display_name = __("Unassigned"); }
?>
				<tr class='<?php echo $class; ?>'>
					<th scope="row"><?php echo $ticket->ticket_id; ?></th>
					<td valign="top"><a href="support.php?page=tickets&amp;tid=<?php echo $ticket->ticket_id; ?>"><?php echo $ticket->title; ?></a></td>
					<td valign="top"><?php echo $ticket_status[$ticket->ticket_status]; ?></td>
					<td valign="top"><?php echo $ticket_priority[$ticket->ticket_priority]; ?></td>
					<td valign="top"><?php echo $ticket->display_name; ?></td>
					<td valign="top"><?php echo date(get_option("date_format") ." ". get_option("time_format") ." T  (\G\M\T P)", strtotime($ticket->ticket_updated)); ?></td>
				</tr>
<?php
			}
		}
?>
			</tbody>
		</table>
	<br /><br />

	<h2><?php _e("Add Ticket"); ?></h2>
		<p><em><?php _e("* All fields are required."); ?></em></p>
		<form action="support.php?page=tickets" method="post" name="newticket" id="newticket">
			<table class="form-table">
				<tr class="form-field form-required">
					<th scope="row"><label for="subject"><?php _e("Subject"); ?></label></th>
					<td><input type="text" name="subject" id="subject" maxlength="100" size="60" />&nbsp;<small>(<?php _e("max: 100 characters"); ?>)</small></td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row">Category:</th>
					<td>
						<select name="category" id="category">
<?php
		$get_cats = $wpdb->get_results("SELECT cat_id, cat_name FROM {$wpdb->tickets_cats} WHERE site_id = '{$current_site->id}' ORDER BY cat_name ASC");
		if ( empty($get_cats) ) {
			$wpdb->query("INSERT INTO {$wpdb->tickets_cats} (site_id, cat_name) VALUES ('{$current_site->id}', 'General')");
			$get_cats = $wpdb->get_results("SELECT cat_id, cat_name FROM {$wpdb->tickets_cats} WHERE site_id = '{$current_site->id}' ORDER BY cat_name ASC");
		}
		$x = 0;
		foreach ($get_cats as $cat) {
			if ( $x == 0 ) {
				$selected = ' selected="selected"';
				$x++;
			} else {
				$selected = "";
			}
?>
							<option<?php echo $selected; ?> value="<?php echo $cat->cat_id; ?>"><?php echo $cat->cat_name; ?></option>
<?php
		}
?>
						</select>
					</td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row">Priority:</th>
					<td>
						<select name="priority" id="priority">
<?php
		$x = 0;
		foreach ($ticket_priority as $key => $val) {
			if ( $x == 0 ) {
				$selected = ' selected="selected"';
				$x++;
			} else {
				$selected = "";
			}
?>
							<option<?php echo $selected; ?> value="<?php echo $key; ?>"><?php echo $val; ?></option>
<?php
		}
?>
						</select>
					</td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row"><?php _e("Status"); ?></th>
					<td><em><?php _e("New Ticket"); ?></em></td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row"><label for="message"><?php _e("Problem Description"); ?></label></th>
					<td>&nbsp;<small>(<?php _e("Please provide as much information as possible, so that we may better help you."); ?>)</small><br /><textarea name="message" id="message" rows="12" cols="58"></textarea></td>
				</tr>
			</table>
			<p class="submit">
				<input type="hidden" name="addticket" value="1" />
				<input name="submitticket" type="submit" id="addusersub" value="<?php _e("Submit New Ticket"); ?>" />
			</p>
		</form>

<?php
	} // end empty current ticket check
?>
</div>
<?php
}

function incsub_support_notification_admin_email() {
	global $wpdb;
	$admins = get_site_option("site_admins");
	if ( !empty($admins) ) {
		// we only need the first one.
		return $wpdb->get_var("SELECT user_email FROM {$wpdb->users} WHERE user_login = '{$admins[0]}'");
	} else {
		// not likely, if so, they have more problems than we can help with. :)
		return get_site_option("admin_email");
	}
}

incsub_support_tickets_output();
?>