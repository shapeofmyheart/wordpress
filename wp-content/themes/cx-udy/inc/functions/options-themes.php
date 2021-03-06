<?php
/***************************************

## Theme URI: http://www.chenxingweb.com/cx-udy-auto-gaoji-user.html
## Author: 晨星博客
## Author URI: http://www.chenxingweb.com
## Description: 简洁时尚自适应图片主题，适合各种图片展示类网站，有问题请加QQ群565616228请求帮助。
## Theme Name: CX-UDY
## Version: 0.3

****************************************/
function cx_themes_total() {
	$_index_images_10 = cx_options('_index_images_10');
	$pic_total = pic_total();
	if(isset($_index_images_10) && $_index_images_10 =='off'){
		echo '<div class="btns-sum"><span>'.$pic_total.'</span>张</div>';
	}
}

function cx_src() {
	$_ajax = cx_options('_ajax_off');
	if(is_category() && is_paged() && isset($_ajax) && $_ajax=='off'){
		echo 'src=';
	} else {
		echo 'src="'.cx_loading().'" data-original=';
	}
}
function cx_post_txtto() {
	$id = get_the_ID();
	$_post_txt = get_post_meta($id,'_post_txt',true);
	if(isset($_post_txt) && $_post_txt != ""){
		echo $_post_txt;
	}else{
		echo "小编比较懒，这个视频描述简介暂时没有更新，请稍后在看…";
	}
}
function cx_like($id = 0,$to = true) {
	if($id == 0)
	$id = get_the_ID();
	$li  = '';
	$li .= '<span class="cx_like"><i class="fa fa-heart"></i>';
	$like_ding = get_post_meta($id,'bigfa_ding',true);
	if( isset($like_ding) && $like_ding != ""){
		$li .= $like_ding;
	} else {
		$li .= 0;
	}
	$li .= '</span>';
	if($to){
		echo $li;
	}else{
		return $li;
	}

}

