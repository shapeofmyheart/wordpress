<?php
/**
 * Theme Name: CX-UDY
 * Theme URI: http://www.chenxingweb.com/store/1910.html
 * Author: 晨星博客
 * Author URI: http://www.chenxingweb.com
 * Description: 简洁时尚自适应图片主题，适合各种图片展示类网站，有问题请加QQ群565616228请求帮助。
 * Version: 0.6
 * Text Domain: cx-udy
 * Domain Path: /languages
 */

global $get_img, $uid;
?>
<div class="main">
  <div class="main_inner">
        <div class="main_left">
		  <div class="item_title">
			<h1> <?php the_title();if(isset($get_img))echo '('.pic_total().'P)';?></h1>
			<div class="single-cat"><span>分类:</span> <?php the_category( '-' ) ?> / <span>发布于</span><?php the_time('Y-n-j');?> <?php edit_post_link(); ?></div>
		  </div>
		  <div class="item_info cl">
			<div style="float:left;"> 
				 <i class="fa fa-eye"></i> <span class="cx-views"><?php echo Bing_get_views(false);?></span> 人气 / 
				 <i class="fa fa-comment"></i> <span><?php comments_popup_link( '0', '1', '%' ); ?></span> 评论 
			 </div>
			<div class="post_au">
				<?php
				if(isset($get_img)&&$get_img== "all"){
					echo cx_post_download().'<a href="'.get_the_permalink().'"><i class="fa fa-television" style="margin-right:3px;"></i>单图模式</a>';
				}else{
					echo cx_post_download();
					echo "作者：";
					echo the_author_posts_link();
				}
				?>
			</div>
		  </div>
		  
		  <?php cx_ad_zhenghe(2);?>


<?php 
/** .content **/
echo '<div class="content" id="content">';
/** .content_left **/
echo '<div class="content_left">';
do_action('single_option',$post,$uid,$get_img);

/** 标准文章 **/	
if(!isset($get_img)){
	post_vip_chen(cx_biao_post_content(),$uid);
}elseif($get_img=="all"){
	post_vip_chen(all_img($post->post_content),$uid);
}

/** post_love_Meta  **/				
cx_love_post();
/** div.content_left  **/	
echo "</div>";
/** div.content  **/
echo "</div>";
