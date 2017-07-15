<?php
function getvideoid($url){
	$data['status'] = 0;
	if(strpos($url,'youku.com')){
		$data['type'] = 'youku';
		if(strpos($url,'html')){
			$data['id']=inter($url,'id_','.html');
		}
		elseif(strpos($url,'swf')){
			$data['id']=inter($url,'/sid/','/');
		}else{
			urldebug($url);
		}
	}elseif(strpos($url,'qq.com')){
		$data['type'] = 'qq';
		if(strpos($url,'vid=')){
			$data['id']=inter($url,'vid=','');
		}
		else{
			$arr = explode("/",$url);
			$data['id']=str_replace('.html','',$arr[count($arr)-1]);
		}
	}elseif(strpos($url,'bilibili.com')){
		$data['type'] = 'bili';
		$data['id']=inter($url,'av','/');
	}elseif(strpos($url,'tudou.com')||strpos($url,'tudouui.com')){
		$data['type'] = 'tudou';
		$data['id']='';
		if(strpos($url,'swf')){
			$wd=inter($url,'iid=','/');
			if(strpos($wd,'swf')){
				$wd=inter($url,'iid=','&');
			}
			$data['id'] = $wd;
		}
		if(!$data['id']){
			$content=get_curl_contents($url);
			$wd=inter($content,'vcode:"','"');
			if(!$wd){
				$wd=inter($content,'vcode: \'','\'');	
			}
			if ($wd){
				$data['type'] = 'youku';
				$data['id'] = $wd;
			}else{
				$data['id'] = trim(inter($content,'iid:',','));
			}
		}
		if(!$data['id']){
			urldebug($url);
		}
	}elseif(strpos($url,'letv.com')){
		$data['type'] = 'letv';
		if(strpos($url,'swf')){
			$wd=inter($url,'swf?id=','&');
			$data['id'] = $wd;
		}else{
				$content=get_curl_contents($url);
				$wd=inter($content,'vid:',',');
				if($wd){
					$data['id'] = $wd;
				}elseif($wd == 0){
					$data['id']=inter($content,'vid=','&');
				}else{
					urldebug($url);
				}
		}
	}elseif(strpos($url,'56.com')){
		$data['type'] = '56';
		if(strpos($url,'v_')){
			$wd=inter($url,'v_','.');
		}elseif(strpos($url,'cpm_')){
			$wd=inter($url,'cpm_','.');
		}elseif(strpos($url,'vid-')){
			$wd=inter($url,'vid-','.');
		}elseif(strpos($url,'open_')){
			$wd=inter($url,'open_','.');
		}elseif(strpos($url,'redian/')){
			$wd=explode('redian/',$url);
			$wd2 = explode('/',$wd[1]);
			$wd = '';
			$wd = $wd2[0];
			if($wd2[1]){
				$wd = $wd2[1];
			}
		}
		if($wd){
			$data['id'] = $wd;
		}else{
			urldebug($url);
		}
	}elseif(strpos($url,'pan.baidu')||strpos($url,'yun.baidu')){
		$data['type'] = 'baidu';
		if(strpos($url,'shareid=')){
			list($add, $wd) = explode('link?',$url);
			strpos($url,'&shareid=') && list($uk, $id) = explode('&shareid=',$wd);
			strpos($url,'&uk=') && list($id, $uk) = explode('&uk=',$wd);
			$id=strtr($id,array("shareid=" => ""));
			$uk=strtr($uk,array("uk=" => ""));
			$wd = $id . '-' . $uk;
		}else{
			list($add, $wd) = explode('/s/',$url);
		}
		if($wd){
			$data['id'] = $wd;
		}else{
			urldebug($url);
		}
	}elseif(strpos($url,'ku6.com')){
		$data['type'] = 'ku6';
		if(strpos($url,'html')){
			$arr=explode('/',$url);
			$wd=$arr[count($arr)-1];
			$wd=str_replace('.html','',$wd);
		}elseif(strpos($url,'swf')){
			$arr=explode('/',$url);
			$wd=$arr[count($arr)-2];
		}else{
			urldebug($url);
		}
		if($wd){
			$data['id'] = $wd;
		}else{
			urldebug($url);
		}
	}else{
		$data['type'] = 'url';
		$data['id'] = $url;
	}
	return $data;
}
/*
*inter函数其实不怎么好用
*解析部分已经全部移除了
*但是视频id的获取这里暂时懒得重写就吧inter函数暂时丢这里了
*后面有时间会把这部分代码也重写一下的
*/
function inter($str,$start,$end){
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
function get_curl_contents($url,$header=0,$nobody=0,$ipopen=0){
		if(!function_exists('curl_init')) die('php.ini未开启php_curl.dll');
		$c = curl_init();
		curl_setopt($c, CURLOPT_URL, $url);
		curl_setopt($c, CURLOPT_HEADER, $header);
		curl_setopt($c, CURLOPT_NOBODY, $nobody);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($c, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
		$ipopen==0&&curl_setopt($c, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:'.$_SERVER["REMOTE_ADDR"], 'CLIENT-IP:'.$_SERVER["REMOTE_ADDR"]));
		$content = curl_exec($c);

		curl_close($c);
	return $content;
}
function urldebug($url,$off = false){//如果不希望往服务器回传数据，请自己把$off的值改为true
	$data['status'] = -1;
	$data['msg'] = '该地址不能正常解析，已经记录，会在最短的时间内解决该问题';
	$data['url'] = $url;
	if($off == false){
		$url= 'http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		$out = 'http://debug.flv.pw/urldebug.php?url='.base64_encode($url);
		if($out != '1'){
			$data['msg'] = '该地址不能正常解析，地址记录无法正常记入数据库';
		}
	}
	echo json_encode($data);
	die;
}
?>