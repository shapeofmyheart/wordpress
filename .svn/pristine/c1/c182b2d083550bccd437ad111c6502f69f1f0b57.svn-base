<?php
/***************************************

## Theme URI: http://www.chenxingweb.com/cx-udy-auto-gaoji-user.html
## Author: 晨星博客
## Author URI: http://www.chenxingweb.com
## Description: 简洁时尚自适应图片主题，适合各种图片展示类网站，有问题请加QQ群565616228请求帮助。
## Theme Name: CX-UDY
## Version: 0.3

****************************************/

/* 创建数据表
/* ------------ */
function chenxing_message_install_callback(){
    global $wpdb;
    $table_name = $wpdb->prefix . 'chenxing_message';   
    if( $wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name ) :   
		$sql = " CREATE TABLE `$table_name` (
			`msg_id` int NOT NULL AUTO_INCREMENT, 
			PRIMARY KEY(msg_id),
			INDEX uid_index(user_id),
			INDEX mtype_index(msg_type),
			INDEX mdate_index(msg_date),
			`user_id` int,
			`msg_type` varchar(20),
			`msg_date` datetime,
			`msg_title` tinytext,
			`msg_content` text
		) ENGINE = MyISAM CHARSET=utf8;";
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');   
			dbDelta($sql);   
    endif;
}
function chenxing_message_install(){
    global $pagenow;   
    if ( is_admin() && 'themes.php' == $pagenow && isset( $_GET['activated'] ) )
        chenxing_message_install_callback();
}
add_action( 'load-themes.php', 'chenxing_message_install' ); 

/* 添加消息
/* --------- */
function add_chenxing_message( $uid=0, $type='', $date='', $title='', $content='' ){

	$uid = intval($uid);
	$title = sanitize_text_field($title);
	
	if( !$uid || empty($title) ) return;

	$type = $type ? sanitize_text_field($type) : 'unread';
	$date = $date ? $date : current_time('mysql');
	$content = htmlspecialchars($content);
	
	global $wpdb;
	$table_name = $wpdb->prefix . 'chenxing_message';

	if($wpdb->query( "INSERT INTO $table_name (user_id,msg_type,msg_date,msg_title,msg_content) VALUES ('$uid', '$type', '$date', '$title', '$content')" ))
		return 1;
	
	return 0;
	
}
// 添加消息的定时器
add_action( 'add_chenxing_message_event', 'add_chenxing_message', 10, 5 );

/* 更新状态
/* --------- */
function update_chenxing_message_type( $id=0, $uid=0, $type='' ){

	$id = intval($id);
	$uid = intval($uid);

	if( ( !$id || !$uid) || empty($type) ) return;

	global $wpdb;
	$table_name = $wpdb->prefix . 'chenxing_message';

	if( $id===0 ){
		$sql = " UPDATE $table_name SET msg_type = '$type' WHERE user_id = '$uid' ";
	}else{
		$sql = " UPDATE $table_name SET msg_type = '$type' WHERE msg_id = '$id' ";
	}

	if($wpdb->query( $sql ))
		return 1;
	
	return 0;
	
}
// 更新状态的定时器
add_action( 'update_chenxing_message_type_event', 'update_chenxing_message_type', 10, 3 );

/* 获取消息（积分消息除外）
/* ------------------------ */
function get_chenxing_message( $uid=0 , $count=0, $where='', $limit=0, $offset=0 ){
	
	$uid = intval($uid);
	
	if( !$uid ) return;

	global $wpdb;
	$table_name = $wpdb->prefix . 'chenxing_message';
	
	if($count){
		if($where) $where = " AND ($where)";
		$check = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE user_id='$uid' $where" );
	}else{
		$check = $wpdb->get_results( "SELECT msg_id,msg_type,msg_date,msg_title,msg_content FROM $table_name WHERE user_id='$uid' AND $where ORDER BY (CASE WHEN msg_type LIKE 'un%' THEN 1 ELSE 0 END) DESC, msg_date DESC LIMIT $offset,$limit" );
	}
	if($check)	return $check;

	return 0;

}

/* 获取用户的积分消息
/* ------------------ */
function get_chenxing_credit_message( $uid=0 , $limit=0, $offset=0 ){
	
	$uid = intval($uid);
	
	if( !$uid ) return;

	global $wpdb;
	$table_name = $wpdb->prefix . 'chenxing_message';
	
	$check = $wpdb->get_results( "SELECT msg_id,msg_date,msg_title FROM $table_name WHERE msg_type='credit' AND user_id='$uid' ORDER BY msg_date DESC LIMIT $offset,$limit" );

	if($check)	return $check;

	return 0;

}

/* 获取私信
/* ---------- */
function get_chenxing_pm( $pm=0, $from=0, $count=false, $single=false, $limit=0, $offset=0 ){
	
	$pm = intval($pm);
	$from = intval($from);
	
	if( !$pm || !$from ) return;

	global $wpdb;
	$table_name = $wpdb->prefix . 'chenxing_message';
	
	$title_sql = $single ? "msg_title='{\"pm\":$pm,\"from\":$from}'" : "( msg_title='{\"pm\":$pm,\"from\":$from}' OR msg_title='{\"pm\":$from,\"from\":$pm}' )";
	
	if($count){
		$check = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE ( msg_type='repm' OR msg_type='unrepm' ) AND $title_sql" );
	}else{
		$check = $wpdb->get_results( "SELECT msg_id,msg_date,msg_title,msg_content FROM $table_name WHERE ( msg_type='repm' OR msg_type='unrepm' ) AND $title_sql ORDER BY msg_date DESC LIMIT $offset,$limit" );
	}
	if($check)	return $check;

	return 0;

}
