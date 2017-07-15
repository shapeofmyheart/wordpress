<?php
global $get_tab,$oneself,$curauth,$admin,$cat_count,$wp_query;
$can_post_cat = cx_options('_tougao_post_user',0,'1');//接受投稿的分类
$cat_count = $can_post_cat!=0?count($can_post_cat):0;
//分页参数
$argspage = array(
	'prev_text'          =>'<i class="fa fa-chevron-left"></i>',
	'next_text'          =>'<i class="fa fa-chevron-right"></i>',
	'mid_size' => 3,
	'before_page_number' => '<span class="meta-nav screen-reader-text">第 </span>',
	'after_page_number' => '<span class="meta-nav screen-reader-text"> 页</span>',
);
//~ 默认文章列表start
if( $get_tab=='post' ) {
	if( isset($_GET['action']) && in_array($_GET['action'], array('new', 'edit')) && $cat_count && is_user_logged_in() && $oneself && current_user_can('edit_posts') ){
		//引入投稿文件
		require 'web-post.php';		
	}else{

		if($cat_count){
			$item_html = '';
			if( is_user_logged_in() && !current_user_can('edit_posts') ){					
				$item_html .= __('非常遗憾，你现在登录的账号没有投稿权限！','cx-udy');					
			}
		}else{
			if( have_posts() ) $item_html = sprintf( __('发表了 %s 篇文章','cx-udy'), $posts_count );
		}		
	echo '<div class="user-msg">'.$item_html.'</div>';	
	if(!isset($_GET['sh'])){
	$args = is_user_logged_in() ? array_merge( $wp_query->query_vars, array( 'post_status' => array( 'publish') ) ) : $wp_query->query_vars;
	query_posts( $args );
	if(have_posts()){
	echo '<ul class="ul_author_list cl">';
		while ( have_posts() ) : the_post();
			global $post;
			cx_themes_switch(4000,$post);
		endwhile; // end of the loop. 
	echo "</ul>";
	}else{
		echo '<div class="weizhaodao"><img src="'.cx_loading("weizhaodao").'"></div>';
	}

	the_posts_pagination($argspage);
	wp_reset_query();
	}else{
		$args = is_user_logged_in() ? array_merge( $wp_query->query_vars, array( 'post_status' => array( 'pending', 'draft' ) ) ) : $wp_query->query_vars;
	query_posts( $args );
	if(have_posts()){
	echo '<ul class="ul_author_list cl">';
		while ( have_posts() ) : the_post();
			global $post;
			cx_themes_switch(4000,$post);
		endwhile; // end of the loop.		
	echo "</ul>";
	}else{
	echo '<div class="weizhaodao"><img src="'.cx_loading("weizhaodao").'"></div>';
	}		
	the_posts_pagination($argspage);
	wp_reset_query();	
		}
	}
}
//~ 默认文章列表end