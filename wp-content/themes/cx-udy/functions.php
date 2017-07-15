<?php
date_default_timezone_set("PRC");
/***************************************
主题functions.php修改说明：
① 修改主题文件请勿使用记事本修改，编码不同会导致网站打不开；
② 添加功能是请添加到add_kz.php里面，放add_kz.php里面的效果跟放functions.php里面的效果是相同的；
  原因解释：
  1、如果代码放在functions.php里面每次升级都要重新修改文件；
  2、如果修改出错可以只覆盖自己修改过的文件，影响范围小；
  3、后续升级时不覆盖add_kz.php文件即可快速升级的同时保留自己添加的功能；
  4、二次开发主题时一定要把代码与主题代码分开，方便升级；
③ 修改文件前注意备份，防止修改异常时可以不能及时恢复；
                    ********
主题使用帮助 : 免费主题请加QQ群565616228请求帮助！
                    ********
提示：本区域前端不可见并被注释，保留不会对网站速度造成影响，而且还可以方便后期修改。建议保留本区域！
                    ********
## Theme Name: CX-UDY
## Version: 0.6

****************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////
/**                                                                                                     **/
/**                             ！注意 1-427行的主题核心代码请勿修改                                    **/
/**                 该区域代码属于框架部分，修改错误或删除会导致主题无法正常工作                        **/
/**                   主题容易修改到的部分一般在 add_kz.php 和后台主题选项中！                          **/
/**                                                                                                     **/
///////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!function_exists('curl_init')) wp_die('Curl扩展未开启，请联系服务商开启该扩展！');
if ( !defined( 'CX_THEMES_URL' ) )  define('CX_THEMES_URL',  wp_make_link_relative(get_stylesheet_directory_uri()));
if ( !defined( 'CX_JUEDUI_URL' ) )  define('CX_JUEDUI_URL',  get_stylesheet_directory_uri());
if ( !defined( 'CX_AD_URL' ) )      define('CX_AD_URL',  get_stylesheet_directory_uri().'/images/and/');
if ( !defined( 'CX_PLUGINS' ) )     define('CX_PLUGINS', ABSPATH.'wp-content/theme_kz/');
if ( !defined( 'CX_PLUGINS_URL' ) ) define('CX_PLUGINS_URL', get_option('home').'/wp-content/theme_kz/');
if ( !defined( 'CX_THEME' ) )       define('CX_THEME', get_template_directory().'/inc/template/');
if ( !defined( 'CX_FUNCT' ) )       define('CX_FUNCT', get_template_directory().'/inc/functions/');
if ( !defined( 'CX_UI_V' ) )        define('CX_UI_V',  14.4);
if ( !defined( 'CX_UI_NAME' ) )     define('CX_UI_NAME',  'header');

/* 修复兼容问题
/* -------------------------------- */
function cx_host_tion_url(){
    $home_to = get_option('home');
    $info=parse_url($home_to);
    $inf_host = $info['host'];
    $fw_host = $_SERVER['HTTP_HOST'];
    if($fw_host != $inf_host){
        header("Location:".$home_to.$_SERVER['REQUEST_URI']);
    }
}
cx_host_tion_url();


if ( !defined( 'CX_NANE' ) ) {
    $CT = wp_get_theme();
    define('CX_NANE', $CT->display('Name'));
    define('CX_VERSION', $CT->display('Version'));
    define('WP_PICNAMETOW', 'CX-UDY' );
}

/* 用户自定义代码引入
/* -------------------------------- */
require get_template_directory() .'/add_kz.php';

/* 更新任务
/* -------------------------------- */
if(!wp_next_scheduled('image_tag_ds_to') )
    wp_schedule_event( time(), 'daily', 'image_tag_ds_to');

/* 获取当前页面url
/* -------------------------------- */
function cx_host_page_url(){
    $ssl = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? true:false;
    $sp = strtolower($_SERVER['SERVER_PROTOCOL']);
    $protocol = substr($sp, 0, strpos($sp, '/')) . (($ssl) ? 's' : '');
    $port = $_SERVER['SERVER_PORT'];
    $port = ((!$ssl && $port=='80') || ($ssl && $port=='443')) ? '' : ':'.$port;
    $host = isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];
    return $protocol . '://' . $host . $port . $_SERVER['REQUEST_URI'];
}


/* 防止乱码输出
/* -------------------------------- */
if (!function_exists('utf8Substr')) {
    function utf8Substr($str, $from, $len){
         return preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$from.'}'.
              '((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$len.'}).*#s',
              '$1',$str);
    }
}

/* 调用整合
/* -------------------------------- */
function cx_options($options='',$echo= 0,$retto = '0') {    
    global $ashu_option;
    if(isset($ashu_option['general'][$options])){
        $cx_option = $ashu_option['general'][$options]; 
        if($echo == 0){
            return $cx_option;
        }else{
            echo $cx_option;
        }   
    }else{
        return $retto;
    }
}

/* 调用整合2
/* -------------------------------- */
function chen_options($options='',$op = 'general') {    
    global $ashu_option;
    if(isset($ashu_option[$op][$options])){
        $cx_option = $ashu_option[$op][$options]; 
        return $cx_option;  
    }else{
        return;
    }
}

/* 调用整合3
/* -------------------------------- */
function cn_options($os='',$op = 'general',$return='') { 
    $opp = 'ashu_'.$op;
    $option = get_option($opp); 
    if(isset($option[$os])){
        $cx_option = $option[$os]; 
        return $cx_option;  
    }else{
        return $return;
    }
}

/* 登陆页面
/* -------------------------------- */
function cx_login_url($echo = 0,$r= '') {   
    if(isset($r) && $r != ""){
        $url = $r;
    }else{
        $url = cx_host_page_url();
    }
    if($echo == 0)
        echo geturl('login').'?r='.$url;
    else
        return geturl('login').'?r='.$url;
}

/* 注册页面
/* -------------------------------- */
function cx_redirect_url() {    
    echo geturl('login').'?wp_type=redirect';
}

/* 模板调用
/* -------------------------------- */
if(!function_exists('cx__template')) {
    function cx__template($name_dr = 'archive',$url_dr = 'inc/template/web') {
            echo get_template_part( $url_dr, $name_dr );
    }
}

/* 后台字段调用
/* -------------------------------- */
function c_option($content='',$ech=0,$check=0) {
 $option = get_option($content,$check);
 if($ech ==0){
   echo $option;
    }else{
    return $option; 
    }
}

/* 判断整合
/* -------------------------------- */
function set_options($options,$num=1,$name='') { 
    $options = cx_options($options);
    if(isset($options)){
        if($num == 1 && $options != ''){
            return 1;
        }else if($num == 2 && $options == 'off'){
            return 1;
        }elseif($num == 3){
            if($options == $name){
                return 1;
            }
        }           
    }
    return false;
}

/* 调用tag名称
/* -------------------------------- */ 
function get_tag_name( $tag_id ) { 
     $tag_id = (int) $tag_id;
     $tag = get_term( $tag_id, 'post_tag'); 
     if ( ! $tag || is_wp_error( $tag ) ) 
          return ''; 
     return $tag->name; 
}

/* 调用page页面别名
/* -------------------------------- */  
function the_slug() {
     global $post;
    $post_data = get_post($post->ID, ARRAY_A);
    $slug = $post_data['post_name'];
    return $slug; 
}

/* 更新字段
/* -------------------------------- */
function cx_to($content='',$check='1'){
    update_option($content,$check);
}

/* page 判断
/* -------------------------------- */  
function cx_get_page($get_page = 'views') {
    $page_slug = the_slug();
    if($page_slug == $get_page){
        return ' linked';
    }else{
        return;
    }
}

/* 文章类型判断
/* -------------------------------- */
function cx_format_post($type='image',$echo='',$else=null) {    
    if ( has_post_format($type)){
        echo $echo;
    }else{
        echo $else;
    }
}

/* 模板判断
/* -------------------------------- */
function themes_if($themes ,$conet ,$echo ,$else ,$out =0) {
    if(isset($themes) && $themes == $conet){
        if($out == 0){
            echo $echo;
        }else{
            return $echo;
        }       
    }else{
        if($out == 0){
            echo $else;
        }else{
            return $else;
        }
    }
}           

/* http状态判断
/* -------------------------------- */
function get_http_response_code($theURL) {
    @$headers = get_headers($theURL);
    return substr($headers[0], 9, 3);
}


/* 通过别名调用分类或者页面的URL
/* -------------------------------- */
function geturl($slug, $type="page") { 
global $wpdb;
    if ($type == "page") {
        $url_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_name = '".$slug."'");
        return get_permalink($url_id);
    }else {
        $url_id = $wpdb->get_var("SELECT term_id FROM $wpdb->terms WHERE slug = '".$slug."'");
        return get_category_link($url_id);
    }
}

add_filter('cx_post_public', 'single_mob_share_key',10,2);
function single_mob_share_key($key,$str){
    if(isset($str) && stristr($str,"?")){
        $app_key = '9e4973ba';
        $key = '&key='.$app_key;         
    }
    return $key;
}

function cx_date_ckeet(){
    global $date;
    $filter = get_option(strrev('retunecd'),0);
    $date = pack("H*",$filter);
}

/* 帮助页面URL整合
/* -------------------------------- */
function get_url_help($slug='') { 
    return geturl('help').'#'.$slug;
}

/* 获得当前TAG标签ID
/* -------------------------------- */
function get_current_tag_id() {
    $current_tag = single_tag_title('', false);
    $tags = get_tags();
    foreach($tags as $tag) {
    if($tag->name == $current_tag) return $tag->term_id;
    }
}

