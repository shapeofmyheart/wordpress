<?php
include_once('vids.php');
include_once('ckfunctions.php');
$url = trim($_GET["url"]);
$data = getvideoid($url);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ck-video直连地址</title>
<style type="text/css"> 
#center { 
position:absolute; 
width:200px; 
height:40px; 
left:50%; 
top:50%; 
z-index:1; 
margin-left:-100px; 
margin-top:-20px 
}        
</style>
</head>

<body>
<?php if($data['type'] == 'youku'){?>
<p style="text-align: center;">
<embed src="http://player.youku.com/player.php/sid/<?php echo $data['id']; ?>/v.swf" allowFullScreen="true" quality="high" width="100%" height="100%" align="middle" allowScriptAccess="always" type="application/x-shockwave-flash"></embed>
</p>
<?php }elseif($data['type'] == 'tudou'){?>
<p style="text-align: center;">
<embed src="http://www.tudou.com/v/<?php $tudouid = explode("/",$url);$num = count($tudouid)-1; $vid = str_replace('.html','',$tudouid[$num]); if(!$vid){$vid= $tudouid[$num - 1];}echo $vid; ?>&resourceId=0_05_05_99/v.swf" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" wmode="opaque" width="100%" height="100%"></embed>
</p>
<?php }elseif($data['type'] == 'letv'){?>
<p style="text-align: center;">
<embed src="http://i7.imgs.letv.com/player/swfPlayer.swf?autoplay=1" flashVars="id=<?php echo $data['id']; ?>" width="100%" height="100%" allowFullScreen="true" type="application/x-shockwave-flash" />
</p>
<?php }elseif($data['type'] == 'qq'){?>
<p style="text-align: center;">
<embed src="http://static.video.qq.com/TPout.swf?vid=<?php echo $data['id']; ?>&auto=0" allowFullScreen="true" quality="high" width="100%" height="100%" align="middle" allowScriptAccess="always" type="application/x-shockwave-flash"></embed>
</p>
<?php }elseif($data['type'] == '56'){?>
<p style="text-align: center;">
<embed src="http://player.56.com/v_<?php echo $data['id']; ?>.swf" type="application/x-shockwave-flash" width="100%" height="100%" allowfullscreen="true" allownetworking="all" allowscriptaccess="always"></embed>
</p>
<?php }elseif($data['type'] == 'ku6'){?>
<p style="text-align: center;">
<embed src="http://player.ku6.com/refer/<?php echo $data['id']; ?>/v.swf" width="100%" height="100%" allowscriptaccess="always" allowfullscreen="true" type="application/x-shockwave-flash" flashvars="from=ku6"></embed>
</p>
<?php }elseif($data['type'] == 'bili'){?>
<p style="text-align: center;">
<embed pluginspage="http://www.macromedia.com/go/getflashplayer" src="http://static.hdslb.com/miniloader.swf?aid=<?php echo $data['id']; ?>&amp;page=1" type="application/x-shockwave-flash" menu="false" wmode="transparent" allowfullscreen="true" allowscriptaccess="never" allownetworking="internal" height="100%" width="100%" />
</p>
<?php 
}
elseif(strstr($url,'sohu.com')){
preg_match('|vid="(.*?)";|',get_curl_contents($url),$sid);	
?>
<p style="text-align: center;">
<embed src="http://share.vrs.sohu.com/<?php echo $sid[1];?>/v.swf&skinNum=1&topBar=0&showRecommend=0&autoplay=true&api_key=0292c23ebb65e900a06c27d17465b338&fbarad=&shareBtn=0" allowFullScreen="true" quality="high" width="100%" height="100%" align="middle" allowScriptAccess="always" type="application/x-shockwave-flash"></embed>
</p>
<?php }
elseif(strstr($url,'iqiyi.com')){
$open = get_curl_contents($url);
preg_match('|data-player-videoid="(.*?)"|',$open,$vid);
preg_match('|data-player-tvid="(.*?)"|',$open,$tvid);
?>
<p style="text-align: center;">
<embed src="http://player.video.qiyi.com/<?php echo $vid[1];?>/0/0/v_19rrnopby8.swf-albumId=<?php echo $tvid[1];?>-tvId=<?php echo $tvid[1];?>-isPurchase=0-cnId=6" allowFullScreen="true" quality="high" width="100%" height="100%" align="middle" allowScriptAccess="always" type="application/x-shockwave-flash"></embed>
</p>
<?php }
elseif(strstr($url,'pps.tv')){
preg_match('|play_(.*?).html|',$url,$pid);
?>
<p style="text-align: center;">
<embed height="100%" width="100%" name="v_31S52Y" id="video_player_other" allowscriptaccess="always" pluginspage="http://get.adobe.com/cn/flashplayer/" flashvars="url_key=<?php echo $pid[1];?>" allowfullscreen="true" quality="hight" src="http://player.pps.tv/player/sid/<?php echo $pid[1];?>/v.swf" type="application/x-shockwave-flash" wmode="Opaque">
</p>
<?php }
else{
echo '<script type="text/javascript">
function openLink(){
window.open("'.$url.'");
}
window.onload = openLink;
</script>';
?>
<div id="center">
<input type="button" value="点击在官方网站播放" name="newLink" onclick="openLink();" />
</div>
<?php }?>
</body>
</html>