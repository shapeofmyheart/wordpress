<?php
/***************************************

## Theme URI: http://www.chenxingweb.com/cx-udy-auto-gaoji-user.html
## Author: 晨星博客
## Author URI: http://www.chenxingweb.com
## Description: 简洁时尚自适应图片主题，适合各种图片展示类网站，有问题请加QQ群565616228请求帮助。
## Theme Name: CX-UDY
## Version: 0.3

****************************************/
wp_get_header();?>
  <div class="fl">
    <div class="fl_title">
      <div class="fl01"> 搜索结果：</div>
    </div>
    <div class="filter-wrap">
      <div class="filter-tag">
		<div class="fl_list"><span> 共找到<?php global $wp_query; echo $wp_query->found_posts; ?>篇关于“<?php echo get_search_query(); ?>”的内容</span>
		</div>            
      </div>      
    </div>
  </div>
<?php
/** 调用分类列表 **/
cx__template('archive');
/**底部**/
get_footer(); 