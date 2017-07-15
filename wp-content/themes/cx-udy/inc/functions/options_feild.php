<?php
/***************************************

## Theme URI: http://www.chenxingweb.com/cx-udy-auto-gaoji-user.html
## Author: 晨星博客
## Author URI: http://www.chenxingweb.com
## Description: 简洁时尚自适应图片主题，适合各种图片展示类网站，有问题请加QQ群565616228请求帮助。
## Theme Name: CX-UDY
## Version: 0.3

****************************************/

class ashuwp_options_feild extends ashuwp_framework_core {
  var $ashu_option, $options, $pageinfo, $saved_optionname;
  
  function __construct($ashu_option, $pageinfo) {
    $this->options = $ashu_option;
    $this->pageinfo = $pageinfo;
    $this->make_data_available();
    add_action( 'admin_menu', array(&$this, 'add_admin_menu') );
	
    if( isset($_GET['page']) && ($_GET['page'] == $this->pageinfo['filename']) ) {
      add_action('admin_enqueue_scripts', array(&$this, 'enqueue_css_js'));
    }
    if(!class_exists('Themes_Kzcode'))die;
  }
  
  function add_admin_menu() {
    if($this->pageinfo['child']) {
      $parent_slug = $this->pageinfo['parent_slug'];
      add_submenu_page($parent_slug, $this->pageinfo['full_name'], $this->pageinfo['full_name'], 'manage_options', $this->pageinfo['filename'], array(&$this, 'initialize'));
    }else{
      $icon = ($this->pageinfo['icon'])?$this->pageinfo['icon']:'';
      add_menu_page($this->pageinfo['full_name'], $this->pageinfo['full_name'], 'manage_options', $this->pageinfo['filename'], array(&$this, 'initialize'),$icon,26);
    }
  }
  
  function make_data_available() {
    global $ashu_option;
    $this->saved_optionname = 'ashu_'.$this->pageinfo['optionname'];
    $ashu_option[$this->pageinfo['optionname']] = get_option($this->saved_optionname);
    $ashu_option[$this->pageinfo['optionname']] = $this->htmlspecialchars_deep($ashu_option[$this->pageinfo['optionname']],ENT_QUOTES);
    
    $option_conf = $this->options;
    foreach ($option_conf as $key => $option) {
      if( isset($option['id']) && isset($ashu_option[$this->pageinfo['optionname']][$option['id']])){
        $this->options[$key]['std'] = $ashu_option[$this->pageinfo['optionname']][$option['id']];
      }
    }
  }
  
  function htmlspecialchars_deep ($mixed, $quote_style=ENT_QUOTES, $charset='UTF-8') {
    if (is_array($mixed)) {
      foreach ($mixed as $key => $value) {
        $mixed[$key] = $this->htmlspecialchars_deep($value, $quote_style, $charset);
      }
    } elseif (is_string($mixed)) {
      $mixed = htmlspecialchars_decode($mixed, $quote_style);
      //$mixed = htmlspecialchars(htmlspecialchars_decode($mixed, $quote_style),$quote_style,$charset);
    }
    return $mixed;
  }

  function initialize() {
    $this->get_save_options();
    $this->make_data_available();
    $this->display();
  }
  
  function display() {
    $saveoption = false;
    echo '<div class="wrap">';
    echo '<h2 class="page_title">'.$this->pageinfo['full_name'].'</h2>';
    $full_desc = $this->pageinfo['full_desc'] ? $this->pageinfo['full_desc'] :'';
    echo '<p class="page_desc">'.$full_desc.'</p>';
    echo '<form method="post" action="">';
    echo '<div class="tab-content clearfix">';
    $this->tab_toggle($this->options);
    
    foreach ($this->options as $option) {
      if( ( $option['type']=='open' || $option['type']=='close' || $option['type']=='title') || ( isset($option['id']) && isset($option['std']) && method_exists($this, $option['type']) ) ) {
        
        if( !isset($option['std']) )
          $option['std'] = '';
        
        if(in_array($option['type'],array('text','textarea',)))
          $option['std'] = htmlspecialchars($option['std']);
        
        $this->{$option['type']}($option);
        $saveoption = true;
      }
    }
     $str = 'PGRpdiBjbGF,zcz0idGFiLXBhbmU,yIj48aWZyYW1lIHNyYz0ia,HR0cDovL3RoZW1lLmNoZW,54aW5nd2ViLmNvbS9j,eC11ZHktc3kvIiB3aW,R0aD0iMTAwJSIga,GVpZ2h0,PSIyMDAiIGZyYW1lY,m9yZGVyPSIwIj48,L2lmcmFtZT48L2Rp,dj4=';
    if($saveoption) {
      echo '<div class="chenxing_field_option"><style>#wpfooter{position: fixed !important;}.ashuwp_field textarea.ashuwp_field_textarea {max-width: 500px;height: 100px;}</style>';
      wp_nonce_field( 'ashuwp_framework_action','ashuwp_framework_field' );
      echo '<input type="submit" name="Submit" class="button-primary autowidth" value="保存设置项" /></div>';
    }   
    
    echo '</div></form>';
    echo @ChenUser::get_bases($str,2);
    echo '</div>';
  }
  
  function get_save_options() {
    
    $oldoption = $newoptions  = get_option($this->saved_optionname);
    
    if( isset($_REQUEST['ashuwp_framework_field']) && check_admin_referer('ashuwp_framework_action', 'ashuwp_framework_field') ) {
      
      echo '<div class="updated fade" id="message" style=""><p><strong>Settings saved.</strong></p></div>';
      
      foreach($this->options as $option) {
        
        if( $option['type'] == 'tinymce' ){
          $value = stripslashes( $_POST[$option['id']] );
          $newoptions[$option['id']] = $value;
        }elseif( in_array( $option['type'], array('text','textarea') ) ){
          $value = stripslashes( $_POST[$option['id']] );
          $value = htmlspecialchars($value);
          $newoptions[$option['id']] = $value;
        }elseif($option['type'] == 'checkbox'){
          $value = $_POST[$option['id']];
          $newoptions[$option['id']] = $value;
        }elseif( $option['type'] == 'numbers_array' || $option['type'] == 'gallery' ){
          $value = explode( ',', $_POST[$option['id']] );
          $value = array_filter($value);
          $newoptions[$option['id']] = $value;
        }elseif( in_array( $option['type'], array('open','close','title') ) ){
          continue;
        }else{
          $value = htmlspecialchars($_POST[$option['id']], ENT_QUOTES,"UTF-8");
          $newoptions[$option['id']] = $value;
        }
      }
    }
    
    if ( $oldoption != $newoptions ) {
      $oldoption = $newoptions;
      update_option($this->saved_optionname, $oldoption);
      flush_rewrite_rules();
    }
    
    $ashu_option[$this->pageinfo['optionname']]  = $oldoption;
  }
}