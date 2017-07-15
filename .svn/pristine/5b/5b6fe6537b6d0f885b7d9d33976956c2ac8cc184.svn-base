 <?php
/*
Template Name:显示标签VS分类信息
*/
?>
<h1>分类</h1>
<?php
	$args=array(
		'orderby' => 'name',
		'taxonomy' => 'category',
		'order' => 'ASC'
	);
	$categories=get_categories($args);
	foreach($categories as $category) {
		echo '<h3>分类名称：'.$category->name.' || 分类ID：'.$category->term_id.' || 文章数量：'. $category->count. '</h3> ';
	}
?>
<h1>标签</h1>
<?php
	$args=array(
		'orderby' => 'name',
		'taxonomy' => 'post_tag',
		'order' => 'ASC'
	);
	$categories=get_categories($args);
	foreach($categories as $category) {
		echo '<h3>标签名称：'.$category->name.' || 标签ID：'.$category->term_id.' || 文章数量：'. $category->count. '</h3> ';
	}
?>