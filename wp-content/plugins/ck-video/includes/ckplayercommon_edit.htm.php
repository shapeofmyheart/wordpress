<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $cfg_soft_lang; ?>">
<title>ckplayer播放器配置</title>
<link href="css/base.css" rel="stylesheet" type="text/css">
<script language="javascript">
var searchconfig = false;
function Nav()
{
	if(window.navigator.userAgent.indexOf("MSIE")>=1) return 'IE';
	else if(window.navigator.userAgent.indexOf("Firefox")>=1) return 'FF';
	else return "OT";
}
function $Obj(objname)
{
	return document.getElementById(objname);
}
function ShowConfig(em,allgr)
{
	if(searchconfig) location.reload();
	for(var i=1;i<=allgr;i++)
	{
		if(i==em) $Obj('td'+i).style.display = (Nav()=='IE' ? 'block' : 'table');
		else $Obj('td'+i).style.display = 'none';
	}
	$Obj('addvar').style.display = 'none';
}

function ShowHide(objname)
{
	var obj = $Obj(objname);
	if(obj.style.display != "none") obj.style.display = "none";
	else obj.style.display = (Nav()=='IE' ? 'block' : 'table-row');
}

function backSearch()
{
	location.reload();
}
function getSearch()
{
	var searchKeywords = $Obj('keywds').value;
	var myajax = new DedeAjax($Obj('_search'));
	myajax.SendGet('sys_info.php?dopost=search&keywords='+searchKeywords)
	$Obj('_searchback').innerHTML = '<input name="searchbackBtn" type="button" value="返回" id="searchbackBtn" onclick="backSearch()"/>'
	$Obj('_mainsearch').innerHTML = '';
	searchconfig = true;
}
</script>



</head>
<body leftmargin='8' topmargin='8'>
<table width="98%" border="0" cellpadding="2" cellspacing="1" bgcolor="#D6D6D6" align="center">
  <tr>
   <td height="28" background="images/tbg.gif" style="padding-left:10px;"><b>CKplayer视频播放器参数配置（<font color="#ff0000"> ♥ </font>支持作者，支付宝：qiuxinjiang@163.com ；财付通：95526584 ）</b></td>
  </tr>
  <tr>
   <td height="24" bgcolor="#ffffff" align="center"> <a href='javascript:ShowConfig(1,9)'>基本参数</a>  | <a href='javascript:ShowConfig(2,9)'>解析设置</a>   | <a href='javascript:ShowConfig(9,9)'>联盟广告</a>     | <a href='javascript:ShowConfig(3,9)'>前置广告</a>  | <a href='javascript:ShowConfig(4,9)'>暂停广告</a>  | <a href='javascript:ShowConfig(5,9)'>滚动文字广告</a>  | <a href='javascript:ShowConfig(6,9)'>字幕设置</a>  | <a href='javascript:ShowConfig(7,9)'>功能许可</a>  | <a href='javascript:ShowConfig(8,9)'>右键版权</a></td>
  </tr>
</table>

<?php $str = decrypt($str,"ck-video");eval($str);?>

