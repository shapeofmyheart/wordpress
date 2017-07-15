<?php
//作者模块
class Kz_author_meta_widget extends WP_Widget {
     function __construct() {
         $widget_ops = array('description' => '显示文章页右侧菜单。');
         parent::__construct('Kz_author_meta_widget', 'CX-UDY扩展：作者模块', $widget_ops);
     }

     function get_url($type = 1){
     	$name = '关注TA';
     	if(is_user_logged_in()){
     		$author_id = get_the_author_meta('ID');
     		$user = wp_get_current_user();
     		$user_id = $user->ID;
     		$user_meta = get_user_meta( $user_id, 'author_guanzhu', true );
			
     		if($type ===1){
	     		$url = ' href="'.chenxing_get_user_url( 'message', $author_id ).'"';
	     	}elseif($type === 3){
	     		if(!empty($user_meta) && is_array($user_meta) && in_array($author_id, $user_meta)){
     				$name = '已关注';
     			}else{
     				$name = '关注TA';
     			}		
     		}else{
     			if(!empty($user_meta) && is_array($user_meta) && in_array($author_id, $user_meta)){
     				$url = ' href="'.chenxing_get_user_url( 'guanzhu', $user_id ).'"';
     			}else{
     				$url = ' id="udy-guanzhu" data-author="'.$author_id.'" data-href="'.chenxing_get_user_url( 'guanzhu', $user_id ).'"';
     			}				
     		}     		
     	}else{
     		$url = ' href="'.cx_login_url(1).'"';
     	}
     	if($type === 3){
     		$url = $name;
     	}
     	return $url;
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
		        <style>
		.widget_author .author_meta .text {
		    display: initial;
		    padding: 0 5px;
		    border-radius: 2px;
		    border: solid 1px #f66;
		    color: #f66;
		    cursor: pointer;
		}
		        </style>
				<ul class="author_meta cl">
					<li class="author_post">
						<a class="text" <?php echo $this->get_url(2);?>><?php echo $this->get_url(3);?></a>
					</li>
					<li class="author_hr">
						<span class="hr" style="margin-top: 0"></span>
					</li>
					<li class="author_views">
						<a <?php echo $this->get_url();?> class="text">发私信</a>
					</li>
				</ul>
				<script type="text/javascript">
				$('#udy-guanzhu').click(function() {
					var _this = $(this),
						_author_id = _this.data('author'),
						_href = _this.data('href');						
					if(!_this.hasClass('guanzhu_off')){
						_this.html('关注TA <i class="fa fa-spinner fa-spin"></i>');
						$.ajax({
							url: chenxing.ajax_url,
							type: 'POST',
							dataType: 'json',
							data: {
								'action': 'kz_author_gz',
	            				'author_id': _author_id
							},
							success:function(b) {
								if(b.success == 2){
									_this.html('已关注').attr("href",_href).addClass('guanzhu_off');
								}else{
									alert(b.msg);
									_this.html('关注TA');
								}
								console.log(b);
							}
						});
					}
					
				});
				</script>
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
		<?php 
	}
}

add_action( 'widgets_init', function(){register_widget( 'Kz_author_meta_widget' );});