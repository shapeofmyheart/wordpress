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
if ( has_post_format( 'image' ))
add_filter('the_content', 'img_info');
if(isset($wp_query->query_vars['image']))
$get_img = $wp_query->query_vars['image'];
//获取登录用户id
$uid = get_current_user_id()?get_current_user_id():0;
while ( have_posts() ) : the_post();
if(has_post_format('image') && !isset($get_img)){
	cx__template('archive-images');
}else{
	cx__template('archive-blog');
}
endwhile;
do_action('post_meta_db',$get_img);
/** 评论模板 **/
comments_template();
/** div.main_left **/
echo "</div>";
/** 侧边调用 **/
if ( !has_post_format('image') || isset($get_img))
	get_sidebar();
/** div.main_inner **/
echo "</div>";
/** div.main **/
echo "</div>";
/** 底部公共模板 **/
get_footer();