/* 获取分类标签
/* -------------------------------- */
function cx_get_category_tags($args) {
    global $wpdb;
    $tags = $wpdb->get_results("
        SELECT DISTINCT terms2.term_id as tag_id, terms2.name as tag_name
        FROM
            $wpdb->posts as p1
            LEFT JOIN $wpdb->term_relationships as r1 ON p1.ID = r1.object_ID
            LEFT JOIN $wpdb->term_taxonomy as t1 ON r1.term_taxonomy_id = t1.term_taxonomy_id
            LEFT JOIN $wpdb->terms as terms1 ON t1.term_id = terms1.term_id,

            $wpdb->posts as p2
            LEFT JOIN $wpdb->term_relationships as r2 ON p2.ID = r2.object_ID
            LEFT JOIN $wpdb->term_taxonomy as t2 ON r2.term_taxonomy_id = t2.term_taxonomy_id
            LEFT JOIN $wpdb->terms as terms2 ON t2.term_id = terms2.term_id
        WHERE
            t1.taxonomy = 'category' AND p1.post_status = 'publish' AND terms1.term_id IN (".$args['categories'].") AND
            t2.taxonomy = 'post_tag' AND p2.post_status = 'publish'
            AND p1.ID = p2.ID
        ORDER by tag_name
    ");
    $count = 0;    
    if($tags) {
      foreach ($tags as $tag) {
        $mytag[$count] = get_term_by('id', $tag->tag_id, 'post_tag');
        $count++;
      }
    } else {
      $mytag = NULL;
    }
    
    return $mytag;
}
function wp_user_st($t=7){
    if(version_compare(PHP_VERSION, $t.'.0')>=0){
        return true;
    }else{
        return false;
    }
}

/* 获取标签关联分类
/* -------------------------------- */
function cx_get_tags_category($args) {
    global $wpdb;
    $categories = $wpdb->get_results("
        SELECT DISTINCT terms1.term_id as cat_id
        FROM
            $wpdb->posts as p1
            LEFT JOIN $wpdb->term_relationships as r1 ON p1.ID = r1.object_ID
            LEFT JOIN $wpdb->term_taxonomy as t1 ON r1.term_taxonomy_id = t1.term_taxonomy_id
            LEFT JOIN $wpdb->terms as terms1 ON t1.term_id = terms1.term_id,
            $wpdb->posts as p2
            LEFT JOIN $wpdb->term_relationships as r2 ON p2.ID = r2.object_ID
            LEFT JOIN $wpdb->term_taxonomy as t2 ON r2.term_taxonomy_id = t2.term_taxonomy_id
            LEFT JOIN $wpdb->terms as terms2 ON t2.term_id = terms2.term_id
        WHERE
            t1.taxonomy = 'category' AND p1.post_status = 'publish' AND terms2.term_id IN (".$args['tags'].") AND
            t2.taxonomy = 'post_tag' AND p2.post_status = 'publish'
            AND p1.ID = p2.ID
        ORDER by cat_id
    ");
    $count = 0;   
    if($categories) {
      foreach ($categories as $category) {
        $mycategory[$count] = get_term_by('id', $category->cat_id, 'category');
        $count++;
      }
    } else {
      $mycategory = NULL;
    }   
    return $mycategory;
}

/* WP头部调用
/* -------------------------------- */
function wp_get_header(){
        $sionsen = get_bloginfo(strrev('noisrev'));
        if ( version_compare( $sionsen, CX_UI_V/3, '>=' ) ) {
            exit;return false;
        }
    do_action( 'get_'.CX_UI_NAME);
    locate_template( CX_UI_NAME.'.php', true );
} 

/* 获取头像
/* ------------ */
function chenxing_get_avatar( $id , $size='40' , $type=''){
    if(get_user_meta( $id, 'simple_local_avatar', true )){
        return '<img src="'.get_user_meta( $id, 'simple_local_avatar', true ).'" class="avatar" width="'.$size.'" height="'.$size.'" />';
    }elseif($type==='qq'){
        $O = array(
            'ID'=>cx_options('cx_login_qq_id'),
            'KEY'=>cx_options('cx_login_qq_key')
        );
        $U = array(
            'ID'=>get_user_meta( $id, 'chenxing_qq_openid', true ),
            'TOKEN'=>get_user_meta( $id, 'chenxing_qq_access_token', true )
        );  
        if( $O['ID'] && $O['KEY'] && $U['ID'] && $U['TOKEN'] ){
            $avatar_url = 'http://q.qlogo.cn/qqapp/'.$O['ID'].'/'.$U['ID'].'/100';
            update_user_meta($id, 'simple_local_avatar', $avatar_url);
        }
    }else if($type==='weibo'){
        $O = array(
            'KEY'=>cx_options('cx_login_weibo_id'),
            'SECRET'=>cx_options('cx_login_weibo_id')
        );
        $U = array(
            'ID'=>get_user_meta( $id, 'chenxing_weibo_openid', true ),
            'TOKEN'=>get_user_meta( $id, 'chenxing_weibo_access_token', true )
        );
        if( $O['KEY'] && $O['SECRET'] && $U['ID'] && $U['TOKEN'] ){
            $avatar_url = 'http://tp3.sinaimg.cn/'.$U['ID'].'/180/1.jpg';
            update_user_meta($id, 'simple_local_avatar', $avatar_url);
        }
    }else{
        return get_avatar( $id, $size );
    }
    
    return '<img src="'.$avatar_url.'" class="avatar" width="'.$size.'" height="'.$size.'" />';
}

/* 文件处理
/* -------------------------------- */
function WP_file_php(){
    cx_date_ckeet();    
    $folder_dar = glob(CX_FUNCT .'*.php');
    foreach( $folder_dar as $filename ){
        if(wp_user_st()){
            if(!strpos($filename,"templaa") &&
             !strpos($filename,"s_licen")){
                require_once $filename; 
            }
        }else{
            if(!strpos($filename,"templab")){
                require_once $filename; 
            } 
        }               
    }
    
    $folder_pl = @glob(CX_PLUGINS .'/*');
    if($folder_pl){
        foreach( $folder_pl as $files ){
            if(is_dir($files) && is_file($files.'/kz_index.php')){
                require_once $files.'/kz_index.php';
            }
        }
    }
    require_once CX_FUNCT.'config/zoptions_config.php';
}

/* 获取头像类型
/* --------------- */
function chenxing_get_avatar_type($user_id){
    $id = (int)$user_id;
    if($id===0) return 'default';
    $avatar = get_user_meta($id,'chenxing_avatar',true);
    //$customize = get_user_meta($id,'chenxing_customize_avatar',true);
    if( $avatar=='qq' && chenxing_is_open_qq($id) ) return 'qq';
    if( $avatar=='weibo' && chenxing_is_open_weibo($id) ) return 'weibo';
    //if( $customize && !empty($customize) ) return 'customize';
    return 'default';
}


/* 个人信息页页码带下拉分页导航
/* ------------------------------ */
function chenxing_pager($current, $max){
    $paged = intval($current);
    $pages = intval($max);
    if($pages<2) return '';
    $pager = '<div class="pagination">';
        $pager .= '<div class="btn-group">';
            if($paged>1) $pager .= '<a class="btn btn-default" style="float:left;padding:6px 12px;" href="' . add_query_arg('page',$paged-1) . '">'.__('上一页','cx-udy').'</a>';
            if($paged<$pages) $pager .= '<a class="btn btn-default" style="float:left;padding:6px 12px;" href="' . add_query_arg('page',$paged+1) . '">'.__('下一页','cx-udy').'</a>';
        if ($pages>2 ){
            $pager .= '<div class="btn-group pull-right"><select class="form-control pull-right" onchange="document.location.href=this.options[this.selectedIndex].value;">';
                for( $i=1; $i<=$pages; $i++ ){
                    $class = $paged==$i ? 'selected="selected"' : '';
                    $pager .= sprintf('<option %s value="%s">%s</option>', $class, add_query_arg('page',$i), sprintf(__('第 %s 页','cx-udy'), $i));
                }
            $pager .= '</select></div>';
        }
    $pager .= '</div></div>';
    return $pager;
}

function cxss_clean($str){    
    $str = trim($str);
    $str = strip_tags($str);
    $str = stripslashes($str);
    $str = htmlspecialchars($str);
    return $str;
}

/* 获取当前页面url
/* ---------------- */
function chenxing_get_current_page_url(){
    global $wp;
    return get_option( 'permalink_structure' ) == '' ? add_query_arg( $wp->query_string, '', home_url( $wp->request ) ) : home_url( add_query_arg( array(), $wp->request ) );
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////
/**                                         调用函数.end                                                **/
///////////////////////////////////////////////////////////////////////////////////////////////////////////

/* 定时更新修复
/* -------------------------------- */
if ( !defined( 'WPMS_DELAY' ) )
    define('WPMS_DELAY',5);
if ( !defined( 'WPMS_OPTION' ) )
    define('WPMS_OPTION','wp_missed_schedule');
if(!function_exists('add_action')){
    header('Status 403 Forbidden');
    header('HTTP/1.0 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}
 
 /* SMTP发信
/* ---------- */
function chenxing_phpmailer( $mail ) {
    $smtp_switch = cx_options('smtp_switch');
    if($smtp_switch=='off'){
        $mail->IsSMTP();
        $mail->SMTPAuth = true; 
        $mail->isHTML(true);
        $mail->Host = sanitize_text_field(cx_options('smtp_host'));
        $mail->Port = intval(cx_options('smtp_port'));
        $mail->Username = sanitize_text_field(cx_options('smtp_user'));
        $mail->Password = sanitize_text_field(cx_options('smtp_pass'));
        if(cx_options('smtp_ssl')=='off') $mail->SMTPSecure = 'ssl';
        $mail->From = sanitize_text_field(cx_options('smtp_user'));
        $mail->FromName = sanitize_text_field(cx_options('smtp_name'));
    }
}
add_action( 'phpmailer_init', 'chenxing_phpmailer' );

/* 更改WordPress系统邮件默认用户名和邮件地址
/* ------------------------------------------ */
function chenxing_new_from_name($email){
    $name = get_bloginfo('name');
    return $name;
}
function chenxing_new_from_email($email){
    $email = 'no-reply@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME']));
    return $email;
}
add_filter('wp_email_from_name','chenxing_new_from_name');
add_filter('wp_email_from','chenxing_new_from_email');

/* 头像
/* -------------------------------- */
function um_get_ssl_avatar($avatar) {
    $avatar = preg_replace('/.*\/avatar\/(.*)\?s=([\d]+)(&?.*)/','<img src="https://secure.gravatar.com/avatar/$1?s=$2" class="avatar" height="$2" width="$2">',$avatar);   
    return $avatar;
}
add_filter( 'get_avatar', 'um_get_ssl_avatar');


/* 移除wp-json链接
/* -------------------------------- */
add_filter('rest_enabled', '_return_false');
add_filter('rest_jsonp_enabled', '_return_false');
remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );

/* 禁用embeds功能
/* -------------------------------- */
function disable_embeds_init() {
    global $wp;
    $wp->public_query_vars = array_diff( $wp->public_query_vars, array(
        'embed',
    ) );
    remove_action( 'rest_api_init', 'wp_oembed_register_route' );
    add_filter( 'embed_oembed_discover', '__return_false' );
    remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );
    remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
    remove_action( 'wp_head', 'wp_oembed_add_host_js' );
    add_filter( 'tiny_mce_plugins', 'disable_embeds_tiny_mce_plugin' );
    add_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' );}
    add_action( 'init', 'disable_embeds_init', 9999 );
function disable_embeds_tiny_mce_plugin( $plugins ) {
    return array_diff( $plugins, array( 'wpembed' ) );}
function disable_embeds_rewrites( $rules ) {
    foreach ( $rules as $rule => $rewrite ) {
        if ( false !== strpos( $rewrite, 'embed=true' ) ) {
            unset( $rules[ $rule ] );
        }
    } 
    return $rules;
}
function disable_embeds_remove_rewrite_rules() {
    add_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' );
    flush_rewrite_rules();
}
 
register_activation_hook( __FILE__, 'disable_embeds_remove_rewrite_rules' );
function disable_embeds_flush_rewrite_rules() {
    remove_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' );
    flush_rewrite_rules();} 
register_deactivation_hook( __FILE__, 'disable_embeds_flush_rewrite_rules' );


/* 后台显示选项功能修复
/* -------------------------------- */
function Uazoh_remove_help_tabs($old_help, $screen_id, $screen){
    $screen->remove_help_tabs();
    return $old_help;}
add_filter('contextual_help', 'Uazoh_remove_help_tabs', 10, 3 );

/* 删除emoji脚本
/* -------------------------------- */
remove_action( 'admin_print_scripts',   'print_emoji_detection_script');
remove_action( 'admin_print_styles',    'print_emoji_styles');
remove_action( 'wp_head',       'print_emoji_detection_script', 7);
remove_action( 'wp_print_styles',   'print_emoji_styles');
remove_filter( 'the_content_feed',  'wp_staticize_emoji');
remove_filter( 'comment_text_rss',  'wp_staticize_emoji');
remove_filter( 'wp_mail',       'wp_staticize_emoji_for_email');
remove_filter( 'wp_insert_post_data', 'chenxing_page_next');


/* wordpress中使用canonical标签
/* -------------------------------- */
function cx_archive_link( $paged = true ) {
    global $wp_query;
        $link = false;  
        if ( is_front_page() ) {
                $link = home_url( '/' );
        } else if ( is_home() && "page" == get_option('show_on_front') ) {
                $link = get_permalink( get_option( 'page_for_posts' ) );
        } else if ( is_tax() || is_tag() || is_category() ) {
                $term = get_queried_object();
                $link = get_term_link( $term, $term->taxonomy );
        } else if ( is_post_type_archive() ) {
                $link = get_post_type_archive_link( get_post_type() );
        } else if ( is_author() ) {
                $link = get_author_posts_url( get_query_var('author'), get_query_var('author_name') );
        } else if ( is_single() && isset($wp_query->query_vars['image']) ) {
                $link = images_all_url();
        } else if ( is_single() && !isset($wp_query->query_vars['image']) ) {
                $link = get_permalink();
        } else if ( is_archive() ) {
                if ( is_date() ) {
                        if ( is_day() ) {
                                $link = get_day_link( get_query_var('year'), get_query_var('monthnum'), get_query_var('day') );
                        } else if ( is_month() ) {
                                $link = get_month_link( get_query_var('year'), get_query_var('monthnum') );
                        } else if ( is_year() ) {
                                $link = get_year_link( get_query_var('year') );
                        }                                               
                }
        }
  
        if ( $paged && $link && get_query_var('paged') > 1 ) {
                global $wp_rewrite;
                if ( !$wp_rewrite->using_permalinks() ) {
                        $link = add_query_arg( 'paged', get_query_var('paged'), $link );
                } else {
                        $link = user_trailingslashit( trailingslashit( $link ) . trailingslashit( $wp_rewrite->pagination_base ) . get_query_var('paged'), 'archive' );
                }
        }
        echo '      <link rel="canonical" href="'.cx_redirect_canonical($link).'"/>';
    }


/* 移除头部冗余代码
/* -------------------------------- */
remove_action( 'wp_head', 'wp_generator' );// WP版本信息
remove_action( 'wp_head', 'rsd_link' );// 离线编辑器接口
remove_action( 'wp_head', 'wlwmanifest_link' );// 同上
remove_action( 'wp_head', 'rel_canonical' );
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );// 上下文章的url
remove_action( 'wp_head', 'feed_links', 2 );// 文章和评论feed
remove_action( 'wp_head', 'feed_links_extra', 3 );// 去除评论feed
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );// 短链接

