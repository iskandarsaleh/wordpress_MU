<?php
// no kiddies.
if ( !defined("ABSPATH") and !defined("INCSUBSUPPORT") ) {
	die("I don't think so, Tim.");
}


function incsub_support_faqadmin() {
	if ( !is_site_admin() ) {
		wp_die("I don't think so, Tim.");
	} elseif ( !get_site_option("incsub_support_faq_version") ) {
		update_site_option("incsub_support_faq_version", "1.0.0");
		include_once(dirname(__FILE__) .'/incsub-support-install.php');
		incsub_support_faqinstall();
	}
?>
	<br />
	<div class="wrap">
<?php
	switch($_GET['action']) {
		case "questions":
			incsub_support_faqadmin_questions();
		break;
		case "categories":
			incsub_support_faqadmin_categories();
		break;
		case "editquestions":
			incsub_support_faqadmin_editquestions();
		break;
		default :
			incsub_support_faqadmin_main();
		break;
	}		

?>
	</div>
<?php
}

function incsub_support_faqadmin_main() {
	global $wpdb, $current_site;
	$questions = $wpdb->get_var("SELECT COUNT(faq_id) FROM {$wpdb->faq} WHERE site_id = '{$current_site->id}'");
	$cats = $wpdb->get_var("SELECT COUNT(cat_id) FROM {$wpdb->faq_cats} WHERE site_id = '{$current_site->id}'");
	$sum_help_yes = $wpdb->get_var("SELECT SUM(help_yes) FROM {$wpdb->faq} WHERE site_id = '{$current_site->id}'");
	$question_text = sprintf( __ngettext( '%s question', '%s questions', $questions ), number_format_i18n( $questions ) );
	$cats_text = sprintf( __ngettext( '%s category', '%s categories', $cats ), number_format_i18n( $cats ) );
	$sentence = sprintf( __( 'You have %1$s contained within %2$s.' ), $question_text, $cats_text );
	if ( $sum_help_yes > 0 ) {
		$sum_help_count = $wpdb->get_var("SELECT SUM(help_count) FROM {$wpdb->faq} WHERE site_id = '{$current_site->id}'");
		$sum_help_percentage = ceil( ($sum_help_yes/$sum_help_count)*100);
		$userusers = sprintf( __ngettext( '%s user', '%s users', $sum_help_count ), number_format_i18n( $sum_help_count ) );
		$users_helped = "<li>". sprintf( __('%1$s out of %2$s have been helped, for an overall success rate of %3$s&#37;'), $sum_help_yes, $userusers, $sum_help_percentage) . "</li>";
	} else {
		$users_helped = "";
	}
	// top 5 helpful questions
	$top5help = $wpdb->get_results("SELECT faq_id, question, help_yes, help_no, (help_yes/help_count)*100 AS help_percent FROM {$wpdb->faq} WHERE site_id = '{$current_site->id}' AND ((help_yes/help_count)*100) > '0' ORDER BY help_percent DESC LIMIT 0, 5");
	$bot5help = $wpdb->get_results("SELECT faq_id, question, help_yes, help_no, (help_yes/help_count)*100 AS help_percent FROM {$wpdb->faq} WHERE site_id = '{$current_site->id}' AND ((help_yes/help_count)*100) > '0' ORDER BY help_percent ASC LIMIT 0, 5");

?>
	<h2><?php _e('FAQ Manager'); ?></h2>
	<div class="handlediv">
		<h3 class='hndle'>
			<span><?php _e('FAQ Stats/Info'); ?></span>
			<a href="wpmu-admin.php?page=faq-manager&amp;action=categories" class="rbutton"><strong><?php _e('Manage FAQ Categories'); ?></strong></a>
			<a href="wpmu-admin.php?page=faq-manager&amp;action=questions" class="rbutton"><strong><?php _e('Manage Questions'); ?></strong></a>
			<br class="clear" />
		</h3>
		<div class="youhave">
			<ul>
				<li><?php echo $sentence; ?></li>
				<?php echo $users_helped; ?>
			</ul>
			<h4><?php _e("Top 5: Most Helpful"); ?></h4>
<?php
	if ( !empty($top5help) ) {
		echo "
			<ul>";
		$already_done = array();
		foreach ( $top5help as $top5 ) {
			// anything less than 50% isn't very helpful, is it?
			if ( $top5->help_percent < 50 ) {
				continue;
			}
			$already_done[] = $top5->faq_id;
			echo "
				<li>{$top5->question} <small>(". ceil($top5->help_percent) ."%)</small></li>";
		}
		echo "
			</ul>";
	} else {
?>
			<p><?php _e("There have not been any ratings for any questions/answers."); ?></p>
<?php
	}
?>
			<h4><?php _e("Top 5: Least Helpful"); ?></h4>
<?php
	if ( !empty($bot5help) ) {
		echo "
			<ul>";
		foreach ( $bot5help as $bot5 ) {
			if ( in_array($bot5->faq_id, $already_done) ) {
				continue;
			}
			echo "
				<li>{$bot5->question} <small>(". ceil($bot5->help_percent) ."%)</small></li>";
		}
		echo "
			</ul>";
	} else {
?>
			<p><?php _e("There have not been any ratings for any questions/answers."); ?></p>
<?php
	}
?>
		</div>
	</div>
<?php
}

