<?php
/***************************************

## Theme URI: http://www.chenxingweb.com/cx-udy-auto-gaoji-user.html
## Author: 晨星博客
## Author URI: http://www.chenxingweb.com
## Description: 简洁时尚自适应图片主题，适合各种图片展示类网站，有问题请加QQ群565616228请求帮助。
## Theme Name: CX-UDY
## Version: 0.3

****************************************/

//作者模块
class author_post extends WP_Widget {
     function __construct() {
         $widget_ops = array('description' => '显示文章页右侧菜单。');
         parent::__construct('author_post', 'CX-UDY：作者模块', $widget_ops);
     }
     function widget($args, $instance) {
		extract($args);
		$number = strip_tags($instance['number']) ? absint( $instance['number'] ) : 4;
		$author_id = get_the_author_meta('ID');
?>
<!--作者模块-->
<div class="widget widget_author">
		<!--头像调用-->
    	<div class="author_avatar">
			<a href="<?php $author_link = get_the_author_posts_link(); $author_link = preg_replace('/(.*)href="(.*)"(.*)/', '$2', $author_link);echo $author_link;?>">
				<?php echo chenxing_get_avatar($author_id,'150',chenxing_get_avatar_type($author_id));?>
			</a>
        </div>
		<ul class="author_meta cl">
			<li class="author_post">
				<span class="num"><?php echo get_the_author_posts();?></span>
				<span class="text">文章数</span>
			</li>
			<li class="author_hr">
				<span class="hr"></span>
			</li>
			<li class="author_views">
				<span class="num"><?php cx_comment_views(get_the_author_meta('ID'));?></span>
				<span class="text">热度</span>
			</li>
		</ul>

		<!--作者热门文章-->
		<h2 class="author_postv">
			<span>Author Views</span>
		</h2>
		<ul class="author_post_list">
		<?php 
		global $post;
		  $args = array( 
			  'author'=> get_the_author_meta('ID'),
			  'post_type'=>get_post_type(),
			  'orderby'=>'comment_count',
			  'order'=>'DESC',
			  'post__not_in' => array( $post->ID ),
			  'posts_per_page' => $number,
			);
			$query = new WP_Query( $args );
			if ( $query->have_posts() ) :
			while ( $query->have_posts() ) : $query->the_post();
			cx_themes_switch(1004);
			endwhile;
			endif;
			?>
			<li>
				<a href="<?php $author_link = get_the_author_posts_link(get_the_author_meta('ID')); $author_link = preg_replace('/(.*)href="(.*)"(.*)/', '$2', $author_link);echo $author_link;?>" title="更多作者文章">
				查看更多  <i class="fa fa-caret-right"></i>
				</a>
			</li>
		</ul>
		<div class="author_lan">
		<?php 
		$author_link = get_the_author_posts_link();
		$author_link = preg_replace('/(.*)href="(.*)"(.*)/', '$2', $author_link);
		echo '<a href="'.$author_link.'">作者专栏</a>';
		wp_reset_postdata(); 
		?>
		</div>
    </div>
<!--作者模块-->
<?php
	}
	function update( $new_instance, $old_instance ) {
		if (!isset($new_instance['submit'])) {
			return false;
		}
			$instance = $old_instance;
			$instance = array();
			$instance['number'] = strip_tags($new_instance['number']);
			return $instance;
		}
	function form($instance) {
		global $wpdb;
		$number = isset( $instance['number'] ) ? $instance['number'] : 4;
		?>
	<p><label for="<?php echo $this->get_field_id('number'); ?>">文章数量：</label>
	<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" step="1" min="1" value="<?php echo $number; ?>" size="3" /></p>
	<input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
<?php }
}
add_action( 'widgets_init', function(){register_widget( 'author_post' );});

//分类目录模块
class cat_list_post extends WP_Widget {
     function __construct() {
         $widget_ops = array('description' => '显示侧边带二级标签的分类栏目。');
         parent::__construct('cat_list_post', 'CX-UDY：分类栏目', $widget_ops);
     }
     function widget($args, $instance) {
		extract($args);
		$number = strip_tags($instance['number']) ? absint( $instance['number'] ) : 5;
		$number2 = strip_tags($instance['number2']) ? absint( $instance['number2'] ) : 10;
		cx_widget_ctag($number, $number2);
	}
	function update( $new_instance, $old_instance ) {
		if (!isset($new_instance['submit'])) {
			return false;
		}
			$instance = $old_instance;
			$instance = array();
			$instance['number'] = strip_tags($new_instance['number']);
			$instance['number2'] = strip_tags($new_instance['number2']);
			return $instance;
		}
	function form($instance) {
		global $wpdb;
		$number = isset( $instance['number'] ) ? $instance['number'] : 5;
		$number2 = isset( $instance['number2'] ) ? $instance['number2'] : 10;
		?>
	<p><label for="<?php echo $this->get_field_id('number'); ?>">分类数量：</label>
	<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" step="1" min="1" value="<?php echo $number; ?>" size="3" /></p>
		<p><label for="<?php echo $this->get_field_id('number2'); ?>">二级菜单数量：</label>
	<input id="<?php echo $this->get_field_id( 'number2' ); ?>" name="<?php echo $this->get_field_name( 'number2' ); ?>" type="number" step="1" min="1" value="<?php echo $number2; ?>" size="3" /></p>
	<input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
<?php }
}
add_action( 'widgets_init', function(){register_widget( 'cat_list_post' );});


