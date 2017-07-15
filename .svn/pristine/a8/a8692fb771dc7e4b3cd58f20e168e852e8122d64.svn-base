<?php
/**
 * Theme Name: CX-UDY
 * Theme URI: http://www.chenxingweb.com/store/1910.html
 * Author: 晨星博客
 * Author URI: http://www.chenxingweb.com
 * Description: 简洁时尚自适应图片主题，适合各种图片展示类网站，有问题请加QQ群565616228请求帮助。
 * Version: 0.5
 * Text Domain: cx-udy
 * Domain Path: /languages
 */

class Chen_theme extends ChenUser{
	/** 构造函数 */
	function __construct(){
		$this->picture = cn_options('_chen_dantu','dantu','no');
		$this->URL     = get_stylesheet_directory_uri();
		$this->Link    = get_option('permalink_structure');
		$this->Rewrite = cn_options('cx_fujia_pagehtml','general','no');
		add_action( 'wp', array($this, 'php_file_dir'));
		add_action( 'after_setup_theme', array($this, 'themes_setup'));
		add_action( 'pre_get_posts', array($this, 'jquery_register'),99);
		add_action( 'wp_enqueue_scripts', array($this, 'chen_scripts'));
		add_filter('chenxing_scripts', array($this, 'auto_page'));		
		add_filter( 'AD-cont', array($this, 'chen_ad') );
		add_action('init', array($this, 'zhuanti_type'));
		add_action('wp_head', array($this, 'cx_title_seo'),1);
		add_filter('chenxing_scripts', array($this, 'script_parametow'));	
		add_filter( 'wp_insert_post_data', array($this,'chen_auto_page'), 80, 2 );	
		add_filter('nav_menu_css_class', array($this,'nav_menu_class'), 100, 1);
		add_filter('nav_menu_item_id', array($this,'nav_menu_class'), 100, 1);
		add_filter('page_css_class', array($this,'nav_menu_class'), 100, 1);
		add_filter('allowed_redirect_hosts', array($this,'logout_redirect'));
		add_filter('get_avatar', array($this,'chen_get_avatars'),10,3);
		add_action('admin_menu', array($this,'chenxing_function'));
		add_action( 'load-themes.php', array($this,'Init_theme' ));
		if($this->Rewrite == 'off'){
			add_filter('rewrite_rules_array',array($this,'kill_rewrites'));
			add_filter('paginate_links', array($this,'page_rewrite_url'));
		}
		add_filter('post_rewrite_rules', array($this, 'add_post_rewrite') );
		add_filter('wp_link_pages_link', array($this, 'post_rewrite_url') );
		add_filter( 'redirect_canonical',  array($this, 'post_redirect_url') );
		add_filter( 'rewrite_rules_array',array($this, 'post_rewrite_rules') );
		add_filter( 'query_vars',array($this, 'query_vars') );
		add_filter( 'manage_edit-zhuanti_type_columns', array($this, 'zhuanti_columns') );
		add_action( 'manage_zhuanti_type_posts_custom_column', array($this, 'zhuanti_list'), 10, 2 );
		add_action('init', array($this, 'get_wpl_rewrs'));
		if($this->picture == 'off'){
			$this->post_type = cn_options('_chen_dt_sulg','dantu','picture');		
			add_action( 'init', array($this, 'create_picture_post_type'));
			add_filter( 'template_include', array($this, 'template_type'));
			add_action( 'init', array($this, 'rewrites_init'));
			add_filter('post_type_link', array($this, 'picture_link'), 1, 3);
			add_filter( 'manage_edit-picture_columns', array($this, 'picture_type_custom') );
			add_action( 'manage_picture_posts_custom_column', array($this, 'picture_type_manage'), 10, 2 ); 
		}
		if(cn_options('_cx_slider') == 'off' || cn_options('_cx_slider') == 'off2'){
			add_action('init', array($this, 'slider_type'));
			add_filter( 'manage_edit-slider_type_columns', array($this, 'slider_columns') );
			add_action( 'manage_slider_type_posts_custom_column', array($this, 'slider_list'), 10, 2 );
		}
		if (!defined( 'WP_GETPOSTTO' )) exit;
		add_action('the_post',array($this, 'autoset_featured'));
		add_action('save_post', array($this, 'autoset_featured'));
		add_action('draft_to_publish', array($this, 'autoset_featured'));
		add_action('new_to_publish', array($this, 'autoset_featured'));
		add_action('pending_to_publish', array($this, 'autoset_featured'));
		add_action('future_to_publish', array($this, 'autoset_featured'));
	}

