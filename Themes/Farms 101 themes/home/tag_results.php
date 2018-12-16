<?php
/*
Template Name: Tag_results
*/
?>
<!--include header-->
<?php get_header(); ?>

<div id="content" class="narrowcolumn">

<h1><?php _e('Results for');?> <?php current_tag();?></h1>

<?php if (tag_results()): ?>
<?php global $post; ?> 
<?php foreach (tag_results() as $post): ?>
	<?php setup_postdata($post); ?>

<div class="post" id="post-<?php the_ID(); ?>">
      <h2><a href="<?php the_guid() ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>"><?php the_title(); ?></a></h2>
       <small><?php _e('Posted');?> <?php the_time(__('F jS, Y')) ?> <?php _e('by')?> <?php the_author() ?> </small>
	<div class="entry">
	<?php the_content(); ?>
	</div>
     </div>
  <?php endforeach; ?>
  
  <?php else : ?>
    <h2 class="center"><?php _e('Not Found'); ?></h2>
    <p class="center"><?php _e("Sorry, but you are looking for something that isn't here.");?></p>
    <?php //include (TEMPLATEPATH . "/searchform.php"); ?>
 <?php endif; ?>

</div>


<!--include sidebar-->
<?php get_sidebar(); ?>

<!--include footer-->
<?php get_footer(); ?>
