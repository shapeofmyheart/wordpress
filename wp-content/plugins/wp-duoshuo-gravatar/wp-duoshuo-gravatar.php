<?php
/**
 * Plugin Name: WP-DuoShuo-Gravatar
 * Plugin URI: http://www.yunfast.com/wp-plugins/wp-duoshuo-gravatar.html
 * Description: In China, the reason of Gravatar avatar can not be accessed is not the Gravatar site server unstable, it is the firewall problem, so the solution is to use the DuoShuo.com Gravatar avatar URL: "http://gravatar.duoshuo.com". 在国内(中国大陆), Gravatar 头像无法稳定访问的原因不是因为 Gravatar 网站服务器不稳定，是国内防火墙的问题，解决的办法是替换成 "http://gravatar.duoshuo.com" 。
 * Version: 1.0
 * Author: shines77
 * Author URI: http://www.yunfast.com/
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */
if (!defined('ABSPATH')) exit;

function yunfast_get_duoshuo_avatar($avatar) {
	// Replacement for the avatar URL, 头像URL替换为 gravatar.duoshuo.com 的域名.
	$avatar = str_replace(array("www.gravatar.com", "0.gravatar.com", "1.gravatar.com", "2.gravatar.com"), "gravatar.duoshuo.com", $avatar);
	// Replacement for the HTTPS protocol to HTTP protocol, 替换为 https 协议为 http 协议.
	$avatar = str_replace("https:", "http:", $avatar);
	return $avatar;
}

add_filter('get_avatar', 'yunfast_get_duoshuo_avatar');
