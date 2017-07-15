<?php 
/***************************************

## Theme URI: http://www.chenxingweb.com/cx-udy-auto-gaoji-user.html
## Author: 晨星博客
## Author URI: http://www.chenxingweb.com
## Description: 简洁时尚自适应图片主题，适合各种图片展示类网站，有问题请加QQ群565616228请求帮助。
## Theme Name: CX-UDY
## Version: 0.3

****************************************/
?>
<div class="main_right sidebar">
<?php
if ( is_active_sidebar( 'sidebar-1' ) ){
	dynamic_sidebar( 'sidebar-1' );
}else{?>
	<div>请到 外观=》小工具 页面设置该模块调用内容。</div>
<?php } ?>
</div>