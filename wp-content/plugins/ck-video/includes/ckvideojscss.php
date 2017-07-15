<script type="text/javascript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/ck-video/js/ck-video.js?v=<?php echo getVersion(); ?>" ></script>
<script type="text/javascript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/ck-video/js/barrage.js?v=<?php echo getVersion(); ?>" ></script>
<script type="text/javascript">
	var isLive=false;
</script>

<?php if($ckoption[jmvideo]){echo '<script type="text/javascript" src="'.get_option('siteurl').'/wp-content/plugins/ck-video/js/ckjm.js?v='.getVersion().'" ></script>';}?>

<script type="text/javascript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/ck-video/ckplayer/ckplayer.js?v=<?php echo getVersion(); ?>" charset="utf-8"></script>
<link rel="stylesheet" href="<?php echo WP_PLUGIN_URL;?>/ck-video/css/video.css?v=<?php echo getVersion(); ?>" type="text/css">
<script language="javascript">
var ckdata=new Array();
<?php 
foreach($ckoption as $key=>$value){
    if($key=='jmvideo'||$key=='neturl'||$key=='lmpretime'||$key=='lmendtime'||$key=='logo'||$key=='sortrank'||$key=='logourl'||$key=='SubSize'||$key=='SubCnColor'||$key=='SubEnColor'||$key=='adpau'||$key=='admar'||$key=='admarurl'||$key=='cthidden'||$key=='cthidtime'||$key=='logpretime'||$key=='loggedadv'||$key=='loggedadvp'||$key=='jindu'||$key=='djzt'||$key=='sjqp'||$key=='qzggss'||$key=='jpbut'||$key=='qzjingyin'||$key=='ztcls'||$key=='opmarquee'||$key=='ckkey'||$key=='ckname'||$key=='ckurl'||$key=='ckver'){
	if($key=='jpbut'&&is_user_logged_in()&&$value==2){$value = 1;}elseif($key=='jpbut'&&is_user_logged_in()==false&&$value==2){$value = 0;}
	if($key=='admar'){
	$ckoptionadmar = explode("||",$value);
	$num = mt_rand(0,count($ckoptionadmar)-1);
	$value = $ckoptionadmar[$num];
	}
	if($key=='adpre'&&$ckoption[qzkaiguan]==0){
	$value = '';
	}
	if($key=='admarurl'){
	$ckoptionadmarurl = explode("||",$value);
	if(count($ckoptionadmarurl)-1<$num){$num = count($ckoptionadmarurl)-1;}
	$value = $ckoptionadmarurl[$num];
	}
	if($key=='neturl'&&$ckoption[neturl]==''){
	$value = content_url();
	}
    echo "ckdata['$key'] ='$value';".PHP_EOL;
	}
}
echo "_whratio='$ckoption[whratio]';
_autosize='$ckoption[autosize]';
_autoplay='$ckoption[ckpause]';";
echo "var analyon = new Array();";
if(!strstr($str,'2167')){return;}
if($ckoption['barrage_set']=='1')
{
echo "ckdata['barrage_control']='barrage_control.swf,2,2,-310,-26,2,1|';";
echo "ckdata['barrage']='barrage.swf,0,0,0,0,2,0|';";

}
echo PHP_EOL;
?>
</script>