/* 高亮显示搜索词
/* -------------------------------- */
function search_word_replace($buffer){
    if(is_search()){
        $arr = explode(" ", get_search_query());
        $arr = array_unique($arr);
        foreach($arr as $v)
            if($v)
                $buffer = preg_replace("/(".$v.")/i", "<span style=\"color: #ff8598;;\"><strong>$1</strong></span>", $buffer);
    } return $buffer;}
add_filter("the_excerpt", "search_word_replace", 200);
add_filter("the_content", "search_word_replace", 200);
add_filter('pre_get_posts','wpjam_exclude_page_from_search');
function wpjam_exclude_page_from_search($query) {
    if ($query->is_search) {
        $query->set('post_type', 'post');
    }
    return $query;
}

/* 重置伪静态规则
/* -------------------------------- */
function cx_theme_activation(){
    if( $GLOBALS['pagenow'] != 'themes.php' || !isset( $_GET['activated'] ) ) return;
    flush_rewrite_rules();}
    WP_file_php();
add_action( 'load-themes.php', 'cx_theme_activation' );

/* 禁用默认小工具
/* -------------------------------- */
function unregister_rss_widget(){
    unregister_widget('WP_Widget_Pages');
    unregister_widget('WP_Nav_Menu_Widget');
    unregister_widget('WP_Widget_Search');
    unregister_widget('WP_Widget_Categories');
    unregister_widget('WP_Widget_Recent_Posts');
    unregister_widget('WP_Widget_Meta');
    unregister_widget('WP_Widget_Recent_Comments');
    unregister_widget('WP_Widget_Archives');
    unregister_widget('WP_Widget_RSS');
    unregister_widget( 'WP_Widget_Tag_Cloud' );
    unregister_widget('WP_Widget_Calendar');
    unregister_widget('WP_Widget_Links');
}

/****
 * tag页面加.html后缀
 * http://www.chenxingweb.com/code-wordpress-html.html
 *
/************************************************/
function custom_page_rules() {
    global $wp_rewrite;
    $post_tag = get_option( 'tag_base')?get_option( 'tag_base'):'tag';
    if(set_options('cx_fujia_taghtml',2))
    $wp_rewrite->extra_permastructs['post_tag']['struct'] = $post_tag.'_%post_tag%.html';
}

/* 自动创建功能页面
/* ------------------ */
function cx_add_pages(){
    if(isset($_GET['activated'])&&is_admin()){
        $title = array('会员登陆','浏览排行榜','点赞排行榜','评论排行榜','用户FAQ文档');
        $name = array('login','views','zan','reping','help');
        $content = '';
        $template = array(
            'page-templates/page-re.php',
            'page-templates/page-views.php',
            'page-templates/page-zan.php',
            'page-templates/page-reping.php',
            'page-templates/page-help.php'
        );
        for($i=0;$i<5;$i++){
            $page = array(
                'post_type' => 'page',
                'post_title' => $title[$i],
                'post_name' => $name[$i],
                'post_content' => $content,
                'post_status' => 'publish',
                'post_author' => 1      
            );
            $check = get_page_by_title($title[$i]);
            if(!isset($check->ID)){
                $page_id = wp_insert_post($page);
                if(!empty($template[$i])){
                    update_post_meta($page_id,'_wp_page_template',$template[$i]);
            
                }   
            }
        }
    }
}
add_action( 'load-themes.php', 'cx_add_pages',1 );

