<?php
/*
Template Name:点赞排行
*/
wp_get_header();
cx_post_ph();
echo '<div class="update_area">';
	echo '<div class="update_area_content">';
	echo '<ul class="update_area_lists cl">';		
		get_most_viewed(40,'zan');
		echo "</ul>";
			echo "</div>";
		echo "</div>";
/** 掉用公共底部 **/
get_footer();