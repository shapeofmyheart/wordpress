<?php
// 获取解析地址
function getanaly($url,$ckdata){
  $analyvideos = explode("||",$ckdata['analyvideos']);
  $analyapis = explode("||",$ckdata['analyapis']);
  $i = 0;
  $j = count($analyapis);
   if($ckdata[neturl]==""){$neturl = content_url();}else{ $neturl = $ckdata[neturl]; };
  $analyapis[$j] = '';

  foreach($analyvideos as $videos){
	 $analyvideo = explode(",",$videos);
	 foreach($analyvideo as $video){
       if($video!=""&&strpos($url,$video)){
	   $j=$i;
	   }
	 }
      $i++;
   }
   $analyapi = $analyapis[$j];
	if(strpos($analyapi,'//')){
	$analy = $neturl.'/plugins/ck-video/analy/out.php?url='.base64_encode($url).'&api='.base64_encode($analyapi);
//	$analy = $analyapi.$url;
	$analyon = '1';
	}elseif($analyapi != ''){
	$analy = $neturl.'/plugins/ck-video/'.$analyapi.$url;
	$analyon = '1';
	}else{
	 $analyon = '0';
	 $analy = $url;
   }
$getanaly = array();
$getanaly[0] = $analy;
$getanaly[1] = $analyon;

return $getanaly;
}
function getmanaly($url,$ckdata){
  $manalyvideos = explode("||",$ckdata['manalyvideos']);
  $manalyapis = explode("||",$ckdata['manalyapis']);
  $i = 0;
  $j = count($manalyapis);
   if($ckdata[neturl]==""){$neturl = content_url();}else{ $neturl = $ckdata[neturl]; };
  $manalyapis[$j] = '';

  foreach($manalyvideos as $mvideos){
	 $manalyvideo = explode(",",$mvideos);
	 foreach($manalyvideo as $mvideo){
       if($mvideo!=""&&strpos($url,$mvideo)){
	   $j=$i;
	   }
	 }
      $i++;
   }
   $manalyapi = $manalyapis[$j];
	if(strpos($manalyapi,'//')){
	$manaly = $manalyapi.$url;//$neturl.'/plugins/ck-video/analy/mobile.php?url='.base64_encode(RemoveXSS($url)). '.m3u8';
	$manalyon = '1';
	}elseif($manalyapi != ''){
	$manaly = $neturl.'/plugins/ck-video/'.$manalyapi.$url;
	$manalyon = '1';
	}else{
	 $manalyon = '0';
	 $manaly = $url;
   }
$getmanaly = array();
$getmanaly[0] = $manaly;
$getmanaly[1] = $manalyon;

return $getmanaly;
}

//删除特殊字符
function Deleterl($str) 
{ 
$str = trim($str); 
$str = strip_tags($str,""); 
$str = ereg_replace("\t","",$str); 
$str = ereg_replace("\r\n","",$str); 
$str = ereg_replace("\r","",$str); 
$str = ereg_replace("\n","",$str); 
$str = ereg_replace(" "," ",$str); 
return $str; 
}




