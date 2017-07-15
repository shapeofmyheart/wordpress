<?php

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
	if($ckdata['DomainSwitch']=="0"){
		echo <<< EOF
<?xml version="1.0" encoding="utf-8"?>
	<Notice>本解析为ck-video专用解析，请开启域名过滤后使用，否则禁止使用</Notice>
EOF;
	}else{
		$mobile = $_GET["url"];
		$mobile = str_replace('.m3u8','',$mobile);
		$directext = array('flv','f4v','mp4','rmov');
		$m3u8ext = array('m3u8','android','pad');
		$mobile = base64_decode($mobile);
		if(in_array(get_extension($mobile),$m3u8ext)||in_array(get_extension($mobile),$m3u8ext)){
//			Header("Location: ".$mobile);
			echo $mobile;
		}else{
			//Header("Location: ".getMobileurl($mobile));
			echo getMobileurl($mobile);
			//	Header("Location: http://movie.ks.js.cn/flv/other/1_0.mp4");
			//	Header("Location: http://yatv.tv/tvstm/yaan06.m3u8");
			exit;
		}
	}
}else{
	header("Content-type: text/xml");
	echo <<< EOF
<?xml version="1.0" encoding="utf-8"?>
	<Notice>非法引用！您地址为http://$ckreferer 该地址未被添加到可引用白名单，请联系管理员添加。该地址未被添加到可引用白名单，请联系管理员添加。</Notice>
EOF;
}
//获取html5播放地址
/* 老版
function getMobileurl($url){
	$ckdata = get_option('ck_video_option');
	      $burl=base64_encode($url);
		  $opts = array(
						'http'=>array(
							'method'=>"GET",
							'header'=>"User-Agent: {$_SERVER['HTTP_USER_AGENT']}\r\nX-Forwarded-For: {$_SERVER['REMOTE_ADDR']}\r\n"
							)
						);
		  $context = stream_context_create($opts);
		  $content = file_get_contents('http://api.flvxz.com/token/'.$ckdata['fltoken'].'/url/'.strtr(base64_encode(preg_replace('/^(https?:)\/\//','$1##',$url)),'+/','-_').'/xmlformat/ckxml/ftype/mp4.m3u8/header/all/mp/0', false, $context);
		  if(preg_match_all('/CDATA\[http:(.[^\]\]]+)]]>/', $content , $matches)){
          	  for ($i=0; $i< count($matches[1]); $i++) {
			    if(count($matches[1])==1){
				$Mobileurl = $Mobileurl.$matches[1][$i];
				}elseif($i==count($matches[1])-1){
				$Mobileurl = $Mobileurl.$matches[1][$i];
				}else{
				$Mobileurl = $Mobileurl.$matches[1][$i].",";
				}
	          }
	        return $Mobileurl;
			}else{return "http://movie.ks.js.cn/flv/other/1_0.mp4";}
}
*/
function getMobileurl($url){
	$ckdata = get_option('ck_video_option');
	$post_data=array ("reurl" => $_SERVER['HTTP_HOST'],"CkLicense" => $ckdata['CkLicense'],"fltoken" => $ckdata['fltoken'],"password" => "Submit");
	$content = get_curl_contents('http://www.ouryq.com/ck-video/analy/mobile.php?url='.$url,0,0,0,$post_data);
	if(preg_match_all('/CDATA\[http:(.[^\]\]]+)]]>/', $content , $matches)){
		for ($i=0; $i< count($matches[1]); $i++) {
			if(count($matches[1])==1){
				$Mobileurl = $Mobileurl.$matches[1][$i];
			}elseif($i==count($matches[1])-1){
				$Mobileurl = $Mobileurl.$matches[1][$i];
			}else{
				$Mobileurl = $Mobileurl.$matches[1][$i].",";
			}
		}
	return $Mobileurl;
	}else{
		return "http://movie.ks.js.cn/flv/other/1_0.mp4";
	}
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


?>