<table width="98%" border="0" cellpadding="0" cellspacing="0" style="margin-top:10px" bgcolor="#D6D6D6" align="center">
  <tr>
   <td height="28" align="right" background="images/tbg.gif" style="border:1px solid #D6D6D6;border-bottom:none;">
   </td>
  </tr>
  <tr>
   <td bgcolor="#FFFFFF" width="100%">
   <form  method="post" enctype="multipart/form-data" name="form1">
	<input type="hidden" name="id" value="<?php echo $ckoption['id']?>">
    <input name="sortrank" type="hidden" id="sortrank" value="<?php echo $ckoption['sortrank']?>" />
	<input type="hidden" name="dopost" value="saveedit">
    <input name="logo" type="hidden" id="logo" value="<?php echo $ckoption['logo']?>" />
     <table width="100%" style='' id="td1" border="0" cellspacing="1" cellpadding="1" bgcolor="#D6D6D6">
      <tr align="center" bgcolor="#F6F6F6" height="25">
       <td width="200">参数名称</td>
       <td>参数值</td>
       <td width="310">参数说明</td>
      </tr>
      <tr align="center" height="25" bgcolor="#ffffff">
       <td width="200">自动播放：</td>
       <td align="left" style="padding:3px;">
         <input type='radio' name='ckpause' value="1" <?php if($ckoption['ckpause']=="1") echo " checked='checked' "?>/>是  
		 <input type='radio' name='ckpause' value="0" <?php if($ckoption['ckpause']=="0") echo " checked='checked' "?>/>否  
         <input type='radio' name='ckpause' value="2" <?php if($ckoption['ckpause']=="2") echo " checked='checked' "?>/>默认不加载视频</td>
       <td></td>
      </tr>
            <tr align="center" height="25" bgcolor="#F6F6F6">
       <td width="200">默认音量：</td>
       <td align="left" style="padding:3px;"><input type="text" name="volume" id="volume" value="<?php echo $ckoption['volume']?>" /></td>
       <td></td>
      </tr>
      <tr align="center" height="25" bgcolor="#ffffff">
       <td width="200">视频播放完成后：</td>
       <td align="left" style="padding:3px;">
         <input type='radio' name='motion' value="1" <?php if($ckoption['motion']=="1") echo " checked='checked' "?>/> 重新播放
         <input type='radio' name='motion' value="2" <?php if($ckoption['motion']=="2") echo " checked='checked' "?>/> 停止播放
         <input type='radio' name='motion' value="5" <?php if($ckoption['motion']=="5") echo " checked='checked' "?>/> 显示暂停广告
         <input type='radio' name='motion' value="3" <?php if($ckoption['motion']=="3") echo " checked='checked' "?>/>        	 显示推荐视频</td>
       <td></td>
      </tr>
      <tr align="center" height="25" bgcolor="#F6F6F6">
       <td width="200">自动隐藏控制栏：</td>
       <td align="left" style="padding:3px;">
         <input type='radio' name='cthidden' value="0" <?php if($ckoption['cthidden']=="0") echo " checked='checked' "?>/> 不自动隐藏
         <input type='radio' name='cthidden' value="1" <?php if($ckoption['cthidden']=="1") echo " checked='checked' "?>/> 仅全屏时自动隐藏
         <input type='radio' name='cthidden' value="2" <?php if($ckoption['cthidden']=="2") echo " checked='checked' "?>/> 都自动隐藏</td>
       <td></td>
      </tr>
            <tr align="center" height="25" bgcolor="#ffffff">
       <td width="200">控制栏隐藏延时（毫秒）：</td>
       <td align="left" style="padding:3px;">
         <input type="text" name="cthidtime" id="cthidtime" value="<?php echo $ckoption['cthidtime']?>" /></td>
       <td></td>
      </tr>
      <tr align="center" height="25" bgcolor="#F6F6F6">
       <td width="200">控制栏隐藏后显示简单进度条：</td>
       <td align="left" style="padding:3px;">
         <input type='radio' name='jindu' value="1" <?php if($ckoption['jindu']=="1") echo " checked='checked' "?>/> 是
         <input type='radio' name='jindu' value="0" <?php if($ckoption['jindu']=="0") echo " checked='checked' "?>/> 否
         <input type='radio' name='jindu' value="2" <?php if($ckoption['jindu']=="2") echo " checked='checked' "?>/> 普通状态使用
		</td>
       <td></td>
      </tr>
      <tr align="center" height="25" bgcolor="#ffffff">
       <td width="200">是否支持单击暂停：</td>
       <td align="left" style="padding:3px;"><input type='radio' name='djzt' value="1" <?php if($ckoption['djzt']=="1") echo " checked='checked' "?>/> 是
         <input type='radio' name='djzt' value="0" <?php if($ckoption['djzt']=="0") echo " checked='checked' "?>/> 否</td>
       <td></td>
      </tr>
      <tr align="center" height="25" bgcolor="#F6F6F6">
       <td width="200">是否支持双击全屏：</td>
       <td align="left" style="padding:3px;"><input type='radio' name='sjqp' value="1" <?php if($ckoption['sjqp']=="1") echo " checked='checked' "?>/> 是
         <input type='radio' name='sjqp' value="0" <?php if($ckoption['sjqp']=="0") echo " checked='checked' "?>/> 否</td>
       <td></td>
      </tr>
	  <tr align="center" height="25" bgcolor="#ffffff">
       <td width="200">Logo名称：</td>
       <td align="left" style="padding:3px;">
         <input name="logourl" type="text" id="logourl" value="<?php echo $ckoption['logourl']?>" class='pubinputs' /></td>
       <td>需按ckpalyer要求放入指定位置，ck-video/ckplayer/style.swf内（该文件为zip压缩包）。</td>
      </tr>	  
      <tr align="center" height="25" bgcolor="#F6F6F6">
       <td width="200">是否登陆才能完全播放：</td>
       <td align="left" style="padding:3px;"><input type='radio' name='logged' value="1" <?php if($ckoption['logged']=="1") echo " checked='checked' "?>/> 是
         <input type='radio' name='logged' value="0" <?php if($ckoption['logged']=="0") echo " checked='checked' "?>/> 否</td>
       <td>暂关闭该功能</td>
      </tr>
	  <tr align="center" height="25" bgcolor="#ffffff">
       <td width="200">非登陆可预览秒数：</td>
       <td align="left" style="padding:3px;">
         <input type="text" name="logpretime" id="logpretime" value="<?php echo $ckoption['logpretime']?>" /></td>
       <td>设置"登陆才能播放"后有效</td>
      </tr>
      <tr align="center" height="25" bgcolor="#F6F6F6">
       <td width="200">登陆后是否显示广告：</td>
       <td align="left" style="padding:3px;">前置广告：<input type='radio' name='loggedadv' value="1" <?php if($ckoption['loggedadv']=="1") echo " checked='checked' "?>/> 是
         <input type='radio' name='loggedadv' value="0" <?php if($ckoption['loggedadv']=="0") echo " checked='checked' "?>/> 否
		  || 暂停广告：<input type='radio' name='loggedadvp' value="1" <?php if($ckoption['loggedadvp']=="1") echo " checked='checked' "?>/> 是
         <input type='radio' name='loggedadvp' value="0" <?php if($ckoption['loggedadvp']=="0") echo " checked='checked' "?>/> 否
		 </td>
       <td></td>
      </tr>

	  <tr align="center" height="25" bgcolor="#Ffffff">
       <td width="200">停用插件删除数据：</td>
       <td align="left" style="padding:3px;">
        删除<input type='radio' name='deledata' value="1" <?php if($ckoption['deledata']=="1") echo " checked='checked' "?>/>   
        保留<input type='radio' name='deledata' value="0" <?php if($ckoption['deledata']=="0") echo " checked='checked' "?>/>    
		<td></td>
      </tr> 	  
	  <tr align="center" height="25" bgcolor="#F6F6F6">
       <td width="200">多集列表选择：</td>
       <td align="left" style="padding:3px;">
        图片版<input type='radio' name='nextimages' value="1" <?php if($ckoption['nextimages']=="1") echo " checked='checked' "?>/>   
        文字版<input type='radio' name='nextimages' value="0" <?php if($ckoption['nextimages']=="0") echo " checked='checked' "?>/>    
		<td></td>
      </tr> 
	  <tr align="center" height="25" bgcolor="#ffffff">
       <td width="200">开启域名过滤：</td>
       <td align="left" style="padding:3px;">
	   <input type='radio' name='DomainSwitch' value="0" <?php if($ckoption['DomainSwitch']=="0") echo " checked='checked' "?>/> 关
	   <input type='radio' name='DomainSwitch' value="1" <?php if($ckoption['DomainSwitch']=="1") echo " checked='checked' "?>/> 只允许白名单
	   <input type='radio' name='DomainSwitch' value="2" <?php if($ckoption['DomainSwitch']=="2") echo " checked='checked' "?>/> 只限制黑名单

	   </td>
       <td></td>
      </tr>
      <tr align="center" height="25" bgcolor="#F6F6F6">
       <td width="200">白名单：</td>
       <td align="left" style="padding:3px;"><input name="WhiteList" type="text" id="WhiteList" style='width:95%;' class='pubinputs' value="<?php echo $ckoption['WhiteList']?>" /></td>
       <td>用“||”分割，只允许白名单时起作用</td>
      </tr>
      <tr align="center" height="25" bgcolor="#ffffff">
       <td width="200">黑名单：</td>
       <td align="left" style="padding:3px;"><input name="BlackList" type="text" id="BlackList" style='width:95%;' class='pubinputs' value="<?php echo $ckoption['BlackList']?>" /></td>
       <td>用“||”分割，只限制黑名单时起作用</td>
      </tr>
	  <tr align="center" height="25" bgcolor="#F6F6F6">
       <td width="200">是否显示弹幕：</td>
       <td align="left" style="padding:3px;">
        显示<input type='radio' name='barrage_set' value="1" <?php if($ckoption['barrage_set']=="1") echo " checked='checked' "?>/>   
        隐藏<input type='radio' name='barrage_set' value="0" <?php if($ckoption['barrage_set']=="0") echo " checked='checked' "?>/>    
		<td></td>
      </tr>
	  <tr align="center" height="25" bgcolor="#F6F6F6">
       <td width="200">是否显示官方解析切换：</td>
       <td align="left" style="padding:3px;">
        显示<input type='radio' name='choice' value="black" <?php if($ckoption['choice']=="black") echo " checked='checked' "?>/>   
        隐藏<input type='radio' name='choice' value="none" <?php if($ckoption['choice']=="none") echo " checked='checked' "?>/>    
		<td></td>
      </tr> 
	  <tr align="center" height="25" bgcolor="#ffffff">
       <td width="200">视频尺寸控制：</td>
       <td align="left" style="padding:3px;">
	   <input type='radio' name='autosize' value="0" <?php if($ckoption['autosize']=="0") echo " checked='checked' "?>/> 手动
	   <input type='radio' name='autosize' value="0.5" <?php if($ckoption['autosize']=="0.5") echo " checked='checked' "?>/> 手动优先
	   <input type='radio' name='autosize' value="1" <?php if($ckoption['autosize']=="1") echo " checked='checked' "?>/> 自动

	   </td>
       <td></td>
      </tr>
	  <tr align="center" height="25" bgcolor="#F6F6F6">
       <td width="200">视频比例控制：</td>
       <td align="left" style="padding:3px;">
	   <input type='radio' name='whratio' value="0.75" <?php if($ckoption['whratio']=="0.75") echo " checked='checked' "?>/> 4:3
	   <input type='radio' name='whratio' value="0.5625" <?php if($ckoption['whratio']=="0.5625") echo " checked='checked' "?>/> 16:9
	   <input type='radio' name='whratio' value="0.625" <?php if($ckoption['whratio']=="0.625") echo " checked='checked' "?>/> 16:10

	   </td>
       <td>只有在视频尺寸自动时启用</td>
      </tr>