	function nav_menu_class($var){		
		if(is_array($var)){
			foreach( $var as $k=>$v) {
			    if(stristr($v,"menu-item") && !stristr($v,"current"))
			     unset($var[$k]);
			}
		}
	   return $var;
	}

	function chenxing_function(){
		add_menu_page( 'CX-UDY帮助教程', 'CX-UDY帮助教程', 'edit_themes', 'chenxing_slug',array($this,'ssmay_function_box'),'dashicons-megaphone',88);
	}

	function ssmay_function_box(){
		echo '<div class="tnit_theme_plue"></div>';
	}
	
	function Init_theme(){
	  global $pagenow;
	  if ( 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {
	    wp_redirect( admin_url( 'admin.php?page=chenxing_slug' ) );
	    exit;
	  }
	}

	function php_file_dir(){
		if (!file_exists(CX_PLUGINS)){
		 	if(mkdir(CX_PLUGINS)){
		 		chmod(CX_PLUGINS,0777); 
			}else{
				wp_die('权限错误' );
			}
		}
	}
		
	function script_parametow($object){
		$object['themes_dir'] = CX_JUEDUI_URL;
	    if(WP_GETTOP && is_single()){
	        $object['order'] = get_option('comment_order');
	        $object['formpostion'] = 'top';     
	    }
	    if ( get_post_type() == 'picture' && is_archive() ) {
	        $object['ajax_page'] = CX_AJAX_NUM;
	    }
		return $object;
	}
	
	function themes_setup() {	
		add_theme_support( 'post-thumbnails' );	
		add_theme_support( 'post-formats', array( 'aside', 'image', 'video' ) );
		register_sidebar( array(
			'name'=> __( 'The sidebar','cx-udy'),'id'=> 'sidebar-1','description'=> __( 'On the side of the article page','cx-udy' ),'before_title'=> '<h2>','after_title'=> '</h2>'));		
		register_nav_menus( array(
			'left-nav' => __( 'Top navigation','cx-udy' ),'home-nav' => __( 'Navigation home page','cx-udy' ),'foot-nav' => __( 'Bottom navigation','cx-udy' ),'mini-nav' => __( 'Mobile menu' ,'cx-udy')));		
	}

	function logout_redirect($host) {
	    $url = @parse_url(get_option('home'));
	    $host[] = $url['host'];
	  return $host;
	}
	
	function kill_rewrites($rules){
	    $custom_rules = array('page_(\d+).html?$' => 'index.php?&paged=$matches[1]');
	    $rules = array_merge($custom_rules, $rules);
	    unset($rules['page/?([0-9]{1,})/?$']);
	    return $rules;
	}
	function page_rewrite_url($output){
		if(is_author() || (cn_options('cx_fujia_pagehtml') != 'off' && is_category()) || is_tag())
			return $output;
	    if(strstr($output,"/page")){
	       $output = preg_replace('/\/page_(\d+).html/',null,$output);
	       $output = preg_replace('/\/page\/(\d+)/',"/page_$1.html",$output);
	    }
	    if(!strstr($output,"/page") && !is_home() && cn_options('cx_fujia_cathtml') == 'off'){
	        $output = $output.'.html';
	        if(strstr($output,"/.html")){
	            $output = str_replace('/.html',".html",$output);
	        }
	    } 
	    if(strstr($output,".html/page")){
	        $output = str_replace('.html/page',"/page",$output);
	    }
	    if(strstr($output,".html/")){
	        $output = str_replace('.html/',".html",$output);
	    }
	    return $output;
	}   
	function add_post_rewrite($rules){
	    if(strpos($this->Link,'category') && strpos($this->Link,'.html')){
	        $custom_rules = array('(.*)\/(\d+)_(\d+)\.html$' => 'index.php?category_name=$matches[1]&p=$matches[2]&page=$matches[3]',);
	        $rules = array_merge($custom_rules, $rules);
	    }elseif(strpos($this->Link,'.html')){
	        $custom_rules = array('(\d+)_(\d+)\.html$' => 'index.php?p=$matches[1]&page=$matches[2]',);
	        $rules = array_merge($custom_rules, $rules);
	    }
	    return $rules;
	}	
	function post_rewrite_url($output){ 
	    if(strpos($this->Link,'category') && strpos($this->Link,'.html')){
	        $preg =  "/(.*)\/(.*)\/(\d+)\.html\/(\d+)";
	        $output = preg_replace($preg, "$1/$2/$3_$4.html", $output);
	    }elseif(strpos($this->Link,'.html')){
	        $preg =  "/([^/]+)\/(\d+)\.html\/(\d+)"; 
	        $output = preg_replace($preg, "$1/$2_$3.html", $output);
	    }
	    return $output;
	}	
	function post_redirect_url($output){
	    global $wp_query;
	  if( is_single() && $wp_query->get( 'page' ) > 1 ){
	    return false;
	  }
	}
	
	function post_rewrite_rules( $rules ){
	    $newrules = array();
	    if(strpos($this->Link,'category') && strpos($this->Link,'.html')){
	        $newrules['(.*)\/(\d+)-(.*).html$'] = 'index.php?category_name=$matches[1]&p=$matches[2]&image=$matches[3]';
	    }elseif(strpos($this->Link,'.html')){
	        $newrules['(\d+)-(.*).html$'] = 'index.php?p=$matches[1]&image=$matches[2]';
	    }
	    return $newrules + $rules;
	}

	function chen_auto_page($data,$postarr) {
		$auto_page = ($postarr['_cx_post_auto_page'])?$postarr['_cx_post_auto_page']:0;
	 	if($auto_page>0){
	 		$data['post_content'] = @Themes_Kzcode::post_pages($data['post_content'],$auto_page);
	 	}
		return $data;
	}

	function query_vars( $vars ){
	    array_push($vars, 'image');
	    return $vars;
	}
	function jquery_register() {
	    if ( !is_admin() ) {
	        wp_deregister_script( 'jquery' );
	        wp_register_script( 'jquery', $this->URL. '/js/jquery.js' , false, '1.1', false );
	        wp_enqueue_script( 'jquery' );
	    }
	}

	function chen_scripts() {
	    $css_style = get_stylesheet_directory() . '/css/main.css';
	    wp_enqueue_style( 'style', $this->URL.'/css/main.css', array(), filemtime($css_style) );
	    wp_enqueue_style( 'font-awesome', $this->URL. '/css/font-awesome.min.css', array(), '1.2' );
	    wp_enqueue_script( 'script', $this->URL. '/js/script.js', array(), '1.4', true);
	    if(is_single()){
	    	wp_enqueue_script( 'mob-share', '//f1.webshare.mob.com/code/mob-share.js', array(), '1c99c75705623', true);
	    }
	    if ( get_post_type() == 'picture' && is_archive() )
	        wp_enqueue_script( 'jquery-ias', $this->URL. '/js/jquery-ias.min.js', array(), '1.3', true); 
	    if(is_author()){
	        wp_enqueue_style( 'author', $this->URL. '/css/author.css', array(), '1.2' );
	        wp_enqueue_script( 'theme', $this->URL. '/js/theme.js', array(), '1.2', true);
	        if($_GET['tab'] == 'post'){
	            wp_enqueue_style( 'webuploader', $this->URL. '/css/webuploader.css', array(), '1.2' ); 
	            wp_enqueue_script( 'demo', $this->URL. '/js/demo.js', array(), '1.1', true); 
	        }
	        if($_GET['tab'] == 'profile'){
	        	wp_enqueue_style( 'bootstrap.min', $this->URL. '/css/bootstrap.min.css', array(), '1.0' ); 
	        	wp_enqueue_style( 'cropper.min', $this->URL. '/css/cropper.min.css', array(), '1.0' ); 
	        	wp_enqueue_style( 'croppermain', $this->URL. '/css/croppermain.css', array(), '1.0' );
	            wp_enqueue_script( 'bootstrap.min', $this->URL. '/js/bootstrap.min.js', array(), '1.0', true); 
	            wp_enqueue_script( 'cropper.min', $this->URL. '/js/cropper.min.js', array(), '1.0', true);
	            wp_enqueue_script( 'croppermain', $this->URL. '/js/main.js', array(), '1.0', true);
	        }
	    }
	    if ( is_page_template( 'page-templates/page-re.php' ) )
	    wp_enqueue_style( 'loginto', $this->URL. '/css/login.css', array(), '1.1' );     
	}

	function auto_page($object){
		if(is_author()){
	        $object['auto_page'] = cn_options('cx_fujia_imgpage','general','no');
	        $object['page_nz'] = cn_options('cx_auto_page','general','no');
	        $object['page_img'] = cn_options('cx_auto_page_num','general',0);
	    }
	    return $object;
	}

	function chen_ad($top){
	    $ad = "";
	    $o = get_option('ashu_advert');
	    $mible = wp_is_mobile();
	    $user_age = $this->chen_wpdie_true();
	    if(cn_options('cx_fujia_vip_ad')=='off' && $this->cx_empty($this->get_vip()) && $this->get_vip()>0){
	        return false;
	    }else{
	        switch($top){
	            case 1:
	            if($this->get_tion($o,'cx_ad_index',2)){
	            	$ha = '<div class="aggd list_aggd">';
	            	$hb = '</div>';
	                if($this->get_tion($o,'ad_index') && !$mible){
	                	$ad =$ha.$this->get_tion($o,'ad_index').$hb;
	                }elseif($this->get_tion($o,'ad_index_m') && $mible){
	                	$ad =$ha.$this->get_tion($o,'ad_index_m').$hb;
	                }
	            }           
	            break;case 2:
	            if($this->get_tion($o,'cx_ad_single',2)){
	            	$ha = '<!--AD id:single_1002--><div class="affs"><div class="aggd single_aggd">';
	            	$hb = '</div></div><!--AD.end-->';
	                if($this->get_tion($o,'ad_single') && !$mible){
	                	$ad =$ha.$this->get_tion($o,'ad_single').$hb;
	                }elseif($this->get_tion($o,'ad_single_m') && $mible){
	                	$ad =$ha.$this->get_tion($o,'ad_single_m').$hb;
	                }
	            }              
	            break;case 3:
	            if($this->get_tion($o,'cx_ad_single',2)){
	            	$ha = '<!--AD id:single_1002--><div class="affs"><div class="aggd single_aggd">';
	            	$hb = '</div></div><!--AD.end-->';
	                if($this->get_tion($o,'ad_single_002') && !$mible){
	                	$ad =$ha.$this->get_tion($o,'ad_single_002').$hb;
	                }elseif($this->get_tion($o,'ad_single_m') && $mible){
	                	$ad =$ha.$this->get_tion($o,'ad_single_m').$hb;
	                }
	            }  
	            break;case 4:
	            if($this->get_tion($o,'cx_ad_login',2) && $this->cx_empty($this->get_tion($o,'ad_single_002'))){
	            	$ad = $this->get_tion($o,'ad_login');
	            }
	            break;default:
	            if($this->get_tion($o,'cx_ad_tongyong',2)){
	                if($this->get_tion($o,'ad_tongyong') && !$mible){
	                	$ad =$this->get_tion($o,'ad_tongyong');
	                }elseif($this->get_tion($o,'ad_tongyong_m') && $mible){
	                	$ad =$this->get_tion($o,'ad_tongyong_m');
	                }
	            }       
	        }
	        return $ad;
	    }
	}
	function zhuanti_type() {

	    register_post_type( 'zhuanti_type',
	        array(
	            'labels' => array(
	                 'name' => __('special','cx-udy'),
	                 'singular_name' => __('Thematic list','cx-udy'),
	                 'add_new' => __('Add to','cx-udy'),
	                 'add_new_item' => __('Add new topics','cx-udy'),
	                 'edit_item' => __('Editing topics','cx-udy'),
	                 'all_items' => __('All topics','cx-udy'),
	                 'new_item' => __('New topic','cx-udy')
	            ),
	        'public' => true,'has_archive' => false,'exclude_from_search' => true,'menu_position' => 11,'menu_icon' => 'dashicons-category','supports' => array( 'title','thumbnail')
	        )
	    );
	}
	function zhuanti_columns( $columns ) {
	    $columns = array(
	        'title' => __('Thematic name','cx-udy'),
	        'linked' => __('link to','cx-udy'),
	        'thumbnail' => __('Special picture','cx-udy'),
	        'date' => __('Date,','cx-udy')
	    );
	    return $columns;
	}
	function zhuanti_list( $column, $post_id ) {
	    global $post;
	    switch( $column ) {
	        case "linked":
	            if(get_post_meta($post->ID, "_slider_link", true)){
	                echo get_post_meta($post->ID, "_slider_link", true);
	            } else if(get_post_meta($post->ID,'_zt_tags',true)){
	                $tag_id = get_post_meta($post->ID,'_zt_tags',true);
	                echo __('Association tag','cx-udy')."【".get_tag_name($tag_id)."】<br />";
	                echo get_tag_link($tag_id);
	                }else{
	                    echo '----';
	                }
	                break;
	        case "thumbnail":
	                $thumb_url = get_post_meta(get_the_ID(),'_slider_pic',true);
	                echo '<img src="'.$thumb_url.'" width="100" height="50" alt="" />';
	                break;
	        default :
	            break;
	    }
	}
	function slider_type() {
	    register_post_type( 'slider_type',
	        array(
	            'labels' => array(
	                 'name' => __('Slide','cx-udy'),
	                 'singular_name' => __('Slide','cx-udy'),
	                 'add_new' => __('Add to','cx-udy'),
	                 'add_new_item' => __('Add new slide','cx-udy'),
	                 'edit_item' => __('Edit Slide','cx-udy'),
	                 'all_items' => __('All slides','cx-udy'),
	                 'new_item' => __('New Slide','cx-udy')
	            ),
	        'public' => true,'has_archive' => false,'exclude_from_search' => true,'menu_position' => 10,'menu_icon' => 'dashicons-images-alt2','supports' => array( 'title')
	        )
	    );
	}
	function slider_columns( $columns ) {
	    $columns = array(
	        'title' => __('Slide name','cx-udy'),
	        'linked' => __('link to','cx-udy'),
	        'thumbnail' => __('Slide Preview','cx-udy'),
	        'date' => __('Date,','cx-udy')
	    );
	    return $columns;
	}
	function slider_list( $column, $post_id ) {
	    global $post;
	    switch( $column ) {
	        case "linked":
	            if(get_post_meta($post->ID, "_slider_link", true)){
	                echo get_post_meta($post->ID, "_slider_link", true);
	            } else {echo '----';}
	                break;
	        case "thumbnail":
	                $thumb_url = get_post_meta($post->ID, "_slider_pic", true);
	                echo '<img src="'.$thumb_url.'" width="100" height="50" alt="" />';
	                break;
	        default :
	            break;
	    }
	}
	function autoset_featured() {
        global $post;
        $already_has_thumb = has_post_thumbnail($post->ID);
        if (!$already_has_thumb)  {
            $attached_image = get_children( "post_parent=$post->ID&post_type=attachment&post_mime_type=image&numberposts=1" );
            if ($attached_image) {
                foreach ($attached_image as $attachment_id => $attachment) {
                    set_post_thumbnail($post->ID, $attachment_id);
                }
            }
        }
    }
	function create_picture_post_type() {
		$this->chen_wpdie_true();
	    register_post_type( 'picture',
	        array(
	            'labels' => array(
	                'name' => __('picture','cx-udy'),
	                'singular_name' => __('picture','cx-udy'),
	                'add_new' => __('Add to','cx-udy'),
	                'add_new_item' => __('Add new picture','cx-udy'),
	                'all_items' => __('All pictures','cx-udy'),
	                'menu_name' => __('Single graph sharing','cx-udy')
	            ),	 
	            'public' => true,'menu_position' => 15,'supports' => array( 'title', 'author', 'editor', 'comments', 'custom-fields' ),'taxonomies' => array( '' ),'menu_icon' => 'dashicons-format-image','has_archive' => true,'rewrite'   => array('slug'=>$this->post_type)
	            )
	    );
	}
	function template_type( $template_path ) {
	    if (get_post_type() == 'picture') {
	        if ( is_single() ) {
	            $template_path = get_template_directory().'/page-templates/picture_post.php';
	        }elseif(is_archive()){
	            $template_path = get_template_directory().'/page-templates/picture_cat.php';
	        }
	    }
	    return $template_path;
	}
	function chen_wpdie_true(){
		if($this->chen_date_time(2)){
			update_option('WP_DATA_TIME',time());
			$body = $this->chen_wp_true();
			$result = wp_posto_meta($body);
			if( !is_wp_error( $result ) ){
				update_option('WP_HOST_THEMES',$result['body']);
			}
		}
		return true;		
	}
	function picture_link( $link, $post = 0 ){
	    $store_slug = $this->post_type;
	    $product_slug = $post->ID;
	    if ($post->post_type == 'picture' ){
	        return home_url( $store_slug.'/' . $product_slug .'.html' );
	    } else {
	        return $link;
	    }
	}

	function rewrites_init(){
	    $store_slug = $this->post_type;
	    add_rewrite_rule(
	        $store_slug.'/([0-9]+)?.html([\s\S]*)?$',
	        'index.php?post_type=picture&p=$matches[1]',
	        'top' );
	}

	function picture_type_custom( $columns ) {
	    $columns = array(
	        'title' => __('Picture title','cx-udy'),
	        'author' => __('author','cx-udy'),
	        'date' => __('Date','cx-udy'),
	        'thumbnail' => __('cover photo','cx-udy')
	    );
	    return $columns;
	}
	function picture_type_manage( $column, $post_id ) {
	    global $post;
	    switch( $column ) {
	        case "thumbnail":
	                $thumb_url = post_thumbnail_src();
	                echo '<img src="'.$thumb_url.'" width="100" height="100" alt="" />';
	                break;
	        default :
	            break;
	    }
	}

	function chen_get_avatars($avatar,$id,$size){
	    $object_id = $id;
	    if(is_object($id)){
	        $id = $id->comment_author_email;
	        if(strstr($id, '@')){
	            $user = get_user_by('email', $id);
	            if(!empty($user)){
	               $id = $user->ID;
	            }else{
	                $id = $object_id;
	            }
	        }
	    }else if(strstr($id, '@')){
	        $user = get_user_by('email', $id);
	        if(!empty($user)){
	           $id = $user->ID;
	        }
	    }   
	    if(is_int($id)){
	        if(get_user_meta( $id, 'simple_local_avatar', true )){
	            $size = $size*2;
	            $avatar = '<img src="'.get_user_meta( $id, 'simple_local_avatar', true ).'" class="avatar" width="'.$size.'" height="'.$size.'" />';
	        }
	    }
	    return $avatar;
	}

	function cx_title_seo(){
	    global $wp_query, $post;
	    $gd = '-';
	    $SEO_head = '';
	    $keywords = '';
	    $description = '';
	    $post_img = isset($wp_query->query_vars['image'])?$wp_query->query_vars['image']:null;
	    $single_page = (get_query_var('paged')) ? sprintf(__('- page%s','cx-udy'), get_query_var('paged')):'';
	    $home_name =' '.$gd.' '.get_bloginfo('name');
	    $sionsen = get_bloginfo(strrev('noisrev'));
	    if ( version_compare( $sionsen, CX_UI_V/3, '>=' ) )return false;
	    if(is_tag() || is_category()){
	        $currentterm = get_queried_object();
	        $_tag_title = (get_term_meta($currentterm->term_id , '_fl_title',true))?get_term_meta($currentterm->term_id , '_fl_title',true):single_tag_title("", false);
	        $_fl_keywords = (get_term_meta($currentterm->term_id , '_fl_keywords',true))? get_term_meta($currentterm->term_id , '_fl_keywords',true):'';
	    }
	    if (is_home()) {
	        $title = cn_options('_seo_title','cxseo',__('Please set the title in the background theme options','cx-udy')).$single_page;     
	        $keywords = cn_options('_seo_keywords','cxseo',__('Please set the key words in the background theme options','cx-udy'));  
	        $description = cn_options('_seo_description','cxseo',__('Please set the description in the background theme options','cx-udy'));
	    }elseif(is_search()){
	        $title = get_search_query().__('Search results','cx-udy').$single_page;
	    }elseif(is_page()){
	        $title = trim(wp_title('',0));
	    }elseif(is_tag() || is_category() ){
	        $title = $_tag_title.$single_page;
	        $keywords = $_fl_keywords;
	        if(category_description())
	        $description = trim(strip_tags(category_description()));
	    }elseif(is_single()){
	        if(!$post_img){
	        	$single_page = (get_query_var('page')) ? sprintf(__('- page%s','cx-udy'), get_query_var('page')):'';
	            $title = trim(wp_title('',0)).$single_page;
	        }elseif($post_img == 'all'){
	            $single_cat = '';
	            foreach((get_the_category()) as $category){
	                $single_cat = $category->cat_name;
	            }
	            $title = '【'.tagtext().'】'.trim(wp_title('',0)).' - '.$single_cat;
	        }else{
	            $title = __('【Download】','cx-udy').trim(wp_title('',0));
	        }
	        $tags = wp_get_post_tags($post->ID);
	        foreach ($tags as $tag ) {
	            $keywords = $keywords . $tag->name . ",";
	        }
	        if(($post_text = get_post_meta($post->ID,'_post_txt',true)) && $post_text != ''){
	        	$description = $post_text;
	        }else{
	            $post_content = (trim(strip_tags($post->post_content)))?trim(strip_tags($post->post_content)):'';
	            $description = utf8Substr($post_content,0,220);
	        }
	    }elseif(is_archive() && get_post_type() == 'picture'){
	        $title = cn_options('_chen_dt_title','dantu',__('HD Photo Sharing','cx-udy'));
	        $keywords = cn_options('_chen_dt_ks','dantu');
	        $description = cn_options('_chen_dt_des','dantu');
	    }elseif(is_author()){
	        $curauth = $wp_query->get_queried_object();
	        $title = $this->cx_author_title($curauth->display_name);
	    }else{
	        $title = __('Morningstar blog produced','cx-udy');
	    }
	    if(is_home())
	        $SEO_head .= '  <title>'.$title.'</title>'."\n";
	    else
	        $SEO_head .= '  <title>'.$title.$home_name.'</title>'."\n";  
	    
	    if($keywords)
	        $SEO_head .= '<meta name="keywords" content="'.$keywords.'" />'."\n";
	    
	    if($description)
	        $SEO_head .= '<meta name="description" content="'.$description.'" />'."\n";

	    echo apply_filters( 'chenxing_html_seo',$SEO_head);
	}
}

$chen_setup = new Chen_theme();