<?php
/*
Template Name:热评排行
*/
wp_get_header();
cx_post_ph();
echo '<div class="update_area">';
	echo '<div class="update_area_content">';
	echo '<ul class="update_area_lists cl">';		
		get_most_viewed(40,'pl');
		echo "</ul>";
			echo "</div>";
		echo "</div>";
/** 掉用公共底部 **/
get_footer();