<?php
require($_SERVER["DOCUMENT_ROOT"].'/wp-load.php');
/* * 
 * 功能：支付宝页面跳转同步通知页面
 * 版本：3.3
 * 日期：2012-07-23
 */

require_once("alipay.config.php");
require_once("lib/alipay_notify.class.php");
?>
<!DOCTYPE HTML>
<html>
    <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
//计算得出通知验证结果
$alipayNotify = new AlipayNotify($alipay_config);
$verify_result = $alipayNotify->verifyReturn();
if($verify_result) {//验证成功
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$out_trade_no = $_GET['out_trade_no'];
	$trade_no = $_GET['trade_no'];
	$trade_status = $_GET['trade_status'];
	$buyer_alipay = $_GET['buyer_email'];

    if($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
		global $wpdb;
		$prefix = $wpdb->prefix;
		$table = $prefix.'chenxing_orders';
		$email = '';
		$insert_order = $wpdb->get_row( "SELECT * FROM $table WHERE order_id = '$out_trade_no'", ARRAY_A );
		if($insert_order){
			if($insert_order['order_status'] == 1){
				$success_time = $_GET['notify_time'];
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
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else {
    wp_die('错误的请求！如果您已经完成付款，请联系管理员!');
}
?>

        <title>支付宝支付结果</title>
		<style type="text/css">
            .font_title{
                font-family:"Microsoft Yahei",微软雅黑;
                font-size:16px;
                color:#000;
                font-weight:bold;
            }
            .font_content{
                font-family:"Microsoft Yahei",微软雅黑;
                font-size:13px;
                color:#888;
                font-weight:normal;
            }
            table{
                border: 0 solid #CCCCCC;
            }
        </style>
	</head>
    <body>
		<table align="center" width="350" cellpadding="5" cellspacing="0">
            <tr>
                <td align="center" class="font_title" colspan="2">恭喜，支付成功!</td>
            </tr>
            <tr>
                <td class="font_content" align="left">支付金额:<?php echo $_GET['total_fee'].' 元'; ?>
                	订单交易成功，如有异常请联系管理员
                </td>
            </tr>
			<tr>
                <td class="font_content" align="center">
	                <a href="<?php echo chenxing_get_user_url( 'credit', $insert_order['user_id'] ); ?>" title="返回积分管理页面">
	                	<button style="cursor:pointer;">返回积分管理页面</button>
	                </a>
                </td>
            </tr>
        </table>
    </body>
</html>