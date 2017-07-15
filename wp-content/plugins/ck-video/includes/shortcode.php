<?php
//视频短代码   
function CK_Video_Next($atts, $content=null){
	if(!is_single()&&!is_page()) return'';//非文章页直接返回空白
	 $ckoption = get_option('ck_video_option');//获取选项   
	if($ckoption[neturl]==""){$neturl = content_url();}else{ $neturl = $ckoption[neturl]; };
    extract(shortcode_atts(array(   
          "vtype" => '视频源',   
          "url" => '视频ID',   
          "autonum" => '0', 
		  "subcn" => '',
		  "suben" => '',
		  "bar" => 'on',
		  "gjump" => '',
		  "gjumpe" => '',
		  "images" => '',
		  "lv" => '0'

    ), $atts)); 
		$url = strip_tags($url);
		if($ckoption[nextimages]=="1"){
		$class_video = new class_video;
		$videoinfo = call_user_func_array( array( $class_video, 'parse' ), array( trim($url) ) );
		$videotime = changeTimeType($videoinfo[time]);
		if(mb_strlen($videoinfo['title'], 'utf-8')>8 ){$downnextend = '...';}else{$downnextend = '';}
		if($videoinfo['title']){$smatext = mb_substr($videoinfo['title'],0,8,'utf-8').$downnextend ;}else{$smatext = $content;}
		if($videoinfo['title']){$bigtest = $videoinfo['title'];}else{$bigtest = $content;}
		if($videoinfo['img']['small']){$smaimages = $videoinfo['img']['small'];$bigimages = $videoinfo['img']['large'];}elseif($images){$smaimages = $images;}else{$smaimages = WP_PLUGIN_URL.'/ck-video/images/vimages.jpg';$bigimages = $videoinfo['img']['large'];}
		}
        if($ckoption[SubSwitch]=="0") {$subcn='';$suben='';}
         if(strpos($url,'youtube.com')){
		 $DWID = GetDMID($url,"http://www.youtube.com/watch?v=","");
		 return '
		 		<a href="javascript:void(0);" onclick=" ckadhide();DMwidth= getparent();ChinnerHTML(\'a1\',\'<iframe id=videoiframe scrolling=no align=middle frameborder=0 marginwidth=0 marginheight=0 src='.$neturl.'/plugins/ck-video/DM/DMvideoPlayer.php?v='.$DWID.'&mt=p&bg=FFFFFF&w=\'+DMwidth+\'&mode=yt ></iframe>\');this.style.color=\'#FF0000\';document.getElementById(\'videoiframe\').width=getparent();document.getElementById(\'videoiframe\').height=getparent()*0.75;">
				'. $content .'
				</a>
				';
		}elseif(strpos($url,'dailymotion.com')){
		 $DWID = GetDMID($url,"http://www.dailymotion.com/video/","");
		 return '
		 		<a href="javascript:void(0);" onclick=" ckadhide();DMwidth= getparent();ChinnerHTML(\'a1\',\'<iframe id=videoiframe scrolling=no align=middle frameborder=0 marginwidth=0 marginheight=0 src='.$neturl.'/plugins/ck-video/DM/DMvideoPlayer.php?v='.$DWID.'&mt=p&bg=FFFFFF&w=\'+DMwidth+\'&mode=dm ></iframe>\');this.style.color=\'#FF0000\';document.getElementById(\'videoiframe\').width=getparent();document.getElementById(\'videoiframe\').height=getparent()*0.75;">
				'. $content .'
				</a>
				';
		}elseif(strpos($url,'d2k://')||strpos($url,'agnet:?xt=')){
		 return '
		 <a href="http://btlubo.com/qq/play.php?bt='.$url.'" target="video">'. $content .'</a>
		 ';
		 }else{
		   $videourl = trim($url);
		   $Mobileurl = $neturl. '/plugins/ck-video/analy/mobile.php?url='.base64_encode(RemoveXSS($url)). '.m3u8';//getMobileurl($videourl);
		   $barrage = base64_encode($videourl);
		   $directext = array('flv','f4v','mp4','rmov');
		   $m3u8ext = array('m3u8','android','pad');
		   $videoext = get_extension($videourl);
		   if(in_array($videoext,$directext)){
		   $f = $videourl;
		   $s = '0';
		   $a = '';
		   $lv = RemoveXSS($lv);
		   $html5 = $videourl;
		   }elseif(in_array($videoext,$m3u8ext)){
		   $f = $neturl.'/plugins/ck-video/ckplayer/m3u8.swf';
		   $a = $videourl;
		   $s = '4';
		   $lv = RemoveXSS($lv);
		   $html5 = $videourl;
		   }else{
		   $f = getanaly($videourl,$ckoption);
		   $s = '2';
		   $lv = '';
		   $a = $videourl;
		   $html5 = $Mobileurl;
		   }
	   if($ckoption[nextimages]=="1"){
		return '
		<div class="video_box">
		<a href="javascript:void(0)" onclick="choice(\''.$f.'\',\''.$s.'\',\''.$lv.'\',\''.$a.'\',\''.$subcn.'\',\''.$suben.'\',\''.$barrage.'\',\''.$html5.'\');"><img src="'.$smaimages.'" title="'.$bigtest.'" alt="'.$bigtest.'" width="145" height="120" id=""><br><span class="font-13 font-bold">'.$smatext.'</span><br></a>
		<div align="center">
		</div>
		<div class="box_left">
		'.$videotime.'<br>
		</div>
		<div class="box_right">
		</div>
		<div class="clear"></div>
		</div>
		 ' ;
		 }else{
		if($content){
		$downnext = $content;
		$title = $content;
		}elseif($videoinfo['title']){
		if(mb_strlen($videoinfo['title'], 'utf-8')>10 ){$downnextend = '...';}else{$downnextend = '';}
		$downnext = mb_substr($videoinfo['title'],0,10,'utf-8').$downnextend ;
		$title = $videoinfo['title'];
		}else{
		$downnext = $content;
		$title = $content;
		}
		   return '
			<a href="javascript:void(0);" title = "'.$title.'" onclick="choice(\''.$f.'\',\''.$s.'\',\''.$lv.'\',\''.$a.'\',\''.$subcn.'\',\''.$suben.'\',\''.$barrage.'\',\''.$html5.'\'); this.style.color=\'#FF0000\'">
				'. $downnext . '
			</a>
			' ;   
		 }
		 }  
}

?>