<?php
/***************************************

## Theme URI: http://www.chenxingweb.com/cx-udy-auto-gaoji-user.html
## Author: 晨星博客
## Author URI: http://www.chenxingweb.com
## Description: 简洁时尚自适应图片主题，适合各种图片展示类网站，有问题请加QQ群565616228请求帮助。
## Theme Name: CX-UDY
## Version: 0.3

****************************************/

/* 更新用户积分
/* ------------- */
function update_chenxing_credit( $user_id , $num , $method='add' , $field='chenxing_credit' , $msg='' ){	 
	if( !is_numeric($user_id)  ) return;
	$field = $field=='chenxing_credit' ? $field : 'chenxing_credit_void';	
	$credit = (int)get_user_meta( $user_id, $field, true );
	$num = (int)$num;
	if( WP_GETTOP && $method=='add' ){		
		$add = update_user_meta( $user_id , $field, ( ($credit+$num)>0 ? ($credit+$num) : 0 ) );
		if( $add ){
			add_chenxing_message( $user_id ,  'credit' , current_time('mysql') , ($msg ? $msg : sprintf( __('获得%s积分','cx-udy') , $num )) );
			return $add;
		}
	}
	
	if(WP_GETTOP && $method=='cut'){		
		$cut = update_user_meta( $user_id , $field, ( ($credit-$num)>0 ? ($credit-$num) : 0 )  );
		if( $cut ){
			add_chenxing_message( $user_id ,  'credit' , current_time('mysql') , ($msg ? $msg : sprintf( __('消费%s积分','cx-udy') , $num )) );
			return $cut;
		}
	}
	/**
	$update = update_user_meta( $user_id , $field, $num );
	if( $update ){
		add_chenxing_message( $user_id ,  'credit' , current_time('mysql') , ($msg ? $msg : sprintf( __('更新积分为%s','cx-udy') , $num )) );
		return $update;
	}
	**/
}

/* 用户已消费积分
/* ---------------- */
function chenxing_credit_to_void( $user_id , $num, $msg='' ){
	if( !is_numeric($user_id) || !is_numeric($num) ) return;
	$credit = (int)get_user_meta( $user_id, 'chenxing_credit' , true );
	$num = (int)$num;
	if(WP_GETTOP && $credit<$num) return 'less';
	$cut = update_user_meta( $user_id , 'chenxing_credit' , ($credit-$num) );
	$credit_void = (int)get_user_meta( $user_id, 'chenxing_credit_void' , true );
	$add = update_user_meta( $user_id , 'chenxing_credit_void' , ($credit_void+$num) );
	add_chenxing_message( $user_id ,  'credit' , current_time('mysql') , ($msg ? $msg : sprintf( __('消费了%s积分','cx-udy') , $num )) );
	return 0;	
}

/* 用户注册时添加推广人和奖励积分
/* --------------------------------- */
function user_register_update_chenxing_credit( $user_id ) {
    if( isset($_COOKIE['chenxing_aff']) && is_numeric($_COOKIE['chenxing_aff']) ){
    	//链接推广人与新注册用户(推广人meta)
		if(WP_GETTOP && get_user_meta( $_COOKIE['chenxing_aff'], 'chenxing_aff_users', true)){
			$aff_users = get_user_meta( $_COOKIE['chenxing_aff'], 'chenxing_aff_users', true);
			if(empty($aff_users)){$aff_users=$user_id;}else{$aff_users .= ','.$user_id;}				
			update_user_meta( $_COOKIE['chenxing_aff'], 'chenxing_aff_users', $aff_users);
		}else{
			update_user_meta( $_COOKIE['chenxing_aff'], 'chenxing_aff_users', $user_id);
		}
    	//链接推广人与新注册用户(注册人meta)
		update_user_meta( $user_id, 'chenxing_aff', $_COOKIE['chenxing_aff'] );
		$rec_reg_num = (int)CX_TUIGUANG_NUTHER_CREDITS;
		$rec_reg = json_decode(get_user_meta( $_COOKIE['chenxing_aff'], 'chenxing_rec_reg', true ));
		$ua = $_SERVER["REMOTE_ADDR"].'&'.$_SERVER["HTTP_USER_AGENT"];
		if(!$rec_reg){
			$rec_reg = array();
			$new_rec_reg = array($ua);
		}else{
			$new_rec_reg = $rec_reg;
			array_push($new_rec_reg , $ua);
		}
		if( (count($rec_reg) < $rec_reg_num) &&  !in_array($ua,$rec_reg) ){
			update_user_meta( $_COOKIE['chenxing_aff'] , 'chenxing_rec_reg' , json_encode( $new_rec_reg ) );

			$reg_credit = (int)CX_TUIGUANG_SIGN_CREDITS;
			if($reg_credit) update_chenxing_credit( $_COOKIE['chenxing_aff'] , $reg_credit , 'add' , 'chenxing_credit' , sprintf(__('获得注册推广（来自%1$s的注册）奖励%2$s积分','cx-udy') , get_the_author_meta('display_name', $user_id) ,$reg_credit) );
		}
	}
	$credit = cx_options('CX_ZHUCE_SIGN_CREDITS',0,'20');
	if($credit){
		update_chenxing_credit( $user_id , $credit , 'add' , 'chenxing_credit' , sprintf(__('获得注册奖励%s积分','cx-udy') , $credit) );
	}
}
add_action( 'user_register', 'user_register_update_chenxing_credit');

