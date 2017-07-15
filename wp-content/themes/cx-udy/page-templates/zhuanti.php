<?php
/*
Template Name:专题页面
*/
wp_get_header();
$themes = 2000;
cx_post_ph();
echo '<div class="update_area">';
	echo '<div class="update_area_content">';
	echo '<ul class="update_area_lists cl">';		
		if ( have_posts() ) : 
			$args=array(
			'post_type'=>'zhuanti_type',
			'posts_per_page'=>20,
			);
		query_posts($args);
		while ( have_posts() ) : the_post();
			cx_themes_switch($themes);
		endwhile;
		endif;
		echo "</ul>";
		wp_reset_query();
		/** 分页代码调用 **/
			the_posts_pagination( array(
				'prev_text'          =>'<i class="fa fa-chevron-left"></i>',
				'next_text'          =>'<i class="fa fa-chevron-right"></i>',
				'mid_size' => 3 ,
				'format' => '?paged=%#%&'.$_SERVER['QUERY_STRING'],
				'before_page_number' => '<span class="meta-nav screen-reader-text">第 </span>',
				'after_page_number' => '<span class="meta-nav screen-reader-text"> 页</span>',
			) );
			echo "</div>";
		echo "</div>";
/** 掉用公共底部 **/
get_footer();