function incsub_support_faqadmin_questions() {
	global $wpdb, $current_site;
	if ( !empty($_POST) ) {
		// post data received...
		if ( !empty($_POST['deleteq']) and $_POST['deleteq'] == 1 ) {
			// deleting
			check_admin_referer("incsub_faqmanagement_managequestions");
			$wh = '';
			foreach($_POST['delete'] as $key => $val) {
				$count[$val['cat_id']] = (!empty($count[$val['cat_id']])) ? $count[$val['cat_id']]+1 : 1;
				if ( is_numeric($val['faq_id']) and is_numeric($key) ) {
					if ( $key == 0 ) {
						$wh .= "WHERE ((faq_id = '". $val['faq_id'] ."'";
					} else {
						$wh .= " OR faq_id = '". $val['faq_id'] ."'";
					}
				}
			}
			if ( !empty($wh) ) {
				// if $wh is empty, there wouldn't be anything to delete.
				$wh .= ") AND site_id = '{$current_site->id}')";
				$wpdb->query("DELETE FROM {$wpdb->faq} ". $wh);
				if ( !empty($wpdb->rows_affected) ) {
					$delete_text = sprintf( __ngettext( '%s question was', '%s questions were', $wpdb->rows_affected ), number_format_i18n( $wpdb->rows_affected ) );
					$sentence = sprintf( __( '%1$s removed' ), $delete_text );
					$mclass = "updated fade";
				} else {
					$sentence = __( "There wasn't anything to delete." );
					$mclass = "error";
				}
				foreach ( $count as $key => $val ) {
					$wpdb->query("UPDATE {$wpdb->faq_cats} SET qcount = qcount-{$val} WHERE site_id = '{$current_site->id}' AND cat_id = '{$key}'");
				}
			}
		} elseif ( !empty($_POST['addq']) and $_POST['addq'] == 1 ) {
			check_admin_referer("incsub_faqmanagement_managequestions");
			if ( empty($_POST['question']) ) {
				$sentence = __( "The question field is empty." );
				$mclass = "error";
			} elseif ( empty($_POST['answer']) ) {
				$sentence = __( "The answer field is empty." );
				$mclass = "error";
			} else {
				$question = wp_specialchars(strip_tags($_POST['question']));
				$answer = wp_specialchars(wpautop($_POST['answer']));
				if ( !is_numeric($_POST['category']) ) {
					$the_cat = $wpdb->get_var("SELECT cat_id FROM {$wpdb->faq_cats} WHERE defcat = '1' AND site_id = '{$current_site->id}'");
				} else {
					$the_cat = $_POST['category'];
				}
				$wpdb->query("INSERT INTO {$wpdb->faq} (site_id, cat_id, question, answer) VALUES ( '{$current_site->id}', '{$the_cat}', '{$question}', '{$answer}')");
				$wpdb->query("UPDATE {$wpdb->faq_cats} SET qcount = qcount+1 WHERE site_id = '{$current_site->id}' AND cat_id = '{$the_cat}'");
				if ( !empty($wpdb->insert_id) ) {
					$sentence = __( "New Q&amp;A inserted successfully." );
					$mclass = "updated fade";
				} else {
					$sentence = __( "Something happened, and nothing was inserted. Check your error logs." );
					$mclass = "error";
				}
			}
		} elseif ( !empty($_POST['updateq']) and $_POST['updateq'] == 1 ) {
			check_admin_referer("incsub_faqmanagement_managequestions");
			if ( empty($_POST['question']) ) {
				$sentence = __( "The question field is empty." );
				$mclass = "error";
			} elseif ( empty($_POST['answer']) ) {
				$sentence = __( "The answer field is empty." );
				$mclass = "error";
			} elseif ( !is_numeric($_POST['faq_id']) ) {
				$sentence = __( "Invalid identification for the question being updated." );
				$mclass = "error";
			} else {
				$question = wp_specialchars(strip_tags($_POST['question']));
				$answer = wp_specialchars(wpautop($_POST['answer']));
				if ( !is_numeric($_POST['category']) ) {
					$the_cat = $wpdb->get_var("SELECT cat_id FROM {$wpdb->faq_cats} WHERE defcat = '1' AND site_id = '{$current_site->id}'");
				} else { 
					$the_cat = $_POST['category'];
					$the_id = $_POST['faq_id'];
				}
				$wpdb->query("UPDATE {$wpdb->faq} SET site_id = '{$current_site->id}', cat_id = '{$the_cat}', question = '{$question}', answer = '{$answer}' WHERE faq_id = '{$the_id}' AND site_id = '{$current_site->id}'");
				if ( !empty($wpdb->rows_affected) ) {
					$sentence = __( "Question/Answer updated successfully." );
					$mclass = "updated fade";
					if ( is_numeric($_POST['old_cat_id']) and $_POST['old_cat_id'] != $the_cat ) {
						// we changed cats, and the update was a success;
						$wpdb->query("UPDATE {$wpdb->faq_cats} SET qcount = qcount-1 WHERE cat_id = '". $_POST['old_cat_id'] ."' AND site_id = '{$current_site->id}'");
						$wpdb->query("UPDATE {$wpdb->faq_cats} SET qcount = qcount+1 WHERE cat_id = '{$the_cat}' AND site_id = '{$current_site->id}'");
					}
				} else {
					$sentence = __( "Something happened, and nothing was updated. Check your error logs." );
					$mclass = "error";
				}
			}
		}
?>
		<div class="<?php echo $mclass; ?>"><p><?php echo $sentence; ?></p></div>
<?php
	}
	$questions = $wpdb->get_results("
		SELECT
			q.faq_id AS faq_id, q.cat_id AS cat_id, q.question AS question, q.answer AS answer, c.cat_name AS cat_name
		FROM {$wpdb->faq} as q
		LEFT JOIN {$wpdb->faq_cats} AS c ON ( q.cat_id = c.cat_id )
		WHERE q.site_id = '{$current_site->id}'
		ORDER BY c.cat_name, q.question ASC
	");

	if ( !empty($_GET['qid']) and is_numeric($_GET['qid']) ) {
		// we need to edit a post;
		$editq = $wpdb->get_results("SELECT faq_id, cat_id, question, answer FROM {$wpdb->faq} WHERE site_id = '{$current_site->id}' AND faq_id = '". $_GET['qid'] ."' LIMIT 1");
		if ( empty($editq[0]) ) {
?>
		<div class="error"><p><?php _e("That question does not exist."); ?></p></div>
<?php
		} else {
			$editq = $editq[0];
?>			
		<h2><?php _e("Editing: "); echo $editq->question; ?></h2>
			<form id="addquestion" action="wpmu-admin.php?page=faq-manager&action=questions" method="post">
		<?php wp_nonce_field("incsub_faqmanagement_managequestions"); ?>
<?php incsub_support_faqadmin_postbox($editq); ?>
				<p class="submit" style="padding: 10px;">
					<input type="hidden" name="faq_id" value="<?php echo $editq->faq_id; ?>" />
					<input type="hidden" name="old_cat_id" value="<?php echo $editq->cat_id; ?>" />
					<input type="hidden" name="updateq" value="1" />
					<input type="submit" class="button" value="Update" />
				</p>
			</form>
<?php
		}
	}
?>
	<script type="text/javascript" language="JavaScript"><!--
		function FAQReverseDisplay(d) {
			if(document.getElementById(d).style.display == "none") { document.getElementById(d).style.display = "block"; }
			else { document.getElementById(d).style.display = "none"; }
		}
		//-->
	</script>
	<h2><?php _e("FAQ Manager"); ?></h2>
	<div class="handlediv">
		<h3 class='hndle'>
			<span><?php _e("Manage Questions/Answers"); ?></span>
			<a href="wpmu-admin.php?page=faq-manager&amp;action=categories" class="rbutton"><strong><?php _e('Manage FAQ Categories'); ?></strong></a>
 			<a href="#addquestion" class="rbutton"><strong><?php _e("Add New Question"); ?></strong></a>
			<br class="clear" />
		</h3>
		<div class="youhave">
			<form id="managecats" action="wpmu-admin.php?page=faq-manager&action=questions" method="post">
				<?php wp_nonce_field("incsub_faqmanagement_managequestions"); ?>

<?php
	$cat_name = '';
	foreach ($questions as $question) {
		if ( $cat_name != $question->cat_name ) {
			if ( !empty($cat_name) and $cat_name != $question->cat_name ) {
?>
					</tbody>
				</table>
				<br /><br />
<?php
			}
?>
				<h3 style="font-size: 140%; text-align: left; padding: 0; margin: 0;"><a href="#" style="text-decoration: none;" onclick="javascript:FAQReverseDisplay('catbody-<?php echo $question->cat_id; ?>')"><?php _e("FAQ Category: "); echo $question->cat_name; ?> <small style="font-size: 12px;">(<?php _e("view questions"); ?>)</small></a></h3>
				<table class="widefat" id="catbody-<?php echo $question->cat_id; ?>" style="display: none; width: 100%;" width="100%">
					<thead>
						<tr>
							<th scope="col" class="check-column">&nbsp;</th>
							<th scope="col" align="left" style="text-align: left; width: 40%;">Question</th>
							<th scope="col" align="left" style="text-align: left; width: 45%;">Answer</th>
							<th scope="col" align="left" style="text-align: left;" width="15%">Option(s)</th>
						</tr>
					</thead>
					<tbody class="list:cat">
<?php
			$cat_name = $question->cat_name;
		}
?>
						<tr id='question-4' class='alternate'>
							<th scope='row' class='check-column'><input type='checkbox' name='delete[][faq_id]' value='<?php echo $question->faq_id; ?>' /><input type="hidden" name="delete[][cat_id]" value="<?php echo $question->cat_id; ?>" /></th>
							<td valign="top">
								<?php echo $question->question; ?>

							</td>
							<td valign="top">
								<?php echo html_entity_decode($question->answer); ?>
							</td>
							<td valign="middle" style="vertical-align: middle;"><a href="wpmu-admin.php?page=faq-manager&amp;action=questions&amp;qid=<?php echo $question->faq_id; ?>" class="button" title="edit this"><?php _e("Edit This"); ?></a></td>
						</tr>
<?php
	}
?>
					</tbody>
				</table>
				<p class="submit" style="padding: 10px;">
					<input type="hidden" name="deleteq" value="1" />
					<input type="submit" class="button" value="Delete Questions" />
				</p>
			</form>
			<br /><br />
			<h2>Add New Question</h2>
			<form id="addquestion" action="wpmu-admin.php?page=faq-manager&action=questions" method="post">
		<?php wp_nonce_field("incsub_faqmanagement_managequestions"); ?>
<?php incsub_support_faqadmin_postbox(); ?>
				<p class="submit" style="padding: 10px;">
					<input type="hidden" name="addq" value="1" />
					<input type="submit" class="button" value="Add New Question" />
				</p>
			</form>
		</div>
	</div>
<?php
}

function incsub_support_faqadmin_categories() {
	global $wpdb, $current_site;
	if ( !empty($_POST['updateq']) ) {
		check_admin_referer("incsub_faqmanagement_managecats");
		if ( !empty($_POST['deleteme']) ) {
				if ( !is_numeric($_POST['defcat']) ) {
					$defcat = $wpdb->get_var("SELECT cat_id FROM {$wpdb->faq_cats} WHERE site_id = '{$current_site->id}' AND defcat = '1'");
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
				$wpdb->query("DELETE FROM {$wpdb->faq_cats} ". $wh);
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
					$wpdb->query("UPDATE {$wpdb->faq_cats} SET cat_name = '". attribute_escape(wp_specialchars(strip_tags($val))) ."' WHERE site_id = '{$current_site->id}' AND cat_id = '{$key}'");
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
			$wpdb->query("INSERT INTO {$wpdb->faq_cats} (site_id, cat_name, defcat) VALUES ('{$current_site->id}', '{$cat_name}', '0')");
			if ( !empty($wpdb->insert_id) ) {
?>
		<div class="updated fade"><p><?php _e("New category added successfully."); ?></p></div>
<?php
			}
		}
	}


	$cats = $wpdb->get_results("SELECT cat_id, cat_name, qcount, defcat FROM {$wpdb->faq_cats} WHERE site_id = '{$current_site->id}' ORDER BY defcat DESC, cat_name ASC");
	if ( empty($cats) ) {
		$wpdb->query("INSERT INTO {$wpdb->faq_cats} (site_id, cat_name, defcat) VALUES ('{$current_site->id}', 'General Questions', '1')");
		$cats = $wpdb->get_results("SELECT cat_id, cat_name, qcount, defcat FROM {$wpdb->faq_cats} WHERE site_id = '{$current_site->id}' ORDER BY defcat DESC, cat_name ASC");
	}
?>
	<h2><?php _e("FAQ Manager"); ?></h2>
	<div class="handlediv">
		<h3 class='hndle'>
			<span><?php _e("Manage Categories"); ?></span>
 			<a href="#addcat" class="rbutton"><strong><?php _e("Add New Category"); ?></strong></a>
			<a href="wpmu-admin.php?page=faq-manager&amp;action=questions" class="rbutton"><strong><?php _e('Manage Questions'); ?></strong></a>
			<br class="clear" />
		</h3>
		<div class="youhave">
			<form id="managecats" action="wpmu-admin.php?page=faq-manager&action=categories" method="post">
<?php wp_nonce_field("incsub_faqmanagement_managecats"); ?>
				<?php if ( count($cats) > 1 ) { ?><p class="submit" style="border-top: none;"><input type="submit" class="button" name="deleteme" value="Delete" /></p><?php } ?>
				<table class="widefat">
					<thead>
						<tr>
							<th scope="col" class="check-column"><?php if ( count($cats) > 1 ) { ?><input type="checkbox" /><?php } ?></th>
				    	    <th scope="col"><?php _e("Name"); ?></th>
				    	    <th scope="col" class="num"><?php _e("Questions");?></th>
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
							<td class='num'><?php echo $cat->qcount; ?></td>
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
	<form name="addcat" id="addcat" method="post" action="wpmu-admin.php?page=faq-manager&amp;action=categories">
	<?php wp_nonce_field("incsub_faqmanagement_addcat"); ?>
	<table class="form-table">
		<tr class="form-field form-required">
			<th scope="row" valign="top"><label for="cat_name">Category Name</label></th>
			<td>
				<input name="cat_name" id="cat_name" type="text" value="" size="40" aria-required="true" /><br />
	            The name is used to identify the category to which questions relate.
			</td>
		</tr>
	</table>
	<p class="submit"><input type="submit" class="button" name="addme" value="Add Category" /></p>
	</form>
<?php
}

function incsub_support_faqadmin_editquestions() {
?>
	<h2>FAQ Edit</h2>
<?php
}

function incsub_support_faqadmin_postbox($data = '') {
	global $wpdb, $current_site;
	$cats = $wpdb->get_results("SELECT cat_id, cat_name, defcat FROM {$wpdb->faq_cats} WHERE site_id = '{$current_site->id}' ORDER BY defcat DESC, cat_name ASC");
	if ( empty($cats) ) {
		$wpdb->query("INSERT INTO {$wpdb->faq_cats} (site_id, cat_name, defcat) VALUES ('{$current_site->id}', 'General Questions')");
		$cats = $wpdb->get_results("SELECT cat_id, cat_name, defcat FROM {$wpdb->faq_cats} WHERE site_id = '{$current_site->id}' ORDER BY defcat DESC, cat_name ASC");
	}
	$rows = get_option('default_post_edit_rows');
	if (($rows < 3) || ($rows > 60)){
		$rows = 12;
	}
	$rows = "rows='$rows'";
	if ( user_can_richedit() ) {
		add_filter('the_editor_content', 'wp_richedit_pre');
	}
?>
	<div id="post-body">
		<h3><label for="question"><?php _e('Question'); ?></label></h3>
		<div id="titlewrap">
			<input type="text" name="question" tabindex="1" value="<?php if ( !empty($data->question) ) { echo $data->question; }?>" id="title" autocomplete="off" style="width: 68.7%;" />
		</div>
		<h3><label for="category"><?php _e('FAQ Category'); ?></label>&nbsp;&nbsp;<small style="font-size: 60%">( <a href="wpmu-admin.php?page=faq-manager&amp;action=newcat">Add new FAQ Category?</a> )</small></h3>
		<div id="content">
			<select name="category" id="category">
<?php
	$x = 0;
	foreach ( $cats as $cat ) {
		if ( $x == 0 and empty($data->cat_id) ) { $selected = ' selected="selected"'; $x++; }
		elseif ( !empty($data->cat_id) and $data->cat_id == $cat->cat_id ) { $selected = ' selected="selected"'; }
		else { $selected = ''; }
?>
				<option<?php echo $selected; ?> value="<?php echo $cat->cat_id; ?>"><?php echo $cat->cat_name; ?></option>
<?php
	}
?>
			</select>
		</div>
		<h3><label for="answer"><?php _e('Answer'); ?></label></h3>
		<div id="<?php echo user_can_richedit() ? 'postdivrich' : 'postdiv'; ?>" class="postarea" style="border: 1px solid #444444; padding: 0; margin: 0; width: 70%;">
			<textarea <?php if ( user_can_richedit() ){ echo 'class="mceEditor"'; } ?> <?php echo $rows; ?> name='answer' tabindex='3' id='answer'><?php if ( !empty($data->answer) ) { echo $data->answer; } else { echo ""; }?></textarea>
		</div>
	</div>
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

add_action("admin_head", "incsub_support_add_css", 100);

switch($_GET['action']) {
	case "editquestion" :
		add_action("admin_head", "incsub_support_add_jsq");
	break;
	case "questions" :
		add_action("admin_head", "incsub_support_add_jsq");
	break;
	case "categories" :
		add_action("admin_head", "incsub_support_add_jsc");
	break;
	default :
		add_action("admin_head", "incsub_support_add_css");
	break;
}

?>
