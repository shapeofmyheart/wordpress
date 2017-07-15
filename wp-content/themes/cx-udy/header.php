<?php

/***************************************

## Theme URI: http://www.chenxingweb.com/cx-udy-auto-gaoji-user.html
## Author: 晨星博客
## Author URI: http://www.chenxingweb.com
## Description: 简洁时尚自适应图片主题，适合各种图片展示类网站，有问题请加QQ群565616228请求帮助。
## Theme Name: CX-UDY
## Version: 0.4.1

****************************************/
cx_host_tion_url();
global $current_user;
$vip_user = getUserMemberInfo($current_user->ID);
$avatar_US = chenxing_get_avatar($current_user->ID , '100' , chenxing_get_avatar_type($current_user->ID) );
//print_r($wp_rewrite);
?>
<!DOCTYPE html>
<html>
	<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="initial-scale=1.0,user-scalable=no"> 
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<?php wp_head(); ?>

		<!--[if lt IE 9]> 
		<script src="http://apps.bdimg.com/libs/html5shiv/3.7/html5shiv.min.js"></script> 
		<![endif]--> 
 
	</head>
	<?php if(is_user_logged_in() && isset($vip_user['user_type_ID']) && $vip_user['user_type_ID']>0){?>
		<body class="home blog<?php body_class_top();?>">
	<?php }elseif(set_options('cx_fujia_mouse',2)){ ?>
		<body oncontextmenu=self.event.returnValue=false onselectstart="return false" onmousedown="isKeyPressed(event)" ondragstart="return false" class="home blog<?php body_class_top();?>" >
	<?php }else{?>
		<body class="home blog<?php body_class_top();?>">
	<?php }?>
		<div class="index_header<?php body_class_top('nav');?>">
			<div class="header_inner">
				<div class="logo">
					<a href="<?php echo home_cx;?>"><img src="<?php 
					if(cx_options('_logo_images')){
						echo cx_options('_logo_images');
					}else{
						echo CX_THEMES_URL.'/images/logo.png';
					}
					?>" alt="<?php bloginfo('name'); ?>" /></a>
				</div>

				<div class="header_menu">
					<ul>
						<?php 
						if(function_exists('wp_nav_menu')) 
							wp_nav_menu(array('container' => false, 'items_wrap' => '%3$s', 'theme_location' => 'left-nav','fallback_cb'=>'Chen_nav_fallback'));
						?>
					</ul>
				</div>
				<div class="login_text pc" style="padding-top: 8px;padding-bottom: 20px;">
				<?php if ( is_user_logged_in() ) {?>
					<a class="rlogin reg_hre_btn" href="<?php echo get_author_posts_url($current_user->ID);?>">个人中心 <i class="fa fa-angle-down"></i></a>
					<div class="nav_user">
					<span class="nav_user_jb">
						<i class="fa fa-caret-up"></i>
					</span>
					<div class="user_tx">
							<?php echo $avatar_US;?>
							<?php 
							if(isset($vip_user['user_type_ID']) && $vip_user['user_type_ID']>0){
								echo '<a href="'.chenxing_get_user_url( 'membership', $current_user->ID ).'"><i class="fa fa-diamond"></i> '.output_order_vipType($vip_user['user_type_ID']).'</a>';
							}else{
								echo '<a href="'.chenxing_get_user_url( 'membership', $current_user->ID ).'"><i class="fa fa-diamond"></i> 开通会员</a>';
							}

								?>
							
					</div>
					<ul>
						<li><a href="<?php echo get_author_posts_url($current_user->ID);?>"><i class="fa fa-pencil-square-o"></i> 文章投稿</a></li>
						<li><a href="<?php echo chenxing_get_user_url( 'comment', $current_user->ID );?>"><i class="fa fa-comments"></i> 我的评论</a></li>
						<li><a href="<?php echo chenxing_get_user_url( 'collect', $current_user->ID );?>"><i class="fa fa-star"></i> 我的收藏</a></li>
						<li><a href="<?php echo chenxing_get_user_url( 'credit', $current_user->ID );?>"><i class="fa fa-credit-card"></i> 我的积分</a></li>
						<li><a href="<?php echo chenxing_get_user_url( 'membership', $current_user->ID );?>"><i class="fa fa-user-md"></i> 会员服务</a></li>
						<li><a href="<?php echo chenxing_get_user_url( 'orders', $current_user->ID );?>"><i class="fa fa-tasks"></i> 订单查询</a></li>
						<?php if(current_user_can('edit_users')){?>
						<li><a href="<?php echo chenxing_get_user_url( 'down', $current_user->ID );?>"><i class="fa fa-download"></i> 下载记录</a></li>
						<li><a href="<?php echo chenxing_get_user_url( 'promote', $current_user->ID );?>"><i class="fa fa-credit-card-alt"></i> 点卡管理</a></li>
						<?php }?>						
						<li><a href="<?php echo chenxing_get_user_url( 'profile', $current_user->ID );?>"><i class="fa fa-cog"></i> 修改资料</a></li>
						<li><a href="<?php echo wp_logout_url(cx_host_page_url()); ?>"><i class="fa fa-sign-out"></i> 退出登录</a></li>
					</ul>
					</div>
					<!--<a class="rlogin login_hre_btn" href="<?php //echo get_author_posts_url($current_user->ID);?>">个人中心</a>-->
				<?php }else{ ?>
					<a class="rlogin reg_hre_btn" href="<?php cx_redirect_url();?>">注册</a>
					<a class="rlogin login_hre_btn logint" href="<?php cx_login_url();?>">登录</a>
				<?php } ?>
				</div>
				<div class="login_text mobie">
					<a href="javascript:;" class="slide-menu"><i class="fa fa-list-ul"></i></a>
				</div>
				<div class="header_search_bar">
					<form action="<?php echo home_cx;?>">
						<button class="search_bar_btn" type="submit"><i class="fa fa-search"></i></button>
						<input class="search_bar_input" type="text" name="s" placeholder="输入关键字">
					</form>
				</div>
			</div>
		</div>
		<!--移动端菜单-->
		<div class="slide-mask"></div>
		<nav class="slide-wrapper">
				<div class="header-info">
				<?php if ( is_user_logged_in() ) {?>
             	     <div class="header-logo">
	        			<a href="<?php echo admin_url();?>">
							<?php echo $avatar_US;?>						
						</a>
	        		</div>
        			<div class="header-info-content">
	        			<a href="<?php echo admin_url();?>">管 理</a>
	        		</div>
				<?php }else{ ?>
             	     <div class="header-logo">
	        			<a href="<?php cx_login_url();?>">	                     
							<img src="<?php echo CX_THEMES_URL;?>/images/avatar.jpg" alt="默认头像" />
						</a>
	        		</div>
        			<div class="header-info-content">
	        			<a href="<?php cx_login_url();?>">登 陆</a>
	        		</div>
				<?php } ?>	
	        	</div>
				<ul class="menu_slide" nav-data="nav_572877">
					<?php 
						if(function_exists('wp_nav_menu')) 
							wp_nav_menu(array('container' => false, 'items_wrap' => '%3$s', 'theme_location' => 'mini-nav','fallback_cb'=>'Chen_nav_fallback'));
					?>
				</ul>
		</nav>
<!-- 头部代码end -->