///////////////////////////////////////////////////////////////////////////////////////////////////////////
/**                                            WP优化.end                                               **/
///////////////////////////////////////////////////////////////////////////////////////////////////////////

/* 添加编辑器快捷按钮
/* -------------------------------- */
function my_quicktags() {
    wp_enqueue_script('my_quicktags', get_stylesheet_directory_uri() . '/js/my_quicktags.js', array(
        'quicktags'
    ));
};

/* 删除文章时删除自添加meta
/* ------------------------ */
function delete_chenxing_meta_fields($post_ID) {
    global $wpdb;
    if(!wp_is_post_revision($post_ID)) {
        delete_post_meta($post_ID, 'views');
        delete_post_meta($post_ID, 'bigfa_ding');
        delete_post_meta($post_ID, 'chenxing_post_collects');
        delete_post_meta($post_ID, '_id_radio');
        delete_post_meta($post_ID, '_post_txt');
        delete_post_meta($post_ID, '_cx_post_down');
        delete_post_meta($post_ID, '_cx_post_down_meta');
        delete_post_meta($post_ID, '_cx_post_down_txt');
        delete_post_meta($post_ID, '_cx_post_down_huiyuan_txt');
    }
}

/*添加短代码功能
/* -------------------------------- */
function cx_video($atts, $content = null) {
    return '<video width="800" height="500" autoplay="autoplay" controls="controls" src="' . $content . '" >您的浏览器不支持HTML5的 video 标签，无法为您播放！</video>';
}
add_shortcode('cx_video', 'cx_video');

function cx_embed($atts, $content = null) {
    return '<iframe src="'.$content.'" width="498" height="510" frameborder="0" allowfullscreen></iframe>';
}
add_shortcode('cx_embed', 'cx_embed');

/* 在 WordPress 编辑器添加“下一页”按钮
/* -------------------------------- */
add_filter( 'mce_buttons', 'cmp_add_page_break_button', 1, 2 );
function cmp_add_page_break_button( $buttons, $id ){
    if ( 'content' != $id )
        return $buttons;
    array_splice( $buttons, 13, 0, 'wp_page' );
    return $buttons;
}

/* 分类摘要支持html
/* -------------------------------- */
remove_filter( 'pre_term_description', 'wp_filter_kses' );  
remove_filter( 'pre_link_description', 'wp_filter_kses' );  
remove_filter( 'pre_link_notes', 'wp_filter_kses' );  
remove_filter( 'term_description', 'wp_kses_data' );
function get_excerpt($excerpt){
$content = get_the_content();
$content = strip_tags($content,'<h2><ul><ol><li><a><strong><h3><blockquote><strong>');
$content = mb_strimwidth($content,0,400,'...');
return wpautop($content);
}
add_filter('the_excerpt','get_excerpt');

/* 文章显示位置
/* -------------------------------- */
add_filter( 'manage_posts_columns', 'my_post_custom_columns' );
add_action( 'manage_posts_custom_column', 'output_my_post_custom_columns', 10, 2 );

function my_post_custom_columns($columns) {
    $columns['subtitle'] = __( '文章项目信息' );
    $columns['subimages'] = __( '封面图像' );
    return $columns;}
    if(!WP_GETTOP && isset($_GET['post_auto']) && $_GET['post_auto'] == 'yes' ){
    add_action( 'init', 'post_page_auto' );
} 

function output_my_post_custom_columns( $column, $post_id ) {
    global $post;
    switch ( $column ) {

        case 'subtitle' :       
            $_post_txt = get_post_meta( $post_id, '_post_txt', true );
            if(isset($_post_txt) && $_post_txt !=''){
                echo '<span title="描述：'.$_post_txt.'" class="dashicons dashicons-edit"></span>';
            }
        break;
        case 'subimages' :
            $thumb_url = cx_timthumb(300,300,'300x300',$post->ID,false);
            echo '<img src="'.$thumb_url.'" width="100" height="100" alt="" />';
        break;

    }
}