//编辑推荐
class bj_like_post extends WP_Widget {
     function __construct(){
         $widget_ops = array('description' => '显示侧边调用文章自定义字段。');
         parent::__construct('bj_like_post', 'CX-UDY：编辑推荐', $widget_ops);
     }
     function widget($args, $instance) {
		extract($args);
		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( '编辑推荐' );
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$number = strip_tags($instance['number']) ? absint( $instance['number'] ) : 10;		
?>
	<div class="widget widget_text">
		<h3><?php echo $title;?></h3>
		<ul class="textwidget">
		<?php 
		$argss = array(
			'posts_per_page' => $number,
			'orderby' => 'date',
			'order' => 'desc',
			'ignore_sticky_posts' => 1,
			'meta_query' => array(array( 
			'key' => '_id_radio',
			'value' => 'bg' 
		)));
		$srPosts = new WP_Query($argss);
		if ( $srPosts->have_posts() ) :
		while ( $srPosts->have_posts() ) : $srPosts->the_post();?>
			<li><a href="<?php the_permalink();?>" target="_blank"><?php the_title();?></a></li>
		<?php endwhile;	else : ?>
			   <li>发布文章时设置了自定义字段这里才会显示哦</li>
		<?php endif; wp_reset_postdata();?>
		</ul>
	</div>
<?php
	}
	function update( $new_instance, $old_instance ) {
		if (!isset($new_instance['submit'])) {
			return false;
		}
		  $instance = $old_instance;
			$instance = array();
		if ( ! empty( $new_instance['title'] ) ) {
			$instance['title'] = sanitize_text_field( $new_instance['title'] );
		}
		$instance['number'] = strip_tags($new_instance['number']);
			return $instance;
		}
	function form($instance) {
		$title = isset( $instance['title'] ) ? $instance['title'] : '编辑推荐';
		$number = isset( $instance['number'] ) ? $instance['number'] : 10;
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ) ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>"/>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>">显示数量：</label>
			<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" step="1" min="1" value="<?php echo $number; ?>" size="3" />
		</p>
	<input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
<?php }
}
add_action( 'widgets_init', function(){register_widget( 'bj_like_post' );});


//热门专题
class zhuanti_huo_post extends WP_Widget {
     function __construct() {
         $widget_ops = array('description' => '显示侧边调用自定义文章类型。');
         parent::__construct('zhuanti_huo_post', 'CX-UDY：热门专题', $widget_ops);
     }
     function widget($args, $instance) {
		extract($args);
		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( '精选美图' );
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$number = strip_tags($instance['number']) ? absint( $instance['number'] ) : 3;
?>
	<div class="widget widget_image"  id="sidebar">
		<h3><?php echo $title;?></h3>
		<ul class="imagewidget">
		<?php 		
		if ( have_posts() ) : 
					$args=array(
					'post_type'=>'zhuanti_type',
					  'posts_per_page'=>$number,
					  'paged'=>1,
					  'orderby'=>'rand',
					);
				query_posts($args);
				while ( have_posts() ) : the_post();
					cx_themes_switch(2001);
				endwhile;
				endif;
				wp_reset_query();	
		?>				
		</ul>
	</div>

<?php
	}
	function update( $new_instance, $old_instance ) {
		if (!isset($new_instance['submit'])) {
			return false;
		}
		  $instance = $old_instance;
			$instance = array();
		if ( ! empty( $new_instance['title'] ) ) {
			$instance['title'] = sanitize_text_field( $new_instance['title'] );
		}
		$instance['number'] = strip_tags($new_instance['number']);
			return $instance;
		}
	function form($instance) {
		$title = isset( $instance['title'] ) ? $instance['title'] : '热门专题';
		$number = isset( $instance['number'] ) ? $instance['number'] : 3;
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( '标题：' ) ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>"/>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>">显示数量：</label>
			<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" step="1" min="1" value="<?php echo $number; ?>" size="3" />
		</p>
	<input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
<?php }
}
add_action( 'widgets_init', function(){register_widget( 'zhuanti_huo_post' );});