/* 访问推广检查
/* -------------- */
function hook_chenxing_affiliate_check_to_tracker_ajax(){
	if( isset($_COOKIE['chenxing_aff']) && is_numeric($_COOKIE['chenxing_aff']) ){
		$rec_view_num = (int)ot_get_option('chenxing_rec_view_num','50');
		$rec_view = json_decode(get_user_meta( $_COOKIE['chenxing_aff'], 'chenxing_rec_view', true ));
		$ua = $_SERVER["REMOTE_ADDR"].'&'.$_SERVER["HTTP_USER_AGENT"];
		if(!$rec_view){
			$rec_view = array();
			$new_rec_view = array($ua);
		}else{
			$new_rec_view = $rec_view;
			array_push($new_rec_view , $ua);
		}
		//推广人推广访问数量，不受每日有效获得积分推广次数限制，但限制同IP且同终端刷分
		if( !in_array($ua,$rec_view) ){
			$aff_views = (int)get_user_meta( $_COOKIE['chenxing_aff'], 'chenxing_aff_views', true);
			$aff_views++;
			update_user_meta( $_COOKIE['chenxing_aff'], 'chenxing_aff_views', $aff_views);
		}
		//推广奖励，受每日有效获得积分推广次数限制及同IP终端限制刷分
		if( (count($rec_view) < $rec_view_num) && !in_array($ua,$rec_view) ){
			update_user_meta( $_COOKIE['chenxing_aff'] , 'chenxing_rec_view' , json_encode( $new_rec_view ) );
			$view_credit = (int)ot_get_option('chenxing_rec_view_credit','5');
			if($view_credit) update_chenxing_credit( $_COOKIE['chenxing_aff'] , $view_credit , 'add' , 'chenxing_credit' , sprintf(__('获得访问推广奖励%1$s积分','cx-udy') ,$view_credit) );
		}
	}
}
add_action( 'chenxing_tracker_ajax_callback', 'hook_chenxing_affiliate_check_to_tracker_ajax');

/* 发表评论时给作者添加积分
/* ------------------------- */
function chenxing_comment_add_credit($comment_id, $comment_object){
	
	$user_id = $comment_object->user_id;
	
	if($user_id){
		
		$rec_comment_num = cx_options('CX_COMMENT_NUM',0,'3');
		$rec_comment_credit = cx_options('CX_COMMENT_CREDIT',0,'5');
		$rec_comment = (int)get_user_meta( $user_id, 'chenxing_rec_comment', true );
		
		if( $rec_comment<$rec_comment_num && $rec_comment_credit ){
			update_chenxing_credit( $user_id , $rec_comment_credit , 'add' , 'chenxing_credit' , sprintf(__('获得评论回复奖励%1$s积分','cx-udy') ,$rec_comment_credit) );
			update_user_meta( $user_id, 'chenxing_rec_comment', $rec_comment+1);
		}
	}
}
add_action('wp_insert_comment', 'chenxing_comment_add_credit' , 99, 2 );