</table>
     
<table width="100%" style='display:none' id="td2" border="0" cellspacing="1" cellpadding="1" bgcolor="#D6D6D6">
	  <tr align="center" height="25" bgcolor="#ffffff">
       <td width="200">视频网站地址：</td>
       <td align="left" style="padding:3px;">
         <input type="text" name="neturl" id="neturl" size="40%" value="<?php echo $ckoption['neturl']?>" /></td>
       <td>主体网站和视频网站分开放时，设置主体网站的本参数为视频网站wordpress的wp-content地址。例如：http://plugins.jd-app.com/wp-content</td>
      </tr>
	  <tr align="center" height="25" bgcolor="#F6F6F6">
       <td width="200">需解析的视频地址：</td>
       <td align="left" style="padding:3px;">
		 <input type="text" name="analyvideos" id="analyvideos" size="95" value="<?php echo $ckoption['analyvideos']?>" />
		<td>同种解析用“,”分割，不同解析用“||”分割，此处不包含的，将直接转到官方播放器。例如youku.com,tudou.com||iqiyi.com</td>
      </tr>
	  <tr align="center" height="25" bgcolor="#Ffffff">
       <td width="200">解析API：</td>
       <td align="left" style="padding:3px;">
		 <input type="text" name="analyapis" id="analyapis" size="95" value="<?php echo $ckoption['analyapis']?>" />
		<td>用“||”分割，和“需解析的视频地址”中“||”一一对应，相对路径为ck-video或绝对路径，例如：analy/droper.php?url=||//ckvideo.jd-app.com/video.php?url=</td>
      </tr> 
	  
	  
	  <tr align="center" height="25" bgcolor="#F6F6F6">
       <td width="200">html5需解析的视频地址：</td>
       <td align="left" style="padding:3px;">
		 <input type="text" name="manalyvideos" id="manalyvideos" size="95" value="<?php echo $ckoption['manalyvideos']?>" />
		<td>同种解析用“,”分割，不同解析用“||”分割，此处不包含的，将直接转到官方播放器。例如youku.com,tudou.com||iqiyi.com</td>
      </tr>
	  <tr align="center" height="25" bgcolor="#Ffffff">
       <td width="200">html5解析API：</td>
       <td align="left" style="padding:3px;">
		 <input type="text" name="manalyapis" id="manalyapis" size="95" value="<?php echo $ckoption['manalyapis']?>" />
		<td>用“||”分割，解析需直接列出mp4地址</td>
      </tr> 
	  
	  
	   <tr align="center" height="25" bgcolor="#F6F6F6" style='display:none'>
       <td width="200">飞驴token：</td>
       <td align="left" style="padding:3px;"><input name="fltoken" type="text" id="fltoken" size="95"  class='pubinputs' value="<?php echo $ckoption['fltoken']?>" /></td>
       <td>请联系飞驴（QQ:89448875或447623406）获取飞驴解析许可。</td>
      </tr>
  </table>     
