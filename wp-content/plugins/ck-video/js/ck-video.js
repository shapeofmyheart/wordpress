//定义部分参数
var _n=0;//目前播放的视频的编号(在数组里的编号)
var frontTime=false;//前置广告倒计时是否在运行中
var frontHtime=false;//后置广告是否在进行中
var _subcn='';
var _suben='';
var _barrage='';
var _width='';
var _height=''
var _f='';
var _s='';
var _neturl='';
var _lv='';
var _a='';
var _Mobileurl='';
var _d='';
var _u='';
var _l='';
var _r='';
var _t='';
var _z='';
var _e='';
var _v='';
var _p='';
var _g='';
var _j='';
var _n='0';
var _videook = new Array();
var _videoext = new Array(".mp4",".flv");


function ckadhide(){
			_adobject = document.getElementsByName("ckad");
			for (x in _adobject){
			document.getElementById(_adobject[x].id).style.display='none';
			}
}
function ckadshow(){
			_adobject = document.getElementsByName("ckad");
			for (x in _adobject){
			document.getElementById(_adobject[x].id).style.display='none';
			}
}
function ChinnerHTML(divID,cHtml){
   document.getElementById(divID).innerHTML=cHtml;
}

function setCookie(c_name,value,expiretimes) {
    var exdate=new Date();
    exdate.setTime(exdate.getTime()+expiretimes*1000);
    document.cookie=c_name+ "=" +escape(value)+
    ((expiretimes==null) ? "" : ";expires="+exdate.toGMTString())+";path=/";
   }
function getCookie(c_name) {
    if (document.cookie.length>0)
    {
     c_start=document.cookie.indexOf(c_name + "=");
     if (c_start!=-1)
     { 
      c_start=c_start + c_name.length+1 ;
      c_end=document.cookie.indexOf(";",c_start);
      if (c_end==-1) c_end=document.cookie.length;
      return unescape(document.cookie.substring(c_start,c_end));
     } 
    }
    return "";
   }
function pausedHandler(adid){
	document.getElementById("advp"+adid).style.display='block'; 
}
function okHandler(adid){
	if(parseFloat(CKobject._K_("djstime"+adid).innerHTML)>0){
		djsthtml = "加载成功，广告"
		CKobject._K_("djstext"+adid).innerHTML=djsthtml;
	}
}
function playHandler(adid){
	_videonum = adid;
	document.getElementById("advp"+adid).style.display='none'; 
	CKobject._K_("djstext"+adid).innerHTML="";
	CKobject._K_("djstime"+adid).innerHTML="";
	CKobject._K_("djsm"+adid).innerHTML="";
	if(getparent()<500){setTimeout(ckadhide,10000);}
	if(CKobject.getObjectById("ckplayer_a"+adid).getType()){setTimeout(ckadhide,500);}
}
function playerstop(_videonumnext){
		_videonum = _videonumnext;
		CKobject._K_("djstext"+_videonum).innerHTML="后置广告";
		CKobject._K_('djstime'+_videonum).innerHTML=ckdata['lmendtime'];
		CKobject._K_('djsm'+_videonum).innerHTML="秒";
		_functionend = "setTimeend"+_videonum+"()";
		setTimeout(_functionend,10);
}
function errorHandler(adid){
	if(getCookie('videonum'+adid)!='000'){
			setCookie('videonum'+adid,getCookie('videonum'+adid)+0,50); 
			_videonum = adid;
			choice(getCookie('nowvideo'+adid));
		}else{
			_videonum = adid;
			setCookie('videonum'+adid,0,50);
			document.getElementById("a"+_videonum).innerHTML="<iframe scrolling=\"no\" align=\"middle\" frameborder=\"0\"   width=\""+getsize('w')+"\"  marginwidth=\"0\" marginheight=\"0\" height=\""+getsize('h')+"\"src=\""+ckdata['neturl']+"/plugins/ck-video/includes/direct.php?url="+getCookie('directvideo'+adid)+"\" ></iframe>";
			CKobject._K_("djstext"+_videonum).innerHTML="";
			CKobject._K_("djstime"+_videonum).innerHTML="";
			CKobject._K_("djsm"+_videonum).innerHTML="";
			_adobject = document.getElementsByName("ckad");
			for (x in _adobject){
				document.getElementById(_adobject[x].id).style.display='none';
				}
		}
}
function DirectAnaly(adid,a){
	playHandler(adid);
	document.getElementById("a"+adid).innerHTML="<iframe scrolling=\"no\" align=\"middle\" frameborder=\"0\"   width=\""+getsize('w')+"\"  marginwidth=\"0\" marginheight=\"0\" height=\""+getsize('h')+"\"src=\""+ckdata['neturl']+"/plugins/ck-video/includes/direct.php?url="+getCookie('directvideo'+adid)+"\" ></iframe>";

}

