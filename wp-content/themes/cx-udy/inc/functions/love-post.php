<?php 
/**
 * Theme Name: CX-UDY
 * Theme URI: http://www.chenxingweb.com/store/1910.html
 * Author: 晨星博客
 * Author URI: http://www.chenxingweb.com
 * Description: 简洁时尚自适应图片主题，适合各种图片展示类网站，有问题请加QQ群565616228请求帮助。
 * Version: 0.5
 * Text Domain: cx-udy
 * Domain Path: /languages
 */

//资源判断
function cx_post_down_if(){	
	global $post;
	$down = get_post_meta($post->ID,'_cx_post_down',true);
	if(!empty($down)&& $down != "off"){
		return true;
	}else{
		return false;
	}
}

//下载按钮
function cx_post_download(){	
	if(cx_post_down_if()){
		return '<a style="margin-right:15px;color: #2CCBE6;" class="ajax ajax_down_chen" href="#"><i class="fa '.apply_filters('chen_down_icon','fa-download').'" style="margin-right:3px;"></i>'.apply_filters('chen_down_name','下载附件').'</a>';
	}else{
		return;
	}
}

//Post Meta Love
function cx_love_post(){
	global $post;
	$css = '';
	if(cx_post_down_if()){
		$css = 'style="width:320px"';
	}
	?>
	<!--通用代码-->
	<div class="tag cl" style="margin-top:30px;">
		<span class="dtpost-like cl"<?php echo $css;?>>
			<a href="javascript:;" data-action="ding" data-id="<?php the_ID(); ?>" class="favorite<?php if(isset($_COOKIE['bigfa_ding_'.$post->ID])) echo ' done';?>">
				<i class="fa fa-thumbs-up"></i>
				<span class="count">
					<em class="ct_ding" style="color: #F58282;"><?php $bigfa_ding = get_post_meta($post->ID,'bigfa_ding',true); if($bigfa_ding) echo $bigfa_ding; else echo '0';?></em>个赞
				</span>
			</a>
			<!--收藏功能-->
			<?php 
			$uid = get_current_user_id(); 
			if(!empty($uid)&&$uid!=0){
			$mycollects = get_user_meta($uid,'chenxing_collect',true);
			$mycollects = explode(',',$mycollects);
			$match = 0;
			foreach ($mycollects as $mycollect){
				if ($mycollect == $post->ID):$match++;endif;
			}		
			if ($match==0){ ?>
			<a class="share-btn collect collect-no" pid="<?php echo $post->ID ; ?>" href="javascript:;" uid="<?php echo get_current_user_id(); ?>" title="点击收藏">
				<i class="fa fa-star"></i>
				<span class="count">收藏</span>
			</a>
			<?php }else{ ?>
				<a class="share-btn collect collect-yes" style="cursor:default;" title="你已收藏">
					<i class="fa fa-star"></i>
					<span class="count">已收藏</span>
				</a>
			<?php 
				}		
			}else{ ?>
			<a class="share-btn collect collect-no" nonce="3b7560ab" style="cursor:default;" title="你必须注册并登录才能收藏">
				<i class="fa fa-star"></i>
				<span class="count">收藏</span>
			</a>				
			<?php } ?>
			<!--收藏功能-->
			<!--下载按钮-->
			<?php if(cx_post_down_if()){?>
				<a class="share-down ajax_down_chen" href="#">
					<i class="fa <?php echo apply_filters('chen_down_icon','fa-download');?>"></i>
					<span class="count"><?php echo apply_filters('chen_down_name','下载附件');?></span>
				</a>
			<?php } ?>
				<a class="share-fx" href="javascript:;">
					<i class="fa fa-share-alt"></i>
					<span class="count">分享</span>
				</a>
		</span>
		<!--MOB SHARE BEGIN-->
		<div class="myshare cl">
			<ul class="-mob-share-list">
				<li class="-mob-share-qq"></li>
				<li class="-mob-share-qzone"></li>
				<li class="-mob-share-weixin"></li>
				<li class="-mob-share-weibo"></li>
				<li class="-mob-share-renren"></li>
				<li class="-mob-share-douban"></li>
			</ul>
		</div>
		<!--MOB SHARE END-->
		<div class="post_hyh">
			<?php
			$next_post = get_next_post();
			if (!empty( $next_post ))
				echo '<a href="'.get_permalink( $next_post->ID ).'">换一篇</a>';
			else
				hyh_cx_src(1);
			?>
		</div>
	</div>
<?php 
}

//文章分页及正文内容
function cx_link_post_content(){
	$html  = '<a href="'.link_page().'" title="上一页" class="pre-cat"><i class="fa fa-chevron-left"></i></a>';
	$html .= '<a href="'.nextpage().'" title="下一页" class="next-cat"><i class="fa fa-chevron-right"></i></a>';
	$html .= '<div class="image_div" id="image_div">';
	$html .= chen_the_content();
	$html .= '<div class="nav-links page_imges">';
	$html .= '<a href="'.link_page().'" class="page-numbers next" title="上一页"><i class="fa fa-chevron-left"></i></a>';
	$html .= chen_link_pages();
	$html .= '<a href="'.nextpage().'" class="page-numbers prev" title="下一页"><i class="fa fa-chevron-right"></i></a>';
	$html .= '</div></div>';
	return $html;
}

//标准文章分页及内容
function cx_biao_post_content(){
	global $pages;
	$html  = '';
	$html .= chen_the_content();
	if(count($pages)>1){
		$html .= '<div class="nav-links page_imges">';
		$html .= '<a href="'.link_page().'" class="page-numbers next" title="上一页"><i class="fa fa-chevron-left"></i></a>';
		$html .= chen_link_pages();
		$html .= '<a href="'.nextpage().'" class="page-numbers prev" title="下一页"><i class="fa fa-chevron-right"></i></a>';
		$html .= '</div>';
	}	
	return $html;
}

function post_vip_chen($post,$uid){
	//获取当前用户的用户中心地址
	$url_VIP = chenxing_get_user_url( 'membership', $uid );
	//提示信息
	$vip_tx_1 = '<div class="VIP_tixing">查看该文章需要普通会员以上权限 <a href="'.$url_VIP.'">升级会员</a></div>';
	$vip_tx_2 = '<div class="VIP_tixing">查看该文章需要白金会员以上权限 <a href="'.$url_VIP.'">升级会员</a></div>';
	$vip_tx_3 = '<div class="VIP_tixing">查看该文章需要钻石会员以上权限 <a href="'.$url_VIP.'">升级会员</a></div>';
	$vip_tx_4 = '<div class="VIP_tixing">查看该文章需要登陆账号 <a href="'.cx_login_url(1).'">点击登陆</a></div>';
	//判断开始
	if(post_cat_vip()) {
		if(is_user_logged_in()){
			if(post_cat_vip(1,1)){
				if(!_vip_shengji_jf($uid,'1,2,3')){
					echo $post;
				}else{
					echo $vip_tx_1;
				}
			}elseif(post_cat_vip(1,2)){
				if(!_vip_shengji_jf($uid,'2,3')){
					echo $post;
				}else{
					echo $vip_tx_2;
				}
			}elseif(post_cat_vip(1,3)){
				if(!_vip_shengji_jf($uid,'3')){
					echo $post;
				}else{
					echo $vip_tx_3;
				}
			}
		}else{
			echo $vip_tx_4;
		}
	}else{
		echo $post;
	}
}

