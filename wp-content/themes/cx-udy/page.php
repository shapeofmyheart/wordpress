<?php
/***************************************

## Theme URI: http://www.chenxingweb.com/cx-udy-auto-gaoji-user.html
## Author: 晨星博客
## Author URI: http://www.chenxingweb.com
## Description: 简洁时尚自适应图片主题，适合各种图片展示类网站，有问题请加QQ群565616228请求帮助。
## Theme Name: CX-UDY
## Version: 0.3

****************************************/
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