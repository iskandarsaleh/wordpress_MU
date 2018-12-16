<?php
// no kiddies.
if ( !defined("ABSPATH") and !defined("INCSUBSUPPORT") ) {
	die("I don't think so, Tim.");
}

// pretty basic stuff here.
	global $current_site, $wpdb;
	if ( !empty($_GET['action']) and $_GET['action'] == 'vote' ) {
		if ( ($_GET['help'] == "yes" or $_GET['help'] == "no") and is_numeric($_GET['qid']) ) {
			$get_help = ($_GET['help'] == "no") ? "help_no = help_no+1" : "help_yes = help_yes+1";
			$wpdb->query("UPDATE {$wpdb->faq} SET {$get_help}, help_count = help_count+1 WHERE faq_id = '". $_GET['qid'] ."' AND site_id = '{$current_site->id}'");
		}
	}
	$faqs = $wpdb->get_results("SELECT 
		q.faq_id, q.question, q.answer, q.help_count, q.help_yes, q.help_no, c.cat_name, c.cat_id, c.qcount
		FROM {$wpdb->faq} AS q
		LEFT JOIN {$wpdb->faq_cats} AS c ON ( q.cat_id = c.cat_id )
		WHERE q.site_id = '{$current_site->id}'
		ORDER BY c.cat_name ASC");
?>
<div class="wrap">
	<script type="text/javascript" language="JavaScript"><!--
		function FAQReverseDisplay(d) {
			if(document.getElementById(d).style.display == "none") { document.getElementById(d).style.display = "block"; }
			else { document.getElementById(d).style.display = "none"; }
		}
		//-->
	</script>
	<h2><?php _e("Frequently Asked Questions"); ?></h2>
	<ul>
<?php
	$current_cat = '';
	foreach ($faqs as $faq) {
		if ( $current_cat != $faq->cat_name ) {
			if ( !empty($current_cat) ) {
?>
			</ul>
		</li>
<?php
			}
			$available_text = sprintf( __ngettext( '%s question', '%s questions', $faq->qcount ), number_format_i18n( $faq->qcount ) );
			$sentence = sprintf( __( '%1$s available' ), $available_text );

?>
		<li><a href="javascript:FAQReverseDisplay('category-<?php echo $faq->cat_id; ?>')"><?php echo $faq->cat_name; ?> <?php echo "<small>({$sentence})</small>"; ?></a>
			<ul id="category-<?php echo $faq->cat_id; ?>" style="display: none;">
<?php
			$current_cat = $faq->cat_name;
		}
?>
				<li>
					<a href="javascript:FAQReverseDisplay('answer-<?php echo $faq->faq_id; ?>')"><?php echo $faq->question; ?></a><br />
					<div id="answer-<?php echo $faq->faq_id; ?>" style="padding: 15px; border: 1px solid #464646; width: 60%; display: none;">
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
?>
			</ul>
		</li>
	</ul>
</div>