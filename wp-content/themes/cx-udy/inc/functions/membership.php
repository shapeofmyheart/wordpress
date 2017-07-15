<?php
/***************************************

## Theme URI: http://www.chenxingweb.com/cx-udy-auto-gaoji-user.html
## Author: 晨星博客
## Author URI: http://www.chenxingweb.com
## Description: 简洁时尚自适应图片主题，适合各种图片展示类网站，有问题请加QQ群565616228请求帮助。
## Theme Name: CX-UDY
## Version: 0.3

****************************************/

//添加会员数据库
if ( !defined('ABSPATH') ) {exit;}
if(CX_USERS_SYSTEM!='on') {return;}
//建立数据表
function create_membership_table(){
	//是否开启会员系统
	if(CX_USERS_SYSTEM == 'on'){
		global $wpdb;
		include_once(ABSPATH.'/wp-admin/includes/upgrade.php');
		$table_charset = '';
		$prefix = $wpdb->prefix;
		$users_table = $prefix.'chenxing_vip_users';
		if($wpdb->has_cap('collation')) {
			if(!empty($wpdb->charset)) {
				$table_charset = "DEFAULT CHARACTER SET $wpdb->charset";
			}
			if(!empty($wpdb->collate)) {
				$table_charset .= " COLLATE $wpdb->collate";
			}		
		}
		$create_vip_users_sql="CREATE TABLE $users_table (id int(11) NOT NULL auto_increment,user_id int(11) NOT NULL,user_type tinyint(4) NOT NULL default 0,startTime datetime NOT NULL default '0000-00-00 00:00:00',endTime datetime NOT NULL default '0000-00-00 00:00:00',PRIMARY KEY (id),INDEX uid_index(user_id),INDEX utype_index(user_type)) ENGINE = MyISAM $table_charset;";
		maybe_create_table($users_table,$create_vip_users_sql);
		
	}
}
add_action('admin_menu','create_membership_table');

//获取会员类型
function getUserMemberType($uid=''){
	date_default_timezone_set ('Asia/Shanghai');
	global $wpdb;
	if(empty($uid)):
	$user_info = wp_get_current_user();
	$id = $user_info->ID;
	else: $id = $uid;
	endif;
	$prefix = $wpdb->prefix;
	$table = $prefix.'chenxing_vip_users';
	$userType=$wpdb->get_row("select * from ".$table." where user_id=".$id);
	//0代表已过期 1代表月费会员 2代表季费会员 3代表年费会员 FALSE代表未开通过会员
	if($userType){
		if(time() >strtotime($userType->endTime)){
			$wpdb->query("update $table set user_type=0,endTime='0000-00-00 00:00:00' where user_id=".$id);
			return (int)0;
		}
		return (int)$userType->user_type;
	}
	return FALSE;
}

function vip_ing_num(){
	global $post;
	$post_id = $post->ID;
	$vip_imgaes = get_post_meta($post_id,'vip_imgaes',true);
	if(!$vip_imgaes){
		$vip_f = substr($post->post_content,0,strrpos($post->post_content,'<!--vip-->'));
		$mun = (int)substr_count($vip_f,'<img');
		update_post_meta($post_id, 'vip_imgaes', $mun);		
		return $mun; 
	}else{
		return $vip_imgaes;
	}		
}

/* 文章VIP图片处理
/* -------------------------------- */
add_filter('the_content','vip_img_info',1);
function vip_img_info($vip_post){
	global $pages;
	//文章分页数量
	$max = (int)count($pages);
	//当前文字分页数量
	$min = (int)get_query_var('page');
	//免费文章分页数量
	$num = vip_ing_num();
	//加载登陆用户信息
	$user_info = wp_get_current_user();
	//获取用户id
	$user_id = $user_info->ID;
	//免费用户看到的内容
	if(is_user_logged_in()){
		$content = '<div class="VIP_tixing">该图片需要会员才能查看<a href="'.chenxing_get_user_url( 'membership', $user_id ).'">开通会员</a></div>';
	}else{
		$content = '<div class="VIP_tixing">该图片需要登陆才能查看<a href="'.cx_login_url(1).'">立即登陆</a></div>';
	}
	
	//获取当前用户的VIP状态
	$user_vip = getUserMemberType($user_id);
	if($max>$num && $num>0){
		if($min>$num){
			if(isset($user_vip) && $user_vip>0){
				return $vip_post;
			}else{
				$vip_post = preg_replace('/<img(.*?)>/i', $content, $vip_post);
				return $vip_post;
			}
			
		}else{
			return $vip_post;
		}		
	}else{
		return $vip_post;
	}	
}

