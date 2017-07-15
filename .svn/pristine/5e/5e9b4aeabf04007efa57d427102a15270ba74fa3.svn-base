<?php
/*
Template Name:帮助页面
*/
wp_get_header();
while ( have_posts() ) : the_post();
?>

<div class="main">
  <div class="main_inner">
        <div class="main_left" style="width:100%">
		  <div class="item_title">
			<h1> <?php the_title();?></h1>
			<div class="single-cat"> <span>发布时间：</span> <?php the_time('Y-n-j');?></div>
		  </div>
		  <!--AD id:single_1002-->
		  
		   <!--AD.end-->
		  <div class="content">
			<div class="content_left">
				<?php the_content();?>
			</div>
		  </div>
	  
	  
<?php 
endwhile;
/** 评论模板 **/
comments_template();
/** div.main_left **/
echo "</div>";
/** div.main_inner **/
echo "</div>";
/** div.main **/
echo "</div>";
/** 底部公共模板 **/
get_footer();