//解码
function unescape($str) {  
    $ret = ''; 
    $len = strlen ( $str );  
    for($i = 0; $i < $len; $i ++) {  
        if ($str [$i] == '%' && $str [$i + 1] == 'u') {  
            $val = hexdec ( substr ( $str, $i + 2, 4 ) );  
            if ($val < 0x7f)  
                $ret .= chr ( $val );  
            else if ($val < 0x800)  
                $ret .= chr ( 0xc0 | ($val >> 6) ) . chr ( 0x80 | ($val & 0x3f) );  
            else  
                $ret .= chr ( 0xe0 | ($val >> 12) ) . chr ( 0x80 | (($val >> 6) & 0x3f) ) . chr ( 0x80 | ($val & 0x3f) );  
            $i += 5;  
        } else if ($str [$i] == '%') {  
            $ret .= urldecode ( substr ( $str, $i, 3 ) );  
            $i += 2;  
        } else  
            $ret .= $str [$i];  
    }  
    return $ret;  
}
//判断来路
function get_referer(){
$url = $_SERVER["HTTP_REFERER"]; 
$str = str_replace("http://","",$url); 
$strdomain = explode("/",$str); 
$domain = $strdomain[0]; 
return $domain;
}
//解码
function decrypt($data, $key) 
{ 
    $key = md5($key); 
    $x = 0; 
    $data = base64_decode($data); 
    $len = strlen($data); 
    $l = strlen($key); 
	$char   =   "";
	$str    =   "";
    for ($i = 0; $i < $len; $i++) 
    { 
        if ($x == $l)  
        { 
            $x = 0; 
        } 
        $char .= substr($key, $x, 1); 
        $x++; 
    } 
    for ($i = 0; $i < $len; $i++) 
    { 
        if (ord(substr($data, $i, 1)) < ord(substr($char, $i, 1))) 
        { 
            $str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1))); 
        } 
        else 
        { 
            $str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1))); 
        } 
    } 
    return $str; 
}
//xss跨站脚本漏洞过滤
/**
@par $val 字符串参数，可能包含恶意的脚本代码如<script language="javascript">alert("hello world");</script>
* @return  处理后的字符串
**/
function RemoveXSS($val) {
   $val = preg_replace('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '', $val);  
   $search = 'abcdefghijklmnopqrstuvwxyz'; 
   $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';  
   $search .= '1234567890!@#$%^&*()'; 
   $search .= '~`";:?+/={}[]-_|\'\\'; 
   for ($i = 0; $i < strlen($search); $i++) { 
      // ;? matches the ;, which is optional 
      // 0{0,7} matches any padded zeros, which are optional and go up to 8 chars 
 
      // @ @ search for the hex values 
      $val = preg_replace('/(&#[xX]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val); // with a ; 
      // @ @ 0{0,7} matches '0' zero to seven times  
      $val = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $val); // with a ; 
   } 
 
   // now the only remaining whitespace attacks are \t, \n, and \r 
   $ra1 = Array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'bgsound', 'title', 'base'); 
   $ra2 = Array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload'); 
   $ra = array_merge($ra1, $ra2); 
 
   $found = true; // keep replacing as long as the previous round replaced something 
   while ($found == true) { 
      $val_before = $val; 
      for ($i = 0; $i < sizeof($ra); $i++) { 
         $pattern = '/'; 
         for ($j = 0; $j < strlen($ra[$i]); $j++) { 
            if ($j > 0) { 
               $pattern .= '(';  
               $pattern .= '(&#[xX]0{0,8}([9ab]);)'; 
               $pattern .= '|';  
               $pattern .= '|(&#0{0,8}([9|10|13]);)'; 
               $pattern .= ')*'; 
            } 
            $pattern .= $ra[$i][$j]; 
         } 
         $pattern .= '/i';  
         $replacement = substr($ra[$i], 0, 2).'<x>'.substr($ra[$i], 2); // add in <> to nerf the tag  
         $val = preg_replace($pattern, $replacement, $val); // filter out the hex tags  
         if ($val_before == $val) {  
            // no replacements were made, so exit the loop  
            $found = false;  
         }  
      }  
   }  
   return $val;  
}
//获取文章扩展名
function get_extension($file)
{
return pathinfo($file, PATHINFO_EXTENSION);
}
//获取youtube视频ID

function GetDMID($str,$start,$end){
	$wd2='';
	if($str && $start){
		$arr=explode($start,$str);
		if(count($arr)>1){
			$wd=$arr[1];
			if($end){
				$arr2=explode($end,$wd);
				if(count($arr2)>1){
					$wd2=$arr2[0];
				}
				else{
					$wd2=$wd;
				}
			}
			else{
				$wd2=$wd;
			}
		}
	}
	return $wd2;
}
//改变时间秒为时分秒
function changeTimeType($seconds){
	if ($seconds>3600){
		$hours = intval($seconds/3600);
		$minutes = $seconds600;
		$time = $hours.":".gmstrftime('%M:%S', $minutes);
	}else{
		$time = gmstrftime('%H:%M:%S', $seconds);
	}
return $time;
}
//获取插件版本
function getVersion(){
	if ( !function_exists('get_plugin_data') ){
		require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
	}
	$plugin_data = get_plugin_data(CKVIDEO_ROOT.'/ck-video.php');
    return $plugin_data['Version'];
	
}
//s换为年月日时
function Sec2Time($time){ 
  if(is_numeric($time)){ 
    $value = array( 
      "years" => 0, "days" => 0, "hours" => 0, 
      "minutes" => 0, "seconds" => 0, 
    ); 
    if($time >= 31556926){ 
      $value["years"] = floor($time/31556926); 
      $time = ($time%31556926); 
    } 
    if($time >= 86400){ 
      $value["days"] = floor($time/86400); 
      $time = ($time%86400); 
    } 
    if($time >= 3600){ 
      $value["hours"] = floor($time/3600); 
      $time = ($time%3600); 
    } 
    if($time >= 60){ 
      $value["minutes"] = floor($time/60); 
      $time = ($time%60); 
    } 
    $value["seconds"] = floor($time); 
    return (array) $value; 
  }else{ 
    return (bool) FALSE; 
  } 
}
//随机数
function getRandChar($length){
   $str = null;
   $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
   $max = strlen($strPol)-1;

   for($i=0;$i<$length;$i++){
    $str.=$strPol[rand(0,$max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
   }

   return $str;
  }
?>