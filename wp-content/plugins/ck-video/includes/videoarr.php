<script language="javascript">
<?php 
$farr = 'var farr'.$videonum.' = new Array();'.PHP_EOL;
$aarr = 'var aarr'.$videonum.' = new Array();'.PHP_EOL;
$html5arr = 'var html5arr'.$videonum.' = new Array();'.PHP_EOL;
$lvarr = 'var lvarr'.$videonum.' = new Array();'.PHP_EOL;
$sarr = 'var sarr'.$videonum.' = new Array();'.PHP_EOL;
$bararr = 'var bararr'.$videonum.' = new Array();'.PHP_EOL;
$analyonarr = 'var analyonarr'.$videonum.' = new Array();'.PHP_EOL;
if($ckoption[jmvideo]=='1'){$jmfunsta='strencode(';$jmfunend=')';}
foreach($urls as $url){
	$videourl = trim($url);
	$getmanaly=getmanaly($videourl,$ckoption);
	$Mobileurl = $getmanaly[0];//$neturl. '/plugins/ck-video/analy/mobile.php?url='.base64_encode(RemoveXSS($url)). '.m3u8';//getMobileurl($videourl);
	if($ckoption[barrage_set]==1){$barrage = base64_encode(RemoveXSS($videourl));}else{$barrage = '';}
	$directext = array('flv','f4v','mp4','rmov');
	$m3u8ext = array('m3u8','android','pad');
	$videoext = get_extension($videourl);
	if(in_array($videoext,$directext)){
		   $f = $videourl;
		   $s = '0';
		   $a = '';
		   $lv = RemoveXSS($lv[$n]);
		   $html5 = $videourl;
		   $analyon = '3';
	}elseif(in_array($videoext,$m3u8ext)){
		   $f = $neturl.'/plugins/ck-video/ckplayer/m3u8.swf';
		   $a = $videourl;
		   $s = '4';
		   $lv = RemoveXSS($lv[$n]);
		   $html5 = $videourl;
		   $analyon = '3';
	}else{
		   $getanaly=getanaly($videourl,$ckoption);
		   $f = $getanaly[0];
		   $s = '2';
		   $lv = '';
		   $a = $videourl;//'gq_XODQwNzE5OTM2_ev_3_youku';
		   $html5 = $Mobileurl;
		   $analyon = $getanaly[1];
	}
$farr .= 'farr'.$videonum.'.push('.$jmfunsta.'\''.strencode($f).'\''.$jmfunend.');'.PHP_EOL;
$aarr .= 'aarr'.$videonum.'.push('.$jmfunsta.'\''.strencode($a).'\''.$jmfunend.');'.PHP_EOL;
$html5arr .= 'html5arr'.$videonum.'.push('.$jmfunsta.'\''.strencode($html5).'\''.$jmfunend.');'.PHP_EOL;
$lvarr .= 'lvarr'.$videonum.'.push(\''.$lv.'\');'.PHP_EOL;
$sarr .= 'sarr'.$videonum.'.push(\''.$s.'\');'.PHP_EOL;
$bararr .= 'bararr'.$videonum.'.push('.$jmfunsta.'\''.strencode(base64_encode(RemoveXSS($url))).'\''.$jmfunend.');'.PHP_EOL;
$analyonarr .= 'analyonarr'.$videonum.'.push(\''.$analyon.'\');'.PHP_EOL;
}
echo $farr.$aarr.$html5arr.$lvarr.$sarr.$bararr.$analyonarr.'analyon[\''.$videonum.'\']=analyonarr'.$videonum.'';
?>
</script>