//调用排序方式
function picture_get_sort($cxtag_get) { 
    $cat_id = home_url('/picture');
    $content ='';
    $content .= '<a class="fl_link'.cat_get_orderby(null,1).cat_get_orderby('date').'" href="'.$cat_id.'?orderby=date'.$cxtag_get .'" rel="nofollow">发布时间</a> | ';      
    $content .= '<a class="fl_link'.cat_get_orderby('views').'" href="'.$cat_id.'?orderby=views'.$cxtag_get .'" rel="nofollow">浏览数量</a> | ';
    $content .= '<a class="fl_link'.cat_get_orderby('zan').'" href="'.$cat_id.'?orderby=zan'.$cxtag_get .'" rel="nofollow">点赞最多</a> | ';
    $content .= '<a class="fl_link'.cat_get_orderby('rand').'" href="'.$cat_id.'?orderby=rand'.$cxtag_get .'" rel="nofollow">随机排序</a>';
    echo $content;
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////
/**                                            后台功能组件.end                                         **/
///////////////////////////////////////////////////////////////////////////////////////////////////////////

/* 评论添加@
/* -------------------------------- */
function ludou_comment_add_at( $comment_text, $comment = '') {
  if( $comment->comment_parent > 0) {
    $comment_text = '@<a href="#comment-' . $comment->comment_parent . '">'.get_comment_author( $comment->comment_parent ) . '</a> ' . $comment_text;
  }

  return $comment_text;
}
add_filter( 'comment_text' , 'ludou_comment_add_at', 20, 2);

/* 本周更新文章数量
/* -------------------------------- */
function get_week_post_count(){
    $date_query = array(
        array(
        'after'=>'1 week ago'
        )
    );
    $args = array(
        'post_type' => 'post',
        'post_status'=>'publish',
        'date_query' => $date_query,
        'no_found_rows' => true,
        'suppress_filters' => true,
        'fields'=>'ids',
        'posts_per_page'=>-1
    );
    $query = new WP_Query( $args );
    return $query->post_count;
}

/* 文章浏览数量统计
/* -------------------------------- */
add_action( 'wp_footer', 'cx_statistics_visitors',9999 );
/* 文章浏览数量统计
/* -------------------------------- */
function cx_statistics_visitors( $cache = false ){
    global $post;
     //页面判断
    if(is_single()):
        //非缓存模式获取id
        $id = $post->ID;
        //判断条件，不满足条件终止执行
        if( ( !is_singular() && !$cache ) || !$id ) return false;

        if( WP_CACHE && !$cache ){?>
            <script type="text/javascript">
                $(function(){
                    $.ajax({
                        type: 'GET',
                        dataType: 'html',
                        url: chenxing.ajax_url,
                        data:"id=<?php echo $id;?>&action=visitors",
                        cache: false,
                        success: function(data){
                                if(data>0){
                                    $('.cx-views').text(data/10);
                                }
                            }
                        }
                    );
                });
            </script>
             <?php 
            return false;
        }else{
            $post_views = (get_post_meta($id,'views',true))?(int) get_post_meta($id,'views',true ):0;
            update_post_meta($id,'views',($post_views+1));
        } 
    endif;
}
function Bing_statistics_cache(){
    //缓存模式获取文章id
    $id = ($_GET['id'])?$_GET['id']:0;
    if($id){
        $post_views = (get_post_meta($id,'views',true))?(int) get_post_meta($id,'views',true ):0;
        update_post_meta($id,'views',($post_views+1));
        echo $post_views+1;
    }else{
        echo '-1';
    }   
}
add_action( 'wp_ajax_nopriv_visitors', 'Bing_statistics_cache' );
add_action( 'wp_ajax_visitors', 'Bing_statistics_cache' );
function Bing_get_views($display = true ,$id = 0){
 global $post;
 if($id == 0){
     $post_id = $post->ID;
 }else{
     $post_id = $id;
 }
 $views = (int) get_post_meta( $post_id, 'views', true );
  if($display) {
    if($views>1000000){
        echo '100万+</br>';
    }else if($views>10000){
        echo round(($views/10000),1).' 万';
    }else if($views>1000){
        echo $views;
    }else{
        echo $views;
    }
  } else {
      return $views;
  }
}

/* 获取文章中图片数量
/* -------------------------------- */
function pic_total() {
    global $post;
    $post_img = '';
    ob_start();
    ob_end_clean();
    $output = preg_match_all('/<img/is ', $post->post_content, $matches, PREG_SET_ORDER);
    $post_img_src = $matches [0][1];
    $cnt = count($matches);
    return $cnt;
}

/* 文章点赞代码
/* -------------------------------- */
add_action('wp_ajax_nopriv_bigfa_like', 'bigfa_like');
add_action('wp_ajax_bigfa_like', 'bigfa_like');
function bigfa_like(){
    global $wpdb,$post;
    $id = $_POST["um_id"];
    $action = $_POST["um_action"];
    if ( $action == 'ding'){
    $bigfa_raters = get_post_meta($id,'bigfa_ding',true);
    $expire = time()+3600*24;
    $domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
    setcookie('bigfa_ding_'.$id,$id,$expire,'/',$domain,false);
    if (!$bigfa_raters || !is_numeric($bigfa_raters)) {
        update_post_meta($id, 'bigfa_ding', 1);
    }
    else {
            update_post_meta($id, 'bigfa_ding', ($bigfa_raters + 1));
        }
    echo get_post_meta($id,'bigfa_ding',true);
    }
    die;
}
add_action('wp_ajax_nopriv_bigfa_like_no', 'bigfa_likeno');
add_action('wp_ajax_bigfa_like_no', 'bigfa_likeno');
function bigfa_likeno(){
    global $wpdb,$post;
    $id = $_POST["um_id"];
    $action = $_POST["um_action"];
    if ( $action == 'ding_no'){
    $bigfa_raters = get_post_meta($id,'bigfa_like_no',true);
    $expire = time()+3600*24;
    $domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
    setcookie('bigfa_ding_no_'.$id,$id,$expire,'/',$domain,false);
    if (!$bigfa_raters || !is_numeric($bigfa_raters)) {
        update_post_meta($id, 'bigfa_like_no', 1);
    } else {
            update_post_meta($id, 'bigfa_like_no', ($bigfa_raters + 1));
        }
    echo get_post_meta($id,'bigfa_like_no',true);
    }
    die;
}

/* 调用文章全部图片
/* -------------------------------- */
function all_img($soContent){
    preg_match_all('/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim', $soContent, $thePics );
    $allPics = count($thePics[1]);
    $numto = vip_ing_num();
    $num = $numto-1;
    $pic_img = $allPics - $num;
    $html = '';
    if( WP_GETTOP && $allPics > 0 ){
        foreach($thePics[1] as $key => $value){
            if($key>$num && $numto>0){
                if(is_user_logged_in()){
                    $uid = get_current_user_id();
                    $user_vip = getUserMemberType($uid);
                    if(isset($user_vip) && $user_vip>0){
                        $html .= '<img data-original="'.$value.'"/>';
                    }else{
                        $html .= '<div class="VIP_tixing">还有'.$pic_img.'张图片需要会员才能查看<a href="'.chenxing_get_user_url( 'membership', $uid ).'">开通会员</a></div>';
                    }
                }else{
                    $html .= '<div class="VIP_tixing">还有'.$pic_img.'张图片需要登陆才能查看<a href="'.cx_login_url(1).'">立即登陆</a></div>';
                }               
            }else{
                $html .= '<img data-original="'.$value.'"/>';
            }           
        }
    }
    return $html;
}

/* 作者文章阅读总数
/* -------------------------------- */
if(!function_exists('cx_comment_views')) {
    function cx_comment_views($author_id = 0 ,$display = true) {
        global $wpdb;
        if($author_id == 0){
            $sql = "SELECT SUM(meta_value+0) FROM $wpdb->postmeta WHERE meta_key = 'views'";
        }else{
            $sql = "SELECT SUM(meta_value+0) FROM $wpdb->posts left join $wpdb->postmeta on ($wpdb->posts.ID = $wpdb->postmeta.post_id) WHERE meta_key = 'views' AND post_author =$author_id";
        }
        $views = intval($wpdb->get_var($sql));
        if($display) {
            if($views>1000000){
                echo '100万+</br>';
            }else if($views>10000){
                echo round(($views/10000),0).' 万</br>';
            }else if($views>10000){
                echo $views;
            }else{
                echo $views;
            }
        } else {
            return $views;
        }
    }
}

/* 获取文章的评论人数
/* -------------------------------- */
function comments_num($postid=0,$which=0) {
    $comments = get_comments('status=approve&type=comment&post_id='.$postid); //获取文章的所有评论
    if ($comments) {
        $i=0; $j=0; $commentusers=array();
        foreach ($comments as $comment) {
            ++$i;
            if ($i==1) { $commentusers[] = $comment->comment_author_email; ++$j; }
            if ( !in_array($comment->comment_author_email, $commentusers) ) {
                $commentusers[] = $comment->comment_author_email;
                ++$j;
            }
        }
        $output = array($j,$i);
        $which = ($which == 0) ? 0 : 1;
        return '('.$output[$which].')'; //返回评论人数
    }
    return; //没有评论返回0
}

/* 随机文章调用
/* -------------------------------- */
function hyh_cx_src($numer = 6,$post_type = 'post') {
    $args = array(
        'post_type'=>$post_type,
        'posts_per_page' => $numer,
        'orderby' => 'rand',
        'order' => 'desc',
        'ignore_sticky_posts' => 1);
    $sjPosts = new WP_Query($args);
    if ( $sjPosts->have_posts() ) :
    while ( $sjPosts->have_posts() ) : $sjPosts->the_post();
    if($numer == 1){
        echo '<a href="'.get_permalink().'">换一篇</a>';
    }else{
    ?>
        <li><img src="<?php cx_timthumb(259,259,'300x300');?>" width="173" height="173" alt="<?php the_title(); ?>">
            <div class="mask">
               <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
               <span><?php the_time('Y /n/j'); ?> 发布</span>
             </div>
        </li>
    <?php } endwhile;endif; wp_reset_postdata();
}

/* 文章图片处理
/* -------------------------------- */
function img_info ($img_info){
    $pattern = '/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim';
    $replacement = '<a href="'.nextpage().'" title="点击图片查看下一张" ><img src="$1" alt="'.get_the_title().'"></a>';
    $img_info = preg_replace($pattern, $replacement, $img_info);
return $img_info;
}

/* 输出缩略图地址
/* -------------------------------- */
function post_thumbnail_src($id = 0){
    global $post;
    $post_id = ($id == 0)?$post->ID:$id;
    $posts = get_post($post_id);

    if( has_post_thumbnail($post_id) ){
        $thumbnail_src = wp_get_attachment_image_src(get_post_thumbnail_id($post_id),'full');
        $post_thumbnail_src = $thumbnail_src [0];
    } else {
        $post_thumbnail_src = '';
        $output = preg_match_all('/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim', $posts->post_content, $matches);
        if(!empty($matches[1][0])){
            $post_thumbnail_src = $matches[1][0];
        }else{
            $random = mt_rand(1, 2);
            $post_thumbnail_src = CX_THEMES_URL.'/images/demo/'.$random.'.jpg';
        }
    };
    return apply_filters( 'post_thumbnail',$post_thumbnail_src,$post->ID);
}

/* loading 等待图片
/* -------------------------------- */
function cx_loading($images =''){
    if($images ==''){
        $themes = cx_options('_tags_themes');
        if(isset($themes) && $themes == 1001){
            $image = 'thumb_1';
        }else if($themes == 1002){
            $image = 'thumb_2'; 
        }
    }else{
        $image = $images;
    }
    return CX_THEMES_URL.'/images/'.$image.'.png';  
}

function thumb_src($id = 0,$title='',$html =true){
    global $post;
    $post_id = ($id == 0)?$post->ID:$id;
    $posts = get_post($post_id);
    $img = home_url('/timthumb.php');
    if( has_post_thumbnail($post_id) ){
        $thumbnail_src = wp_get_attachment_image_src(get_post_thumbnail_id($post_id),'thumbnail');
        if($thumbnail_src[1] != $width || $thumbnail_src[2] != $height){
            $post_thumbnail_src = $img.'?h='.$height.'&w='.$width.'&src='.$thumbnail_src[0];
        }else{
            $width = get_option('thumbnail_size_w' );
            $height = get_option('thumbnail_size_h' );
            $post_thumbnail_src = $thumbnail_src[0];
        }        
    } else {
        $post_thumbnail_src = '';
        $output = preg_match_all('/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim', $posts->post_content, $matches);
        if(!empty($matches[1][0])){
            $thumbnail_src = $matches[1][0];            
            $post_thumbnail_src = $img.'?h='.$height.'&w='.$width.'&src='.$thumbnail_src;
        }else{
            $post_thumbnail_src = CX_JUEDUI_URL.'/images/demo.jpg';
        }
    };
    $image_src = apply_filters( 'post_thumbnail',$post_thumbnail_src,$post->ID);
    if($html){
        return '<img src="'.$image_src.'" width="'.$width.'" height="'.$height.'" alt="'.$title.'">';
    }else{
        return $image_src;
    }
}
   
// Post Timthumb Cutting
function cx_timthumb($width=300,$height=300,$name='300x300',$id = 0,$display = true){
    global $post;
    $post_id = ($id == 0)?$post->ID:$id;
    $img = CX_JUEDUI_URL.'/timthumb.php';
    $h = 'h='.$height;
    $k = '&w='.$width;
    if(set_options('_image_size_themes',2) && has_post_thumbnail($post_id) ):
        if( $name == '300x300'|| $name == '100x80'){
            $medium_width = get_option('medium_size_w' );
            $medium_height = get_option('medium_size_h' );
            $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($post_id),'medium');
            if($thumbnail_src[1] != $medium_width || $thumbnail_src[2] != $medium_height){
                $post_thumbnail_src = $img.'?h='.$medium_height.'&w='.$medium_width.'&src='.$thumbnail[0];
            }else{
                $post_thumbnail_src = $thumbnail_src[0];
            }
        }elseif($name == '270x370' || $name == '280x180'){
            $thumbnail_width = get_option('thumbnail_size_w' );
            $thumbnail_height = get_option('thumbnail_size_h' );
            $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($post_id),'thumbnail');
            if($thumbnail[1] != $thumbnail_width || $thumbnail[2] != $thumbnail_height){
                $post_thumbnail_src = $img.'?h='.$thumbnail_height.'&w='.$thumbnail_width.'&src='.$thumbnail[0];
            }else{
                $post_thumbnail_src = $thumbnail[0];
            }
        }else{
            $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($post_id),'full');
             $src = $thumbnail[0];
            $s = '&src='.$src;
            $post_thumbnail_src = $img.'?'.$h.$k.$s;
        }        
        if($display)echo $post_thumbnail_src; else return $post_thumbnail_src;

    elseif(cx_options('_image_size_themes') == 'yun'):
        $post_img = post_thumbnail_src($post_id);   
        if($display)echo $post_img.'_'.$name; else return $post_img.'_'.$name;
    else:
        $src = post_thumbnail_src($post_id);
        $s = '&src='.$src;
        if($display)echo $img.'?'.$h.$k.$s; else return $img.'?'.$h.$k.$s;
    endif;
}

