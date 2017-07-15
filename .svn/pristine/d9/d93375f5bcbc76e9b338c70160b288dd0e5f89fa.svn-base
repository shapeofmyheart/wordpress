<?php
require($_SERVER["DOCUMENT_ROOT"].'/wp-load.php');
/* *
 * 功能：支付宝服务器异步通知页面
 * 版本：3.3
 * 日期：2012-07-23
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。


 *************************页面功能说明*************************
 * 创建该页面文件时，请留心该页面文件中无任何HTML代码及空格。
 * 该页面不能在本机电脑测试，请到服务器上做测试。请确保外部可以访问该页面。
 * 该页面调试工具请使用写文本函数logResult，该函数已被默认关闭，见alipay_notify_class.php中的函数verifyNotify
 * 如果没有收到该页面返回的 success 信息，支付宝会在24小时内按一定的时间策略重发通知
 */

require_once("alipay.config.php");
require_once("lib/alipay_notify.class.php");

//计算得出通知验证结果
$alipayNotify = new AlipayNotify($alipay_config);
$verify_result = $alipayNotify->verifyNotify();

if($verify_result) {//验证成功

	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$out_trade_no = $_POST['out_trade_no'];
	$trade_no = $_POST['trade_no'];
	$trade_status = $_POST['trade_status'];
	$buyer_alipay = $_POST['buyer_email'];

    if($_POST['trade_status'] == 'TRADE_FINISHED' || $_POST['trade_status'] == 'TRADE_SUCCESS') {
		global $wpdb;
		$prefix = $wpdb->prefix;
		$table = $prefix.'chenxing_orders';
		$email = '';
		$insert_order = $wpdb->get_row( "SELECT * FROM $table WHERE order_id = '$out_trade_no'", ARRAY_A );
		if($insert_order){
			if($insert_order['order_status'] == 1){
				$success_time = $_POST['notify_time'];
				if($wpdb->query( "UPDATE $table SET order_status=4, trade_no='$trade_no', order_success_time='$success_time', user_alipay='$buyer_alipay' WHERE order_id='$out_trade_no'" )){
					if($insert_order['product_id'] == -4){
                        $cx_alipay = get_option('ashu_alipay_code');
                        $create_int = intval($cx_alipay['alipay_create_int']);
                        $create = intval($insert_order['order_total_price']*$create_int);
                        add_user_credits_by_alipay(intval($create),$insert_order['user_id']);
                    }	
				}
			}

		}
    }
	//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
        
	echo "success";		//请不要修改或删除
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
    //验证失败
    echo "fail";

    //调试用，写文本函数记录程序运行情况是否正常
    //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
}
?>