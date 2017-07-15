<?php
/***************************************
## Theme URI: http://www.chenxingweb.com/cx-udy-auto-gaoji-user.html
## Author: 晨星博客
## Author URI: http://www.chenxingweb.com
## Description: 简洁时尚自适应图片主题，适合各种图片展示类网站，有问题请加QQ群565616228请求帮助。
## Theme Name: CX-UDY
## Version: 0.3

****************************************/
wp_get_header();
/** 分类公共代码 **/
if(!isset($_GET['ctag'])){
	$cxtag = null;
	$cxtag_get = null;
}else{
	$cxtag = $_GET['ctag'];
	$cxtag_get = '&ctag='.$cxtag;
}
if(isset($_GET['orderby'])){
	$order = $_GET['orderby'];
	switch( $order ) {
        case "date":
         $meta_key = '';
		 $orderby = 'date';
        break;
		case "views":
         $meta_key = 'views';
		 $orderby = 'meta_value_num';
        break;
		case "zan":
         $meta_key = 'bigfa_ding';
		 $orderby = 'meta_value_num';
        break;
		case "rand":
         $meta_key = '';
		 $orderby = 'rand';
        break;
        default :
		$meta_key = '';
		$orderby = 'date';
        break;
    }
}else{
	$meta_key = '';
	$orderby = 'date';
}
	
?>
<div class="cat_bg picture" style="background:url(<?php echo CX_THEMES_URL;?>/images/dt_bg.jpg) no-repeat scroll center 0;"></div>
<div class="fl flbg picturefl" style="max-width: 940px;opacity: 0.9;">
    <div class="fl_title">
      <div class="fl01"> 美图分享频道</div>
    </div>
    <div class="filter-wrap">
      <div class="filter-tag">     
        <div class="fl_list" style="margin-top:10px;"><span> 排序：</span>
		<?php picture_get_sort($cxtag_get);?>
        </div>      
      </div>      
    </div>
  </div>
<?php
$themes = 1005;
echo '<div class="update_area">';
	echo '<div class="update_area_content" style="max-width: 940px;">';
	echo '<div class="blog_list cl"><ul class="update_area_list cl" style="margin-top:0;">';			
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			$args = array(
			'post_type'=>'picture',
			'paged'=>$paged,
			'meta_key' =>$meta_key,
			'orderby' => $orderby,
			);
		query_posts($args);
		if ( have_posts() ) : 
		while ( have_posts() ) : the_post();
			cx_themes_switch($themes,$post);
		endwhile;
		endif;
		/** 分页代码调用 **/
		if(isset($_GET['ctag']) || isset($_GET['orderby'])){
			$argspage = array(
				'prev_text'          =>'<i class="fa fa-chevron-left"></i>',
				'next_text'          =>'<i class="fa fa-chevron-right"></i>',
				'mid_size' => 3 ,
				'format' => 'page/%#%?'.$_SERVER['QUERY_STRING'],
				'before_page_number' => '<span class="meta-nav screen-reader-text">第 </span>',
				'after_page_number' => '<span class="meta-nav screen-reader-text"> 页</span>',
			);
		}else{
			$argspage = array(
				'prev_text'          =>'<i class="fa fa-chevron-left"></i>',
				'next_text'          =>'<i class="fa fa-chevron-right"></i>',
				'mid_size' => 3 ,
				'before_page_number' => '<span class="meta-nav screen-reader-text">第 </span>',
				'after_page_number' => '<span class="meta-nav screen-reader-text"> 页</span>',
			);
		}
		the_posts_pagination($argspage);
		echo "</ul>";
		wp_reset_postdata();
		/** 侧边调用 **/
			get_sidebar();
		/** 博客模板添加DIV **/
		echo '</div>';
		
			echo "</div>";
		echo "</div>";
echo "<!--ceshi-->";
/** 掉用公共底部 **/
get_footer();