function choice(_f,_s,_lv,_a,_subtitle_cn,_subtitle_en,_barragenext,_Mobileurl,_nnext){
	_barrage = _barragenext;
	_n = _nnext;
	setCookie('nowvideo'+_videonum,_f,15);
	_a = _a ? _a : getCookie('directvideo'+_videonum);
	setCookie('directvideo'+_videonum,_a,15);
	ckvplay(_f,_s,_neturl,_lv,_a,_Mobileurl,_d,_u,_l,_r,_t,_z,_e,_v,_p,_g,_j,_subtitle_cn,_subtitle_en,_barrage,_width,_height);
}
function getparent(){
		var parentobj = document.getElementById("video").parentNode;
		parentwidth = parentobj.getBoundingClientRect().right - parentobj.getBoundingClientRect().left;
		videowidth = parseInt(parentwidth) ? parseInt(parentwidth) : 600;
		return videowidth;
}
function setadxy(){
		var videodiv=document.getElementById("video");
		var parentdiv=document.getElementById("video").parentNode;
		advptop = parseInt(videodiv.getBoundingClientRect().bottom)-parseInt(parentdiv.getBoundingClientRect().top);
		document.getElementById("cklogin").style.top = advptop+"px";
}
function sethtml5ad(_videonum){
	if(getparent()<500){
		_html5ad = "<div name=\"ckad\" id=\"advp1"+_videonum+"\" style=\"z-index:25;position:absolute;text-align:center;width:180px;display:block;height:150px;left:50%;top:50%; margin-top: 40px;margin-left: -90px;\">"
		+"<script async src=\"//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js\"></script>"
		+"<!-- ckvideohtml5 --><ins class=\"adsbygoogle\"     style=\"display:inline-block;width:180px;height:150px\"     data-ad-client=\"ca-pub-1495498038472167\"     data-ad-slot=\"2057473131\"></ins><script>(adsbygoogle = window.adsbygoogle || []).push({});</script>"
		+"</div>";
		CKobject._K_('advp'+_videonum).innerHTML = _html5ad;
	}

}

function getsize(_wh){
	_whratio = _whratio ? _whratio : 0.75;
	if(_autosize==1){
	_width = getparent();
	_height = getparent()*_whratio;
	}else if(_autosize==0.5){
	_width = _width ? _width : getparent();
	_height = _height ? _height : getparent()*_whratio;
	}
    var _size = new Array(_width,_height); 
	_size['w'] = _width-20;
	_size['h'] = _height-20;
    return 	_size[_wh];
}
function ckvplay(_f,_s,_neturlnext,_lv,_a,_Mobileurl,_analyon,_dnext,_unext,_lnext,_rnext,_tnext,_znext,_e,_vnext,_p,_g,_j,_subtitle_cn,_subtitle_en,_barragenext,_widthnext,_heightnext){
	if(document.getElementById("diranaly"+_videonum)){
		if(_videoext.in_array(GetFileExt(_f))){
			document.getElementById("diranaly"+_videonum).style.display='none'; 
		}else{
			document.getElementById("diranaly"+_videonum).style.display='block'; 
		}
	}
	_width = _widthnext;
	_height = _heightnext;
	_barrage = _barragenext;
	_d = _dnext;
	_u = _unext;
	_l = _lnext;
	_r = _rnext;
	_t = _tnext;
	_z = _znext;
	_e = 2; //暂如此定义结束调用js
	_neturl = _neturlnext;
	_v = _vnext;
	setCookie('nowvideo'+_videonum,_f,30);
	setCookie('directvideo'+_videonum,_a,30);
    _v=_v?_v:80;
    _p=_p==2?_p:0;
	var flashvars={
		f:_f,
		a:_a,
		s:_s,
		lv:_lv,
		c:'0',
		x:'',
		i:'',
		d:'',
		u:_u,
		l:_l,
		r:_r,
		t:_t,
		y:'',
		z:_z,
		e:_e,
		v:_v,
		p:_p,
		h:'3',
		q:'',
		m:'0',
		b:0,
		o:'',
		w:'',
		g:_g,
		j:_j,
		k:'',
		n:'',
		wh:'',
		subtitle_cn:_subtitle_cn,
		subtitle_en:_subtitle_en,
		barrage:ckdata['neturl']+'/plugins/ck-video/Barrage/oldbarrage.php?file='+_barrage,
		loaded:'loadedHandler'+_videonum,
		my_url:encodeURIComponent(window.location.href)
		};
	var params={bgcolor:'#FFF',wmode:"opaque",allowFullScreen:true,allowScriptAccess:'always'};
	var video=[_Mobileurl+'->ajax/get/utf-8'];
	CKobject.embed(_neturl+'/plugins/ck-video/ckplayer/ckplayer.swf', 'a'+_videonum,'ckplayer_a'+_videonum, getsize('w'), getsize('h'),false,flashvars,video,params);
	CKobject._K_("djstext"+_videonum).innerHTML="努力加载中，广告";
	CKobject._K_("djsm"+_videonum).innerHTML="秒";
//	CKobject._K_("daojs"+_videonum).style.width=getsize('w')+"px";
		//强制前置广告显示
		if(frontHtime){//后置广告正在进行中
			CKobject._K_('djstime'+_videonum).innerHTML=ckdata['lmendtime'];//让其结束播放广告并且计算下一部要播放的编号
		}
		if(frontTime){//如果前置广告还在运行中，只需要改变倒计时即可
			CKobject._K_('djstime'+_videonum).innerHTML=ckdata['lmpretime'];
		}else{
			CKobject._K_('djstime'+_videonum).innerHTML=ckdata['lmpretime'];
			_function = "settime"+_videonum+"()";
			setTimeout(_function,100);
		}
	if(analyon[_videonum][_n]=='0'){
		setCookie('videonum'+_videonum,'000',50);
		errorHandler(_videonum);
		}
}
function GetFileExt(filepath) {
            if (filepath != "") {
                var pos = "." + filepath.replace(/.+\./, "");
                return pos;
            }
}
Array.prototype.in_array = function(e)
{
for(i=0;i<this.length && this[i]!=e;i++);
return !(i==this.length);
}