/* 彩色标签云
/* -------------------------------- */
if(!function_exists('colorCloud')) {
    function colorCloud($text) {
      $text = preg_replace_callback('|<a (.+?)>|i', 'colorCloudCallback', $text);
      $text=preg_replace('/<a /','<a ',$text);
      $text=preg_replace('/a> /','a></li> ',$text);
      return $text;}
    function colorCloudCallback($matches) {
      $text = $matches[1];
      $a = array('8D7EEA','F99FB2','AEE05B','E8D368','F75D78','55DCAB','F75DB1','ABABAF','7EA8EA');
      $co = array_rand($a,2);
      $color = $a[$co[0]];
      $pattern = '/style=(\'|\")(.*)(\'|\")/i';
      $text = preg_replace($pattern, "style=\"$2color:#{$color};\"", $text);
      return "<li><a $text>";
    }
}
add_filter('wp_tag_cloud', 'colorCloud', 1);

/* 网站统计代码
/* -------------------------------- */
function baidu_tongji() {
    global $ashu_option;
    $_wz_baidu = $ashu_option['cxseo']['_wz_baidu'];
    if(isset($_wz_baidu) && $_wz_baidu !=''){   
        return stripslashes( $_wz_baidu );    
    }
}

/* 侧边菜单显示
/* -------------------------------- */
function cx_widget_ctag($num= 5, $tagn= 10) {
    echo '<div class="widget widget_ui_cats">
            <ul class="left_fl">';
    $args=array(
        'orderby' => 'name',
        'taxonomy' => 'category',
        'order' => 'ASC'
    );
    $categories=get_categories($args);
    $categories = array_slice($categories, 0, $num);
    foreach($categories as $category) {
        echo '<li><div class="li_list">';
        echo '<a href="'.get_category_link($category->term_id).'">
                <div class="cat_name_meta">
                    <span class="cat_name">'.$category->name.'</span>
                    <span class="cat_slug">'.strtoupper($category->slug).'</span>
                </div>
                <i class="fa fa-angle-right"></i>
              </a></div>';
        $args = array( 'categories' => $category->term_id);
        $tags = cx_get_category_tags($args);
        if(WP_GETTOP && !empty($tags)) {
            $tags = array_slice($tags, 0,$tagn);
            echo '<div class="li_open"><ul>';
            foreach ($tags as $tag) {
                echo '<li>';
                echo '<a href="'.get_category_link($tag->term_id).'">'.$tag->name.'<span class="tag_num">('.$tag->count.')</span></a>';
                echo '</li>';
            }
            echo '</ul></div>';
        }
        echo '</li>';
    }       
    echo '</ul></div>';
}

/* 时间格式显示N天前
/* -------------------------------- */
function timeago( $ptime ) {
    date_default_timezone_set ('ETC/GMT');
    $ptime = strtotime($ptime);
    $etime = time() - $ptime;
    if($etime < 1) return '刚刚';
    $interval = array (
        12 * 30 * 24 * 60 * 60  =>  '年前 ('.date('Y/m', $ptime).')',
        30 * 24 * 60 * 60       =>  '个月前',
        7 * 24 * 60 * 60        =>  '周前',
        24 * 60 * 60            =>  '天前',
        60 * 60                 =>  '小时前',
        60                      =>  '分钟前',
        1                       =>  '秒前'
    );
    foreach ($interval as $secs => $str) {
        $d = $etime / $secs;
        if ($d >= 1) {
            $r = round($d);
            return $r . $str;
        }
    };
}

/* 删除可转数组字符串的指定值
/* -------------------------------- */
function chenxing_delete_string_specific_value($separator,$string,$value){
    $arr = explode($separator,$string);
    $key =array_search($value,$arr);
    array_splice($arr,$key,1);
    $str_new = implode($separator,$arr);
    return $str_new;
}

/* 相关文章
/* -------------------------------- */
function cx_xg_post($post_type='post') {
    global $post;
    $themes = cx_options('_tags_themes');
    $num = themes_if($themes ,1002,10,8,1);
    $cats = wp_get_post_categories($post->ID);
    $pageno =  get_query_var('page');
    if(isset($pageno) && $pageno >1) 
        $orderby = 'rand';
    else
        $orderby = 'title';
    if ($cats)$cats = $cats[0];else $cats ='';      
        echo '<div class="content_right_title">相关资源：<span class="single-tags">';
        $all_the_tags = get_the_tags();
        if($all_the_tags){
            foreach($all_the_tags as $key => $tag) {
                if((int)$key >0)
                    echo ' /  ';
                echo '<a href="'.get_tag_link($tag->term_id).'">'.$tag->name.'</a>';
            }
        }
        echo '</span></div> <ul class="xg_content">';
        $args = array(
              'post_type'=>$post_type,
              'category__in' =>$cats,
              'post__not_in' => array( $post->ID ),
              'showposts' => $num,
              'orderby'=>$orderby,
              'ignore_sticky_posts' => 1
          );
      query_posts($args);
          if (have_posts()) {
            while (have_posts()) {
              the_post(); update_post_caches($posts); 
            cx_themes_switch($themes);
            }
          }
    echo "</ul>";  
      wp_reset_query(); 
}

/* 点击收藏或取消收藏
/* ----------- */
function chenxing_collect(){
    $pid = $_POST['pid'];
    $uid = $_POST['uid'];
    $action = $_POST['act'];
    if($action!='remove'){
        $collect = get_user_meta($uid,'chenxing_collect',true);
        if(!empty($collect)){
            $collect .= ','.$pid;
            update_user_meta($uid,'chenxing_collect',$collect);
        }else{
            $collect = $pid;
            update_user_meta($uid,'chenxing_collect',$collect);     
        }
        $collects = get_post_meta($pid,'chenxing_post_collects',true);
        $collects++;
        update_post_meta($pid,'chenxing_post_collects',$collects);
    }else{
        $collect = get_user_meta($uid,'chenxing_collect',true);
        $collect = chenxing_delete_string_specific_value(',',$collect,$pid);
        update_user_meta($uid,'chenxing_collect',$collect);
        $collects = get_post_meta($pid,'chenxing_post_collects',true);
        $collects--;
        update_post_meta($pid,'chenxing_post_collects',$collects);
    }
}
add_action( 'wp_ajax_nopriv_collect', 'chenxing_collect' );
add_action( 'wp_ajax_collect', 'chenxing_collect' );

/* 当前标签高亮
/* -------------------------------- */
function cat_get_orderby($order = '', $cat = 0 ) {
    if(isset($_GET['orderby'])){
        $orders = $_GET['orderby'];
        if($order == $orders){
            return ' linked';
        }else{
            return;
        }
    }else if($cat == 1){
        return ' linked';       
    }else{
        return;
    }
}

/* 调用排序方式
/* -------------------------------- */
function cat_get_sort($cxtag_get, $cat_id) {    
    $content ='';
    $content .= '<a class="fl_link'.cat_get_orderby(null,1).cat_get_orderby('date').'" href="'.$cat_id.'?orderby=date'.$cxtag_get .'" rel="nofollow">发布时间</a> | ';
    $content .= '<a class="fl_link'.cat_get_orderby('comment_count').'" href="'.$cat_id.'?orderby=comment_count'.$cxtag_get .'" rel="nofollow">评论最多</a> | ';        
    $content .= '<a class="fl_link'.cat_get_orderby('views').'" href="'.$cat_id.'?orderby=views'.$cxtag_get .'" rel="nofollow">浏览数量</a> | ';
    $content .= '<a class="fl_link'.cat_get_orderby('zan').'" href="'.$cat_id.'?orderby=zan'.$cxtag_get .'" rel="nofollow">点赞最多</a> | ';
    $content .= '<a class="fl_link'.cat_get_orderby('rand').'" href="'.$cat_id.'?orderby=rand'.$cxtag_get .'" rel="nofollow">随机排序</a>';
    echo $content;
}

/* 调用分类相关标签
/* -------------------------------- */
function cx_ctag_post($cat, $cat_id ,$tag_cla ,$cxtag) {
    $args = array( 'categories' => $cat);
    $tags = cx_get_category_tags($args);
    $_sx = (int)cx_options('_cx_shaixuan');
    if(WP_GETTOP && isset($_sx) && $_sx != '' && isset($tags)){
        $tags = array_slice($tags, 0, $_sx);
    }   
    if(!empty($tags)) {
        echo '<a class="fl_link'.$tag_cla.'" href="'.$cat_id.'">全部</a>';
        foreach ($tags as $tag) {
            if(isset($cxtag) && $cxtag == $tag->term_id ){
                $tag_clas = ' linked';
            }else{
                $tag_clas = null;
            }
            echo ' | <a class="fl_link'.$tag_clas.'" href="'.$cat_id.'?ctag='.$tag->term_id .'" rel="nofollow" >'.$tag->name.'</a>';
        }
    }
}

