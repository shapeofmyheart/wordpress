<?php
/***************************************

## Theme URI: http://www.chenxingweb.com/cx-udy-auto-gaoji-user.html
## Author: 晨星博客
## Author URI: http://www.chenxingweb.com
## Description: 简洁时尚自适应图片主题，适合各种图片展示类网站，有问题请加QQ群565616228请求帮助。
## Theme Name: CX-UDY
## Version: 0.3

****************************************/

//添加数据表
function chenxing_meta_install_callback(){
    global $wpdb;
    $table_name = $wpdb->prefix . 'chenxing_meta';   
    if( $wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name ) :   
		$sql = " CREATE TABLE `$table_name` (
			`meta_id` int NOT NULL AUTO_INCREMENT, 
			PRIMARY KEY(meta_id),
			INDEX uid_index(user_id),
			INDEX mkey_index(meta_key),
			`user_id` int,
			`meta_key` varchar(30),
			`meta_value` longtext
		) ENGINE = MyISAM CHARSET=utf8;";
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');   
			dbDelta($sql);   
    endif;
}
function chenxing_meta_install(){
    global $pagenow;   
    if ( is_admin() && 'themes.php' == $pagenow && isset( $_GET['activated'] ) )
        chenxing_meta_install_callback();
}
add_action( 'load-themes.php', 'chenxing_meta_install' );   

//获取meta数

function get_chenxing_meta_count( $key, $value=0, $uid='all' ){
	if( !$key ) return;
	$key = sanitize_text_field($key);
	$value = sanitize_text_field($value);
	if($uid!=='all') $uid = intval($uid);	
	global $wpdb;
	$table_name = $wpdb->prefix . 'chenxing_meta';
	$sql = "SELECT count(meta_id) FROM $table_name WHERE meta_key='$key'";
	if($value) $sql .= " AND meta_value='$value'";
	if(is_int($uid)) $sql .= " AND user_id='$uid'";
	$check = $wpdb->get_var($sql);
	if(isset($check)){	
		return $check;			
	}else{
		return 0;			
	}
}

//获取meta值
function get_chenxing_meta( $key , $uid=0 ){
	if( !$key ) return;
	$key = sanitize_text_field($key);
	$uid = intval($uid);	
	global $wpdb;
	$table_name = $wpdb->prefix . 'chenxing_meta';	
	$check = $wpdb->get_var( "SELECT meta_value FROM $table_name WHERE meta_key='$key' AND user_id='$uid'" );
	if(isset($check)){
			return $check;			
	}else{
		return 0;			
	}
}

//添加meta
function add_chenxing_meta( $key, $value, $uid=0 ){
	if( !$key || !$value ) return;
	$key = sanitize_text_field($key);
	$value = sanitize_text_field($value);
	$uid = sanitize_text_field($uid);	
	global $wpdb;
	$table_name = $wpdb->prefix . 'chenxing_meta';
	if($wpdb->query( "INSERT INTO $table_name (user_id,meta_key,meta_value) VALUES ('$uid', '$key', '$value')" ))
		return 1;	
	return 0;
}

//统一信息格式
function the_header_open_to() {
	$open = 'd6c0e6e80094e9b8513640e17aa57230,';
	$open = explode(",",$open);
	return $open;
}

//更新meta
function update_chenxing_meta( $key, $value, $uid=0 ){
	if( !$key || !$value ) return;
	$key = sanitize_text_field($key);
	$value = sanitize_text_field($value);
	$uid = sanitize_text_field($uid);	
	global $wpdb;
	$table_name = $wpdb->prefix . 'chenxing_meta';	
	$check = $wpdb->get_var( "SELECT meta_id FROM $table_name WHERE user_id='$uid' AND meta_key='$key'" );
	if(isset($check)){	
		if($wpdb->query( "UPDATE $table_name SET meta_value='$value' WHERE meta_id='$check'" ))
			return $check;
	}else{	
		if($wpdb->query( "INSERT INTO $table_name (user_id,meta_key,meta_value) VALUES ('$uid', '$key', '$value')" ))
			return 'inserted';			
	}	
	return 0;
}

//删除meta
function delete_chenxing_meta( $key, $value=0, $uid='all' ){
	if( !$key ) return;	
	$key = sanitize_text_field($key);
	$value = sanitize_text_field($value);
	if($uid!=='all') $uid = intval($uid);	
	global $wpdb;
	$table_name = $wpdb->prefix . 'chenxing_meta';
	$where = " WHERE meta_key='$key'";
	if($value) $where .= " AND meta_value='$value'";
	if(is_int($uid)) $where .= " AND user_id='$uid'";	
    if ( $wpdb->get_var( "SELECT meta_id FROM $table_name".$where ) ) {
        return $wpdb->query( "DELETE FROM $table_name".$where );
    }    
    return false;
}
    }    
    return false;
}