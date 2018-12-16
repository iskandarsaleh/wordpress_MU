						<ul class="sidebar" id="widgetSidebar3">
						<?php // if ( !function_exists('dynamic_sidebar')|| !dynamic_sidebar('widgets3') ) : ?>
						<li class="section">
							<h3 class="sansRed">Recent Comments</h3> 
							<ul> 
								<?php $recent_comments = getRecentComments();
								foreach($recent_comments as $c){
								?>
								<li class="sidebarLink"><a href="<?= get_permalink($c->comment_post_ID); ?>#<?= $c->comment_contentIndex; ?>"><?php echo $c->post_title."</a><br /><i>".$c->comment_author; ?> <?php _e('says');?>: </i><?php echo (strlen($c->comment_content) > 90) ? substr(strip_tags($c->comment_content),0 , 90) . "<a href=\"".get_permalink($c->comment_post_ID)."#". $c->comment_contentIndex."\">[...]</a>" : strip_tags($c->comment_content); ?></li>
								<?php } ?>						
							</ul>
						</li>
						<?php // endif; ?>
						</ul>