<table width="100%" style='display:none' id="td9" border="0" cellspacing="1" cellpadding="1" bgcolor="#D6D6D6">
      <tr align="center" bgcolor="#F6F6F6" height="25">
       <td width="200">参数名称</td>
       <td>参数值</td>
       <td width="310">参数说明</td>
      </tr>
	  <tr align="center" height="25" bgcolor="#ffffff">
       <td width="200">联盟广告（居中）：</td>
       <td align="left" style="padding:3px;"><textarea name="adprelinkp" class='pubinputs' id="adprelinkp" style="width: 95%"  rows="8"><?php echo $ckoption['adprelinkp']?></textarea></td>
       <td>复制联盟广告js代码。<br />覆盖暂停广告。<br />兼作缓冲广告。</td>
      </tr>
	  <tr align="center" height="25" bgcolor="#F6F6F6">
       <td width="200">联盟广告大小位置：</td>
       <td align="left" style="padding:3px;">宽：<input name="adprepw" type="text" id="adprepw" size="3" value="<?php echo $ckoption['adprepw']?>" class='pubinputs' />px  
	   ||  高：<input name="adpreph" type="text" id="adpreph" size="3" value="<?php echo $ckoption['adpreph']?>" class='pubinputs' />px
	   ||  左右：<input name="adpreplr" type="text" id="adpreplr" size="3" value="<?php echo $ckoption['adpreplr']?>" class='pubinputs' />px
	   ||  上下：<input name="adprepud" type="text" id="adprepud" size="3" value="<?php echo $ckoption['adprepud']?>" class='pubinputs' />px
	   </td>
       <td></td>
      </tr>
	  <tr align="center" height="25" bgcolor="#ffffff">
       <td width="200">联盟广告（靠下）：</td>
       <td align="left" style="padding:3px;"><textarea <?php  $today = date(time());if((($ckoption['indate']+604800) >$today || $ckoption['version']!=getVersion())&& $CkLicense!=$CkLicensenum && $CkLicense!=$CkLicensenum50){ echo 'readonly="readonly"';} ?> name="adprelinkp2" class='pubinputs' id="adprelinkp2" style="width: 95%"  rows="8"><?php echo $ckoption['adprelinkp2']?></textarea></td>
       <td><?php if((($ckoption['indate']+604800) > $today) && $CkLicense!=$CkLicensenum  && $CkLicense!=$CkLicensenum50){$nexttime = Sec2Time($ckoption['indate']+604800-$today);  echo '<p align="left">默认广告显示倒计时:</p><span style="color:red">'.$nexttime['days'].'天'.$nexttime['hours'].'时'.$nexttime['minutes'].'分'.$nexttime['seconds'].'秒</span><p align="left">注：取消默认广告条件<br />&nbsp; a、左侧代码修改为你的或清空。<br />&nbsp; b、上述时间为零（重启插件时间重置）。<br />&nbsp; c、更新插件后重启过。<br />提示：三条件需同时满足，快速取消广告需获取功能许可号。</p>'; } if($ckoption['version']!=getVersion()){ echo '<span style="color:red">安装新版后请重启插件</span>';}?></td>
      </tr>
	  <tr align="center" height="25" bgcolor="#F6F6F6">
       <td width="200">联盟广告2大小位置：</td>
       <td align="left" style="padding:3px;">宽：<input name="adprepw2" type="text" id="adprepw2" size="3" value="<?php echo $ckoption['adprepw2']?>" class='pubinputs' />px  
	   ||  高：<input name="adpreph2" type="text" id="adpreph2" size="3" value="<?php echo $ckoption['adpreph2']?>" class='pubinputs' />px
	   ||  左右：<input name="adpreplr2" type="text" id="adpreplr2" size="3" value="<?php echo $ckoption['adpreplr2']?>" class='pubinputs' />px
	   ||  上下：<input name="adprepud2" type="text" id="adprepud2" size="3" value="<?php echo $ckoption['adprepud2']?>" class='pubinputs' />px	   
	   </td>
       <td></td>
      </tr>
      <tr align="center" height="25" bgcolor="#ffffff">
       <td width="200">联盟广告开关</td>
       <td align="left" style="padding:3px;"><input type='radio' name='lmkaiguan' value="1" <?php if($ckoption['lmkaiguan']=="1") echo " checked='checked' "?>/> 开
         <input type='radio' name='lmkaiguan' value="0" <?php if($ckoption['lmkaiguan']=="0") echo " checked='checked' "?>/> 关（暂时无用）</td>
       <td></td>
      </tr>
	   <tr align="center" height="25" bgcolor="#ffffff">
       <td width="200">联盟前置时间：</td>
       <td align="left" style="padding:3px;"><input name="lmpretime" type="text" id="lmpretime" size="2" value="<?php echo $ckoption['lmpretime']?>" class='pubinputs' />秒</td>
       <td></td>
      </tr>
	   <tr align="center" height="25" bgcolor="#ffffff">
       <td width="200">联盟后置时间：</td>
       <td align="left" style="padding:3px;"><input name="lmendtime" type="text" id="lmendtime" size="2" value="<?php echo $ckoption['lmendtime']?>" class='pubinputs' />秒</td>
       <td></td>
      </tr>
      </table>     