//获取会员信息
function getUserMemberInfo($uid=''){
	date_default_timezone_set ('Asia/Shanghai');
	global $wpdb;
	if(empty($uid)):
	$user_info = wp_get_current_user();
	$id = $user_info->ID;
	else: $id = $uid;
	endif;
	$prefix = $wpdb->prefix;
	$table = $prefix.'chenxing_vip_users';
	$userInfo=$wpdb->get_row("select * from ".$table." where user_id=".$id,'ARRAY_A');
	if(!$userInfo){
		$Info = array('id'=>$userInfo['id'],'user_id'=>$id,'user_type'=>'非会员','user_status'=>'未开通过会员','startTime'=>'N/A','endTime'=>'N/A');
	}else{
		$Info['id'] = $userInfo['id'];
		$Info['user_id'] = $id;
		$Info['user_type_ID'] = $userInfo['user_type'];
		$Info['startTime'] = $userInfo['startTime'];
		$Info['endTime'] = $userInfo['endTime'];
		$Info['user_type']='过期会员';
		if(time() >strtotime($userInfo['endTime'])){
			$Info['user_status']='已过期';$wpdb->query("update $table set user_type=0,endTime='0000-00-00 00:00:00' where user_id=".$id);
		}else{
			$left=(int)(((strtotime($userInfo['endTime']))-time())/(3600*24));$Info['user_status']=$left.'天后到期';
			switch ($userInfo['user_type']){
				case 3:
					$Info['user_type']='钻石会员';
					break;
				case 2:
					$Info['user_type']='白金会员';
					break;
				default:
					$Info['user_type']='普通会员';		
			}
		}
	}
	return $Info;
}

//给VIP文章加权限限制
function post_cat_vip($cat=0,$tu='',$post_id = 0){
	global $post;
	//获取分类id
	if($post_id == 0){
		$cats = get_the_category($post->ID);
	}else{
		$cats = get_the_category($post_id);
	}
	$cats_id = $cats[0]->cat_ID;
	//普通会员
	$vip_1 =  is_array(cx_options('CX_VIP_QX_MONTHLY_PRICE'))?cx_options('CX_VIP_QX_MONTHLY_PRICE'):array();
	//白金会员
	$vip_2 = is_array(cx_options('CX_VIP_QX_QUARTERLY_PRICE'))?cx_options('CX_VIP_QX_QUARTERLY_PRICE'):array();
	//钻石会员
	$vip_3 = is_array(cx_options('CX_VIP_QX_ANNUAL_PRICE'))?cx_options('CX_VIP_QX_ANNUAL_PRICE'):array();

	$vip = 'vip_'.$tu;

	if($cat == 0){
		if (in_array($cats_id, $vip_1) || in_array($cats_id, $vip_2) || in_array($cats_id, $vip_3)){
			return true;
		}else{
			return false;
		}
	}elseif($cat == 1){
		if(in_array($cats_id, $$vip)){
			return true;
		}else{
			return false;
		}
	}
}

//给文章添加角标显示
function _vip_jiaobiao_echo($id=0){
	$jiao = cx_options('cx_fujia_jiaobiao',0,'no');
	if($jiao == 1){
		if(post_cat_vip(1,3,$id)){
			echo '<div class="vip_jb" title="钻石会员专区" style="background: #fb5c8f;">钻石</div>';
		}elseif(post_cat_vip(1,2,$id)){
			echo '<div class="vip_jb" title="白金会员专区" style="background: #5cc0fb;">白金</div>';
		}elseif(post_cat_vip(1,1,$id)){
			echo '<div class="vip_jb" title="普通会员专区" style="background: #d6d84b;">普通</div>';
		}
	}elseif($jiao == 2){
		if(cx_post_down_if()){
			echo '<div class="vip_jb" title="包含可下载资源" style="background: #5cc0fb;"><i class="fa fa-download"></i></div>';
		}elseif(vip_ing_num()){
			echo '<div class="vip_jb" title="该图集有会员图片" style="background: #fb7878;"><i class="fa fa-eye-slash"></i></div>';
		}
	}
	
}

//获取升级高级会员所需积分数量
function _vip_shengji_jf($user,$id){
	global $wpdb;
	$prefix = $wpdb->prefix;
	$table = $prefix.'chenxing_vip_users';
	$userInfo = $wpdb->get_row("select * from ".$table." where user_id=".$user." AND user_type IN($id)");
	if(!$userInfo){
		return true;
	}else{
		return false;
	}
}

