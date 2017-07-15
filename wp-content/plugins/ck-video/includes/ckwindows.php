<?php
			include(CKVIDEO_ROOT.'/includes/ad.php');
			include(CKVIDEO_ROOT.'/includes/str.php');
//			include_once(CKVIDEO_ROOT.'/includes/login.php');
			include_once(CKVIDEO_ROOT.'/includes/ckvideojscss.php');
			include_once(CKVIDEO_ROOT.'/includes/ckjm.php');
			include(CKVIDEO_ROOT.'/includes/str.php');
			include(CKVIDEO_ROOT.'/includes/videoarr.php');
			if($ckoption[loggedadvp]==0&&is_user_logged_in()){}else{$d = $ckoption[adpau];}
			$u = $ckoption[adpauurl];
			if(($ckoption[loggedadv]==0&&is_user_logged_in())||$ckoption[qzkaiguan]==0){}else{$l = $ckoption[adpre];}
			$r = $ckoption[adpreurl];
			$t = $ckoption[adpretime];
			$z = $ckoption[adbuffer];
			$e = $ckoption[motion];
			$v = $ckoption[volume];
			$p = $ckoption[ckpause];
			$g = RemoveXSS($gjump);
			$j = -RemoveXSS($gjumpe);
			$subtitle_cn = RemoveXSS($subcn);
			$subtitle_en = RemoveXSS($suben);
			if($ckoption[barrage_set]==1){$barrage = base64_encode(RemoveXSS($url));}else{$barrage = '';}
			$ckvideo .= '<div Name="video" id="video" class="video">';
			if($ckoption[choice]=='black'){$ckvideo .= '<div id="diranaly'.$videonum.'" class="diranaly"><a onclick="DirectAnaly(\''.$videonum.'\')">官方<</a> | 切换 | <a onclick="_neturl=ckdata[\'neturl\'];_videonum = \''.$videonum.'\';choice(farr'.$videonum.'[_n],sarr'.$videonum.'[_n],lvarr'.$videonum.'[_n],aarr'.$videonum.'[_n],\''.$subcn.'\',\''.$suben.'\',bararr'.$videonum.'[_n],html5arr'.$videonum.'[_n],_n)">>解析</a></div>';}
			$ckvideo .= '<div class="daojs" id="daojs'.$videonum.'"><span class="daojst" id="djstext'.$videonum.'"></span><span class="daojst" id="djstime'.$videonum.'" style="color:#FFDD00"></span><span class="daojst" id="djsm'.$videonum.'"></span></div>';
			$ckvideo .= $ad;
			$ckvideo = $ckvideo .'<div id="a'.$videonum.'" class="videoa" style=""></div>';
			$ckvideo .= '</div>';
			$ckvideo .= '<p style="text-align: center;"></p>'.PHP_EOL;
			$ckvideo .= '<script language="javascript">'.PHP_EOL;
			$ckvideo .= 'function settime'.$videonum.'(){//前置广告倒计时
var nowT=parseFloat(CKobject._K_("djstime'.$videonum.'").innerHTML);
if(nowT>0){
	frontTime=true;
	CKobject._K_("djstime'.$videonum.'").innerHTML=nowT-1;
	setTimeout("settime'.$videonum.'()",1000);
	if(nowT<ckdata["logpretime"]-5){CKobject.getObjectById("ckplayer_a'.$videonum.'").videoPause();}
	document.getElementById("advp'.$videonum.'").style.display="black"; 
}else{
	frontTime=false;
	CKobject._K_("djstext'.$videonum.'").innerHTML="";
	CKobject._K_("djstime'.$videonum.'").innerHTML="";
	CKobject._K_("djsm'.$videonum.'").innerHTML="";
//	document.getElementById("advp'.$videonum.'").style.display="none"; 
	if(_autoplay=="1")CKobject.getObjectById("ckplayer_a'.$videonum.'").videoPlay();
}
}'.PHP_EOL;
			$ckvideo .= 'function setTimeend'.$videonum.'(){//后置广告倒计时
var nowT=parseFloat(CKobject._K_("djstime'.$videonum.'").innerHTML);
if(nowT>0){
	frontTime=true;
	CKobject._K_("djstime'.$videonum.'").innerHTML=nowT-1;
	setTimeout("setTimeend'.$videonum.'()",1000);
	CKobject.getObjectById("ckplayer_a'.$videonum.'").videoPause();
}else{
	frontTime=false;
	CKobject._K_("djstext'.$videonum.'").innerHTML="";
	CKobject._K_("djstime'.$videonum.'").innerHTML="";
	CKobject._K_("djsm'.$videonum.'").innerHTML="";
	_n++;
	if(_n == farr'.$videonum.'.length){_n=0;};
	choice(farr'.$videonum.'[_n],sarr'.$videonum.'[_n],lvarr'.$videonum.'[_n],aarr'.$videonum.'[_n],\''.$subcn.'\',\''.$suben.'\',bararr'.$videonum.'[_n],html5arr'.$videonum.'[_n],_n);
}
}'.PHP_EOL;
			$ckvideo .= 'function loadedHandler'.$videonum.'(){
if(!CKobject.getObjectById("ckplayer_a'.$videonum.'").getType()){
//	CKobject.getObjectById("ckplayer_a'.$videonum.'").addListener("myObjectChange","myObjectChange"); 
	CKobject.getObjectById("ckplayer_a'.$videonum.'").addListener("play","playHandler(\''.$videonum.'\')");
	CKobject.getObjectById("ckplayer_a'.$videonum.'").addListener("pause","pausedHandler(\''.$videonum.'\')");
	CKobject.getObjectById("ckplayer_a'.$videonum.'").addListener("ended","playerstop(\''.$videonum.'\')");
	CKobject.getObjectById("ckplayer_a'.$videonum.'").addListener("error","errorHandler(\''.$videonum.'\')");
	CKobject.getObjectById("ckplayer_a'.$videonum.'").addListener("sendNetStream","okHandler(\''.$videonum.'\')");
}else{
	CKobject.getObjectById("ckplayer_a'.$videonum.'").addListener("play",playHandler(\''.$videonum.'\'));
	CKobject.getObjectById("ckplayer_a'.$videonum.'").addListener("paused",pausedHandler(\''.$videonum.'\'));
	CKobject.getObjectById("ckplayer_a'.$videonum.'").addListener("error",errorHandler(\''.$videonum.'\'));
	CKobject.getObjectById("ckplayer_a'.$videonum.'").addListener("sendNetStream",okHandler(\''.$videonum.'\'));
}
var barname = new Array();
barname["'.$videonum.'"] = bararr'.$videonum.' ;
loadedHandler("'.$videonum.'",_n,barname);
sethtml5ad("'.$videonum.'");
}'.PHP_EOL;
			$ckvideo .= '_videonum=\''.$videonum.'\';';
			$ckvideo .= 'ckvplay(farr'.$videonum.'[0],sarr'.$videonum.'[0],ckdata["neturl"],lvarr'.$videonum.'[0],aarr'.$videonum.'[0],html5arr'.$videonum.'[0],analyonarr'.$videonum.'[0],\''.$d.'\',\''.$u.'\',\''.$l.'\',\''.$r.'\',\''.$t.'\',\''.$z.'\',\''.$e.'\',\''.$v.'\',\''.$p.'\',\''.$g.'\',\''.$j.'\',\''.$subcn.'\',\''.$suben.'\',\''.$barrage.'\',\''.$width.'\',\''.$height.'\');';
			$ckvideo .= '</script>';
?>	