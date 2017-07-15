<?php
function cklists($atts, $content=null){
	if(!is_single() && !is_page()) return'';//非文章页直接返回空白
	$ckoption = get_option('ck_video_option');//获取选项   
	if($ckoption[neturl]==""){$neturl = content_url();}else{ $neturl = $ckoption[neturl]; };
	extract(shortcode_atts(array(   
          "vtype" => '视频源',   
          "url" => '视频ID',   
          "autonum" => '0', 
		  "subcn" => '',
		  "suben" => '',
		  "gjump" => '',
		  "gjumpe" => '',
		  "images" => '',
		  "lv" => '0',
          "width" => '610', 
          "height" => '460',
          "wh" => '0.75',
		  "bar" => 'on'
    ), $atts)); 
	$urls = explode("||",$url);
	$images = explode("||",$images);
	$lvs = explode("||",$lv);
	$subcns = explode("||",$subcn);
	$subens = explode("||",$suben);
	$gjumps = explode("||",$gjump);
	$contents = explode("||",$content);
	$url = strip_tags($urls[0]);
	$videonum = getRandChar(6);
	$ckvideo = '';
	$CkLicense = '';
	$CkLicensenum50 = '';
	$Version = getVersion(); 
	if($ckoption[SubSwitch]=="0"){$subcn='';$suben='';}
	if(strpos($url,'youtube.com')){
		 $DWID = substr(GetDMID($url,"www.youtube.com/watch?v=","") , 0 , 11);
		 $ckvideo .= '
		 <script type="text/javascript" src="'.WP_PLUGIN_URL.'/ck-video/js/ck-video.js?v='.$Version.'" ></script>
		 <script type="text/javascript" src="'.WP_PLUGIN_URL.'/ck-video/ckplayer/ckplayer.js?v='.$Version.'" charset="utf-8"></script>
		 <link rel="stylesheet" href="'. WP_PLUGIN_URL.'/ck-video/css/video.css?v='.$Version.'" type="text/css">
		 <p style="text-align: center;">
		 <div Name="video" id="video">
		 <div id="a'.$videonum.'" style="z-index:5;position:relative;">
		 <iframe name="videoiframe" id="videoiframe"  allowtransparency="true" src="about:blank" width=0 height=0 framespacing="0" frameborder="no" scrolling="no" onload="document.getElementById(\'videoiframe\').width = getparent();document.getElementById(\'videoiframe\').height = getparent()*0.75;url=\''.$neturl.'/plugins/ck-video/DM/DMvideoPlayer.php?v='.$DWID.'&mt=p&bg=FFFFFF&w=\'+getparent()+\'&mode=yt\';if(document.getElementById(\'videoiframe\').src==\'about:blank\'){document.getElementById(\'videoiframe\').src = url;}"></iframe>
		 </div>
		 </div>
		 </p><p style="text-align: center;">
		 ';
	}elseif(strpos($url,'dailymotion.com')){
		 $DWID = GetDMID($url,"www.dailymotion.com/video/","");
		 $ckvideo .= '
		 <script type="text/javascript" src="'.WP_PLUGIN_URL.'/ck-video/js/ck-video.js?v='.$Version.'" ></script>
		 <script type="text/javascript" src="'.WP_PLUGIN_URL.'/ck-video/ckplayer/ckplayer.js?v='.$Version.'" charset="utf-8"></script>
		 <link rel="stylesheet" href="'. WP_PLUGIN_URL.'/ck-video/css/video.css?v='.$Version.'" type="text/css">
		 <p style="text-align: center;">
		 <div Name="video" id="video">
		 <div id="a'.$videonum.'" style="z-index:5;position:relative;">
		 <iframe name="videoiframe" id="videoiframe"  allowtransparency="true" src="about:blank" width=0 height=0 framespacing="0" frameborder="no" scrolling="no" onload="document.getElementById(\'videoiframe\').width = getparent();document.getElementById(\'videoiframe\').height = getparent()*0.75;url=\''.$neturl.'/plugins/ck-video/DM/DMvideoPlayer.php?v='.$DWID.'&mt=p&bg=FFFFFF&w=\'+getparent()+\'&mode=dm\';if(document.getElementById(\'videoiframe\').src==\'about:blank\'){document.getElementById(\'videoiframe\').src = url;}"></iframe>
		 </div>
		 </div>
		 </p><p style="text-align: center;">
		 ';
	}elseif(strpos($url,'d2k://')||strpos($url,'agnet:?xt=')){
		 $ckvideo .= '
		 <script type="text/javascript" src="'.WP_PLUGIN_URL.'/ck-video/js/ck-video.js?v='.$Version.'" ></script>
		 <script type="text/javascript" src="'.WP_PLUGIN_URL.'/ck-video/ckplayer/ckplayer.js?v='.$Version.'" charset="utf-8"></script>
		 <link rel="stylesheet" href="'. WP_PLUGIN_URL.'/ck-video/css/video.css?v='.$Version.'" type="text/css">
		 <p style="text-align: center;">
		 <div Name="video" id="video">
		 <div id="a'.$videonum.'" style="z-index:5;position:relative;">
		 <iframe name="video" id="video"  allowtransparency="true" src="http://btlubo.com/qq/play.php?bt='.$url.'" width=0 height=0 framespacing="0" frameborder="no" scrolling="no" onload="document.getElementById(\'videoiframe\').width = getparent();document.getElementById(\'videoiframe\').height = getparent()*0.75;"></iframe>
		 </div>
		 </div>
		 </p><p style="text-align: center;">
		 ';
	}else{
		include(CKVIDEO_ROOT.'/includes/ckwindows.php');
	}	
	$cklistscon ='';
	$n = 0;	//列表用
	if($urls[1]){
		foreach($urls as $url){
			if($contents[$n]==''){$contents[$n]=$n+1;}
			$url = strip_tags($url);
			if($ckoption[nextimages]=="1"){
				$class_video = new class_video;
				$videoinfo = call_user_func_array( array( $class_video, 'parse' ), array( trim($url) ) );
				$videotime = changeTimeType($videoinfo[time]);
				if($videoinfo['title']){$smatext = $videoinfo['title'];}else{$smatext = $contents[$n];}
				if($videoinfo['title']){$bigtest = $videoinfo['title'];}else{$bigtest = $contents[$n];}
				if($videoinfo['img']['small']){$smaimages = $videoinfo['img']['small'];$bigimages = $videoinfo['img']['large'];}elseif($images[$n]){$smaimages = $images[$n];}else{$smaimages = WP_PLUGIN_URL.'/ck-video/images/vimages.jpg';$bigimages = $videoinfo['img']['large'];}
			}
			if($ckoption[SubSwitch]=="0") {$subcn='';$suben='';}
			if(strpos($url,'youtube.com')){
				if($ckoption[nextimages]=="1"){
					$DWID = substr(GetDMID($url,"www.youtube.com/watch?v=","") , 0 , 11);
					$cklistscon = $cklistscon . '<div class="video_box">
	<a href="javascript:void(0)" onclick="DMwidth= getparent();ChinnerHTML(\'a'.$videonum.'\',\'<iframe id=videoiframe scrolling=no align=middle frameborder=0 marginwidth=0 marginheight=0 src='.$neturl.'/plugins/ck-video/DM/DMvideoPlayer.php?v='.$DWID.'&mt=p&bg=FFFFFF&w=\'+DMwidth+\'&mode=yt ></iframe>\');this.style.color=\'#FF0000\';document.getElementById(\'videoiframe\').width=getparent();document.getElementById(\'videoiframe\').height=getparent()*0.75;"><span class="ck_list_img"><img src="https://i.ytimg.com/vi/'.$DWID.'/mqdefault.jpg" title="'.$bigtest.'" alt="'.$bigtest.'" id=""></span><wp_nokeywordlink><span class="ck_list_title">'.$smatext.'</span></wp_nokeywordlink></a>
	<div align="center">
	</div>
	<div class="ck_box_left">
		'.$videotime.'<br>
	</div>
	<div class="ck_box_right">
	</div>
	<div class="clear"></div>
	</div>';
					$n++;
				}else{
				$DWID = substr(GetDMID($url,"www.youtube.com/watch?v=","") , 0 , 11);
				$cklistscon = $cklistscon . '<a href="javascript:void(0);" onclick="DMwidth= getparent();ChinnerHTML(\'a'.$videonum.'\',\'<iframe id=videoiframe scrolling=no align=middle frameborder=0 marginwidth=0 marginheight=0 src='.$neturl.'/plugins/ck-video/DM/DMvideoPlayer.php?v='.$DWID.'&mt=p&bg=FFFFFF&w=\'+DMwidth+\'&mode=yt ></iframe>\');this.style.color=\'#FF0000\';document.getElementById(\'videoiframe\').width=getparent();document.getElementById(\'videoiframe\').height=getparent()*0.75;">'. $contents[$n] .'</a>';
				$n++;
				}
			}elseif(strpos($url,'dailymotion.com')){
				if($ckoption[nextimages]=="1"){
					$DWID = GetDMID($url,"www.dailymotion.com/video/","");
					$cklistscon = $cklistscon . '<div class="video_box">
	<a href="javascript:void(0)" onclick="DMwidth= getparent();ChinnerHTML(\'a'.$videonum.'\',\'<iframe id=videoiframe scrolling=no align=middle frameborder=0 marginwidth=0 marginheight=0 src='.$neturl.'/plugins/ck-video/DM/DMvideoPlayer.php?v='.$DWID.'&mt=p&bg=FFFFFF&w=\'+DMwidth+\'&mode=dm ></iframe>\');this.style.color=\'#FF0000\';document.getElementById(\'videoiframe\').width=getparent();document.getElementById(\'videoiframe\').height=getparent()*0.75;"><span class="ck_list_img"><img src="'.$smaimages.'" title="'.$bigtest.'" alt="'.$bigtest.'" id=""></span><wp_nokeywordlink><span class="ck_list_title">'.$smatext.'</span></wp_nokeywordlink></a>
	<div align="center">
	</div>
	<div class="ck_box_left">
		'.$videotime.'<br>
	</div>
	<div class="ck_box_right">
	</div>
	<div class="clear"></div>
	</div>';
					$n++;
				}else{
				$DWID = GetDMID($url,"www.dailymotion.com/video/","");
				$cklistscon = $cklistscon . '<a href="javascript:void(0);" onclick="DMwidth= getparent();ChinnerHTML(\'a'.$videonum.'\',\'<iframe id=videoiframe scrolling=no align=middle frameborder=0 marginwidth=0 marginheight=0 src='.$neturl.'/plugins/ck-video/DM/DMvideoPlayer.php?v='.$DWID.'&mt=p&bg=FFFFFF&w=\'+DMwidth+\'&mode=dm ></iframe>\');this.style.color=\'#FF0000\';document.getElementById(\'videoiframe\').width=getparent();document.getElementById(\'videoiframe\').height=getparent()*0.75;">'. $contents[$n] .'</a>';
				$n++;
				}
			}elseif(strpos($url,'d2k://')||strpos($url,'agnet:?xt=')){
				$cklistscon = $cklistscon . '<a href="http://btlubo.com/qq/play.php?bt='.$url.'" target="video">'. $contents[$n] .'</a>';
				$n++;
			}else{
				if($ckoption[nextimages]=="1"){
					$cklistscon = $cklistscon . '<div class="video_box">
	<a href="javascript:void(0)" onclick="_videonum=\''.$videonum.'\';choice(farr'.$videonum.'['.$n.'],sarr'.$videonum.'['.$n.'],lvarr'.$videonum.'['.$n.'],aarr'.$videonum.'['.$n.'],\''.$subcn[$n].'\',\''.$suben[$n].'\',bararr'.$videonum.'['.$n.'],html5arr'.$videonum.'['.$n.'],\''.$n.'\');"><span class="ck_list_img"><img src="'.$smaimages.'" title="'.$bigtest.'" alt="'.$bigtest.'" id=""></span><wp_nokeywordlink><span class="ck_list_title">'.$smatext.'</span></wp_nokeywordlink></a>
	<div align="center">
	</div>
	<div class="ck_box_left">
		'.$videotime.'<br>
	</div>
	<div class="ck_box_right">
	</div>
	<div class="clear"></div>
	</div>';
					$n++;
				}else{
					if($contents[$n]){
						$downnext = $contents[$n];
						$title = $contents[$n];
					}elseif($videoinfo['title']){
						if(mb_strlen($videoinfo['title'], 'utf-8')>10 ){$downnextend = '...';}else{$downnextend = '';}
						$downnext = mb_substr($videoinfo['title'],0,10,'utf-8').$downnextend ;
						$title = $videoinfo['title'];
					}else{
						$downnext = $contents[$n];
						$title = $contents[$n];
					}
					$cklistscon = $cklistscon . '<a href="javascript:void(0);" title = "'.$title.'" onclick="_videonum=\''.$videonum.'\';choice(farr'.$videonum.'['.$n.'],sarr'.$videonum.'['.$n.'],\''.$lv.'\',aarr'.$videonum.'['.$n.'],\''.$subcn[$n].'\',\''.$suben[$n].'\',bararr'.$videonum.'['.$n.'],html5arr'.$videonum.'['.$n.'],\''.$n.'\'); this.style.color=\'#FF0000\'">'. $downnext . '</a>' ;  
					$n++;
				}
			}  
		}
	}
	return $ckvideo.'<div class="videolist">'.$cklistscon.'</div><p style="text-align: center;">&nbsp;</p>';
}
?>