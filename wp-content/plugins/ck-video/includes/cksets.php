<?php
function CK_Video_register() { 
if(current_user_can( 'administrator' )){
 $indate = date(time());
 $ckoption = get_option('ck_video_option');//获取选项   
if($ckoption==''){
//设置默认数据
$ckoption=array(
            	"indate"=>$indate,
            	"logo"=>"",
            	"jmkey"=>"暂无用",
            	"jmvideo"=>"0",
            	"autosize"=>"1",
            	"whratio"=>"0.75",
            	"nextimages"=>"1",
            	"barrage_set"=>"0",
            	"fltoken"=>"",
            	"choice"=>"none",
            	"analynum"=>"1",
            	"DomainSwitch"=>"0",
            	"WhiteList"=>$_SERVER['HTTP_HOST'],
            	"BlackList"=>"",
            	"CkLicense"=>"",
            	"analyvideos"=>"",
            	"analyapis"=>"",
            	"manalyvideos"=>"",
            	"manalyapis"=>"",
            	"analyapi"=>"",
            	"neturl"=>"",
				"sortrank"=>1,
				"adpre"=>"http://blog.qiuxinjiang.cn/wp-content/themes/HotNewspro/images/logo.png",
				"adprelink"=>"",
				"adprelink2"=>"",
				"adprelinkp"=>"<script async src=\"//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js\"></script>
<!-- ck-video -->
<ins class=\"adsbygoogle\"
     style=\"display:inline-block;width:336px;height:280px\"
     data-ad-client=\"ca-pub-1495498038472167\"
     data-ad-slot=\"3993915538\"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>",
				"adprelinkp2"=>"<script async src=\"//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js\"></script>
<!-- ck-videodown -->
<ins class=\"adsbygoogle\"
     style=\"display:inline-block;width:468px;height:60px\"
     data-ad-client=\"ca-pub-1495498038472167\"
     data-ad-slot=\"7668418731\"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>",
				"adpreurl"=>"http://blog.qiuxinjiang.cn/",
				"adpretime"=>"10",
				"adpau"=>"http://blog.qiuxinjiang.cn/wp-content/themes/HotNewspro/images/logo.png",
				"adpauurl"=>"http://blog.qiuxinjiang.cn/",
				"adbuffer"=>"http://blog.qiuxinjiang.cn/wp-content/themes/HotNewspro/images/logo.png",
				"logourl"=>"ckvideo.png",
				"admar"=>"欢迎使用ck-video插件||请访问“滴水成江”获取最新版本",
				"admarurl"=>"http://blog.qiuxinjiang.cn/ic/wordpress/982.html||http://blog.qiuxinjiang.cn/",
				"logged"=>"0",
				"motion"=>"2",
				"ckpause"=>"1",
				"volume"=>80,
				"cthidden"=>"1",
				"qzkaiguan"=>"0",
				"lmkaiguan"=>"1",
				"lmpretime"=>"10",
				"lmendtime"=>"5",
				"cthidtime"=>"3000",
				"logpretime"=>"10",
				"loggedadv"=>"1",
				"loggedadvp"=>"1",
				"jindu"=>"0",
				"adprew"=>"336",
				"adpreh"=>"280",
				"adprelr"=>"0",
				"adpreud"=>"20",
				"adprew2"=>"468",
				"adpreh2"=>"60",
				"adprelr2"=>"0",
				"adpreud2"=>"20",
				"adprepw"=>"336",
				"adpreph"=>"280",
				"adpreplr"=>"0",
				"adprepud"=>"20",				
				"adpreplr2"=>"0",
				"adprepud2"=>"20",				
				"adprepw2"=>"468",
				"adpreph2"=>"60",
				"version"=>getVersion(),
				"djzt"=>"1",
				"sjqp"=>"1",
				"qzggss"=>"1",
				"jpbut"=>"1",
				"qzjingyin"=>"1",
				"ztcls"=>"1",
				"opmarquee"=>"2",
				"ckkey"=>"",
				"ckname"=>"",
				"ckurl"=>"",
				"ckver"=>"",
				"deledata"=>"1",
				"SubSize"=>"22",
				"SubCnColor"=>"#FFFFFF",
				"SubEnColor"=>"#FFDD00",
				"SubSwitch"=>"1",
				);
update_option('ck_video_option',$ckoption);//更新选项
}else{$ckoption[indate] = $indate; $ckoption[version] = getVersion();update_option('ck_video_option',$ckoption);}
}
} 

function CK_Video_remove() {   
if(current_user_can( 'administrator' )){
$ckoption = get_option('ck_video_option');
if($ckoption[deledata]==1){
/* 删除 wp_options 表中的对应记录 */
delete_option('ck_video_option'); 
 }  
}   
}


function CK_Video_addbuttons() {
    if(current_user_can( 'editor' )||current_user_can( 'administrator' )){
     //增加设置菜单
	 require( CKVIDEO_ROOT.'/includes/menu.php');
	 // Add only in Rich Editor mode
	if ( get_user_option('rich_editing') == 'true') {
	// add the button for wp25 in a new way
		add_filter("mce_external_plugins", "add_ckvideo_tinymce_plugin", 5);
		add_filter('mce_buttons', 'register_ckvideo_button', 5);
	}
}
}
// Load the TinyMCE plugin : editor_plugin.js (wp2.5)
function add_ckvideo_tinymce_plugin($plugin_array) {
	$plugin_array['ckvideo'] = CKVIDEO_URL.'/js/editor_plugin.js';
	return $plugin_array;
}
// used to insert button in wordpress 2.5x editor
function register_ckvideo_button($buttons) {
	array_push($buttons, "separator", "ckvideo");
	return $buttons;
}



?>