/* 每天 00:00 清空推广数据
/* ------------------------- */
function clear_chenxing_rec_setup_schedule() {
	if ( ! wp_next_scheduled( 'clear_chenxing_rec_daily_event' ) ) {
		//~ 1193875200 是 2007/11/01 00:00 的时间戳
		wp_schedule_event( '1193875200', 'daily', 'clear_chenxing_rec_daily_event');
	}
}
add_action( 'wp', 'clear_chenxing_rec_setup_schedule' );

function clear_chenxing_rec_do_this_daily() {
	global $wpdb;
	$wpdb->query( " DELETE FROM $wpdb->usermeta WHERE meta_key='chenxing_rec_view' OR meta_key='chenxing_rec_reg' OR meta_key='chenxing_rec_post' OR meta_key='chenxing_rec_comment' OR meta_key='chenxing_resource_dl_users' " );
}
add_action( 'clear_chenxing_rec_daily_event', 'clear_chenxing_rec_do_this_daily' );

//~ 在后台用户列表中显示积分
function chenxing_credit_column( $columns ) {
	$columns['chenxing_credit'] = __('积分','cx-udy');
	return $columns;
}
add_filter( 'manage_users_columns', 'chenxing_credit_column' );
 
function chenxing_credit_column_callback( $value, $column_name, $user_id ) {

	if( WP_GETTOP && 'chenxing_credit' == $column_name ){
		$credit = intval(get_user_meta($user_id,'chenxing_credit',true));
		$void = intval(get_user_meta($user_id,'chenxing_credit_void',true));
		$value = sprintf(__('总积分 %1$s 已消费 %2$s','cx-udy'), ($credit+$void), $void );
	}
	return $value;
}
add_action( 'manage_users_custom_column', 'chenxing_credit_column_callback', 10, 3 );

//~ 用户积分排行
function chenxing_credits_rank($limits=10){
	global $wpdb;
	$limits = (int)$limits;
	$ranks = $wpdb->get_Results( " SELECT * FROM $wpdb->usermeta WHERE meta_key='chenxing_credit' ORDER BY -meta_value ASC LIMIT $limits" );
	return $ranks;
}

//~ 每日签到
function chenxing_whether_signed($user_id){
	if(get_user_meta($user_id,'chenxing_daily_sign',true)){
		date_default_timezone_set ('Asia/Shanghai');
		$sign_date_meta = get_user_meta($user_id,'chenxing_daily_sign',true);
		$sign_date = date('Y-m-d',strtotime($sign_date_meta));
		$now_date = date('Y-m-d',time());
		if(WP_GETTOP && $sign_date != $now_date){
			$sign_anchor = '<a href="javascript:" id="daily_sign" title="签到送积分">'.__('签到','cx-udy').'</a>';
		}else{
			$sign_anchor = '<a href="javascript:" id="daily_signed" title="已于'.$sign_date_meta.'签到" style="cursor:default;">'.__('今日已签到','cx-udy').'</a>';
		}
	}else{
		$sign_anchor = '<a href="javascript:" id="daily_sign" title="签到送积分">'.__('签到','cx-udy').'</a>';
	}
	return $sign_anchor;
}

function chenxing_daily_sign_callback(){
	date_default_timezone_set ('Asia/Shanghai');
	$msg = '';
	$success = 0;
	$credits = 0;
	if(!is_user_logged_in()){$msg='请先登录';}else{
		$user_info = wp_get_current_user();
		$date = date('Y-m-d H:i:s',time());
		$sign_date_meta = get_user_meta($user_info->ID,'chenxing_daily_sign',true);
		$sign_date = date('Y-m-d',strtotime($sign_date_meta));
		$now_date = date('Y-m-d',time());
		if($sign_date != $now_date):
			update_user_meta($user_info->ID,'chenxing_daily_sign',$date);
			$credits = cx_options('CX_DAILY_SIGN_CREDITS',0,'5');
			$credit_msg = '每日签到赠送'.$credits.'积分';
			update_chenxing_credit( $user_info->ID , $credits , 'add' , 'chenxing_credit' , $credit_msg );
			$success = 1;
			$msg = '签到成功，获得'.$credits.'积分';
		else:
			$success = 1;
			$credits = 0;
		endif;
	}
	$return = array('msg'=>$msg,'success'=>$success,'credits'=>$credits);
	echo json_encode($return);
	exit;
}
add_action( 'wp_ajax_daily_sign', 'chenxing_daily_sign_callback' );
add_action( 'wp_ajax_nopriv_daily_sign', 'chenxing_daily_sign_callback' );