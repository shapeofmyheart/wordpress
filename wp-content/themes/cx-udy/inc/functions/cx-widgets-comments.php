<?php
// 近期评论
class recent_comments extends WP_Widget {
     function __construct(){
         $widget_ops = array('description' => '用于文章页侧边栏近期留言');
         parent::__construct('recent_comments', 'CX-UDY：近期评论', $widget_ops);
     }
     function widget($args, $instance) {
		extract($args);
		$title = apply_filters( 'widget_title', $instance['title'] );
		$number = strip_tags($instance['number']) ? absint( $instance['number'] ) : 5;
?>
<div class="widget widget_coments">
	<?php echo ($title)?'<h3>'.$title.'</h3>':'';?>
	<ul>
		<?php
		$show_comments = $number;
		$my_email = get_bloginfo ('admin_email');
		$i = 1;
		$args = array(
			'status' => 'approve',
			'number' => $show_comments*4,
			'type'=>'comment',
		);
		$comments = get_comments($args);
		//print_r($comments);
		foreach ($comments as $my_comment) {
			if ($my_comment->comment_author_email != $my_email) {
				?>
				<li class="sidcomment">
					<div class="cmt">
                        <em class="arrow"></em>
                        <?php echo utf8Substr(trim(strip_tags(convert_smilies($my_comment->comment_content))),0,200); ?> 
                    </div>
					<div class="perMsg cl">
                        <a href="<?php echo get_permalink($my_comment->comment_post_ID);?>" target="_blank" class="avater" rel="nofollow">
                            <?php echo chenxing_get_avatar($my_comment->user_id, '40' , chenxing_get_avatar_type($my_comment->user_id)); ?>
                        </a>
                        <div class="txt">
                            <div class="rows cl">
                                <a href="<?php echo get_permalink($my_comment->comment_post_ID);?>" target="_blank" class="name" rel="nofollow"><span><?php echo($my_comment->comment_author);?></span>评论文章：</a>
                                <span class="time"> <?php echo  date("m月d日", strtotime($my_comment->comment_date));?></span>
                            </div>
                            <div class="artHeadTit">
                                <a href="<?php echo get_permalink($my_comment->comment_post_ID);?>" target="_blank" title="<?php echo get_the_title($my_comment->comment_post_ID);?>">
                                    <?php echo get_the_title($my_comment->comment_post_ID);?>
                                </a>
                            </div>
                        </div>
                    </div>					
				</li>
				<?php
				if ($i == $show_comments) break;
				$i++;
			}
		}
		?>
	</ul>
</div>

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
			$title = '近期评论';
		}
		global $wpdb;
		$instance = wp_parse_args((array) $instance, array('number' => '5'));
		$number = strip_tags($instance['number']);
?>
	<p><label for="<?php echo $this->get_field_id( 'title' ); ?>">标题：</label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>
	<p><label for="<?php echo $this->get_field_id('number'); ?>">显示数量：</label>
	<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
	<input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
<?php }
}
add_action( 'widgets_init', function(){register_widget( 'recent_comments' );});
