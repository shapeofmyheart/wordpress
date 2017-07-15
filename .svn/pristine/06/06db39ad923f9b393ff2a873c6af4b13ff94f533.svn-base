<?php
/***************************************

## Theme URI: http://www.chenxingweb.com/cx-udy-auto-gaoji-user.html
## Author: 晨星博客
## Author URI: http://www.chenxingweb.com
## Description: 简洁时尚自适应图片主题，适合各种图片展示类网站，有问题请加QQ群565616228请求帮助。
## Theme Name: CX-UDY
## Version: 0.3

****************************************/
function get_author_class($comment_author_email,$user_id){
	global $wpdb;
	$author_count = count($wpdb->get_results(
	"SELECT comment_ID as author_count FROM $wpdb->comments WHERE comment_author_email = '$comment_author_email' "));
    $adminEmail = get_option('admin_email');if($comment_author_email ==$adminEmail) return;
	if($author_count>=10 && $author_count<20)
		echo '<a class="vip1" title="评论达人 LV.1"></a>';
	else if($author_count>=20 && $author_count<40)
		echo '<a class="vip2" title="评论达人 LV.2"></a>';
	else if($author_count>=40 && $author_count<80)
		echo '<a class="vip3" title="评论达人 LV.3"></a>';
	else if($author_count>=80 && $author_count<160)
		echo '<a class="vip4" title="评论达人 LV.4"></a>';
	else if($author_count>=160 && $author_count<320)
		echo '<a class="vip5" title="评论达人 LV.5"></a>';
	else if($author_count>=320 && $author_count<640)
		echo '<a class="vip6" title="评论达人 LV.6"></a>';
	else if($author_count>=640)
		echo '<a class="vip7" title="评论达人 LV.7"></a>';
}
function mytheme_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);

	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'div-comment';
	} else {
		$tag = 'li';
		$add_below = 'comment';
	}
?>
	
	<<?php echo $tag ?> <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
	<div class="comment cf comment_details">
		<div class="avatar left">
			<a href="javascript:void(0)">
				<?php echo chenxing_get_avatar($comment->user_id , '100' , chenxing_get_avatar_type($comment->user_id) ); ?>
			</a>
		</div>	
	<?php if ( 'div' != $args['style'] ) : ?>
		<div id="div-comment-<?php comment_ID() ?>" class="commenttext">
	<?php endif; ?>
	<div class="comment-wrapper">
          <div class="postmeta">
			  <a class="user_info_name" href="javascript:void(0)"><?php comment_author();?></a>
			  <?php if($comment->user_id == 1) echo "<a title='博主' class='vip'></a>"; ?>
			  <time class="timeago" datetime="<?php printf( __('%1$s at %2$s'), get_comment_date( 'Y-m-d' ),  get_comment_time() ); ?>"> • <?php echo get_comment_date( 'm-d' ); ?></time>
			  <?php edit_comment_link( '编辑' , '&nbsp;', '' ); ?>
			  <?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		  </div>
          <div class="commemt-main">
            <?php comment_text(); ?>
          </div>
     </div>
	<?php if ( $comment->comment_approved == '0' ) : ?>
		<div class="comment-awaiting-moderation">您的评论正在等待审核！</div>
	<?php endif; ?>
	<?php if ( 'div' != $args['style'] ) : ?>
	</div>
	<?php endif; ?>
	</div>
<?php 
}