//获取开通会员订单记录
function getUserMemberOrders($uid=''){
	global $wpdb;
	if(empty($uid)){
		$user_info = wp_get_current_user();
		$id = $user_info->ID;
	}else{
		$id = $uid;
	}
	$prefix = $wpdb->prefix;
	$table = $prefix.'chenxing_orders';
	$vip_orders=$wpdb->get_Results("select * from ".$table." where user_id=".$id." and product_id in (-1,-2,-3)",'ARRAY_A');
	return $vip_orders;
}

//转换会员开通类型
function output_order_vipType($code){
	switch($code){
		case 3:
			$type = '钻石会员';
			break;
		case 2:
			$type = '白金会员';
			break;
		default:
			$type = '普通会员';
	}
	return $type;
}

//创建会员订单
function create_the_vip_order(){
	$success=0;
	$order_id ='';
	$msg ='';
	$credit = (int)get_user_meta($uid,'chenxing_credit',true);
	if(!is_user_logged_in()){$msg='请先登录';}else{
		$user_info = wp_get_current_user();
		$uid = $user_info->ID;
		$user_name=$user_info->display_name;
		$user_email = $user_info->user_email;
		$product_id = $_POST['product_id'];
		$credit = (int)get_user_meta($uid,'chenxing_credit',true);
		if($product_id==-3){
			$order_price=cx_options('CX_VIP_ANNUAL_PRICE',0,'800');
			$order_name='钻石会员';
		}elseif($product_id==-2){
			$order_price=cx_options('CX_VIP_QUARTERLY_PRICE',0,'280');
			$order_name='白金会员';
		}else{
			$order_price=cx_options('CX_VIP_MONTHLY_PRICE',0,'100');
			$order_name='普通会员';
		}
		if($order_price<=$credit) {
			$insert = insert_order($product_id,$order_name,$order_price,1,$order_price,4,'',$uid,$user_name,$user_email,'','','','','');
				if($insert):
					//扣除积分//发送站内信
					update_chenxing_credit( $uid , $order_price , 'cut' , 'chenxing_credit' , '开通'.$order_name.'消费'.$order_price.'积分' );
					//更新已消费积分
					if(get_user_meta($uid,'chenxing_credit_void',true)){
						$void = get_user_meta($uid,'chenxing_credit_void',true);
						$void = $void + $order_price;
						update_user_meta($uid,'chenxing_credit_void',$void);
					}else{
						add_user_meta( $uid,'chenxing_credit_void',$order_price,true );
					}
					if($product_id==-1){
						elevate_user_vip(1,$uid,$user_name,'',$user_email);
					}elseif($product_id==-2){	
						elevate_user_vip(2,$uid,$user_name,'',$user_email);
					}elseif($product_id==-3){
						elevate_user_vip(3,$uid,$user_name,'',$user_email);
					}
					$msg = '购买成功，已扣除'.$order_price.'积分';
					$success = 1;
				else:
					$msg = '创建订单失败，请重新再试';
				endif;			
		}else{
			$msg = '积分不足，请充值后再开通会员服务！';
		}		
	}
	$return = array('success'=>$success,'msg'=>$msg,'order_id'=>$order_id);
	echo json_encode($return);
	exit;
}
//add_action( 'wp_ajax_nopriv_create_vip_order', 'create_the_vip_order' );
add_action( 'wp_ajax_create_vip_order', 'create_the_vip_order' );