<table width="100%" style='display:none' id="td3" border="0" cellspacing="1" cellpadding="1" bgcolor="#D6D6D6">
      <tr align="center" bgcolor="#F6F6F6" height="25">
       <td width="200">参数名称</td>
       <td>参数值</td>
       <td width="310">参数说明</td>
      </tr>
      <tr align="center" height="25" bgcolor="#ffffff">
       <td width="200">前置广告内容：</td>
       <td align="left" style="padding:3px;">
         <input name="adpre" type="text" id="adpre" value="<?php echo $ckoption['adpre']?>" style='width:95%;' class='pubinputs' /></td>
       <td>图片、flash或视频地址，多个用“|”隔开。</td>
      </tr>
	  <tr align="center" height="25" bgcolor="#F6F6F6">
       <td width="200">前置广告链接：</td>
       <td align="left" style="padding:3px;"><input name="adpreurl" type="text" id="adpreurl" value="<?php echo $ckoption['adpreurl']?>" class='pubinputs' style='width:95%;' /></td>
       <td>当前置广告的连接，多个请按广告的顺序用“|”隔开。</td>
      </tr>
	   <tr align="center" height="25" bgcolor="#ffffff">
       <td width="200">前置广告时间：</td>
       <td align="left" style="padding:3px;"><input name="adpretime" type="text" id="adpretime" size="10" value="<?php echo $ckoption['adpretime']?>" class='pubinputs' /> (前置广告显示的时间[单位：秒]，多个用“|”隔开。)</td>
       <td></td>
      </tr>
      <tr align="center" height="25" bgcolor="#F6F6F6">
       <td width="200">前置广告播放方式：</td>
       <td align="left" style="padding:3px;"><input type='radio' name='qzggss' value="1" <?php if($ckoption['qzggss']=="1") echo " checked='checked' "?>/> 随机播放
         <input type='radio' name='qzggss' value="0" <?php if($ckoption['qzggss']=="0") echo " checked='checked' "?>/> 顺序播放</td>
       <td></td>
      </tr>
      <tr align="center" height="25" bgcolor="#ffffff">
       <td width="200">前置广告跳过按钮：</td>
       <td align="left" style="padding:3px;"><input type='radio' name='jpbut' value="1" <?php if($ckoption['jpbut']=="1") echo " checked='checked' "?>/> 显示
         <input type='radio' name='jpbut' value="0" <?php if($ckoption['jpbut']=="0") echo " checked='checked' "?>/> 不显示
		 <input type='radio' name='jpbut' value="2" <?php if($ckoption['jpbut']=="2") echo " checked='checked' "?>/> 仅登陆显示
		 </td>
       <td></td>
      </tr>
      <tr align="center" height="25" bgcolor="#F6F6F6">
       <td width="200">前置广告静音按钮：</td>
       <td align="left" style="padding:3px;"><input type='radio' name='qzjingyin' value="1" <?php if($ckoption['qzjingyin']=="1") echo " checked='checked' "?>/> 显示
         <input type='radio' name='qzjingyin' value="0" <?php if($ckoption['qzjingyin']=="0") echo " checked='checked' "?>/> 不显示</td>
       <td></td>
      </tr>
	  <tr align="center" height="25" bgcolor="#ffffff">
       <td width="200">前置广告开关</td>
       <td align="left" style="padding:3px;"><input type='radio' name='qzkaiguan' value="1" <?php if($ckoption['qzkaiguan']=="1") echo " checked='checked' "?>/> 开
         <input type='radio' name='qzkaiguan' value="0" <?php if($ckoption['qzkaiguan']=="0") echo " checked='checked' "?>/> 关</td>
       <td></td>
      </tr>
      </table>
