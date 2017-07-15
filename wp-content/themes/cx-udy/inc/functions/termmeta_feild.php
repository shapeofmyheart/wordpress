<?php
/***************************************

## Theme URI: http://www.chenxingweb.com/cx-udy-auto-gaoji-user.html
## Author: 晨星博客
## Author URI: http://www.chenxingweb.com
## Description: 简洁时尚自适应图片主题，适合各种图片展示类网站，有问题请加QQ群565616228请求帮助。
## Theme Name: CX-UDY
## Version: 0.3

****************************************/

class ashuwp_termmeta_feild extends ashuwp_framework_core {
  var $ashu_feild,
  $taxonomy_conf;
  
  function __construct($ashu_feild,$taxonomy_conf){
    $this->ashu_feild = $ashu_feild;
    $this->taxonomy_conf = $taxonomy_conf;
    
    foreach($this->taxonomy_conf as $taxonomy){
      add_action($taxonomy.'_add_form_fields', array(&$this, 'taxonomy_fields_adds'), 10, 2);
      add_action($taxonomy.'_edit_form_fields', array(&$this, 'taxonomy_metabox_edit'), 10, 2);
      add_action('created_'.$taxonomy, array(&$this, 'save_taxonomy_metadata'), 10, 1);
      add_action('edited_'.$taxonomy,array(&$this, 'save_taxonomy_metadata'), 10, 1);
      add_action('admin_enqueue_scripts', array(&$this, 'enqueue_css_js'));
      add_action('delete_'.$taxonomy, array(&$this,'delete_taxonomy_metadata'),10,1);
    }
    
  }
  
  function taxonomy_fields_adds(){
    
    echo '<div class="tab-content taxonomy_add_page clearfix">';
    $this->tab_toggle($this->ashu_feild);
    
    foreach($this->ashu_feild as $ashu_feild){
      if ( ( $ashu_feild['type']=='open' || $ashu_feild['type']=='close' ) || (isset($ashu_feild['id']) && method_exists($this, $ashu_feild['type'])) ){
        if($ashu_feild['type']=='open' || $ashu_feild['type']=='close'){
          $this->{$ashu_feild['type']}($ashu_feild);
          continue;
        }
        
        if($ashu_feild['type']=='tinymce'){
          $this->reminder($ashu_feild);
          continue;
        }
        
        if($ashu_feild['type']=='open' || $ashu_feild['type']=='close'){
          $this->{$ashu_feild['type']}($ashu_feild);
          continue;
        }
        
        if(!isset($ashu_feild['std']))
          $ashu_feild['std'] = '';
        
        $this->{$ashu_feild['type']}($ashu_feild);
      }
    }
    echo '<!--end-->';
  }
  
  function taxonomy_metabox_edit($tag){
    
    echo '<tr class="form-field ashuwp_feild_wrap"><td colspan="2"><div class="tab-content taxonomy_edit_page">';
    $this->tab_toggle($this->ashu_feild);
    
    foreach($this->ashu_feild as $ashu_feild){
      if ( ( $ashu_feild['type']=='open' || $ashu_feild['type']=='close' ) || (isset($ashu_feild['id']) && method_exists($this, $ashu_feild['type'])) ){
        if($ashu_feild['type']=='open' || $ashu_feild['type']=='close'){
          $this->{$ashu_feild['type']}($ashu_feild);
          continue;
        }
        
        $feild_value = get_term_meta($tag->term_id , $ashu_feild['id'],true);
        if( $feild_value != '' ){
          $ashu_feild['std'] = $feild_value;
        }
        
        $this->{$ashu_feild['type']}($ashu_feild);
      }
    }
    
    echo '</div></td></tr>';
  }
  
  function delete_taxonomy_metadata($term_id){
    foreach($this->ashu_feild as $ashu_feild){
      if(isset($ashu_feild['id']))
        delete_term_meta($term_id,$ashu_feild['id']);
    }
  }
  
  function save_taxonomy_metadata($term_id){
    foreach($this->ashu_feild as $ashu_feild){
      
      if( isset($ashu_feild['id']) && $ashu_feild['id'] && isset($_POST[$ashu_feild['id']]) ){
        if(!current_user_can('manage_categories')){
          return;
        }
        
        $old_data = get_term_meta($term_id , $ashu_feild['id'],true);
        
        if( $ashu_feild['type'] == 'tinymce' ){
          $data =  stripslashes($_POST[$ashu_feild['id']]);
        }elseif( $ashu_feild['type'] == 'checkbox' ){
          $data =  $_POST[$ashu_feild['id']];
        }elseif( $ashu_feild['type'] == 'numbers_array' || $ashu_feild['type'] == 'gallery' ){
          $data = explode( ',', $_POST[$ashu_feild['id']] );
          $data = array_filter($data);
        }elseif( in_array( $ashu_feild['type'], array('open','close','title') ) ){
          continue;
        }else{
          $data = htmlspecialchars($_POST[$ashu_feild['id']], ENT_QUOTES,"UTF-8");
        }
        
        if($data == "")
          delete_term_meta($term_id , $ashu_feild['id'], $data);
        else
          update_term_meta($term_id , $ashu_feild['id'], $data);
      }
    }
  }
  
  function reminder($values){
    if( !isset($values['id']) )
      return;
    echo '<div class="ashuwp_field">';
      echo '<label class="ashuwp_field_label" for="'.$values['id'].'">';
      if( isset($values['name']) )
        echo $values['name'];
      echo '</label>';
      echo '<div class="ashuwp_field_area"><p>Please add this feild into the edit page.</p></div>';
    echo '</div>';
  }
}