//开通用户VIP
function elevate_user_vip($type=1,$user_id,$user_name,$from,$to){
	date_default_timezone_set ('Asia/Shanghai');
	$admin_email = get_bloginfo ('admin_email');
	$blogname = get_bloginfo('name');
	global $wpdb;
	$prefix = $wpdb->prefix;
	$table = $prefix.'chenxing_vip_users';
	$userInfo=$wpdb->get_row("select * from ".$table." where user_id=".$user_id);
	$period = 3600*24*30;
	switch($type){
		case 3:
			$period = 3600*24*365;
			break;
		case 2:
			$period = 3600*24*90;
			break;
		default:
			$period = 3600*24*30;
	}
	//$vip_status = getUserMemberType($user_id);
	$endTime = time()+$period;
	$endTime = strftime('%Y-%m-%d %X',$endTime);
	if(WP_GETTOP && !$userInfo){
		$wpdb->query( "INSERT INTO $table (user_id,user_type,startTime,endTime) VALUES ('$user_id', '$type', NOW(),'$endTime')" );
	}else{
		if(time() > strtotime($userInfo->endTime)){
			$wpdb->query( "UPDATE $table SET user_type='$type', startTime=NOW(), endTime='$endTime' WHERE user_id='$user_id'" );
		}else{
			$endTime = strtotime($userInfo->endTime)+$period;
			$endTime = strftime('%Y-%m-%d %X',$endTime);
			$wpdb->query( "UPDATE $table SET user_type='$type', endTime='$endTime' WHERE user_id='$user_id'" );
		}
	}
	//email
	$vip=$wpdb->get_row("select * from ".$table." where user_id=".$user_id);
	$content = '<p>您已成功开通或续费了会员，以下为当前会员信息，如有任何疑问，请及时联系我们（Email:<a href="mailto:'.$admin_email.'" target="_blank">'.$admin_email.'</a>）。</p><div style="background-color:#fefcc9; padding:10px 15px; border:1px solid #f7dfa4; font-size: 12px;line-height:160%;">会员状态：'.output_order_vipType($vip->user_type).'<br>开通时间：'.$vip->startTime.'<br>到期时间：'.$vip->endTime.'</div>';
	$html = store_email_template_wrap($user_name,$content);
	if(empty($from)){$wp_email = 'no-reply@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME']));}else{$wp_email=$from;}
	$title='会员状态变更提醒';
	$fr = "From: \"" . $blogname . "\" <$wp_email>";
	$headers = "$fr\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
	wp_mail( $to, $title, $html, $headers );
}

//手动提升用户至VIP
function chenxing_manual_promotevip($user_id,$user_name,$to,$type=1,$endTime){
	date_default_timezone_set ('Asia/Shanghai');
	$admin_email = get_bloginfo ('admin_email');
	$blogname = get_bloginfo('name');
	global $wpdb;
	$prefix = $wpdb->prefix;
	$table = $prefix.'chenxing_vip_users';
	$userInfo=$wpdb->get_row("select * from ".$table." where user_id=".$user_id);
	if(!$userInfo){
		$wpdb->query( "INSERT INTO $table (user_id,user_type,startTime,endTime) VALUES ('$user_id', '$type', NOW(),'$endTime')" );
	}else{
		if(strtotime($endTime) > strtotime($userInfo->endTime) && time() > strtotime($userInfo->endTime)){
			$wpdb->query( "UPDATE $table SET user_type='$type', startTime=NOW(), endTime='$endTime' WHERE user_id='$user_id'" );
		}elseif(strtotime($endTime) > strtotime($userInfo->endTime) && time() <= strtotime($userInfo->endTime)){
			$wpdb->query( "UPDATE $table SET user_type='$type', endTime='$endTime' WHERE user_id='$user_id'" );
		}
	}
	//email
	$vip=$wpdb->get_row("select * from ".$table." where user_id=".$user_id);
	$content = '<p>系统管理员已为您成功开通或续费了会员，以下为当前会员信息，如有任何疑问，请及时联系我们（Email:<a href="mailto:'.$admin_email.'" target="_blank">'.$admin_email.'</a>）。</p><div style="background-color:#fefcc9; padding:10px 15px; border:1px solid #f7dfa4; font-size: 12px;line-height:160%;">会员状态：'.output_order_vipType($vip->user_type).'<br>开通时间：'.$vip->startTime.'<br>到期时间：'.$vip->endTime.'</div>';
	$html = store_email_template_wrap($user_name,$content);
	$wp_email = 'no-reply@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME']));
	$title='会员状态变更提醒';
	$fr = "From: \"" . $blogname . "\" <$wp_email>";
	$headers = "$fr\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
	wp_mail( $to, $title, $html, $headers );
}

//会员标识
function chenxing_member_icon($uid){
	$uid = (int)$uid;
	$type = getUserMemberType($uid);
	//0代表已过期 1代表月费会员 2代表季费会员 3代表年费会员 FALSE代表未开通过会员
	if($type===3)$icon = '<i class="ico annual_member"></i>';
	elseif($type===2)$icon = '<i class="ico quarter_member"></i>';
	elseif($type===1)$icon = '<i class="ico month_member"></i>';
	elseif($type===0)$icon = '<i class="ico expired_member"></i>';
	else $icon = '';
	return $icon;
}

?>>