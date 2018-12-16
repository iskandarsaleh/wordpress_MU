<?php
// no kiddies.
if ( !defined("ABSPATH") and !defined("INCSUBSUPPORT") ) {
	die("I don't think so, Tim.");
}

function incsub_support_ticketadmin() {
	if ( !is_site_admin() ) {
		wp_die("I don't think so, Tim.");
	} elseif ( !get_site_option("incsub_support_ticket_version") ) {
		update_site_option("incsub_support_ticket_version", "1.0.0");
		include_once(dirname(__FILE__) .'/incsub-support-install.php');
		incsub_support_ticketinstall();
	}
?>
	<br />
	<div class="wrap">
<?php
	switch($_GET['action']) {
		case "categories":
			incsub_support_ticketadmin_categories();
		break;
		default :
			incsub_support_ticketadmin_main();
		break;
	}

?>
	</div>
<?php
}

function incsub_support_ticketadmin_main() {
	global $wpdb, $current_site, $current_user, $ticket_status, $ticket_priority;
	if ( !empty($_POST['modifyticket']) and $_POST['modifyticket'] == 1 ) {
		if ( !empty($_POST['canelsubmit']) ) {
			wp_redirect("wpmu-admin.php?page=ticket-manager");
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
			$status = ($_POST['closeticket'] == 1) ? 5 : 2;
			$responsibility_options = array( "keep" => "", "punt" => ", admin_id = '0'", "accept" => ", admin_id = '{$current_user->id}'", "help" => "");
			$email_message = false;
			// get the user to reply to, before inserting a new message.
			$reply_to_id = $wpdb->get_var("SELECT user_id FROM {$wpdb->tickets_messages} WHERE ticket_id = '{$ticket_id}' ORDER BY message_date DESC LIMIT 1");
			if ( array_key_exists($_POST['responsibility'], $responsibility_options) ) {
				$adding_update_key = $responsibility_options[$_POST['responsibility']];
			} else {
				// screwing around? we'll just see about that.
				$adding_update_key = $responsibility_options['accept'];
			}

			$wpdb->query("INSERT INTO {$wpdb->tickets_messages}
				(site_id, ticket_id, admin_id, subject, message)
				VALUES ('{$current_site->id}', '{$ticket_id}', '{$current_user->id}', '{$title}', '{$message}')
			");

			if ( !empty($wpdb->insert_id) ) {
				$wpdb->query("UPDATE {$wpdb->tickets}
					SET
						cat_id = '{$category}', last_reply_id = '{$current_user->id}', ticket_priority = '{$priority}', ticket_status = '{$status}', num_replies = num_replies+1{$adding_update_key}
					WHERE site_id = '{$current_site->id}' AND ticket_id = '{$ticket_id}'
					LIMIT 1
				");

				if ( !empty($wpdb->rows_affected) ) {
					$notification = __("Ticket has been updated successfully, and the user notified of your response. You will be notified by email of any responses to this ticket.");
					$nclass = "updated fade";
					$title = stripslashes($title);
					$email_message = array(
						"to"		=> incsub_support_notification_user_email($reply_to_id),
						"subject"	=> __("Support Ticket Updated: ") . $title,
						"message"	=> _("

	***  DO NOT REPLY TO THIS EMAIL  ***

	Subject: ". $title ."
	Status: ". $ticket_status[$status] ."
	Priority: ". $ticket_priority[$priority] ."

	Please log into your site and visit the support page to reply to this ticket, if needed.

	------------------------------
	     Begin Ticket Message
	------------------------------

	". $message ."

	------------------------------
	      End Ticket Message
	------------------------------

	Thanks,
	". $wpdb->get_var("SELECT user_nicename FROM {$wpdb->users} WHERE ID = '{$current_user->id}'") .",
	". get_site_option("site_name") ."\r\n\r\n"), // ends lang string

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

	$do_history = ( !empty($_GET['action']) and $_GET['action'] == 'history' ) ? "AND t.ticket_status = '5'" : "AND t.ticket_status != '5'";
	$tickets = $wpdb->get_results("
		SELECT t.ticket_id, t.user_id, t.cat_id, t.admin_id, t.ticket_type, t.ticket_priority, t.ticket_status, t.ticket_updated, t.title, c.cat_name, u.display_name
		FROM $wpdb->tickets AS t
		LEFT JOIN $wpdb->tickets_cats AS c ON (t.cat_id = c.cat_id)
		LEFT JOIN $wpdb->users AS u ON (t.admin_id = u.ID)
		WHERE t.site_id = '{$current_site->id}' {$do_history}
	");
?>
	<h2><?php _e("Support Ticket Management"); ?></h2>
	<div class="handlediv">
		<h3 class='hndle'>
<?php
	if ( !empty($_GET['tid']) or !empty($_GET['action']) ) {
		if ( !empty($_GET['action']) ) {
?>
			<span><?php _e("Archived Tickets"); ?></span>
<?php
		} else {
?>
			<span><?php _e("Managing Ticket"); ?></span>
<?php
		}
?>
 			<a href="wpmu-admin.php?page=ticket-manager&amp;action=categories#addcat" class="rbutton"><strong><?php _e("Add New Category"); ?></strong></a>
			<a href="wpmu-admin.php?page=ticket-manager" class="rbutton"><strong><?php _e('Ticket Main'); ?></strong></a>
<?php
	} else {
?>
			<span><?php _e("Active Tickets"); ?></span>
 			<a href="wpmu-admin.php?page=ticket-manager&amp;action=categories#addcat" class="rbutton"><strong><?php _e("Add New Category"); ?></strong></a>
			<a href="wpmu-admin.php?page=ticket-manager&amp;action=history" class="rbutton"><strong><?php _e('Archived Tickets'); ?></strong></a>
<?php
	}
?>
			<br class="clear" />
		</h3>
		<div class="youhave">
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
		WHERE (m.ticket_id = '". $_GET['tid'] ."' AND t.site_id = '{$current_site->id}')
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
		<form action="wpmu-admin.php?page=ticket-manager" method="post" name="updateticket" id="updateticket">
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
					<th scope="row"><label for="responsibility"><?php _e("Ticket Responsibility"); ?></label></th>
					<td>
						<select name="responsibility" id="responsibility">
<?php
				if ( $current_ticket->admin_id == $current_user->id ) {
?>
							<option selected="selected" value="keep"><?php _e("Keep Responsibility For This Ticket"); ?></option>
							<option value="punt"><?php _e("Give Up Responsibility To Allow Another Admin To Accept"); ?></option>
<?php
				} else {
?>
							<option selected="selected" value="accept"><?php _e("Accept Responsibility For This Ticket"); ?></option>
<?php
					if ( !empty($current_ticket->admin_id) or $current_ticket->admin_id != 0 ) {
?>
							<option value="help"><?php _e("Keep Current Admin, And Just Help Out With A Reply"); ?></option>
<?php
					}
				}
?>
					</td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row"><label for="message"><?php _e("Add A Reply"); ?></label></th>
					<td>&nbsp;<small>(<?php _e("Please provide as much information as possible, so that the user can understand the solution/request."); ?>)</small><br /><textarea name="message" id="message" rows="12" cols="58"></textarea></td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row"><label for="closeticket"><?php _e("Close Ticket?"); ?></label></th>
					<td><input type="checkbox" name="closeticket" id="closeticket" value="1" /> <strong><?php _e("Yes, close this ticket."); ?></strong><br /><small><em><?php _e("Once a ticket is closed, users can no longer reply to (or update) it."); ?></em></small></td>
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
					<td valign="top"><a href="wpmu-admin.php?page=ticket-manager&amp;tid=<?php echo $ticket->ticket_id; ?>"><?php echo $ticket->title; ?></a></td>
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
<?php
	}
?>
		</div>
<?php

}

function incsub_support_ticketadmin_categories() {
	global $wpdb, $current_site;
	if ( !empty($_POST['updateq']) ) {
		check_admin_referer("incsub_ticketmanagement_managecats");
		if ( !empty($_POST['deleteme']) ) {
				if ( !is_numeric($_POST['defcat']) ) {
					$defcat = $wpdb->get_var("SELECT cat_id FROM {$wpdb->tickets_cats} WHERE site_id = '{$current_site->id}' AND defcat = '1'");
				} else {
					$defcat = $_POST['defcat'];
				}
				$wh = '';
			foreach($_POST['delete'] as $key => $val) {
				if ( $defcat == $val ) {
					continue;
				}

				if ( is_numeric($val) and is_numeric($key) ) {
					if ( $key == 0 ) {
						$wh .= "WHERE ( (cat_id = '{$val}'";
					} else {
						$wh .= " OR cat_id = '{$val}'";
					}
				}
			}
			if ( !empty($wh) ) {
				// if $wh is empty, there wouldn't be anything to delete.
				$wh .= ") AND site_id = '{$current_site->id}' AND defcat != '1')";
				$wpdb->query("DELETE FROM {$wpdb->tickets_cats} ". $wh);
				$delete_text = sprintf( __ngettext( '%s category was', '%s categories were', $wpdb->rows_affected ), number_format_i18n( $wpdb->rows_affected ) );
				$sentence = sprintf( __( '%1$s removed' ), $delete_text );
				// set any orphaned questions to the default cat.
				$wpdb->query("UPDATE {$wpdb->faq} SET cat_id = '{$defcat}' ". str_replace(" AND defcat != '1'", "", $wh));
?>
		<div class="updated fade"><p><?php echo $sentence; ?></p></div>
<?php
			} else {
?>
		<div class="error"><p><?php _e("There was not anything to delete."); ?></p></div>
<?php
			}
		} elseif ( !empty($_POST['updateme']) ) {
			$x = 0;
			foreach ( $_POST['cat'] as $key => $val ) {
				if ( is_numeric($key) ) {
					$wpdb->query("UPDATE {$wpdb->tickets_cats} SET cat_name = '". attribute_escape(wp_specialchars(strip_tags($val))) ."' WHERE site_id = '{$current_site->id}' AND cat_id = '{$key}'");
					$x++;
				}
			}
			if ( $x > 0 ) {
				$update_text = sprintf( __ngettext( '%s category was', '%s categories were', $x ), number_format_i18n( $x ) );
				$sentence = sprintf( __( '%1$s updated' ), $update_text );
?>
		<div class="updated fade"><p><?php echo $sentence; ?></p></div>
<?php
			} else {
?>
		<div class="error"><p><?php _e("There was not anything to update."); ?></p></div>
<?php

			}
		}
	} elseif ( !empty($_POST['addme']) ) {
		check_admin_referer("incsub_faqmanagement_addcat");
		if ( !empty($_POST['cat_name']) ) {
			$cat_name = attribute_escape(wp_specialchars($_POST['cat_name']));
			$wpdb->query("INSERT INTO {$wpdb->tickets_cats} (site_id, cat_name, defcat) VALUES ('{$current_site->id}', '{$cat_name}', '0')");
			if ( !empty($wpdb->insert_id) ) {
?>
		<div class="updated fade"><p><?php _e("New category added successfully."); ?></p></div>
<?php
			}
		}
	}


	$cats = $wpdb->get_results("SELECT cat_id, cat_name, defcat FROM {$wpdb->tickets_cats} WHERE site_id = '{$current_site->id}' ORDER BY defcat DESC, cat_name ASC");
	if ( empty($cats) ) {
		$wpdb->query("INSERT INTO {$wpdb->tickets_cats} (site_id, cat_name, defcat) VALUES ('{$current_site->id}', 'General', '1')");
		$cats = $wpdb->get_results("SELECT cat_id, cat_name, defcat FROM {$wpdb->tickets_cats} WHERE site_id = '{$current_site->id}' ORDER BY defcat DESC, cat_name ASC");
	}
?>
	<h2><?php _e("Support Ticket Management"); ?></h2>
	<div class="handlediv">
		<h3 class='hndle'>
			<span><?php _e("Ticket Categories"); ?></span>
 			<a href="#addcat" class="rbutton"><strong><?php _e("Add New Category"); ?></strong></a>
			<a href="wpmu-admin.php?page=ticket-manager" class="rbutton"><strong><?php _e('Ticket Manager'); ?></strong></a>
			<br class="clear" />
		</h3>
		<div class="youhave">
			<form id="managecats" action="wpmu-admin.php?page=ticket-manager&action=categories" method="post">
<?php wp_nonce_field("incsub_ticketmanagement_managecats"); ?>
				<?php if ( count($cats) > 1 ) { ?><p class="submit" style="border-top: none;"><input type="submit" class="button" name="deleteme" value="Delete" /></p><?php } ?>
				<table class="widefat">
					<thead>
						<tr>
							<th scope="col" class="check-column"><?php if ( count($cats) > 1 ) { ?><input type="checkbox" /><?php } ?></th>
				    	    <th scope="col"><?php _e("Name"); ?></th>
						</tr>
					</thead>
					<tbody id="the-list" class="list:cat">
<?php
	foreach ($cats as $cat) {
		if ( $cat->defcat == 1 ) {
			$checkcol = '<input type="hidden" name="defcat" value="'. $cat->cat_id .'" />';
			$textcol = "<h3>". $cat->cat_name . "</h3> <small>( Default category, cannot be removed. )</small>";
		} else {
			$checkcol = '<input type="checkbox" name="delete[]" value="'. $cat->cat_id .'" />';
			$textcol = '<input type="text" size="40" name="cat['. $cat->cat_id .']" value="'. $cat->cat_name .'" />';
		}
		if ( $class == ' class="alternate"' ) {
			$class = "";
		} else {
			$class = ' class="alternate"';
		}
?>
						<tr id="cat-<?php echo $cat->cat_id; ?>" class="<?php echo $class; ?>">
							<th scope="row" class="check-column"><?php echo $checkcol; ?></th>
							<td><?php echo $textcol; ?></td>
						</tr>
<?php
	}
?>
					</tbody>
				</table>

				<p class="submit" style="padding: 10px;">
					<input type="hidden" name="updateq" value="1" />
					<?php if ( count($cats) > 1 ) { ?><input type="submit" class="button" name="updateme" value="Update Categories" />&nbsp;&nbsp;&nbsp;<input type="submit" class="button" name="deleteme" value="Delete" /><?php } ?>
				</p>
			</form>
		</div>
	</div>
	<br />
	<h2>Add New Category</h2>
	<form name="addcat" id="addcat" method="post" action="wpmu-admin.php?page=ticket-manager&amp;action=categories">
	<?php wp_nonce_field("incsub_faqmanagement_addcat"); ?>
	<table class="form-table">
		<tr class="form-field form-required">
			<th scope="row" valign="top"><label for="cat_name">Category Name</label></th>
			<td>
				<input name="cat_name" id="cat_name" type="text" value="" size="40" aria-required="true" /><br />
	            The name is used to identify the category to which tickets relate.
			</td>
		</tr>
	</table>
	<p class="submit"><input type="submit" class="button" name="addme" value="Add Category" /></p>
	</form>
<?php
}


function incsub_support_add_jsq() {
//return;
	// add tinymce js, if applicable.

?>
	<script type="text/javascript" src="<?php bloginfo('home'); ?>/wp-admin/js/editor.js?ver=20080325"></script>
	<script type="text/javascript" src="<?php bloginfo('home'); ?>/wp-includes/js/tinymce/tiny_mce_config.php?ver=20080327"></script>
	<script type="text/javascript">
	//<![CDATA[
		window.onload= function() {
			tinyMCE.execCommand("mceAddControl", false, "answer");
		}
	// ]]>
	</script>
<?php
}

function incsub_support_add_css() {
	// add admin css
	wp_admin_css( 'css/dashboard' );
}

function incsub_support_add_jsc() {
?>
	<script type="text/javascript" src="<?php bloginfo('home'); ?>/wp-admin/js/forms.js?ver=20080401"></script>
<?php
}

function incsub_support_notification_user_email($user_id) {
	global $wpdb;
	return $wpdb->get_var("SELECT user_email FROM {$wpdb->users} WHERE ID = '{$user_id}'");
}

add_action("admin_head", "incsub_support_add_css", 100);

switch($_GET['action']) {
	case "categories" :
		add_action("admin_head", "incsub_support_add_jsc");
	break;
	default :
		add_action("admin_head", "incsub_support_add_css");
	break;
}

?>
