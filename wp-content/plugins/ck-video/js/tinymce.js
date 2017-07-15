function init() {
	tinyMCEPopup.resizeToInnerSize();
}

function getCheckedValue(radioObj) {
	if(!radioObj)
		return "";
	var radioLength = radioObj.length;
	if(radioLength == undefined)
		if(radioObj.checked)
			return radioObj.value;
		else
			return "";
	for(var i = 0; i < radioLength; i++) {
		if(radioObj[i].checked) {
			return radioObj[i].value;
		}
	}
	return "";
}

/* 集数前面补零 */  
function pad(num, n) {  
    var len = num.toString().length;  
    while(len < n) {  
        num = "0" + num;  
        len++;  
    }  
    return num;  
}  


function insertCK_Videocode() {
    var str = document.getElementById("cvurl").value;
	var cvwidth = " width=\"" + document.getElementById("cvwidth").value+"\"";
	var cvheight = " height=\"" + document.getElementById("cvheight").value+"\"";
	var cvname = document.getElementById("cvname").value;
	var vimages = document.getElementById("vimages").value;
	var gjump = document.getElementById("gjump").value;
	var gjumpe = document.getElementById("gjumpe").value;
	var lv = 0;
	if(document.getElementById("lv").checked){lv = 1};
	
	if(document.getElementById("auto").checked){
	     var auto = " auto=\"1\" ";
		 }else auto = " auto=\"0\" ";
	var shortcode = "" ;
	cvurl = " url=\"" + str+"\"";
	shortcode = shortcode+"[ckvideo  "+ cvwidth + cvheight + cvurl + " lv=\""+lv+"\" images=\""+vimages+"\"  gjump=\""+gjump+"\" gjumpe=\""+gjumpe+"\" subcn=\"\" suben=\"\"]" + cvname + "[/ckvideo]";
	window.tinyMCE.activeEditor.insertContent(shortcode);
	tinyMCEPopup.editor.execCommand('mceRepaint');
	tinyMCEPopup.close();
	return;
}

function clearText() {
		document.getElementById("cvurl").value="";
		document.getElementById("cvname").value="";
}
// 多集连播框
function moreURLdiv(){
	if(document.getElementById('moreurl').checked){
		document.getElementById("cvurl").rows="4";
		document.getElementById("cvname").rows="4";
		document.getElementById("vimages").rows="4";
		document.getElementById("gjump").size="80";
		document.getElementById("gjumpe").size="80";
	}else{
		document.getElementById("cvurl").rows="1";
		document.getElementById("cvname").rows="1";
		document.getElementById("vimages").rows="1";
		document.getElementById("gjump").size="5";
		document.getElementById("gjumpe").size="5";
	}
  document.getElementById('moreurldiv').style.display = document.getElementById('moreurldiv').style.display=='none'?'block':'none';
}
//官方地址
 function iframeurl(url)
{
  document.getElementById("video").src=url;
}

//重置视频宽度
function resize(){
if (window.innerWidth) 
winWidth = window.innerWidth; 
else if ((document.body) && (document.body.clientWidth)) 
winWidth = document.body.clientWidth; 
//获取窗口高度 
if (window.innerHeight) 
winHeight = window.innerHeight; 
else if ((document.body) && (document.body.clientHeight)) 
winHeight = document.body.clientHeight; 
//通过深入Document内部对body进行检测，获取窗口大小 
if (document.documentElement && document.documentElement.clientHeight && document.documentElement.clientWidth) 
{ 
winHeight = document.documentElement.clientHeight; 
winWidth = document.documentElement.clientWidth; 
} 
//结果输出至两个文本框 
var nWidth = winWidth*0.9;
var nHeight = nWidth*0.8;
var oEle = document.getElementByName("video");
oEle.height = nHeight + 'px';
oEle.width = nWidth + 'px';
}