function cx_themes_switch($content=null,$post= 0,$mate='views',$i=0){
	$theme = cx_options('_tags_themes');
	$cx_themes = (int)$content;
	$cx_theme_list_html = apply_filters( 'cx_theme_list_html', '',$cx_themes,$post,$mate,$i);
	if($cx_theme_list_html != ''){
		echo $cx_theme_list_html;
		return false;
	}
	switch ($cx_themes) {
	case 1001:	?>
		<li class="i_list list_n1"> 
			<a href="<?php the_permalink();?>" title="<?php the_title();?>"> 
				<img class="waitpic" src="<?php echo cx_loading();?>" data-original="<?php cx_timthumb(280,180,'280x180');?>" width="280" height="180" alt="<?php the_title();?>">
			</a>
			<div class="case_info">
				<div class="meta-title"> <?php the_title();?> </div>
				<div class="meta-post"><i class="fa fa-clock-o"></i> <?php the_time('Y-n-j');cx_like();?></div>
			</div>
			<?php _vip_jiaobiao_echo();?>
		</li><!-- 4*3 缩略图模板-->
	<?php break;case 1002:?>
		<li class="i_list list_n2"> 
			<a href="<?php the_permalink();?>" title="<?php the_title();?>"> 
				<img class="waitpic" src="<?php echo cx_loading();?>" data-original="<?php cx_timthumb(270,370,'270x370');?>" width="270" height="370" alt="<?php the_title();?>">
			</a>
			<div class="case_info">
				<div class="meta-title"> <?php the_title();?> </div>
				<div class="meta-post"><i class="fa fa-clock-o"></i> <?php the_time('Y-n-j');cx_like();?></div>
			</div>
			<?php _vip_jiaobiao_echo();?>
		</li><!-- 3*5 缩略图模板-->
		
	<?php break;case 1003:?>
		<li class="tuts_top3">
			<div class="tuts_top3_bg">
				<a href="<?php the_permalink(); ?>" target="_blank" title="<?php the_title(); ?>">
					<img src="<?php echo cx_loading();?>" data-original="<?php cx_timthumb(280,180,'280x180');?>" alt="<?php the_title(); ?>" width="250" height="160">
					<p><?php the_title(); ?></p>
				</a> 
			</div>
			<?php _vip_jiaobiao_echo();?>
		</li>	 <!-- 相关文章模板-->	
		
	<?php break;case 1004:?>
		<li class="z-date">
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
			<?php the_title(); ?>
			</a>
		</li><!-- 作者文章 -->
    
	<?php break;case 1005:
	$post_views = (int) get_post_meta( $post->ID, 'views', true );
	if( !update_post_meta( $post->ID, 'views', ( $post_views + 1 ) ) ) add_post_meta( $post->ID, 'views', 1, true );
	?>
		<li class="img_list list_n4"> 
			<a href="<?php the_permalink();?>" title="<?php the_title();?>"> 
				<img class="waitpic" src="<?php echo cx_loading();?>" data-original="<?php echo post_thumbnail_src();?>" alt="<?php the_title();?>">
			</a>
			<div class="img_title"><?php the_title();?></div>
			<div class="case_info_img">
				<div class="meta-post">
					<i class="fa fa-clock-o"></i> <?php the_time('Y-n-j');?> / 
					<i class="fa fa-eye"></i> <?php Bing_get_views(true,$post->ID);?> / 
					<i class="fa fa-user"></i> <?php the_author_posts_link();?>
					<span class="cx_like">
						  <a href="javascript:;" data-action="ding" data-id="<?php echo $post->ID; ?>" class="favorite<?php if(isset($_COOKIE['bigfa_ding_'.$post->ID])) echo ' done';?>">
							  <i class="fa fa-thumbs-up"></i>
							  <span class="count">
									<em class="ct_ding"><?php if( get_post_meta($post->ID,'bigfa_ding',true) )echo get_post_meta($post->ID,'bigfa_ding',true);else echo '0';?></em>
							  </span>
						  </a>
						  <a href="javascript:;" data-action="ding_no" data-id="<?php echo $post->ID; ?>" class="tiresome<?php if(isset($_COOKIE['bigfa_ding_no_'.$post->ID])) echo ' done';?>">
							  <i class="fa fa-thumbs-down" style="color: #A09E9E;"></i>
							  <span class="count">
									<em class="ct_ding" style="color: #A09E9E;"><?php if( get_post_meta($post->ID,'bigfa_like_no',true) )echo get_post_meta($post->ID,'bigfa_like_no',true);else echo '0';?></em>
							  </span>
						  </a>
					</span>
				</div>
			</div>
		</li><!-- 4*3 缩略图模板-->
	<?php break;case 2000:
		$_slider_link = get_post_meta(get_the_ID(),'_slider_link',true);
		$tag_link = get_post_meta(get_the_ID(),'_zt_tags',true);
		if(isset($_slider_link) && $_slider_link != "")
			$tags_link = $_slider_link;
		else
			$tags_link = get_tag_link($tag_link);
	?>
		<li class="i_list list_n3"> 
			<a href="<?php echo $tags_link;?>" title="<?php the_title();?>"> 
				<img class="waitpic" src="<?php echo cx_loading('zhuanti');?>" data-original="<?php echo get_post_meta(get_the_ID(),'_slider_pic',true);?>" width="270" height="120" alt="<?php the_title();?>" />
			<div class="case_info">
				<div class="meta-title"> <?php the_title();?> </div>
			</div>
			</a>
		</li><!-- .专题模板 2000-->
	<?php break;case 2001:
		$_slider_link = get_post_meta(get_the_ID(),'_slider_link',true);
		$tag_link = get_post_meta(get_the_ID(),'_zt_tags',true);
		if(isset($_slider_link) && $_slider_link != "")
			$tags_link = $_slider_link;
		else
			$tags_link = get_tag_link($tag_link);
		?>
		<li>
			<a href="<?php echo $tags_link;?>" target="_blank">
				<img src="<?php echo get_post_meta(get_the_ID(),'_slider_pic',true);?>" alt="<?php the_title();?>" width="270" height="120">
				<span>
				<h3><?php the_title();?></h3>
				<i class="fa fa-chevron-circle-right"></i>
				</span>
			</a>
		</li><!-- .侧边专题模板 2001-->
	<?php break;case 2002:
		$_slider_link = get_post_meta(get_the_ID(),'_slider_link',true);
		$tag_link = get_post_meta(get_the_ID(),'_zt_tags',true);
		if(isset($_slider_link) && $_slider_link != "")
			$tags_link = $_slider_link;
		else
			$tags_link = get_tag_link($tag_link);
	?>
		<li>
			<a href="<?php echo $tags_link;?>">
				<img src="<?php echo get_post_meta(get_the_ID(),'_slider_pic',true);?>" alt="<?php the_title();?>" width="270" height="120">
				<span><?php the_title();?></span>
			</a>
		</li><!-- .首页专题模板 2002-->
	<?php break;case 3000:
			if((int)$theme == 1001){
				$timthumb = cx_timthumb(280,180,'280x180',$post->ID,false);
				$class = ' list_n1';
				$width = 280;
				$height = 180;
			}else{
				$timthumb = cx_timthumb(270,370,'270x370',$post->ID,false);
				$class = ' list_n2';
				$width = 270;
				$height = 370;
			}
			$class_id = $i+1;
	?>
		<li class="i_list <?php echo $class;?>"> 
			<a href="<?php echo get_permalink($post->ID);?>" title="<?php echo $post->post_title;?>"> 
				<img class="waitpic" src="<?php echo cx_loading();?>" data-original="<?php echo $timthumb;?>" width="<?php echo $width;?>" height="<?php echo $height;?>" alt="<?php echo $post->post_title;?>">
			</a>
			<div class="case_info">
				<div class="meta-title"> <?php echo $post->post_title;?> </div>
				<div class="meta-post"><i class="fa fa-clock-o"></i> <?php echo date("Y-m-d",strtotime($post->post_date));cx_like($post->ID);?></div>
			</div>
			<div class="meta_zan xl_<?php echo $class_id;?>">
			<?php 
			if($mate=='views'){
				echo '<i class="fa fa-eye"></i>';
				Bing_get_views(true,$post->ID);
			}else if($mate=='zan'){
				cx_like($post->ID);
			}else{
				echo '<i class="fa fa-comment"></i>';
				echo $post->comment_count;
			}
			?>
			</div>
		</li><!-- 排行榜模板-->
	<?php break;case 4000:?>
		<li>
			<img src="<?php cx_timthumb(100,80,'100x80');?>" width="100" height="80" />
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			<div class="author_post_meta">
			<?php if( $post->post_status=='publish' ){ ?>		
				<div class="postlist-meta">
						<span><i class="fa fa-clock-o"></i>&nbsp;<?php echo date(__('Y年m月j日','cx-udy'),get_the_time('U'));?></span> / 
						<span><i class="fa fa-folder-open"></i>&nbsp;<?php the_category(' '); ?></span> / 
						<span><?php if ( comments_open() ): ?><i class="fa fa-comments"></i>&nbsp;<a href="<?php comments_link(); ?>"><?php comments_number( '0', '1', '%' ); ?></a><?php  endif; ?></span>/
						<span><i class="fa fa-edit"></i>&nbsp;<?php edit_post_link(); ?></span>


						<?php $uid = get_current_user_id();global $curauth; if(isset($curauth->ID)&&$curauth->ID==$uid && isset($_GET['tab']) && $_GET['tab'] == 'collect'){?>
							 / <span class="collect collect-yes remove-collect" style="cursor:pointer;" pid="<?php echo $post->ID;?>" uid="<?php echo get_current_user_id();?>" title="取消收藏"><i class="fa fa-star"></i> 取消收藏 </span>
						<?php } ?>
				</div>
			<?php }else{ 
					$meta_output = '<div class="entry-meta">';
						if( $post->post_status==='pending' ) $meta_output .= sprintf(__('正在等待审核，你可以 <a href="%1$s">预览</a> 或 <a href="%2$s">重新编辑</a> 。','cx-udy'), get_permalink(), get_edit_post_link() );
						if( $post->post_status==='draft' ) $meta_output .= sprintf(__('这是一篇草稿，你可以 <a href="%1$s">预览</a> 或 <a href="%2$s">继续编辑</a> 。','cx-udy'), get_permalink(), get_edit_post_link() );
						$meta_output .= '</div>';
						echo $meta_output;
			} ?>
			</div>
		</li>
	<?php break;default:?>	
<?php }
}
