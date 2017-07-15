<?php
header("Content-type: text/xml");
$wpconfig = realpath("../../../../wp-config.php");
if (!file_exists($wpconfig))  {
	echo "Could not found wp-config.php. Error in path :\n\n".$wpconfig ;	
	die;	
}
require_once($wpconfig);
$ckdata = get_option('ck_video_option');



$WhiteList = explode("||",$ckdata['WhiteList']);
$BlackList = explode("||",$ckdata['BlackList']);
$ckreferer = get_referer();
if(($ckdata['DomainSwitch']=="1"&&in_array($ckreferer,$WhiteList))||($ckdata['DomainSwitch']=="2"&&!in_array($ckreferer,$BlackList))||$ckdata['DomainSwitch']=="0"){

$url = base64_decode($_GET["url"]);
$analyapi = base64_decode($_GET["api"]);
$opts = array(
	'http'=>array(
		'method'=>"GET",
		'header'=>"User-Agent: {$_SERVER['HTTP_USER_AGENT']}\r\nX-Forwarded-For: {$_SERVER['REMOTE_ADDR']}\r\n"
	)
);
$context = stream_context_create($opts);
$content = file_get_contents($analyapi.$url, false, $context);
if(!Judge_Analy_Succeed($content)){
$post_data=array ("reurl" => $_SERVER['HTTP_HOST'],"CkLicense" => $ckdata['CkLicense'],"fltoken" => $ckdata['fltoken'],"password" => "Submit");
$content = get_curl_contents($analyapi.$url,0,0,0,$post_data);
}
if(!Judge_Analy_Succeed($content)){
$post_data=array ("reurl" => $_SERVER['HTTP_HOST'],"CkLicense" => $ckdata['CkLicense'],"fltoken" => $ckdata['fltoken'],"password" => "Submit");
$content = get_curl_contents('http://analy.qiuxinjiang.cn/?url='.$url,0,0,0,$post_data);
}
echo $content;

}else{
echo <<< EOF
<?xml version="1.0" encoding="utf-8"?>
	<Notice>非法引用！您地址为http://$ckreferer 该地址未被添加到可引用白名单，请联系管理员添加。该地址未被添加到可引用白名单，请联系管理员添加。</Notice>
EOF;
		}

function get_curl_contents($url,$header=0,$nobody=0,$ipopen=0,$post_data){
		if(!function_exists('curl_init')) die('php.ini未开启php_curl.dll');
		$c = curl_init();
		curl_setopt($c, CURLOPT_URL, $url);
		curl_setopt($c, CURLOPT_HEADER, $header);
		curl_setopt($c, CURLOPT_NOBODY, $nobody);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($c, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
		curl_setopt($c, CURLOPT_POST, 1);
		curl_setopt($c, CURLOPT_POSTFIELDS, $post_data);
		$ipopen==0&&curl_setopt($c, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:'.$_SERVER["REMOTE_ADDR"], 'CLIENT-IP:'.$_SERVER["REMOTE_ADDR"]));
		$content = curl_exec($c);

		curl_close($c);
	return $content;
}
function Judge_Analy_Succeed($content){
	if(preg_match_all('/CDATA\[http:(.[^\]\]]+)]]>/', $content , $matches)){
	/*弱化判断
			foreach($matches[1] as $match){
                if(strpos($match,'flv')||strpos($match,'mp4')||strpos($match,'f4v')){
					return true;
               }
               }
			return false;
	强化时需删除下面一行*/
	return true;
	}else{return false;}
}
 ?>