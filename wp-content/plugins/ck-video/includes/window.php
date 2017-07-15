<?php
$wpconfig = realpath("../../../../wp-config.php");
if (!file_exists($wpconfig))  {
	echo "Could not found wp-config.php. Error in path :\n\n".$wpconfig ;	
	die;	
}
require_once($wpconfig);
require_once(ABSPATH.'/wp-admin/admin.php');
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>插入视频</title>
<!-- 	<meta http-equiv="Content-Type" content="<?php// bloginfo('html_type'); ?>; charset=<?php //echo get_option('blog_charset'); ?>" /> -->
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-content/plugins/ck-video/js/tinymce.js"></script>
	<base target="_self" />
</head>
		<body id="link" onload="tinyMCEPopup.executeOnLoad('init();');" >
<!-- <form onsubmit="insertLink();return false;" action="#"> -->
<form id="ckvideo" action="#">
<table width="780" border="1" cellpadding="10" cellspacing="5" rules="rows" style="border:5px solid #E2E2E2;">
    <tr bgcolor="#F6F6F6">
    <td width="70">视频名称</td>
    <td width="710" colspan=3><textarea title="输入视频名称." class="java" id="cvname" style="width: 100%" name="cvname" rows="1"></textarea></td>
    </tr>
    <tr>
    <td></td>
    <td>直播<input type="checkbox" id="lv"  /></td>
    <td align="right">多集视频</td>
    <td><input type="checkbox" name="moreurl" id="moreurl" onchange="moreURLdiv()" /></td>

    </tr>
  <tr>
	
  <td>视频地址</td>
    <td colspan=3><textarea title="输入视频地址或视频ID." class="java" id="cvurl" style="width: 100%" name="cvurl" rows="1"></textarea></td>
  </tr>
  <tr bgcolor="#F6F6F6">
	
  <td>缩略图</td>
    <td colspan=3><textarea title="输入视频地址或视频ID." class="java" id="vimages" style="width: 100%" name="vimages" rows="1"></textarea></td>
  </tr>
  <tr>
    <td></td>
    <td colspan=3><div id="moreurldiv"  style="display:none">
				<div style="display:none">
				起始集数<input title="输入起始集数." class="java" id="startnum"  name="startnum" type="text" size="2" value="1"/>
				每行集数<input title="输入每行." class="java" id="linenum"  name="linenum" type="text" size="2" value="8"/></div>
                两集中间用“||”隔开。
				</div>
	</td>	
  </tr>	
  <tr bgcolor="#F6F6F6">
    <td>视频宽度</td>
    <td><input title="输入视频宽度." class="java" id="cvwidth"  name="cvwidth" type="text" size="5" value="600"/>px</td>
    <td align="right">视频高度</td>
    <td><input title="输入视频高度." class="java" id="cvheight"  name="cvheight" type="text" size="5" value="460"/>px</td>
  </tr>	
  <tr>
    <td>跳过片头</td>
    <td colspan=3><input title="跳过片头时间." class="java" id="gjump"  name="gjump" type="text" size="5" value="0"/>秒</td>
  </tr>	
  <tr>
    <td>跳过片尾</td>
     <td colspan=3><input title="跳过片尾时间." class="java" id="gjumpe"  name="gjumpe" type="text" size="5" value="0"/>秒</td>
  </tr>
  <tr bgcolor="#F6F6F6" style="display:none">
    <td>自动播放</td>
    <td>是<input type="radio" name="autovideo" id="auto" value="1" >否<input type="radio" name="autovideo" id="autono" value="0" checked="checked"></td>
	<td align="right">暂未起用</td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td align="right"><INPUT id="cancel"  type="button" value="清&nbsp;&nbsp;除" name="cancel" runat="server" onclick="clearText()"></td>
	<td><INPUT id="insert"  type="button" value="插&nbsp;&nbsp;入" name="insert" runat="server" onclick="insertCK_Videocode()">	</td>
  </tr>	
</table>
</form>
</body>
</html>