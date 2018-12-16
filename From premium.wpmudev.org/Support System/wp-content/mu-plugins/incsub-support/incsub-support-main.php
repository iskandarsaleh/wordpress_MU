<?php
// no kiddies.
if ( !defined("ABSPATH") and !defined("INCSUBSUPPORT") ) {
	die("I don't think so, Tim.");
}

function incsub_support_main_output() {
	global $wpdb, $current_site, $blog_id, $ticket_status, $ticket_priority;
	$open_tickets = $wpdb->get_results("
			SELECT t.ticket_id, t.ticket_priority, t.ticket_status, t.ticket_updated, t.title, l.display_name AS last_user_reply 
			FROM {$wpdb->tickets} AS t LEFT JOIN {$wpdb->users} AS l ON ( t.last_reply_id = l.ID )
			WHERE site_id = '{$current_site->id}' AND blog_id = '{$blog_id}' AND ticket_status != '5' 
			ORDER BY ticket_priority DESC, ticket_updated DESC LIMIT 5");

	$top5help = $wpdb->get_results("SELECT faq_id, question, answer, help_yes, help_no, (help_yes/help_count)*100 AS help_percent FROM {$wpdb->faq} WHERE site_id = '{$current_site->id}' ORDER BY help_percent DESC LIMIT 0, 5");



?>
<br />
<div class="wrap">
	<script type="text/javascript" language="JavaScript"><!--
		function FAQReverseDisplay(d) {
			if(document.getElementById(d).style.display == "none") { document.getElementById(d).style.display = "block"; }
			else { document.getElementById(d).style.display = "none"; }
		}
		//-->
	</script>
	<h2><?php _e("Support System"); ?></h2>
	<div style="width: 63%; float: left;">
		<h3><?php _e("Recent Support Tickets"); ?></h3>
<?php
		if ( !empty($open_tickets) ) {
?>
		<table class="widefat" cellpadding="3" cellspacing="3" border="1">
			<thead>
				<tr>
					<th scope="col"><?php _e("Ticket Subject"); ?></th>
					<th scope="col" width="35%"><?php _e("Last Updated"); ?></th>
					<th scope="col" width="35%"><?php _e("Details"); ?></th>
				</tr>
			</thead>
			<tbody>
<?php
			foreach ( $open_tickets as $ticket ) {
				$mclass = ($mclass == "alternate") ? "" : "alternate";
?>
					<tr class="<?php echo $mclass; ?>">
						<th scope="row"><a href="support.php?page=tickets&tid=<?php echo $ticket->ticket_id; ?>"><?php echo $ticket->title; ?></a></th>
						<td><?php echo str_replace(" ... ", "<br />", date(get_option("date_format") ." ... ". get_option("time_format") ." T  (\G\M\T P)", strtotime($ticket->ticket_updated))); ?></td>
						<td>
							<strong><?php _e("Priority"); ?>:</strong> <?php echo $ticket_priority[$ticket->ticket_priority]; ?><br />
							<strong><?php _e("Status"); ?>:</strong> <?php echo $ticket_status[$ticket->ticket_status]; ?><br />
							<strong><?php _e("Last Reply From"); ?>:</strong> <?php echo $ticket->last_user_reply; ?>
						</td>
					</tr>
<?php
			}
?>
			</tbody>
		</table>
<?php
		} else {
?>
		<p><?php _e("You're in luck today, as you don't have any unanswered support tickets."); ?></p>
<?php
		}
?>
	</div>

	<div style="float: right; width: 35%">
		<h3><?php _e("Popular FAQ's"); ?></h3>
<?php
		if ( !empty($top5help) ) {
?>
		<ul>
<?php
			foreach ( $top5help AS $faq ) {
?>
			<li>
				<a href="javascript:FAQReverseDisplay('answer-<?php echo $faq->faq_id; ?>')"><?php echo $faq->question; ?></a><br />
				<div id="answer-<?php echo $faq->faq_id; ?>" style="padding: 15px; border: 1px solid #464646; width: 90%; display: none;">
<?php
				if ( !empty($faq->help_count) and $faq->help_yes > 0 ) {
					$sentence = sprintf( __( '%1$s of %2$s users found this to be helpful.' ), $faq->help_yes, $faq->help_count );
				} else {
					$sentence = "";
				}
?>
					<?php echo html_entity_decode($faq->answer); ?>
					<p style="padding: 10px; text-align: right;">
						<?php _e("Was this solution helpful? "); ?>
						<a href="support.php?page=faq&amp;action=vote&amp;help=yes&amp;qid=<?php echo $faq->faq_id; ?>"><?php _e("Yes"); ?></a> | <a href="support.php?page=faq&amp;action=vote&amp;help=no&amp;qid=<?php echo $faq->faq_id; ?>"><?php _e("No"); ?></a><br />
						<?php echo "<small><em>{$sentence}</em></small>"; ?>
					</p>
				</div>
			</li>
<?php
			}
		} else {
?>
		<p><?php _e("We're currently updating and collecting new stats on our FAQ. Please visit"); ?> <a href="support.php?page=faq"><?php _e("our FAQ"); ?></a> <?php _e("for a full listing."); ?></p>
<?php
		}
?>
	</div>
</div>
<?php
}
	incsub_support_main_output();
?>