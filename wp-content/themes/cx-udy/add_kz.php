<?php
/***********
**
** @晨星博客开发主题扩展代码放置区
** @添加方法：
**   @1、 从下一行开始，放置您复制的代码；
**   @2、 注意代码中符号的格式，php代码全部用半角符号，全角会报错；
**   @3、 禁止使用windows记事本编辑改php文件；
**
**********************************************/


 
///////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                                                                                       //
//            以下是主题的一些默认参数，如果默认值不能满足您的需求可以通过修改来实现部分效果             //
//                                                                                                       //
///////////////////////////////////////////////////////////////////////////////////////////////////////////


if ( !defined( 'CX_USERS_SYSTEM' ) )              define('CX_USERS_SYSTEM', 'on');//是否启用会员系统
if ( !defined( 'CX_AUTO_POST' ) )                 define('CX_AUTO_POST', 5);//图片超过5个自动分页
if ( !defined( 'CX_AUTO_LUNBO' ) )                define('CX_AUTO_LUNBO', 3);//幻灯片轮播图数量
if ( !defined( 'CX_PAGE_NUM' ) )                  define('CX_PAGE_NUM', 3);//定义分页当前页码前后显示数量
if ( !defined( 'CX_DT_NUM' ) )                    define('CX_DT_NUM', 5);//单图模式下文章分页数量
if ( !defined( 'CX_AJAX_NUM' ) )                  define('CX_AJAX_NUM', 5);//单图模式ajax自动加载分页数量
if ( !defined( 'CX_IMAGES_NUM' ) )                define('CX_IMAGES_NUM', 3);//图片预加载多少张
if ( !defined( 'CX_BQTJ' ) )        			  define('CX_BQTJ',1);
if ( !defined( 'CX_DT_NUMTOW' ) )      			  define('CX_DT_NUMTOW',10);

if ( !defined( 'CX_TUIGUANG_SIGN_CREDITS' ) )     define('CX_TUIGUANG_SIGN_CREDITS', 10);//推广奖励积分数
if ( !defined( 'CX_TUIGUANG_NUTHER_CREDITS' ) )   define('CX_TUIGUANG_NUTHER_CREDITS', 5);//推广奖励积分次数

 
///////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                                                                                       //
//                  			   以下功能不常用，非特色需求请勿开启！				                     //
//                                                                                                       //
///////////////////////////////////////////////////////////////////////////////////////////////////////////

//add_filter('the_content', 'page_glmt_cx');//过滤分页符

//add_filter( 'site_url', 'cx_remove_root' );//站内后台相关链接使用相对路径


///////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                                                                                       //
//             以下修改可能导致主题运行不正常或后台设置项失效 ，该区域不建议大家做任何修改               //
//                                                                                                       //
///////////////////////////////////////////////////////////////////////////////////////////////////////////


add_filter( 'max_srcset_image_width', create_function( '', 'return 1;' ) );//禁用自适应图像
add_action('pre_get_posts', 'fa_orderby_views');//新增文章排序方式
add_filter('pre_option_link_manager_enabled','__return_true'); //添加链接功能
add_action('admin_print_scripts', 'my_quicktags');//添加短代码按钮
add_action('widgets_init','unregister_rss_widget');//禁用默认小工具
update_option('image_default_link_type', 'none');//图片默认无连接
add_action('wp_head', 'cx_archive_link');//给页面添加canonical标签
add_filter('show_admin_bar', '__return_false');//禁用工具栏
add_action('delete_post', 'delete_chenxing_meta_fields');//删除文章时删除自定义字段

///////////////////////////////////////////////////////////////////////////////////////////

/* 发布文章自动设置字段
/* -------------------------------- */
add_action('publish_post', 'add_custom_field_automatically', 10, 2 );
add_action( 'publish_picture', 'add_custom_field_automatically', 10, 2 );
function add_custom_field_automatically($post_ID) {
	global $wpdb;
	if(!wp_is_post_revision($post_ID)) {
		$random = 0;
		$random2 = 0;
		if(set_options('cx_fujia_views',2))
			$random = mt_rand(500, 2000);
		if(set_options('cx_fujia__ding',2))
			$random2 = mt_rand(5, 20);
		add_post_meta($post_ID, 'views', $random, true);
		add_post_meta($post_ID, 'bigfa_ding', $random2, true);
		add_post_meta($post_ID, 'chenxing_post_collects', 0, true);
	}
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                                                                                       //
//  以下是主题伪静态规则，适用于/%category%/%post_id%.html样式，如果使用其他样式需要修改以下规则         //
//                                                                                                       //
///////////////////////////////////////////////////////////////////////////////////////////////////////////

//扩展代码放到上面一行 .end_update_core',    create_function('$a', "return null;")); // 关闭核心提示
add_filter('pre_site_transient_update_plugins', create_function('$a', "return null;")); // 关闭插件提示
add_filter('pre_site_transient_update_themes',  create_function('$a', "return null;")); // 关闭主题提示
remove_action('admin_init', '_maybe_update_plugins'); // 禁止 WordPress 更新插件
remove_action('admin_init', '_maybe_update_core');    // 禁止 WordPress 检查更新
remove_action('admin_init', '_maybe_update_themes');  // 禁止 WordPress 更新主题



/**
 * WordPress 媒体库只显示用户自己上传的文件
 * https://www.wpdaxue.com/view-user-own-media-only.html
 */
//在文章编辑页面的[添加媒体]只显示用户自己上传的文件
function my_upload_media( $wp_query_obj ) {
	global $current_user, $pagenow;
	if( !is_a( $current_user, 'WP_User') )
		return;
	if( 'admin-ajax.php' != $pagenow || $_REQUEST['action'] != 'query-attachments' )
		return;
	if( !current_user_can( 'manage_options' ) && !current_user_can('manage_media_library') )
		$wp_query_obj->set('author', $current_user->ID );
	return;
}
add_action('pre_get_posts','my_upload_media');
 
//在[媒体库]只显示用户上传的文件
function my_media_library( $wp_query ) {
    if ( strpos( $_SERVER[ 'REQUEST_URI' ], '/wp-admin/upload.php' ) !== false ) {
        if ( !current_user_can( 'manage_options' ) && !current_user_can( 'manage_media_library' ) ) {
            global $current_user;
            $wp_query->set( 'author', $current_user->id );
        }
    }
}
add_filter('parse_query', 'my_media_library' );

///////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                                                                                       //
//  以下是主题伪静态规则，适用于/%category%/%post_id%.html样式，如果使用其他样式需要修改以下规则         //
//                                                                                                       //
///////////////////////////////////////////////////////////////////////////////////////////////////////////

//扩展代码放到上面一行 .end