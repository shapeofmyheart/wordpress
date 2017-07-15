<?php 
/***************************************

## Theme URI: http://www.chenxingweb.com/cx-udy-auto-gaoji-user.html
## Author: 晨星博客
## Author URI: http://www.chenxingweb.com
## Description: 简洁时尚自适应图片主题，适合各种图片展示类网站，有问题请加QQ群565616228请求帮助。
## Theme Name: CX-UDY
## Version: 0.3

****************************************/
?>

<!--效果html开始-->
<?php
if(set_options('_cx_slider',2)){
	$args = array(
		'post_type'=>'slider_type',
		'showposts'=>CX_AUTO_LUNBO
	);
	query_posts($args);
	?>
	<div class="site-wrap">
		<ul class="bxslider">
		<?php
		if(have_posts()):
	    while(have_posts()): the_post();
	    $slider_pic = get_post_meta($post->ID,'_slider_pic',true);
	    $slider_link = get_post_meta($post->ID,'_slider_link',true);
	    ?>
	    <li><a target="_blank" href="<?php echo $slider_link; ?>"><img src="<?php echo $slider_pic ?>" alt="<?php the_title(); ?>" width="100%" /></a></li>
	    <?php endwhile; else: ?>
	    <li><a target="_blank" href="http://www.chenxingweb.com"><img src="<?php echo CX_THEMES_URL;?>/images/demo.png" alt="晨星博客" width="100%" /></a></li>
	    <?php endif; ?>
		</ul>
	</div>
	<?php wp_reset_query();
}elseif(set_options('_cx_slider',3,'off2')){?>
	<div class="wrappter">	
        <div class="wrp_left">
            <ul class="bxslider tow_slider">
            <?php 
            $args1 = array(
				'post_type'=>'slider_type',
				'showposts'=>CX_AUTO_LUNBO
			);
			query_posts($args1);
		    if(have_posts()):
			    while(have_posts()): the_post();
			    $slider_pic = get_post_meta($post->ID,'_slider_pic',true);
			    $slider_link = get_post_meta($post->ID,'_slider_link',true);
			    ?>
			    <li><a target="_blank" href="<?php echo $slider_link; ?>"><img src="<?php echo $slider_pic ?>" alt="<?php the_title(); ?>" width="100%" /></a></li>
            <?php endwhile; else: ?>
			    <li><a target="_blank" href="http://www.chenxingweb.com"><img src="<?php echo CX_THEMES_URL;?>/images/demo.png" alt="晨星博客" width="100%" /></a></li>
			<?php endif; wp_reset_query();?>
            </ul>
        </div>
        <div class="wrp_right">
            <ul>
            <?php
            	$args2 = array(
					'post_type'=>'slider_type',
					'offset'=>CX_AUTO_LUNBO,
					'showposts'=>2
				);
				query_posts($args2);
				if(have_posts()):
				    while(have_posts()): the_post();
				    $slider_pic = get_post_meta($post->ID,'_slider_pic',true);
				    $slider_link = get_post_meta($post->ID,'_slider_link',true);
            	?>
                <li>
                    <a href="<?php echo $slider_link; ?>">
                        <img src="<?php echo $slider_pic ?>" alt="<?php the_title(); ?>" width="100%">
                        <div class="cx_title">
                            <span>站内精选</span>
                            <p><?php the_title();?></p>
                        </div>
                    </a>
                </li>
                <?php endwhile; else: ?>
				<li>
                    <a href="#">
                        <img src="<?php echo CX_THEMES_URL;?>/images/demo.png" alt="您还没有设置幻灯片" width="100%">
                        <div class="cx_title">
                            <span>站内精选</span>
                            <p>您的幻灯片数量少于<?php echo CX_AUTO_LUNBO+2;?>个所以这里显示默认信息</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <img src="<?php echo CX_THEMES_URL;?>/images/demo.png" alt="您还没有设置幻灯片" width="100%">
                        <div class="cx_title">
                            <span>站内精选</span>
                            <p>您的幻灯片数量少于<?php echo CX_AUTO_LUNBO+2;?>个所以这里显示默认信息</p>
                        </div>
                    </a>
                </li>
                <?php endif; wp_reset_query();?>
            </ul>
        </div>
    </div>
	<?php wp_reset_query();
}
