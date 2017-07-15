<?php
$insert_order = '';
require($_SERVER["DOCUMENT_ROOT"].'/wp-load.php');
$cx_alipay = get_option('ashu_alipay_code');
if (!wp_verify_nonce( $_POST['alipayNonce'],'alipay-nonce')){
	$msg = '安全认证失败，请重试！';
}elseif(is_user_logged_in()){
	if($_POST['order_id'] == 0){
		$money = ($_POST['alipay-money']) ?intval($_POST['alipay-money']):0;
		//$money = $_POST['alipay-money'];
		if($_POST['alipay_product_id'] == -4 && $money>0){
			$user_info = wp_get_current_user();
			$uid = $user_info->ID;
			$user_name=$user_info->display_name;
			$user_email = $user_info->user_email;
			$create_int = intval($cx_alipay['alipay_create_int']);
			$insert = insert_order(-4,'充值'.intval($money*$create_int).'积分',$money,1,$money,1,'',$uid,$user_name,$user_email,'','','','','');
			if($insert){
				global $wpdb;
				$prefix = $wpdb->prefix;
				$table = $prefix.'chenxing_orders';
				$insert_order = $wpdb->get_row( "SELECT * FROM $table WHERE order_id = '$insert'", ARRAY_A );
			}else{
					$msg = '订单创建错误！';
			}
			
		}else{
			$msg = '表单提交错误，请核实后重新提交！';
		}
	}elseif($_POST['order_id']){
		$insert = ($_POST['order_id'])?$_POST['order_id']:'';
		if($insert){
			global $wpdb;
			$prefix = $wpdb->prefix;
			$table = $prefix.'chenxing_orders';
			$insert_order = $wpdb->get_row( "SELECT * FROM $table WHERE order_id = '$insert'", ARRAY_A );
		}else{
			$msg = '未找到订单！';
		}
	}
	
}else{	
	$msg = '请先登录！';
}
if($msg){
	wp_die($msg);
}elseif($insert_order && is_array($insert_order)){
	$alipay_order = $insert_order;
}else{
	wp_die('未知错误！');
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>支付宝即时到账交易接口接口</title>
</head>
<?php
$cx_alipay = get_option('ashu_alipay_code');
if($cx_alipay && $cx_alipay['alipay_jiekou'] == 'alipay'){
	require_once("alipay.config.php");
	require_once("lib/alipay_submit.class.php");

	/**************************请求参数**************************/
	$out_trade_no = $alipay_order['order_id'];
	$subject = $alipay_order['product_name'];
	$total_fee = $alipay_order['order_total_price'];
	$body = $alipay_order['product_name'];

	/************************************************************/

	//构造要请求的参数数组，无需改动
	$parameter = array(
			"service"       => $alipay_config['service'],
			"partner"       => $alipay_config['partner'],
			"seller_id"  => $alipay_config['seller_id'],
			"payment_type"	=> $alipay_config['payment_type'],
			"notify_url"	=> $alipay_config['notify_url'],
			"return_url"	=> $alipay_config['return_url'],		
			"anti_phishing_key"=>$alipay_config['anti_phishing_key'],
			"exter_invoke_ip"=>$alipay_config['exter_invoke_ip'],
			"out_trade_no"	=> $out_trade_no,
			"subject"	=> $subject,
			"total_fee"	=> $total_fee,
			"body"	=> $body,
			"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))		
	);

	//建立请求
	$alipaySubmit = new AlipaySubmit($alipay_config);
	$html_text = $alipaySubmit->buildRequestForm($parameter,"post", "确认");
	echo $html_text;
}
?>
</body>
</html>