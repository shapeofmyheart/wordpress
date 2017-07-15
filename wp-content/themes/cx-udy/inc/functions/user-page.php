<?php
/***************************************

## Theme URI: http://www.chenxingweb.com/cx-udy-auto-gaoji-user.html
## Author: 晨星博客
## Author URI: http://www.chenxingweb.com
## Description: 简洁时尚自适应图片主题，适合各种图片展示类网站，有问题请加QQ群565616228请求帮助。
## Theme Name: CX-UDY
## Version: 0.3

****************************************/

// 资料卡URL
function chenxing_get_user_url( $type='', $user_id=0 ){
	$user_id = intval($user_id);
	if( $user_id==0 ){
		$user_id = get_current_user_id();
	}
	$url = add_query_arg( 'tab', $type, get_author_posts_url($user_id) );
	return $url;
}

//~ 用户页资料页拒绝搜索引擎索引
function chenxing_author_tab_no_robots(){
	if( is_author() && isset($_GET['tab']) ) wp_no_robots();
}
add_action('wp_head', 'chenxing_author_tab_no_robots');

//~ 更改编辑个人资料链接
function chenxing_profile_page( $url ) {
    return is_admin() ? $url : chenxing_get_user_url('profile');
}
add_filter( 'edit_profile_url', 'chenxing_profile_page' );

//~ 拒绝普通用户访问后台
function chenxing_redirect_wp_admin(){
	if( is_admin() && is_user_logged_in() && !current_user_can('edit_users') && ( !defined('DOING_AJAX') || !DOING_AJAX )  ){
		wp_redirect( chenxing_get_user_url('profile') );
		exit;
	}
}
add_action( 'init', 'chenxing_redirect_wp_admin' );

//~ 普通用户编辑链接改为前台
function chenxing_edit_post_link($url, $post_id){
	if( !current_user_can('edit_users') ){
		$url = add_query_arg(array('action'=>'edit', 'id'=>$post_id), chenxing_get_user_url('post'));
	}
	return $url;
}
add_filter('get_edit_post_link', 'chenxing_edit_post_link', 10, 2);

//~ 在后台用户列表中显示昵称
function chenxing_display_name_column( $columns ) {
	$columns['chenxing_display_name'] = '显示名称';
	unset($columns['name']);
	return $columns;
}
add_filter( 'manage_users_columns', 'chenxing_display_name_column' );
 
function chenxing_display_name_column_callback( $value, $column_name, $user_id ) {

	if( 'chenxing_display_name' == $column_name ){
		$user = get_user_by( 'id', $user_id );
		$value = ( $user->display_name ) ? $user->display_name : '';
	}

	return $value;
}
add_action( 'manage_users_custom_column', 'chenxing_display_name_column_callback', 10, 3 );