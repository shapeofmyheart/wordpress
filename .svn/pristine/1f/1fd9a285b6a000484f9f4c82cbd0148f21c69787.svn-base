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
        <div class="main_left">
		  <div class="item_title">
			<h1> <?php the_title();?></h1>
			<div class="single-cat">分类：<a href="<?php echo home_url('/picture');?>">美图分享</a> / 发布于<?php the_time('Y-n-j');?></div>
		  </div>
		  <div class="item_info">
			<div style="float:left;"> 
				 <i class="fa fa-eye"></i> <span><?php echo Bing_get_views();?></span> 人气 / 
				 <i class="fa fa-comment"></i> <span><?php comments_popup_link( '0', '1', '%' ); ?></span> 评论 / 
			 </div>
			<div class="post_au"> Author：<?php the_author_posts_link();?></div>
		  </div>
		  <!--AD id:single_1002-->
		  <div class="affs">
			<?php cx_ad_zhenghe(2);?>
		  </div>
		   <!--AD.end-->
		  <div class="content">
			<div class="content_left">
			<?php the_content();?>
			  <div class="tag cl">
				 <span class="dtpost-like">
					 <a href="javascript:;" data-action="ding" data-id="<?php the_ID(); ?>" class="favorite<?php if(isset($_COOKIE['bigfa_ding_'.$post->ID])) echo ' done';?>">
						 <i class="fa fa-thumbs-up"></i>
						 <span class="count">
							<em class="ct_ding" style="color: #F58282;"><?php $bigfa_ding = get_post_meta($post->ID,'bigfa_ding',true); if($bigfa_ding) echo $bigfa_ding; else echo '0';?></em>个赞
						</span>
					</a>
					<a href="javascript:;" data-action="ding_no" data-id="<?php the_ID(); ?>" class="tiresome<?php if(isset($_COOKIE['bigfa_ding_no_'.$post->ID])) echo ' done';?>">
						<i class="fa fa-thumbs-down"></i>
						<span class="count">
							被踩<em class="ct_ding"><?php $bigfa_like_no = get_post_meta($post->ID,'bigfa_like_no',true);if($bigfa_like_no)echo $bigfa_like_no; else echo '0';?></em>次
						</span>
					</a>
				</span>
			  </div>
			  <div class="post_hyh">
				<?php
				$next_post = get_next_post();
				if (!empty( $next_post ))
					echo '<a href="'.get_permalink( $next_post->ID ).'">换一篇</a>';
				else
					hyh_cx_src(1,'picture');
				?>
			  </div>
			</div>
		  </div> 
	  
<?php 
endwhile;
/** 相关文章 **/
cx_xg_post('picture');
/** 评论模板 **/
comments_template();
/** div.main_left **/
echo "</div>";
/** 侧边调用 **/
	get_sidebar();
/** div.main_inner **/
echo "</div>";
/** div.main **/
echo "</div>";
/** 底部公共模板 **/
get_footer();