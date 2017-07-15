<?php
if(is_home()){?>
<div class="home-filter">	
		<div class="h-screen-wrap">
			<ul class="h-screen">
				<?php 
				if(function_exists('wp_nav_menu')) 
				wp_nav_menu(array('container' => false, 'items_wrap' => '%3$s', 'theme_location' => 'home-nav','fallback_cb'=>'Chen_nav_fallback'));
				?>				                            
			</ul>
		</div>
		<ul class="h-soup cl">
			<li class="open"><i class="fa fa-coffee"></i>最近一周新增 <em><?php echo get_week_post_count();?></em> 篇文章</li>                                                
		</ul>
	</div>
	<h2 class="btt mobies"> <i class="fa fa-gittip" style="color: #E53A40;"></i>为您推荐 <span>给您推荐一批更精彩的</span> </h2>
<?php
}
$themes = cx_options('_tags_themes');
echo '<div class="update_area">';
echo '<div class="update_area_content">';
echo '<ul class="update_area_lists cl">';		
if ( have_posts() ) : 
	while ( have_posts() ) : the_post();
		cx_themes_switch($themes);
	endwhile;
endif;
echo "</ul>";
cx_ad_zhenghe(1);

/** 分页代码调用 **/
$page_numter = (!is_paged()) ? CX_PAGE_NUM*2-1 : CX_PAGE_NUM;
$argspage = array(
	'prev_text'          =>'<i class="fa fa-chevron-left"></i>',
	'next_text'          =>'<i class="fa fa-chevron-right"></i>',
	'mid_size' => $page_numter,
	'before_page_number' => '<span class="meta-nav screen-reader-text">第 </span>',
	'after_page_number' => '<span class="meta-nav screen-reader-text"> 页</span>',
);
the_posts_pagination($argspage);
echo "</div>";
echo "</div>";
wp_reset_query();