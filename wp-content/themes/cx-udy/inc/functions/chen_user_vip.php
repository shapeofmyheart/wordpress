<?php
/**
 * Theme Name: CX-UDY
 * Theme URI: http://www.chenxingweb.com/store/1910.html
 * Author: 晨星博客
 * Author URI: http://www.chenxingweb.com
 * Description: 简洁时尚自适应图片主题，适合各种图片展示类网站，有问题请加QQ群565616228请求帮助。
 * Version: 0.5
 * Text Domain: cx-udy
 * Domain Path: /languages
 */

function get_user_vip_records(){
	$record = array();
	if(is_user_logged_in()){
		global $wpdb;
		$prefix = $wpdb->prefix;
		$orders=$wpdb->get_Results("select * from ".$prefix."chenxing_vip_users",'ARRAY_A');
		$record = $orders;
	}
	return $record;
}

//获取vip会员信息
function get_vip_meta($id){
	$user = get_user_by( 'id',$id );
	echo '<a href="'.get_author_posts_url($user->ID).'">'.$user->display_name.'</a>';
}