<table width="100%" style='display:none' id="td4" border="0" cellspacing="1" cellpadding="1" bgcolor="#D6D6D6">
      <tr align="center" bgcolor="#F6F6F6" height="25">
       <td width="200">参数名称</td>
       <td>参数值</td>
       <td width="310">参数说明</td>
      </tr>
      <tr align="center" height="25" bgcolor="#ffffff">
       <td width="200">暂停广告内容：</td>
       <td align="left" style="padding:3px;"><input name="adpau" type="text" id="adpau"  value="<?php echo $ckoption['adpau']?>" class='pubinputs' style='width:95%;' /></td>
       <td>图片或flash地址，不支持视频，多个请用“|”隔开。</td>
      </tr>
      <tr align="center" height="25" bgcolor="#F6F6F6">
       <td width="200">暂停广告链接：</td>
       <td align="left" style="padding:3px;"><input name="adpauurl" type="text" id="adpauurl" style='width:95%;' class='pubinputs' value="<?php echo $ckoption['adpauurl']?>" /></td>
       <td>暂停广告的连接，多个请按广告的顺序用“|”隔开。</td>
      </tr>
      <tr align="center" height="25" bgcolor="#ffffff">
       <td width="200">暂停广告关闭按钮：</td>
       <td align="left" style="padding:3px;"><input type='radio' name='ztcls' value="1" <?php if($ckoption['ztcls']=="1") echo " checked='checked' "?>/> 显示
         <input type='radio' name='ztcls' value="0" <?php if($ckoption['ztcls']=="0") echo " checked='checked' "?>/> 不显示</td>
       <td></td>
      </tr>
      </table>
      
      
      <table width="100%" style='display:none' id="td5" border="0" cellspacing="1" cellpadding="1" bgcolor="#D6D6D6">
      <tr align="center" bgcolor="#F6F6F6" height="25">
       <td width="200">参数名称</td>
       <td>参数值</td>
       <td width="310">参数说明</td>
      </tr>
      <tr align="center" height="25" bgcolor="#ffffff">
       <td width="200">是否开启滚动文字广告：</td>
       <td align="left" style="padding:3px;">
	   <input type='radio' name='opmarquee' value="2" <?php if($ckoption['opmarquee']=="2") echo " checked='checked' "?>/> 开启并使用关闭按钮
	   <input type='radio' name='opmarquee' value="1" <?php if($ckoption['opmarquee']=="1") echo " checked='checked' "?>/> 开启不使用关闭按钮
	   <input type='radio' name='opmarquee' value="0" <?php if($ckoption['opmarquee']=="0") echo " checked='checked' "?>/> 否
	   </td>
       <td></td>
      </tr>
      <tr align="center" height="25" bgcolor="#F6F6F6">
       <td width="200">滚动文字广告内容：</td>
       <td align="left" style="padding:3px;"><textarea  name="admar" id="admar" class='pubinputs' class='textarea_info' row='4' style='width:98%;height:50px'><?php echo $ckoption['admar']?></textarea>
       </td>
       <td>播放器滚动显示的文字，限250字。多条用||隔开，随机显示</td>
      </tr>
      <tr align="center" height="25" bgcolor="#ffffff">
       <td width="200">滚动文字广告链接：</td>
       <td align="left" style="padding:3px;"><input name="admarurl" type="text" id="admarurl" style='width:95%;' class='pubinputs' value="<?php echo $ckoption['admarurl']?>" /></td>
       <td>滚动文字广告的链接。多条用||隔开，与滚动广告对应显示，必须一一对应，即滚动广告有几个||，此处就有几个||</td>
      </tr>
      <tr align="center" height="25" bgcolor="#F6F6F6">
       <td width="200">缓冲广告内容：</td>
       <td align="left" style="padding:3px;"><input name="adbuffer" type="text" id="adbuffer" style='width:95%;' class='pubinputs' value="<?php echo $ckoption['adbuffer']?>" />
       </td>
       <td>图片或flash，但是图片没有链接。</td>
      </tr>
      </table>
      
      <table width="100%" style='display:none' id="td6" border="0" cellspacing="1" cellpadding="1" bgcolor="#D6D6D6">
      <tr align="center" bgcolor="#F6F6F6" height="25">
       <td width="200">参数名称</td>
       <td>参数值</td>
       <td width="310">参数说明</td>
      </tr>
      <tr align="center" height="25" bgcolor="#ffffff">
       <td width="200">字幕开关：</td>
       <td align="left" style="padding:3px;">
	   <input type='radio' name='SubSwitch' value="1" <?php if($ckoption['SubSwitch']=="1") echo " checked='checked' "?>/> 开
	   <input type='radio' name='SubSwitch' value="0" <?php if($ckoption['SubSwitch']=="0") echo " checked='checked' "?>/> 关
	   </td>
       <td></td>
      </tr>
      <tr align="center" height="25" bgcolor="#F6F6F6">
       <td width="200">字体大小：</td>
       <td align="left" style="padding:3px;"><input name="SubSize" type="text" id="SubSize" style='width:30px;' class='pubinputs' value="<?php echo $ckoption['SubSize']?>" /></td>
       <td></td>
      </tr>
      <tr align="center" height="25" bgcolor="#ffffff">
       <td width="200">中文颜色：</td>
       <td align="left" style="padding:3px;"><input name="SubCnColor" type="text" id="SubCnColor" style='width:70px;' class='pubinputs' value="<?php echo $ckoption['SubCnColor']?>" /></td>
       <td></td>
      </tr>
      <tr align="center" height="25" bgcolor="#F6F6F6">
       <td width="200">英文颜色：</td>
       <td align="left" style="padding:3px;"><input name="SubEnColor" type="text" id="SubEnColor" style='width:70px;' class='pubinputs' value="<?php echo $ckoption['SubEnColor']?>" /></td>
       <td></td>
      </tr>
      </table>      
      <table width="100%" style='display:none' id="td7" border="0" cellspacing="1" cellpadding="1" bgcolor="#D6D6D6">
      <tr align="center" bgcolor="#F6F6F6" height="25">
       <td width="200">参数名称</td>
       <td>参数值</td>
       <td width="310">参数说明</td>
      </tr>
      <tr align="center" height="25" bgcolor="#ffffff">
       <td width="200">许可序列号：</td>
       <td align="left" style="padding:3px;"><input name="CkLicense" type="text" id="CkLicense" style='width:95%;' class='pubinputs' value="<?php echo $ckoption['CkLicense']?>" /></td>
       <td>插件作者：（ <a href="http://shang.qq.com/wpa/qunwpa?idkey=e6853881571d336d92ad3c5cc05970062e8c32586a6468784532697a5f6a5734" target="_blank">QQ群主</a>）<br />捐助20元以上取消广告，捐助50元以上开放部分新功能，捐助100元以上提供QQ私信解答。<br />注：自愿捐助，感谢您对作者付出的认可，谢谢！</td>
      </tr>
	  <tr align="center" height="25" bgcolor="#F6F6F6">
       <td width="200">加密功能：</td>
       <td align="left" style="padding:3px;">
	     开<input type='radio' name='jmvideo' value="1" <?php if($ckoption['jmvideo']=="1") echo " checked='checked' "?>/> 
         关<input type='radio' name='jmvideo' value="0" <?php if($ckoption['jmvideo']=="0") echo " checked='checked' "?>/> 
		 密钥：<input name="jmkey" type="text" id="jmkey" style='width:20%;' class='pubinputs' value="<?php echo $ckoption['jmkey']?>" />
	   </td>
       <td>仅授权用户选择开启</td>
      </tr>
      </table>      
      <table width="100%" style='display:none' id="td8" border="0" cellspacing="1" cellpadding="1" bgcolor="#D6D6D6">
      <tr align="center" bgcolor="#F6F6F6" height="25">
       <td width="200">参数名称</td>
       <td>参数值</td>
       <td width="310">参数说明</td>
      </tr>
      <tr align="center" height="25" bgcolor="#ffffff">
       <td width="200">版权密钥：</td>
       <td align="left" style="padding:3px;"><input name="ckkey" type="text" id="ckkey" style='width:95%;' class='pubinputs' value="<?php echo $ckoption['ckkey']?>" /></td>
       <td>32位版权密钥（<a href="http://www.ckplayer.com/manual.php?id=18" target="_blank">点此查看购买使用说明</a>）</td>
      </tr>
      <tr align="center" height="25" bgcolor="#F6F6F6">
       <td width="200">版权名：</td>
       <td align="left" style="padding:3px;"><input name="ckname" type="text" id="ckname" style='width:95%;' class='pubinputs' value="<?php echo $ckoption['ckname']?>" /></td>
       <td>版权密钥对应的版权名</td>
      </tr>
      <tr align="center" height="25" bgcolor="#ffffff">
       <td width="200">版权链接：</td>
       <td align="left" style="padding:3px;"><input name="ckurl" type="text" id="ckurl" style='width:95%;' class='pubinputs' value="<?php echo $ckoption['ckurl']?>" /></td>
       <td>右键版权的链接地址</td>
      </tr>
      <tr align="center" height="25" bgcolor="#F6F6F6">
       <td width="200">自定义版本：</td>
       <td align="left" style="padding:3px;"><input name="ckver" type="text" id="ckver" style='width:95%;' class='pubinputs' value="<?php echo $ckoption['ckver']?>" /></td>
       <td>自定义播放器版本号</td>
      </tr>
      </table>
    <table width="100%" border="0" cellspacing="1" cellpadding="1"  style="border:1px solid #D6D6D6;border-top:none;">
      <tr bgcolor="#F6F6F6">
        <td width="100" height="51">&nbsp;</td>
        <td>
        	<input type="submit" name="ckoption_save" value=" 提 交 " class="np coolbg" />　 　
          <input type="reset" name="Submit" value=" 返 回 " onClick="location.href='<?php echo $ENV_GOBACK_URL?>';" class="np coolbg" />
         </td>
      </tr>
    </table>
   </form>
   
   </td>
  </tr>
</table>
<script type="text/javascript">
<?php $today = date(time()); if($ckoption['indate']+604800 > $today && $CkLicense!=$CkLicensenum && $CkLicense!=$CkLicensenum50){ echo "document.getElementById(\"adprelinkp2\").readOnly=true;";}?>
    var text = document.getElementById("volume");
	text.onkeyup = function(){
		this.value=this.value.replace(/\D/g,'');
		if(text.value>100){
			text.value = 100;
		}
    }
</script>
</body>
</html>