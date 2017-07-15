<?php
/* *
 * 配置文件
 * 版本：3.4
 * 修改日期：2016-03-08
 */
 
$cx_alipay_config 				= get_option('ashu_alipay_code');
$alipay_config['partner']		= $cx_alipay_config['alipay_pid'];
$alipay_config['seller_id']		= $alipay_config['partner'];
$alipay_config['key']			= $cx_alipay_config['alipay_md5'];
$alipay_config['notify_url'] 	= CX_JUEDUI_URL.'/inc/alipay-sdk/notify_url.php';
$alipay_config['return_url'] 	= CX_JUEDUI_URL.'/inc/alipay-sdk/return_url.php';
$alipay_config['sign_type']   	= strtoupper('MD5');
$alipay_config['input_charset']	= strtolower('utf-8');
$alipay_config['cacert']    	= getcwd().'\\cacert.pem';
$alipay_config['transport']    	= 'http';
$alipay_config['payment_type']	= "1";
$alipay_config['service'] 		= "create_direct_pay_by_user";

//↑↑↑↑↑↑↑↑↑↑请在这里配置您的基本信息↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑


//↓↓↓↓↓↓↓↓↓↓ 请在这里配置防钓鱼信息，如果没开通防钓鱼功能，为空即可 ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
	
// 防钓鱼时间戳  若要使用请调用类文件submit中的query_timestamp函数
$alipay_config['anti_phishing_key'] = "";
	
// 客户端的IP地址 非局域网的外网IP地址，如：221.0.0.1
$alipay_config['exter_invoke_ip'] = "";
		
//↑↑↑↑↑↑↑↑↑↑请在这里配置防钓鱼信息，如果没开通防钓鱼功能，为空即可 ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑

?>