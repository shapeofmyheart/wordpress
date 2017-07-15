<?php
/*
Plugin Name:CK-Video
Plugin URI: http://blog.qiuxinjiang.cn/ic/wordpress/982.html
Description: 1、本插件将ckplayer播放器整合在Wordpress中，借助相关解析可以方便播放优酷、土豆、乐视等任何解析支持的视频站视频，只需提供给ckplayer支持的xml即可。<br />2、本插件可以播放视频直连地址包括mp4、flv、f4v、rmov、m3u8等。<br />3、插件可播放Youtube、Dailymotion站点视频。4、本插件借助于网友的播放器可播放磁力链/迅雷/bt种子40位Hash值等。
Version: 1.7
Author: 滴水成江
Author URI:  http://www.qiuxinjiang.cn/
*/
$ckoption = get_option('ck_video_option');
/* plugin-update-checker */
require 'plugin-updates/plugin-update-checker.php';
$MyUpdateChecker = new PluginUpdateChecker_1_6 (
    'http://www.ouryq.com/ck-video/updata.php?CkLicense='.$ckoption[CkLicense],
    __FILE__,
    'ck-video'
);
/*
function addSecretKey($query){
	$query['secret'] = 'foo';
	return $query;
}
$MyUpdateChecker->addQueryArgFilter('addSecretKey');
*/
define('CKVIDEO_ROOT',dirname(__FILE__)); 
define('CKVIDEO_URL',plugins_url('ck-video')); 
include_once(CKVIDEO_ROOT.'/includes/cksets.php');
include_once(CKVIDEO_ROOT.'/includes/ckfunctions.php');
include_once(CKVIDEO_ROOT.'/includes/videoinfo.php');
include_once(CKVIDEO_ROOT.'/includes/shortcode.php');
include_once(CKVIDEO_ROOT.'/includes/cklists.php');
//include_once(CKVIDEO_ROOT.'/includes/ckthumbnail.php');
/* 启用、停用插件时要调用的函数 */
register_activation_hook( __FILE__, 'CK_Video_register' );   
register_deactivation_hook( __FILE__, 'CK_Video_remove' );   


// 增加设置按钮
add_filter('plugin_action_links', 'add_ck_settings_link', 10, 2 );
function add_ck_settings_link($links, $file) {
   if(current_user_can('level_10')){
	static $this_plugin;
	if (!$this_plugin) $this_plugin = plugin_basename(__FILE__);
 
	if ($file == $this_plugin){
		$settings_link = '<a href="'.wp_nonce_url("admin.php?page=ck-video/includes/menu.php").'">设置</a>';
		array_unshift($links, $settings_link);
	}
	return $links;
}
}
add_action('init', 'CK_Video_addbuttons');
//add_shortcode('ckvideo','CK_Video');   
add_shortcode('ckvideo','cklists'); 	
add_shortcode('ckvideonext','CK_Video_Next'); 	
add_action('admin_print_scripts', 'ckvideo_quicktags');
function ckvideo_quicktags() {
    wp_enqueue_script(
        'ckvideo_quicktags',
        CKVIDEO_URL.'/js/ckvideo_quicktags.js',
        array('quicktags')
    );
    }


?>