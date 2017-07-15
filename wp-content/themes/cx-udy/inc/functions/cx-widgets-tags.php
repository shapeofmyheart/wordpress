<?php
// 标签调用
class recent_tags_num extends WP_Widget {
     function __construct(){
         $widget_ops = array('description' => '调用tag标签');
         parent::__construct('recent_tags_num', 'CX-UDY：标签云', $widget_ops);
     }
     function widget($args, $instance) {
		extract($args);
		$title = apply_filters( 'widget_title', $instance['title'] );
		$number = strip_tags($instance['number']) ? absint( $instance['number'] ) : 15;
?>
<div class="widget widget_tags_num">
	<?php echo ($title)?'<h3>'.$title.'</h3>':'';?>
	<ul class="cl">
		<?php
		$args=array(
			'taxonomy' => 'post_tag',
			'order' => 'ASC',
			'number' =>$number
		);
		$categories=get_categories($args);
		$rand_mt = mt_rand(1,$number-1);
		$i = 0;
		foreach ($categories as $tag) {
			echo ($i == $rand_mt || $i == ($rand_mt*2))?'<li class="tag_color_s">':'<li>';
			echo '<a href="'.get_tag_link($tag->term_id).'" title="'.$tag->name.'">'.$tag->name.'</a>';
			echo '</li>';
			$i++;
		}
		?>
	</ul>
</div>
<style>
.widget_tags_num ul{
	background: #fff;
	padding: 5px;
}
.widget_tags_num ul li {
    float: left;
    margin: 5px;
}
.widget_tags_num ul li a {
    display: inline-block;
    padding: 2px 10px;
    border: solid 1px #dadada;
    border-radius: 20px;
    box-shadow: 0 0 2px rgba(0, 0, 0, 0.11);
    color: #999;
}
.widget_tags_num ul li.tag_color_s a{
	color: #f66;
    border-color: #f66;
}
.widget_tags_num ul li a:hover {
    color: #f66;
    border-color: #f66;
}
</style>
<?php
	//echo $after_widget;
	}
	function update( $new_instance, $old_instance ) {
		if (!isset($new_instance['submit'])) {
			return false;
		}
			$instance = $old_instance;
			$instance = array();
			$instance['title'] = strip_tags( $new_instance['title'] );
			$instance['number'] = strip_tags($new_instance['number']);
			return $instance;
		}
	function form($instance) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = '标签云';
		}
		global $wpdb;
		$instance = wp_parse_args((array) $instance, array('number' => '15'));
		$number = strip_tags($instance['number']);
?>
	<p><label for="<?php echo $this->get_field_id( 'title' ); ?>">标题：</label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>
	<p><label for="<?php echo $this->get_field_id('number'); ?>">显示数量：</label>
	<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
	<input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
<?php }
}
add_action( 'widgets_init', function(){register_widget( 'recent_tags_num' );});