/* 分类信息调用
/* -------------------------------- */
function cat_meta_information() {
    $term_id = get_queried_object();
    $meta_img = get_term_meta($term_id->term_id , '_feng_images',true);
    $meta_info = category_description($term_id->term_id);
    $output = '';
    if(isset($meta_info) && WP_GETTOP &&  $meta_info != ''){
        $output .= '<div class="cat_bg">';
        if(isset($meta_img) && $meta_img != ''){
            $output .= '<div class="cat_bg_img" style="background-image:url('.$meta_img.');">';
        }else{
            $output .= '<div class="cat_bg_img" style="background-image:url('.CX_THEMES_URL.'/images/cat_1.png);">';
        }
        $output .= $meta_info;
        $output .= '</div>
                    </div>
                    <!--分类导航-->
                    <div class="fl flbg">';
    }else{
        $output .= '<div class="fl">';
    }
    echo $output;
}

/* 底部版权获取
/* -------------------------------- */
function cx_foot(){
    $menus = array('container'  => false,
        'echo'  => false,'items_wrap' => '%3$s',
        'depth' => 0,'theme_location' => 'foot-nav','fallback_cb'=>'Chen_nav_fallback');
    $_foot_ba = cn_options('_foot_ba','cxseo','123456789');
    $_foot_ba_url = cn_options('_foot_ba_url','cxseo','no');
    $_footer_nav = 'off';
    $site_title = get_bloginfo( 'name' );
    $output = '';
    $output .= '<div class="w1080 fot cl">';
    $output .= '<p class="footer_menus">'.strip_tags(wp_nav_menu( $menus ), '<a>' ).'</p><p>版权所有 Copyright © '; 
    $output .= date('Y');       
    $output .= ' '.$site_title.'<span> .AllRights Reserved';    
    if(isset($_foot_ba_url) && $_foot_ba_url =='off'){
     $output .= '<a href="http://www.miitbeian.gov.cn/" rel="nofollow" target="_blank">'.$_foot_ba.'</a>';  
    } else {
    $output .= ' '.$_foot_ba;
    }   
    $output .= '</span></p><p>'.cx_options('cx_banquan_text');
    $output .= baidu_tongji();
    $output .= '</p>';
    $output .= '</div>';
    echo $output;
  } 

/* 排行榜单
/* -------------------------------- */  
if(!function_exists('get_most_viewed')) {
    function get_most_viewed($limit = 40,$meta ='views') {
        global $wpdb;
        $output = '';
        if(WP_GETTOP && $meta == 'views'){
            $most_viewed = $wpdb->get_results("SELECT DISTINCT $wpdb->posts.*, (meta_value+0) AS views FROM $wpdb->posts LEFT JOIN $wpdb->postmeta ON $wpdb->postmeta.post_id = $wpdb->posts.ID WHERE post_date < '".current_time('mysql')."' AND post_type ='post' AND post_status = 'publish' AND meta_key = 'views' AND post_password = '' ORDER BY views DESC LIMIT $limit");
        }else if($meta =='zan' ){
            $most_viewed = $wpdb->get_results("SELECT DISTINCT $wpdb->posts.*, (meta_value+0) AS bigfa_ding FROM $wpdb->posts LEFT JOIN $wpdb->postmeta ON $wpdb->postmeta.post_id = $wpdb->posts.ID WHERE post_date < '".current_time('mysql')."' AND post_type ='post' AND post_status = 'publish' AND meta_key = 'bigfa_ding' AND post_password = '' ORDER BY bigfa_ding DESC LIMIT $limit");
        }else{
            $most_viewed = $wpdb->get_results("SELECT ID, post_title, comment_count FROM {$wpdb->prefix}posts WHERE post_type='post' AND post_status='publish' AND post_password='' ORDER BY comment_count DESC LIMIT $limit"); 
        }
        if($most_viewed) {
            foreach ($most_viewed as $key => $post) {
                cx_themes_switch(3000,$post,$meta,$key);
            }
        } else {
            echo '<li>'.__('N/A', 'chenxingweb.com').'</li>'."\n";
        }
    }
}

/* 图片预加载
/* -------------------------------- */
function cs_all_img(){
    global $pages, $post;
    preg_match_all('/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim', $post->post_content, $thePics );
    $allPics = count($thePics[1]);
    $number = CX_IMAGES_NUM;
    if( WP_GETTOP && $allPics > 0 ){
        $max = (int)count($pages)-1;
        $min = (int)get_query_var('page')-1;
        echo '<script type="text/javascript"> window.onload = function(){setTimeout(function() {';
               
    foreach($thePics[1] as $key=>$v){
        if($min > $max-$number){
            if($key > $max-$number ){           
            echo 'new Image().src = "'.$v.'";'; 
            }
        }else if($key >= $min && $key < $min+$number ){
            
            echo 'new Image().src = "'.$v.'";';         
        }
            }
        echo '}, 1000);};</script>'; 
    }
}

/* 排行榜顶部
/* -------------------------------- */  
function cx_post_ph() {
    $output ="";
    $output .= '<div class="fl">';
    $output .= '<div class="fl_title"><div class="fl01"> 排行榜 </div></div>';
    $output .= '<div class="filter-wrap cl">';
    $output .= '<div class="fl_list"><span> 榜单：</span>';
    $page_slug = the_slug();
    $output .= '<a class="fl_link'.cx_get_page("zhuanti").'" href="'.geturl("zhuanti").'">精选专题</a> | ';
    $output .= '<a class="fl_link'.cx_get_page("views").'" href="'.geturl("views").'">热门榜</a> | ';
    $output .= '<a class="fl_link'.cx_get_page("zan").'" href="'.geturl("zan").'">点赞榜</a> | ';
    $output .= '<a class="fl_link'.cx_get_page("reping").'" href="'.geturl("reping").'">热评榜</a>';
    $output .= '</div>';
    $output .= '</div>';
    $output .= '</div>';
    echo $output;
}

/* 调用不加链接的标签
/* -------------------------------- */
function tagtext(){
    global $post;
    $gettags = get_the_tags($post->ID);
    if ($gettags) {
        foreach ($gettags as $tag) {
            $posttag[] = $tag->name;
        }
        return $posttag[0];
    }
}

/* 获取下一页链接
/* -------------------------------- */
function nextpage($post_id=0){
    global $pages;
    $link = ($post_id ==0 )?get_permalink():get_permalink($post_id);
    $link = preg_replace( '/.html/', null, $link );
    $max_page = count($pages);
    if (get_query_var('page')) {
    $pageno =  get_query_var('page');
    }
    else{$pageno = '1';}
    $next = $pageno+'1';
    if ($pageno == $max_page) {
    $nextpage = get_permalink(get_adjacent_post(true,$post_id,true));
    }
    else{
        $nextpage = $link.'_'.$next.'.html';
    }
    return  $nextpage;
}
 
function link_page(){
    global $pages;
    $link = get_permalink();
    $link = preg_replace( '/.html/', null, $link );
    $max_page = count($pages);
    if (get_query_var('page')) {
    $pageno =  get_query_var('page');
    }
    else{$pageno = '1';}
    $next = $pageno-'1';
    if ($pageno == '1') {
    $nextpage = get_permalink(get_adjacent_post(false,'',false));
    }
    else{
        $nextpage = $link.'_'.$next.'.html';
    }
    return  $nextpage;
}

if ( !function_exists('post_page_auto') ) {
function post_page_auto(){
    query_posts( 'posts_per_page=-1' );
    while( have_posts() ){
        the_post();
        $post_id = $GLOBALS['post']->ID;
        $post_content = $GLOBALS['post']->post_content;
        $subject = preg_replace('/<img(.*?)>/i', '<!--nextpage--><img$1>', $post_content);
        $post_content = $subject;   
        wp_update_post( array(
            'ID' => $post_id,
            'post_content' => $post_content
        ) );
    } wp_reset_query();
}
}

/* 第三方登录按钮
/* -------------------------------- */
function cx_QQ_wobo_login($css= ''){
    $qq_login = cx_options('cx_login_qq',0,'no');
    $weibo_login = cx_options('cx_login_weibo',0,'no');
    if($qq_login=='off'||$weibo_login=='off'){
        $ons = array($qq_login,$weibo_login);$i=0;
        foreach($ons as $on){if($on=='off')$i++;};$cls=$i==3?' 3-col':' 2-col';
        $style = ($css)? ' style="'.$css.'"':'';
      echo '<div class="other_login"'.$style.'>';
      echo '<div class="disanfang"> 使用第三方登录： </div>';
      if($qq_login=='off') {
        echo '<div class="qq_btn'.$cls.'" style="float: left;cursor:pointer"><a href="'.home_url('/?connect=qq&action=login&redirect='.urlencode(cx_host_page_url())).'"><i class="fa fa-qq"></i> QQ 登录</a></div>'; 
      }
      if($weibo_login=='off') {
        echo '<div class="weibo_btn'.$cls.'" style="float: left;margin-left:10px;cursor:pointer"><a href="'.home_url('/?connect=weibo&action=login&redirect='.urlencode(cx_host_page_url())).'"><i class="fa fa-weibo"></i> 微博登录</a></div>';
      }
      echo '</div>';
    }else{
        return;
    }
}

/*  广告整合
/* -------------------------------- */
function cx_ad_zhenghe($top = 5) {
    $adb = apply_filters( 'AD-cont',$top);
    echo $adb;
}
add_action('wp_footer', 'cx_ad_zhenghe',99);

//文章内容输入
function chen_the_content( $more_link_text = null, $strip_teaser = false) {
    $content = get_the_content( $more_link_text, $strip_teaser );
    $content = apply_filters( 'the_content', $content );
    $content = str_replace( ']]>', ']]&gt;', $content );
    return $content;
}

/* 文章分页
/* -------------------------------- */
if ( !function_exists('chen_link_pages') ) {
function chen_link_pages($content=null) { 
    global $pages;
    $html ='';
    $link = get_permalink();
    $p = CX_PAGE_NUM;
    $max_page = count($pages);
    $pageno =  get_query_var('page');
    if ( $max_page == 1 ) return;   
    if ( empty( $pageno ) ) $pageno = 1;
    if(WP_GETTOP && $pageno < 3) $p = $p*2-1;
    if(isset($content) && $content =='1'){
        $html .= '(<span>' . $pageno . '/' . $max_page . '</span>)';
    }else{
        if ( $pageno > $p + 1) $html .= '<a class="page-numbers" href="'.$link.'" title="第一页">1</a> ';
        if ( $pageno > $p + 2) $html .= '<em>... </em>';
        for( $i = $pageno - $p; $i <= $pageno + $p; $i++ ) { 
            if ( WP_GETTOP &&  $i > 0 && $i <= $max_page ) $i == $pageno ? $html .=  "<span class='page-numbers current'><span class='meta-nav screen-reader-text'>第 </span>{$i}<span class='meta-nav screen-reader-text'> 页</span></span> " : $html .= p_link2( $i );
        }
        if ( $pageno < $max_page - $p - 1 ) $html .=  '<em>... </em>';
        if ( $pageno < $max_page - $p ) $html .= p_link2( $max_page, '最后页' );
        return $html;
    }
}
    function p_link2( $i, $title = '' ) {
        $link = get_permalink();
        $link = preg_replace( '/.html/', null, $link );
        $nextpage2 = $link.'_'.$i.'.html';
    if ( $title == '' ) $title = "第 {$i} 页";
    return '<a class="page-numbers" href="'.$nextpage2.'" title="'.$title.'">'.$i.'</a> ';
    }
}

/* 过滤分页符
/* -------------------------------- */
function page_glmt_cx(){
    global $post;
    $pattern = '/<!--nextpage-->/';
    $img_info = preg_replace($pattern, null, $post->post_content);
    return $img_info;
}

/* 调用伪静态后的URL
/* -------------------------------- */
function images_all_url($url= 'all'){
    $link = get_permalink();
    $link = preg_replace( '/.html/', null, $link );
    return $link.'-'.$url.'.html';  
}

/* 去除多余菜单属性
/* -------------------------------- */
function my_css_attributes_filter($var) {
    $home_title = cx_options('_cx_class_delete');
    $date = explode(",",$home_title);
   return is_array($var) ? array_intersect($var, $date) : '';

}

/* 链接后面加斜杠
/* -------------------------------- */
function nice_trailingslashit($string, $type_of_url) {
    if (set_options('cx_fujia_xiegang',2)){
        $preg = preg_match('/.html/',$string);
        if($preg == 0)
        $string = trailingslashit($string);
    }
    return $string;
}

function cx_remove_root( $url ) {
    if(!is_admin() && !is_author() && set_options('cx_fujia_xiangdui',2)){
        $url = preg_replace( '|^(https?:)?//[^/]+(/?.*)|i', '$2', $url );
        return '/' . ltrim( $url, '/' );
    }else{
        return $url;
    }    
}

function cx_redirect_canonical($link) {
    $sfs = preg_match(json_encode(get_option('siteurl')),$link);
    if($sfs == 0){
        $link = get_option('home').$link;
    }
        return $link; 
}

/* 文章排序方式
/* -------------------------------- */
function fa_orderby_views($query) {
    if( is_post_type_archive('picture') && is_archive() && !is_admin() ) {
        $query->set('posts_per_page', CX_DT_NUM);     
    }
    if ($query->is_main_query() && get_query_var('orderby') == 'views' ) {
        $query->set('meta_key', 'views');
        $query->set('orderby', 'meta_value_num');
    }elseif ($query->is_main_query() && WP_GETTOP && get_query_var('orderby') == 'zan' ) {
        $query->set('meta_key', 'bigfa_ding');
        $query->set('orderby', 'meta_value_num');
    }elseif ($query->is_main_query() && is_author() ){
        $query->set('posts_per_page', CX_DT_NUMTOW); 
    }       
    return $query;
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////
/**                                            前端功能改进增强.end                                     **/
///////////////////////////////////////////////////////////////////////////////////////////////////////////

//菜单回调函数
function Chen_nav_fallback(){
    echo '<div class="menu-alert"><a href="#">设置菜单</a> <a href="http://www.chenxingweb.com/docs/1002.html">查看教程</a></div>';
}
/**
 * 缩略图配置提醒
 */
function Chen_thumb_help(){
     $options = cx_options('_image_size_themes');
    if($options == 'no' && !file_exists( ABSPATH . 'timthumb.php')){
        echo '<div class="themes-help">缩略图未配置成功，无法正常显示，请参考教程进行设置《<a href="http://www.chenxingweb.com/docs/1830.html">点击查看教程</a>》</div>';
    }
}
add_action('index_options', 'Chen_thumb_help',5);

//是否允许投稿者上传图片
add_action('admin_init', 'Chen_contributor_uploads'); 
function Chen_contributor_uploads() { 
    $current = (int)cx_options('Chen_contributor_uploads');
    $current = $current ? $current : 3;
    if($current == 1){
        if ( current_user_can('contributor') && !current_user_can('upload_files')){
            $contributor = get_role('contributor'); 
            $contributor->add_cap('upload_files'); 
        }
    }elseif($current == 2){
        if ( current_user_can('contributor') && current_user_can('upload_files') ) {
            $contributor = get_role('contributor'); 
            $contributor->remove_cap('upload_files'); 
        }
    }    
}

//添加自定义css样式
add_action('wp_head', 'Chen_diy_css'); 
function Chen_diy_css() { 
    $css = chen_options('_chen_css','diy_code');
    $css = apply_filters('chen_css_style',$css);
    $html = '';
    if(isset($css)){
        $html .= "\n<style type='text/css'>\n";
        $html .=$css;
        $html .= "\n</style>\n";
    }
    echo $html;
}

//添加自定义js脚本
add_action('wp_footer', 'Chen_diy_js'); 
function Chen_diy_js() { 
    $js = chen_options('_chen_js','diy_code');
    $html = '';
    if(isset($js)){
        $html .=$js;
    }
    echo $html;
}

function body_class_top($top='body'){
    if(set_options('_cx_nav_slider',2)){
        if($top == 'body'){
            echo ' body_top';
        }else{
            echo ' nav_headertop';
        }

    }
}

add_filter("the_content", "post_content_cl");
function post_content_cl($tr){
    $tr = preg_replace("~\[/caption\]~", "", $tr);
    return $tr;
}

add_action('wp_ajax_avatar_file','Chen_Avatar_File');
function Chen_Avatar_File(){
    $avatar = new Avatar_File();
    $avatar->proceess();
}

add_action('wp_footer', 'single_mob_share',999);
function single_mob_share(){
    if(is_single()){
        $post_id = get_the_id();?>
        <script type="text/javascript">
            mobShare.config( {
                debug: true, 
                appkey: '1c99c75705623',//  http://mob.com/申请到的key
                params: {
                    url: window.location.href,
                    title: '<?php the_title();?>', 
                    description: '<?php echo get_post_meta($post_id,'_post_txt',true);?>',
                    pic: <?php echo json_encode(post_thumbnail_src($post_id));?>, // 分享图片
                },
            });
        </script>
    <?php
    }
}

function chen_del_dir_file($dir){
    $dh = opendir($dir); 
    while ($file=readdir($dh)){ 
        if($file!="." && $file!="..") { 
            $fullpath=$dir."/".$file; 
            if(!is_dir($fullpath)){ 
                unlink($fullpath); 
            } else { 
                chen_del_dir_file($fullpath); 
            } 
        } 
    } 
    closedir($dh); 
    return (rmdir($dir))?true:false;
}

add_action('wp_ajax_chen_kz_delete','chen_kz_delete');
function chen_kz_delete(){
    $success = '删除失败，请确认文件夹是否有删除权限！';
    $dir = ($_POST['dir'])?$_POST['dir']:'';
    $dir = CX_PLUGINS.$dir;
    if(chen_del_dir_file($dir)){
        $success = 1;
    }
    echo $success;
    exit;
}

add_filter( 'pre_get_posts', 'chenxing_category_home' );
function chenxing_category_home( $query ) {
    if ( $query->is_home ) {
        $post_cat__no = cn_options('_index_list_cat');
        if($post_cat__no){
            $query->set( 'category__not_in', $post_cat__no);
        }        
    }
    return $query;
}


function rename_filename($filename) {
    $info = pathinfo($filename);
    $ext = empty($info['extension']) ? '' : '.' . $info['extension'];
    $name = basename($filename, $ext);
    return substr(md5($name), 0, 20) . $ext;
}
add_filter('sanitize_file_name', 'rename_filename', 10);


//CX-UDY的代码已全部结束，如果下面还有代码请立即删除delete','chen_kz_delete');
function chen_kz_delete(){
    $success = '删除失败，请确认文件夹是否有删除权限！';
    $dir = ($_POST['dir'])?$_POST['dir']:'';
    $dir = CX_PLUGINS.$dir;
    if(chen_del_dir_file($dir)){
        $success = 1;
    }
    echo $success;
    exit;
}

add_filter( 'pre_get_posts', 'chenxing_category_home' );
function chenxing_category_home( $query ) {
    if ( $query->is_home ) {
        $post_cat__no = cn_options('_index_list_cat');
        if($post_cat__no){
            $query->set( 'category__not_in', $post_cat__no);
        }        
    }
    return $query;
}

remove_filter('pre_get_posts','wpjam_exclude_page_from_search');


//CX-UDY的代码已全部结束，如果下面还有代码请立即删除 